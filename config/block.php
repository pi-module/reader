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
    'recent-feed' => array(
        'title' => _a('Recent feeds'),
        'description' => _a('Recent websites feeds'),
        'render' => array('block', 'recentFeed'),
        'template' => 'recent-feed',
        'config' => array(
            'number' => array(
                'title' => _a('Number'),
                'description' => '',
                'edit' => 'text',
                'filter' => 'number_int',
                'value' => 5,
            ),
            'show-time' => array(
                'title' => _a('Show time'),
                'description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'show-source' => array(
                'title' => _a('Show source'),
                'description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'show-hits' => array(
                'title' => _a('Show hits'),
                'description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'show-description' => array(
                'title' => _a('Show description'),
                'description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
            'link-type' => array(
                'title' => _a('Link type'),
                'description' => '',
                'edit' => array(
                    'type' => 'select',
                    'options' => array(
                        'options' => array(
                            'internal' => _a('Internal'),
                            'external' => _a('External'),
                        ),
                    ),
                ),
                'filter' => 'text',
                'value' => 'internal',
            ),
            'show-morelink' => array(
                'title' => _a('Show more link'),
                'description' => '',
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 0,
            ),
            'block-effect' => array(
                'title' => _a('Use block effects'),
                'description' => _a('Use block effects or set custom effect on theme'),
                'edit' => 'checkbox',
                'filter' => 'number_int',
                'value' => 1,
            ),
        ),
    ),
);