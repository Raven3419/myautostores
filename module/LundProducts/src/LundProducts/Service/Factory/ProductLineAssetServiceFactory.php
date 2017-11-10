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

use LundProducts\Service\ProductLineAssetService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see ProductLineAssetService}.
 */
class ProductLineAssetServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ProductLineAssetService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $productLineAssetService = new ProductLineAssetService(
            $serviceLocator->get('LundProducts\ObjectManager'),
            $serviceLocator->get('RocketUser\Repository\UserRepository'),
            $serviceLocator->get('LundProducts\Repository\ProductLineAssetRepository'),
            $serviceLocator->get('LundProducts\Repository\ProductLinesRepository'),
            $serviceLocator->get('RocketDam\Repository\AssetRepository'),
            $serviceLocator->get('FormElementManager')->get('LundProducts\Form\ProductLineAssetForm'),
            $serviceLocator->get('LundProducts\Options\LundProductsOptions')
        );

        $productLineAssetService->setProductLineAssetPrototype($serviceLocator->get('LundProducts\Entity\ProductLineAssetPrototype'));

        return $productLineAssetService;
    }
}
