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
    // route name
    'reader' => array(
        'name' => 'reader',
        'type' => 'Module\Reader\Route\Reader',
        'options' => array(
            'route' => '/reader',
            'defaults' => array(
                'module' => 'reader',
                'controller' => 'index',
                'action' => 'index'
            )
        ),
    )
);