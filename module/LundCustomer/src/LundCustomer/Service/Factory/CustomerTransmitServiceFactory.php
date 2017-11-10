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

use LundCustomer\Service\CustomerTransmitService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see CustomerTransmitService}.
 */
class CustomerTransmitServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return CustomerTransmitService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $customerTransmitService = new CustomerTransmitService(
            $serviceLocator->get('LundCustomer\ObjectManager'),
            $serviceLocator->get('LundCustomer\Repository\CustomerTransmitRepository'),
            $serviceLocator->get('LundCustomer\Repository\CustomerRepository'),
            $serviceLocator->get('RocketDam\Repository\AssetRepository'),
            $serviceLocator->get('LundProducts\Repository\BrandsRepository'),
            $serviceLocator->get('LundProducts\Service\ChangesetsService'),
            $serviceLocator->get('LundProducts\Service\FileLogService'),
            $serviceLocator->get('LundCustomer\Service\CustomerService'),
            $serviceLocator->get('LundCustomer\Options\LundCustomerOptions')
        );

        $customerTransmitService->setCustomerTransmitPrototype($serviceLocator->get('LundCustomer\Entity\CustomerTransmitPrototype'));

        return $customerTransmitService;
    }
}
