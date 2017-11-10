<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer\Service
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundCustomer\Service\Factory;

use LundCustomer\Service\CustomerService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see CustomerService}.
 */
class CustomerServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return CustomerService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $customerService = new CustomerService(
            $serviceLocator->get('LundCustomer\ObjectManager'),
            $serviceLocator->get('RocketUser\Repository\UserRepository'),
            $serviceLocator->get('LundCustomer\Repository\CustomerRepository'),
            $serviceLocator->get('FormElementManager')->get('LundCustomer\Form\CustomerForm'),
            $serviceLocator->get('RocketDam\Service\AssetService'),
            $serviceLocator->get('LundCustomer\Options\LundCustomerOptions')
        );

        $customerService->setCustomerPrototype($serviceLocator->get('LundCustomer\Entity\CustomerPrototype'));

        return $customerService;
    }
}
