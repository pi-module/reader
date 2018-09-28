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

namespace Module\Reader\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class SourceForm extends BaseForm
{
    public function __construct($name = null, $option = array())
    {
        parent::__construct($name);
    }

    public function getInputFilter()
    {
        if (!$this->filter) {
            $this->filter = new SourceFilter;
        }
        return $this->filter;
    }

    public function init()
    {
        // id
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        // title
        $this->add(array(
            'name' => 'title',
            'options' => array(
                'label' => __('Title'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                'required' => true,

            )
        ));
        // link
        $this->add(array(
            'name' => 'link',
            'options' => array(
                'label' => __('Feed link'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                'required' => true,

            )
        ));
        // time_parse_period
        $this->add(array(
            'name' => 'time_parse_period',
            'type' => 'select',
            'options' => array(
                'label' => __('Parse period'),
                'value_options' => array(
                    60 => __('1 min'),
                    300 => __('5 min'),
                    600 => __('10 min'),
                    900 => __('15 min'),
                    1800 => __('30 min'),
                    3600 => __('1 hour'),
                    7200 => __('2 hours'),
                    10800 => __('3 hours'),
                    14400 => __('4 hours'),
                    18000 => __('5 hours'),
                    21600 => __('6 hours'),
                    43200 => __('12 hours'),
                    86400 => __('1 day'),
                ),
            ),
            'attributes' => array(
                'required' => true,
                'value' => 86400,
            )
        ));
        // status
        $this->add(array(
            'name' => 'status',
            'type' => 'select',
            'options' => array(
                'label' => __('Status'),
                'value_options' => array(
                    1 => __('Published'),
                    2 => __('Pending review'),
                    3 => __('Draft'),
                    4 => __('Private'),
                    5 => __('Delete'),
                ),
            ),
            'attributes' => array(
                'required' => true,

            )
        ));
        // Save
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => __('Submit'),
            )
        ));
    }
}