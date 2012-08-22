<?php
/**
 * This file is part of MySQLDumper released under the GNU/GPL 2 license
 * http://www.mysqldumper.net
 *
 * @package         MySQLDumper
 * @subpackage      Controllers
 * @version         SVN: $Rev$
 * @author          $Author$
 */
/**
 * Assign config- and language to view
 *
 * Helper to auto assign the config- and language instance to view instances
 *
 * @package         MySQLDumper
 * @subpackage      Action_Helper
 */
class Msd_Action_Helper_AssignConfigAndLanguage extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Actual Zend_View instance
     * @var Zend_View
     */
    protected $_view;

    /**
     * PreDispatcher
     *
     * @return void
     */
    public function preDispatch()
    {
        $controllerName = $this->getRequest()->getControllerName();
        if ($controllerName == 'install') {
            return;
        }

        $view   = $this->getView();
        $config = Msd_Registry::getConfig();
        if ($config->getParam('configFile', 'defaultConfig.ini') == 'defaultConfig.ini') {
            $redirectUrl = $view->serverUrl() . $view->url(
                array(
                    'controller' => 'install',
                    'action' => 'index',
                    null,
                    true)
            );
            $redirector  = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $redirector->gotoUrl($redirectUrl);
        }
        $view->config        = $config;
        $view->dynamicConfig = Msd_Registry::getDynamicConfig();
        $view->lang          = Msd_Language::getInstance();
    }

    /**
     * Get the view instance of the actual controller
     *
     * @return Zend_View
     */
    public function getView()
    {
        if (null !== $this->_view) {
            return $this->_view;
        } else {
            $controller  = $this->getActionController();
            $this->_view = $controller->view;
            return $this->_view;
        }
    }
}
