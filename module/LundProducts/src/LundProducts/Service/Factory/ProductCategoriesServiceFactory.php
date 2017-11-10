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

use LundProducts\Service\ProductCategoryService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see ProductCategoriesService}
 */
class ProductCategoriesServiceFactory implements FactoryInterface
{
    /**
     * Create Product Line service from factory
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ProductCategoryService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $productCategoriesService = new ProductCategoryService(
            $serviceLocator->get('LundProducts\ObjectManager'),
            $serviceLocator->get('LundProducts\Repository\ProductCategoriesRepository'),
            $serviceLocator->get('FormElementManager')->get('LundProducts\Form\ProductCategoryForm')
        );

        return $productCategoriesService;
    }
}
