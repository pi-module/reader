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
    'reader' => array(
        'title' => _a('Feed reader comments'),
        'icon' => 'icon-post',
        'callback' => 'Module\Reader\Api\Comment',
        'locator' => 'Module\Reader\Api\Comment',
    ),
);