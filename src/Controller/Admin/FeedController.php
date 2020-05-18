<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\Reader\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Laminas\Db\Sql\Predicate\Expression;

class FeedController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Get source
        $source = array();
        $select = $this->getModel('source')->select();
        $rowSet = $this->getModel('source')->selectWith($select);
        foreach ($rowSet as $row) {
            $source[$row->id] = $row->toArray();
        }
        // Get feed
        $feeds = array();
        $where = array('status' => array(1, 2, 3, 4));
        $order = array('id DESC', 'time_create DESC');
        $limit = intval($this->config('admin_perpage'));
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $select = $this->getModel('feed')->select()->where($where)->order($order)->offset($offset)->limit($limit);
        $rowSet = $this->getModel('feed')->selectWith($select);
        foreach ($rowSet as $row) {
            $feeds[$row->id] = $row->toArray();
            $feeds[$row->id]['sourceTitle'] = $source[$row->source]['title'];
        }
        // Set paginator
        $count = array('count' => new Expression('count(*)'));
        $select = $this->getModel('feed')->select()->columns($count);
        $count = $this->getModel('feed')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router' => $this->getEvent()->getRouter(),
            'route' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array_filter(array(
                'module' => $this->getModule(),
                'controller' => 'feed',
                'action' => 'index',
            )),
        ));
        // Set view
        $this->view()->setTemplate('feed-index');
        $this->view()->assign('feeds', $feeds);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('config', $config);
    }

    public function ajaxAction()
    {
        // Get id and status
        $id = $this->params('id');
        $status = $this->params('status');
        $return = array();
        // set product
        $feed = $this->getModel('feed')->find($id);
        // Check
        if ($feed && in_array($status, array(1, 2, 3, 4, 5))) {
            // Accept
            $feed->status = $status;
            // Save
            if ($feed->save()) {
                $return['message'] = sprintf(__('%s set status successfully'), $feed->title);
                $return['ajaxStatus'] = 1;
                $return['id'] = $feed->id;
                $return['feedStatus'] = $feed->status;
            } else {
                $return['message'] = sprintf(__('Error in set status for %s feed'), $feed->title);
                $return['ajaxStatus'] = 0;
                $return['id'] = 0;
                $return['feedStatus'] = $feed->status;
            }
        } else {
            $return['message'] = __('Please select feed');
            $return['ajaxStatus'] = 0;
            $return['id'] = 0;
            $return['feedStatus'] = 0;
        }
        return $return;
    }
}