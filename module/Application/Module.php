<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * Lund Digital Platform Application
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    Application
 * @subpackage Module
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\View\Resolver\TemplatePathStack;

/**
 * Application
 *
 * @category   Zend
 * @package    Application
 * @subpackage Module
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class Module implements
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ControllerProviderInterface,
    ViewHelperProviderInterface,
    FormElementProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();

        $em->attach(MvcEvent::EVENT_RENDER, function (MvcEvent $event) {
            $sm = $event->getParam('application')->getServiceManager();

            $entityManager = $sm->get('Doctrine\ORM\EntityManager');

            $siteRepo   = $sm->get('RocketCms\Repository\SiteRepository');
            $layoutRepo = $sm->get('RocketCms\Repository\LayoutRepository');

            $env = $_SERVER['APP_SITE'];

            if ($env != 'lunddigitalplatform') {
                $site   = $siteRepo->findOneBy(array('envVariable' => $env));
                $layout = $layoutRepo->findOneBy(array('site' => $site->getSiteId()));

                /** @var TemplateMapResolver $viewResolverMap */
                $vtmr = $sm->get('ViewTemplateMapResolver');

                $templateMap = array(
                    $layout->getDirectory() . '/layout'     => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/page.phtml',
                    $layout->getDirectory() . '/header'     => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/header.phtml',
                    $layout->getDirectory() . '/footer'     => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/footer.phtml',
                    $layout->getDirectory() . '/top-nav'    => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/top-nav.phtml',
                    $layout->getDirectory() . '/sidebar'    => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/sidebar.phtml',
                    $layout->getDirectory() . '/sidebar-my-account'    => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/sidebar-my-account.phtml',
                    $layout->getDirectory() . '/sidebar-customer-information'    => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/sidebar-customer-information.phtml',
                    $layout->getDirectory() . '/sidebar-login'    => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/sidebar-login.phtml',
                    $layout->getDirectory() . '/sidebar-privacy-policy'    => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/sidebar-privacy-policy.phtml',
                    $layout->getDirectory() . '/footer-nav' => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/footer-nav.phtml',
                    $layout->getDirectory() . '/404'        => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/404.phtml',
                    $layout->getDirectory() . '/403'        => __DIR__ . '/view/layouts/' . $layout->getDirectory() . '/403.phtml',

                );

                $vtmr->setMap($templateMap);

                /** @var TemplatePathStack $viewResolverPathStack */
                $vtps = $sm->get('ViewTemplatePathStack');

                $vtps->clearPaths();
                $vtps->addPath(__DIR__ . '/view/layouts/' . $layout->getDirectory() . '/templates');
            }

        }, 10);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($em);
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
            __DIR__ . '/config/navigation.config.php',
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
     * {@inheritDoc}
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
}
