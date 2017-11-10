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

use LundProducts\Service\ProductLineFeatureService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see ProductLineFeatureService}.
 */
class ProductLineFeatureServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ProductLineFeatureService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $productLineFeatureService = new ProductLineFeatureService(
            $serviceLocator->get('LundProducts\ObjectManager'),
            $serviceLocator->get('RocketUser\Repository\UserRepository'),
            $serviceLocator->get('LundProducts\Repository\ProductLineFeatureRepository'),
            $serviceLocator->get('LundProducts\Repository\ProductLinesRepository'),
            $serviceLocator->get('FormElementManager')->get('LundProducts\Form\ProductLineFeatureForm'),
            $serviceLocator->get('LundProducts\Options\LundProductsOptions')
        );

        $productLineFeatureService->setProductLineFeaturePrototype($serviceLocator->get('LundProducts\Entity\ProductLineFeaturePrototype'));

        return $productLineFeatureService;
    }
}
