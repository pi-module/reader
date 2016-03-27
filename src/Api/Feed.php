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
namespace Module\Reader\Api;

use Pi;
use Pi\Application\Api\AbstractApi;
use Zend\Json\Json;

/*
 * Pi::api('feed', 'reader')->getFeed($parameter, $field);
 * Pi::api('feed', 'reader')->getFeedList();
 * Pi::api('feed', 'reader')->canonizeFeed($feed);
 */
class Feed extends AbstractApi
{
    public function getFeed($parameter, $field = 'id')
    {
        $feed = Pi::model('feed', $this->getModule())->find($parameter, $field);
        $feed = $this->canonizeFeed($feed);
        return $feed;
    }

    public function getFeedList()
    {
        $feedList = array();

        return $feedList;
    }

    public function canonizeFeed($feed)
    {
        // Check
        if (empty($feed)) {
            return '';
        }
        // object to array
        $feed = $feed->toArray();
        // Set time
        $feed['time_create_view'] = _date($feed['time_create']);
        // Set feed url
        $feed['feedUrl'] = Pi::url(Pi::service('url')->assemble('reader', array(
            'module' => $this->getModule(),
            'controller' => 'feed',
            'id' => $feed['id'],
        )));
        // Set date_modified
        $feed['date_modified'] = Json::decode($feed['date_modified'], true);
        // return feed
        return $feed;
    }
}