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
namespace Module\Reader\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Zend\Db\Sql\Predicate\Expression;

class IndexController extends ActionController
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
        $where = array('status' => 1);
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($this->config('view_perpage'));
        $offset = (int)($page - 1) * $this->config('view_perpage');
        $select = $this->getModel('feed')->select()->where($where)->order($order)->offset($offset)->limit($limit);
        $rowSet = $this->getModel('feed')->selectWith($select);
        foreach ($rowSet as $row) {
            $feeds[$row->id] = Pi::api('feed', 'reader')->canonizeFeed($row);
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
                'controller' => 'index',
                'action' => 'index',
            )),
        ));
        // Set view
        $this->view()->setTemplate('feed-list');
        $this->view()->assign('feeds', $feeds);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('config', $config);
    }
}