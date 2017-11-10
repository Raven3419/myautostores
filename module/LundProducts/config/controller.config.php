<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Config
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts;

return array(
    'factories' => array(
        'LundProducts\Controller\Brands'               => 'LundProducts\Controller\Factory\BrandsControllerFactory',
        'LundProducts\Controller\Changesets'           => 'LundProducts\Controller\Factory\ChangesetsControllerFactory',
        'LundProducts\Controller\Parse'                => 'LundProducts\Controller\Factory\ParseControllerFactory',
        'LundProducts\Controller\ProductLines'         => 'LundProducts\Controller\Factory\ProductLinesControllerFactory',
        'LundProducts\Controller\Parts'                => 'LundProducts\Controller\Factory\PartsControllerFactory',
        'LundProducts\Controller\ProductCategories'    => 'LundProducts\Controller\Factory\ProductCategoriesControllerFactory',
        'LundProducts\Controller\Vehicles'             => 'LundProducts\Controller\Factory\VehiclesControllerFactory',
        'LundProducts\Controller\ProductReviews'       => 'LundProducts\Controller\Factory\ProductReviewsControllerFactory',
        'LundProducts\Controller\Monitor'              => 'LundProducts\Controller\Factory\MonitorControllerFactory',
        'LundProducts\Controller\Generate'             => 'LundProducts\Controller\Factory\GenerateControllerFactory',
        'LundProducts\Controller\Imagine'              => 'LundProducts\Controller\Factory\ImagineControllerFactory',
        'LundProducts\Controller\OrderItem'            => 'LundProducts\Controller\Factory\OrderItemControllerFactory',
        'LundProducts\Controller\PartAsset'            => 'LundProducts\Controller\Factory\PartAssetControllerFactory',
        'LundProducts\Controller\ProductLineAsset'     => 'LundProducts\Controller\Factory\ProductLineAssetControllerFactory',
        'LundProducts\Controller\FileLog'              => 'LundProducts\Controller\Factory\FileLogControllerFactory',
        'LundProducts\Controller\BrandProductCategory' => 'LundProducts\Controller\Factory\BrandProductCategoryControllerFactory',
        'LundProducts\Controller\ProductLineFeature'   => 'LundProducts\Controller\Factory\ProductLineFeatureControllerFactory',
    ),
);
