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
        'public' => array(
            'title' => _a('Global public resource'),
            'access' => array(
                'guest',
                'member',
            ),
        ),
    ),
    // Admin section
    'admin' => array(
        'source' => array(
            'title' => _a('Source'),
            'access' => array(),
        ),
        'feed' => array(
            'title' => _a('List of feeds'),
            'access' => array(),
        ),
    ),
);