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
namespace Module\Reader\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Module\Reader\Form\SourceForm;
use Module\Reader\Form\SourceFilter;

class SourceController extends ActionController
{
    public function indexAction()
    {
        // Get info from url
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Set cron url
        $cronUrl = Pi::url($this->url('reader', array(
            'module'      => 'reader',
            'controller'  => 'parse',
            'action'      => 'index',
            'password'    => $config['cron_password'],
        )));
        // Get info
        $list = array();
        $order = array('id DESC');
        $select = $this->getModel('source')->select()->order($order);
        $rowSet = $this->getModel('source')->selectWith($select);
        // Make list
        foreach ($rowSet as $row) {
            $list[$row->id] = $row->toArray();
            $list[$row->id]['time'] = $row->time_parse_last + $row->time_parse_period;
            if ($list[$row->id]['time'] > time()) {
                $list[$row->id]['delay'] = 0;
            } else {
                $delay = time() - $list[$row->id]['time'];
                if ($delay < 3600) {
                    $list[$row->id]['delay'] = sprintf(__('Delayed %s min'), intval($delay / 60));
                } elseif ($delay < 86400) {
                    $list[$row->id]['delay'] = sprintf(__('Delayed %s hours'), intval($delay / 3600));
                } else {
                    $list[$row->id]['delay'] = sprintf(__('Delayed %s days'), intval($delay / 86400));
                }
            }
        }
        // Set view
        $this->view()->assign('list', $list);
        $this->view()->assign('cronUrl', $cronUrl);
    }

    public function updateAction()
    {
        // Get id
        $id = $this->params('id');
        // Set form
        $form = new SourceForm('source');
        $form->setAttribute('enctype', 'multipart/form-data');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new SourceFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                // Save values
                if (!empty($values['id'])) {
                    $row = $this->getModel('source')->find($values['id']);
                } else {
                    $values['time_create'] = time();
                    $row = $this->getModel('source')->createRow();
                }
                $row->assign($values);
                $row->save();
                // Jump
                $message = __('Source data saved successfully.');
                $this->jump(array('action' => 'index'), $message);
            }
        } else {
            if ($id) {
                $source = $this->getModel('source')->find($id)->toArray();
                $form->setData($source);
            }
        }
        // Set view
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Add source'));
    }
}