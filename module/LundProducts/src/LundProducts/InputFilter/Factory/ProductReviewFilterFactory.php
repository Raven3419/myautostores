<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * @category   Zend
 * @package    LundProducts\InputFilter
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\InputFilter\Factory;

use LundProducts\InputFilter\ProductReviewFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see ProductReviewFilter}.
 */
class ProductReviewFilterFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ProductReviewFilter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $parentLocator            = $serviceLocator->getServiceLocator();
        $productReviewsRepository = $parentLocator->get('LundProducts\Repository\ProductReviewsRepository');
        $options                  = $parentLocator->get('LundProducts\Options\LundProductsOptions');

        return new ProductReviewFilter($productReviewsRepository, $options);
    }
}
