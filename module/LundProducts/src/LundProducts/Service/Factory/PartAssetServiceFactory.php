<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Service
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Service\Factory;

use LundProducts\Service\PartAssetService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see PartAssetService}.
 */
class PartAssetServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return PartAssetService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $partAssetService = new PartAssetService(
            $serviceLocator->get('LundProducts\ObjectManager'),
            $serviceLocator->get('RocketUser\Repository\UserRepository'),
            $serviceLocator->get('LundProducts\Repository\PartAssetRepository'),
            $serviceLocator->get('LundProducts\Repository\PartsRepository'),
            $serviceLocator->get('RocketDam\Repository\AssetRepository'),
            $serviceLocator->get('FormElementManager')->get('LundProducts\Form\PartAssetForm'),
            $serviceLocator->get('LundProducts\Options\LundProductsOptions')
        );

        $partAssetService->setPartAssetPrototype($serviceLocator->get('LundProducts\Entity\PartAssetPrototype'));

        return $partAssetService;
    }
}
