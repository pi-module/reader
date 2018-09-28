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
namespace Module\Reader\Model;

use Pi\Application\Model\Model;

class Source extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $columns = array(
        'id',
        'title',
        'link',
        'time_create',
        'time_parse_last',
        'time_parse_period',
        'status',
        'extra',
    );
}