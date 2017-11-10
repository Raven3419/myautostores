<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundCustomer\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * ParseController Factory
 *
 * @category   Zend
 * @package    LundCustomer\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ParseControllerFactory implements FactoryInterface
{
    /*
     * @param ServiceLocatorInterface $sl
     *
     * @return ParseController
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $sm     = $sl->getServiceLocator();

        return new \LundCustomer\Controller\ParseController(
            $sm->get('LundCustomer\Service\ParseCustomerService'),
            $sm->get('LundCustomer\Service\CustomerService'),
            $sm->get('RocketUser\Service\UserService'),
            $sm->get('RocketAdmin\Service\AuditService'),
            $sm->get('RocketDam\Service\AssetService'),
            $sm->get('LundCustomer\Service\RetailerService'),
            $sm->get('RocketBase\Repository\CountryRepository'),
            $sm->get('RocketBase\Repository\StateRepository')
        );
    }
}
