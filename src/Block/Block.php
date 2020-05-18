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
namespace Module\Reader\Block;

use Pi;
use Module\Guide\Form\SearchLocationForm;
use Laminas\Db\Sql\Predicate\Expression;

class Block
{
    public static function recentFeed($options = array(), $module = null)
    {
        // Set options
        $block = array();
        $block = array_merge($block, $options);

        // Get source
        $source = array();
        $select = Pi::model('source', $module)->select();
        $rowSet = Pi::model('source', $module)->selectWith($select);
        foreach ($rowSet as $row) {
            $source[$row->id] = $row->toArray();
        }

        // Get feed
        $where = array('status' => 1);
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($block['number']);
        $select = Pi::model('feed', $module)->select()->where($where)->order($order)->limit($limit);
        $rowSet = Pi::model('feed', $module)->selectWith($select);
        foreach ($rowSet as $row) {
            $feeds[$row->id] = Pi::api('feed', 'reader')->canonizeFeed($row);
            $feeds[$row->id]['sourceTitle'] = $source[$row->source]['title'];
        }
        $block['resources'] = $feeds;

        return $block;
    }
}