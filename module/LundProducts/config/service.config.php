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
    'abstract_factories' => array(
        'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        'Zend\Log\LoggerAbstractServiceFactory',
    ),
    'aliases' => array(
        'LundProducts\ObjectManager' => 'Doctrine\ORM\EntityManager',
    ),
    'invokables' => array(
        'LundProducts\Entity\ChangesetsPrototype'               => 'LundProducts\Entity\Changesets',
        'LundProducts\Entity\ChangesetDetailsPrototype'         => 'LundProducts\Entity\ChangesetDetails',
        'LundProducts\Entity\ChangesetDetailsVehiclesPrototype' => 'LundProducts\Entity\ChangesetDetailsVehicles',
        'LundProducts\Entity\BrandsPrototype'                   => 'LundProducts\Entity\Brands',
        'LundProducts\Entity\PartAssetPrototype'                => 'LundProducts\Entity\PartAsset',
        'LundProducts\Entity\ProductLineAssetPrototype'         => 'LundProducts\Entity\ProductLineAsset',
        'LundProducts\Entity\BrandProductCategoryPrototype'     => 'LundProducts\Entity\BrandProductCategory',
        'LundProducts\Entity\ProductLineFeaturePrototype'       => 'LundProducts\Entity\ProductLineFeature',
        'LundProducts\Entity\PromoPrototype'                    => 'LundProducts\Entity\Promo',
    ),
    'factories' => array(
        'LundProducts\Options\LundProductsOptions'                   => 'LundProducts\Options\Factory\LundProductsOptionsFactory',
        'LundProducts\Config'                                        => 'LundProducts\Factory\ConfigFactory',
        'LundProducts\Repository\ChangesetsRepository'               => 'LundProducts\Repository\Factory\ChangesetsRepositoryFactory',
        'LundProducts\Repository\ChangesetDetailsRepository'         => 'LundProducts\Repository\Factory\ChangesetDetailsRepositoryFactory',
        'LundProducts\Repository\ChangesetDetailsVehiclesRepository' => 'LundProducts\Repository\Factory\ChangesetDetailsVehiclesRepositoryFactory',
        'LundProducts\Service\ChangesetsService'                     => 'LundProducts\Service\Factory\ChangesetsServiceFactory',
        'LundProducts\Service\ChangesetDetailsService'               => 'LundProducts\Service\Factory\ChangesetDetailsServiceFactory',
        'LundProducts\Service\ChangesetDetailsVehiclesService'       => 'LundProducts\Service\Factory\ChangesetDetailsVehiclesServiceFactory',
        'LundProducts\Repository\BrandsRepository'                   => 'LundProducts\Repository\Factory\BrandsRepositoryFactory',
        'LundProducts\Service\BrandsService'                         => 'LundProducts\Service\Factory\BrandsServiceFactory',
        'LundProducts\Service\ParseMasterService'                    => 'LundProducts\Service\Factory\ParseMasterServiceFactory',
        'LundProducts\Service\ParseSupplementService'                => 'LundProducts\Service\Factory\ParseSupplementServiceFactory',
        'LundProducts\Service\ParsePromoService'                     => 'LundProducts\Service\Factory\ParsePromoServiceFactory',
        'LundProducts\Service\PromoService'                          => 'LundProducts\Service\Factory\PromoServiceFactory',
        'LundProducts\Repository\PromoRepository'                    => 'LundProducts\Repository\Factory\PromoRepositoryFactory',
        'LundProducts\Service\ProductLineService'                    => 'LundProducts\Service\Factory\ProductLineServiceFactory',
        'LundProducts\Service\PartService'                           => 'LundProducts\Service\Factory\PartServiceFactory',
        'LundProducts\Repository\ProductLinesRepository'             => 'LundProducts\Repository\Factory\ProductLinesRepositoryFactory',
        'LundProducts\Repository\PartsRepository'                    => 'LundProducts\Repository\Factory\PartsRepositoryFactory',
        'LundProducts\Repository\ProductCategoriesRepository'        => 'LundProducts\Repository\Factory\ProductCategoriesRepositoryFactory',
        'LundProducts\Service\ProductCategoryService'                => 'LundProducts\Service\Factory\ProductCategoriesServiceFactory',
        'LundProducts\Service\VehCollectionService'                  => 'LundProducts\Service\Factory\VehCollectionServiceFactory',
        'LundProducts\Repository\VehCollectionRepository'            => 'LundProducts\Repository\Factory\VehCollectionRepositoryFactory',
        'LundProducts\Service\ProductReviewService'                  => 'LundProducts\Service\Factory\ProductReviewServiceFactory',
        'LundProducts\Repository\ProductReviewsRepository'           => 'LundProducts\Repository\Factory\ProductReviewsRepositoryFactory',
        'LundProducts\Repository\PartVehCollectionRepository'        => 'LundProducts\Repository\Factory\PartVehCollectionRepositoryFactory',
        'LundProducts\Repository\FileLogRepository'                  => 'LundProducts\Repository\Factory\FileLogRepositoryFactory',
        'LundProducts\Service\FileLogService'                        => 'LundProducts\Service\Factory\FileLogServiceFactory',
        'LundProducts\Repository\PartAssetRepository'                => 'LundProducts\Repository\Factory\PartAssetRepositoryFactory',
        'LundProducts\Service\PartAssetService'                      => 'LundProducts\Service\Factory\PartAssetServiceFactory',
        'LundProducts\Repository\ProductLineAssetRepository'         => 'LundProducts\Repository\Factory\ProductLineAssetRepositoryFactory',
        'LundProducts\Service\ProductLineAssetService'               => 'LundProducts\Service\Factory\ProductLineAssetServiceFactory',
        'LundProducts\Repository\BrandProductCategoryRepository'     => 'LundProducts\Repository\Factory\BrandProductCategoryRepositoryFactory',
        'LundProducts\Service\BrandProductCategoryService'           => 'LundProducts\Service\Factory\BrandProductCategoryServiceFactory',
        'LundProducts\Service\LundProductService'                    => 'LundProducts\Service\Factory\LundProductServiceFactory',
        'LundProducts\Repository\VehYearRepository'                  => 'LundProducts\Repository\Factory\VehYearRepositoryFactory',
        'LundProducts\Repository\ProductLineFeatureRepository'       => 'LundProducts\Repository\Factory\ProductLineFeatureRepositoryFactory',
        'LundProducts\Service\ProductLineFeatureService'             => 'LundProducts\Service\Factory\ProductLineFeatureServiceFactory',
    ),
);
