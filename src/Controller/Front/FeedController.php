<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\Reader\Controller\Front;

use Pi;
use Pi\Filter;
use Pi\Mvc\Controller\ActionController;

class FeedController extends ActionController
{
    public function indexAction()
    {
        // Get info from url
        $id = $this->params('id');
        $module = $this->params('module');
        // Get Module Config
        $config = Pi::service('registry')->config->read($module);
        // Get source
        $source = array();
        $select = $this->getModel('source')->select();
        $rowSet = $this->getModel('source')->selectWith($select);
        foreach ($rowSet as $row) {
            $source[$row->id] = $row->toArray();
        }
        // Find feed
        $feed = Pi::api('feed', 'reader')->getFeed($id);
        // Check status
        if (!$feed || $feed['status'] != 1) {
            $this->getResponse()->setStatusCode(404);
            $this->terminate(__('The feed not found.'), '', 'error-404');
            $this->view()->setLayout('layout-simple');
            return;
        }
        // Update Hits
        $this->getModel('feed')->increment('hits', array('id' => $feed['id']));
        // Set source title
        $feed['sourceTitle'] = $source[$feed['source']]['title'];
        // Set SEO data
        $filter = new Filter\HeadKeywords;
        $filter->setOptions(array(
            'force_replace_space' => (bool) $config['keywords_replace_space']
        ));
        $seoKeywords = $filter($feed['title']);
        // Set view
        $this->view()->headTitle($feed['title']);
        $this->view()->headDescription($feed['title'], 'set');
        $this->view()->headKeywords($seoKeywords, 'set');

        $this->view()->setTemplate('feed-detail');
        $this->view()->assign('feed', $feed);
        $this->view()->assign('config', $config);
    }
}