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

/*
 * Pi::api('feed', 'reader')->getFeed($parameter, $type);
 * Pi::api('feed', 'reader')->getFeedList();
 */
class Feed extends AbstractApi
{
    public function getFeed($parameter, $type = 'id')
    {
        $feed = Pi::model('feed', $this->getModule())->find($parameter, $type);
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

        return $feed;
    }
}