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

use LundCustomer\Service\RetailerService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see RetailerService}.
 */
class RetailerServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return RetailerService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $retailerService = new RetailerService(
            $serviceLocator->get('LundCustomer\ObjectManager'),
            $serviceLocator->get('LundCustomer\Repository\RetailerRepository'),
            $serviceLocator->get('FormElementManager')->get('LundCustomer\Form\RetailerForm'),
            $serviceLocator->get('LundCustomer\Options\LundCustomerOptions'),
            $serviceLocator->get('LundCustomer\Repository\PostalCodeRepository')
        );

        $retailerService->setRetailerPrototype($serviceLocator->get('LundCustomer\Entity\RetailerPrototype'));

        return $retailerService;
    }
}
