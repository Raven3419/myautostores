<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundFeeds\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * ParseController Factory
 *
 * @category   Zend
 * @package    LundFeeds\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class EdgenetControllerFactory implements FactoryInterface
{
    /*
     * @param ServiceLocatorInterface $sl
     *
     * @return AcesController
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $sm     = $sl->getServiceLocator();
        $config = $sm->get('Config');

        // TODO: put path to parse log in config object
        //$writer = new \Zend\Log\Writer\Stream('./data/logs/master_parse.log');
        return new \LundFeeds\Controller\EdgenetController(
            $sm->get('RocketDam\Service\AssetService'),
            $sm->get('LundProducts\Service\FileLogService'),
            $sm->get('RocketAdmin\Service\AuditService'),
            $sm->get('LundProducts\Service\ChangesetsService')
        );
    }
}
