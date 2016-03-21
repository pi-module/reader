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
return array(
    // Admin section
    'admin' => array(
        'source' => array(
            'label' => _a('Source'),
            'permission' => array(
                'resource' => 'source',
            ),
            'route' => 'admin',
            'module' => 'reader',
            'controller' => 'source',
            'action' => 'index',
        ),
        'feed' => array(
            'label' => _a('List of feeds'),
            'permission' => array(
                'resource' => 'feed',
            ),
            'route' => 'admin',
            'module' => 'reader',
            'controller' => 'feed',
            'action' => 'index',
        ),
    ),
);