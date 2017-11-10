<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundCustomer\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use LundCustomer\Controller\CustomerController;

/**
 * Controller Factory
 *
 * @category   Zend
 * @package    LundCustomer\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class CustomerControllerFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sl
     *
     * @return \LundCustomer\Controller\CustomerController
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $sm = $sl->getServiceLocator();
        $em = $sm->get('EventManager');

        $cn = new CustomerController(
            $sm->get('LundCustomer\Service\CustomerService'),
            $sm->get('LundCustomer\Service\CustomerTransmitService'),
            $sm->get('LundCustomer\Options\LundCustomerOptions')
        );

        $em->attach('dispatch', function ($e) use ($cn) {
            $cn->layout()->pageTitle = 'Accounts';
            $cn->layout()->pageDescr = 'Customer System';
        }, 100);

        $cn->setEventManager($em);

        return $cn;
    }
}
