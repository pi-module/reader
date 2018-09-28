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
return array(
    // Front section
    'front' => array(
        array(
            'title' => _a('Index page'),
            'controller' => 'index',
            'permission' => 'public',
            'block' => 1,
        ),
        array(
            'title' => _a('Feed'),
            'controller' => 'feed',
            'permission' => 'public',
            'block' => 1,
        ),
    ),
    // Admin section
    'admin' => array(
        array(
            'title' => _a('Source'),
            'controller' => 'source',
            'permission' => 'source',
        ),
        array(
            'title' => _a('List of feeds'),
            'controller' => 'feed',
            'permission' => 'feed',
        ),
    ),
);