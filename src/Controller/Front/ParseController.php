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
namespace Module\Reader\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;

class ParseController extends ActionController
{
    public function indexAction()
    {
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $password = $this->params('password');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Get password
        if ($password == $config['cron_password']) {
            // Do cron
            return Pi::api('parse', 'reader')->doParse();
        } else {
            return array(
                'message' => __('Error : password not true!'),
                'status'  => 0,
                'time'    => time(),
            );
        }
    }
}