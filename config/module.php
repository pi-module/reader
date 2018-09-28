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
    // Module meta
    'meta' => array(
        'title' => _a('Feed reader'),
        'description' => _a('Feed reader system'),
        'version' => '0.0.5',
        'license' => 'New BSD',
        'logo' => 'image/logo.png',
        'readme' => 'docs/readme.txt',
        'demo' => 'http://pialog',
        'icon' => 'fa-rss',
    ),
    // Author information
    'author' => array(
        'Name' => 'Hossein Azizabadi',
        'email' => 'azizabadi@faragostaresh.com',
        'website' => 'http://pialog',
        'credits' => 'Pi Engine Team'
    ),
    // Resource
    'resource' => array(
        'database' => 'database.php',
        'config' => 'config.php',
        'permission' => 'permission.php',
        'page' => 'page.php',
        'navigation' => 'navigation.php',
        'block' => 'block.php',
        'route' => 'route.php',
        'comment' => 'comment.php',
    ),
);