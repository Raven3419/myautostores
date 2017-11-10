<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Module
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\InputFilterProviderInterface;

/**
 * LundProducts
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Module
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class Module implements
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface,
    FormElementProviderInterface,
    InputFilterProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $sm = $e->getApplication()->getServiceManager();

        $categoryService = $sm->get('LundProducts\Service\ProductCategoryService');
        $lineService     = $sm->get('LundProducts\Service\ProductLineService');
        $partService     = $sm->get('LundProducts\Service\PartService');

        if (!isset($_SESSION['categories'])) {
            //TODO Replace with dynamic values
 //           $_SESSION['categories'] = $categoryService->getCount();
            $_SESSION['categories'] = '1';
        }
        if (!isset($_SESSION['lines'])) {
 //           $_SESSION['lines'] = $lineService->getCount();
            $_SESSION['lines'] = '1';
        }
        if (!isset($_SESSION['parts'])) {
 //           $_SESSION['parts'] = $partService->getCount();
            $_SESSION['parts'] = '1';
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        $config = array();

        $configFiles = array(
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/router.config.php',
            __DIR__ . '/config/navigation.config.php'
        );

        foreach ($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile);
        }

        return $config;
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }

   /**
    * {@inheritDoc}}
    */
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }

   /**
    * {@inheritDoc}
    */
    public function getViewHelperConfig()
    {
        return include __DIR__ . '/config/view-helper.config.php';
    }

   /**
    * {@inheritDoc}
    */
    public function getFormElementConfig()
    {
        return include __DIR__ . '/config/form-element.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getInputFilterConfig()
    {
        return include __DIR__ . '/config/input-filter.config.php';

    }
}
