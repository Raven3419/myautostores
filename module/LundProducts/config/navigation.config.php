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
    'navigation' => array(
        'admin' => array(
            array(
                'label'      => 'Products',
                'route'      => 'rocket-admin/products',
                'permission' => 'LundProducts\Controller\Changesets:index',
                'icon'       => 'icon-cogs',
                'order'      => 200,
                'pages'      => array(
                    array(
                        'label'      => 'Brands',
                        'route'      => 'rocket-admin/products/brands',
                        'permission' => 'LundProducts\Controller\Brands:index',
                        'order'      => 201,
                        'pages'      => array(
                            array(
                                'label'           => 'Create Brand',
                                'route'           => 'rocket-admin/products/brands/create',
                                'permission'      => 'LundProducts\Controller\Brands:create',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'Edit Brand',
                                'route'           => 'rocket-admin/products/brands/edit',
                                'permission'      => 'LundProducts\Controller\Brands:edit',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'View Brand',
                                'route'           => 'rocket-admin/products/brands/view',
                                'permission'      => 'LundProducts\Controller\Brands:view',
                                'use_route_match' => true,
                                'pages'           => array(
                                    array(
                                        'label'           => 'View Brand Product Categories',
                                        'route'           => 'rocket-admin/products/brands/view/product-category',
                                        'use_route_match' => true,
                                        'pages' => array(
                                            array(
                                                'label'           => 'Add Brand Product Category',
                                                'route'           => 'rocket-admin/products/brands/view/product-category/create',
                                                'use_route_match' => true,
                                            ),
                                            array(
                                                'label'           => 'Edit Brand Product Category',
                                                'route'           => 'rocket-admin/products/brands/view/product-category/edit',
                                                'use_route_match' => true,
                                            ),
                                            array(
                                                'label'           => 'View Brand Product Category',
                                                'route'           => 'rocket-admin/products/brands/view/product-category/view',
                                                'use_route_match' => true,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'label' => 'Product Categories',
                        'route' => 'rocket-admin/products/product-categories',
                        'order' => 202,
                        'pages' => array(
                            array(
                                'label' => 'Create Product Category',
                                'route' => 'rocket-admin/products/product-categories/create',
                            ),
                            array(
                                'label'           => 'Edit Product Category',
                                'route'           => 'rocket-admin/products/product-categories/edit',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'View Product Category',
                                'route'           => 'rocket-admin/products/product-categories/view',
                                'use_route_match' => true,
                            ),
                        ),
                    ),
                    array(
                        'label' => 'Product Lines',
                        'route' => 'rocket-admin/products/product-lines',
                        'order' => 203,
                        'pages' => array(
                            array(
                                'label' => 'Create Product Line',
                                'route' => 'rocket-admin/products/product-lines/create',
                            ),
                            array(
                                'label'           => 'Edit Product Line',
                                'route'           => 'rocket-admin/products/product-lines/edit',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'View Product Line',
                                'route'           => 'rocket-admin/products/product-lines/view',
                                'use_route_match' => true,
                                'pages'           => array(
                                    array(
                                        'label'           => 'View Product Line Assets',
                                        'route'           => 'rocket-admin/products/product-lines/view/asset',
                                        'use_route_match' => true,
                                        'pages' => array(
                                            array(
                                                'label'           => 'Add Product Line Asset',
                                                'route'           => 'rocket-admin/products/product-lines/view/asset/create',
                                                'use_route_match' => true,
                                            ),
                                            array(
                                                'label'           => 'Edit Product Line Asset',
                                                'route'           => 'rocket-admin/products/product-lines/view/asset/edit',
                                                'use_route_match' => true,
                                            ),
                                            array(
                                                'label'           => 'View Product Line Asset',
                                                'route'           => 'rocket-admin/products/product-lines/view/asset/view',
                                                'use_route_match' => true,
                                            ),
                                        ),
                                    ),
                                    array(
                                        'label'           => 'View Product Line Features',
                                        'route'           => 'rocket-admin/products/product-lines/view/feature',
                                        'use_route_match' => true,
                                        'pages' => array(
                                            array(
                                                'label'           => 'Add Product Line Feature',
                                                'route'           => 'rocket-admin/products/product-lines/view/feature/create',
                                                'use_route_match' => true,
                                            ),
                                            array(
                                                'label'           => 'Edit Product Line Feature',
                                                'route'           => 'rocket-admin/products/product-lines/view/feature/edit',
                                                'use_route_match' => true,
                                            ),
                                            array(
                                                'label'           => 'View Product Line Feature',
                                                'route'           => 'rocket-admin/products/product-lines/view/feature/view',
                                                'use_route_match' => true,
                                            ),
                                        ),
                                    ),
                                    array(
                                        'label'           => 'View Parts',
                                        'route'           => 'rocket-admin/products/product-lines/view/parts',
                                        'use_route_match' => true,
                                    ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'label' => 'Parts',
                        'route' => 'rocket-admin/products/parts',
                        'order' => 204,
                        'pages' => array(
                            array(
                                'label'           => 'Upload Part Assets',
                                'route'           => 'rocket-admin/products/parts/upload',
                            ),
                            array(
                                'label'           => 'Process Part Assets',
                                'route'           => 'rocket-admin/products/parts/process',
                            ),
                            array(
                                'label'           => 'View Part',
                                'route'           => 'rocket-admin/products/parts/view',
                                'use_route_match' => true,
                                'pages'           => array(
                                    array(
                                        'label'           => 'View Part Assets',
                                        'route'           => 'rocket-admin/products/parts/view/asset',
                                        'use_route_match' => true,
                                        'pages' => array(
                                            array(
                                                'label'           => 'Add Part Asset',
                                                'route'           => 'rocket-admin/products/parts/view/asset/create',
                                                'use_route_match' => true,
                                            ),
                                            array(
                                                'label'           => 'Edit Part Asset',
                                                'route'           => 'rocket-admin/products/parts/view/asset/edit',
                                                'use_route_match' => true,
                                            ),
                                            array(
                                                'label'           => 'View Part Asset',
                                                'route'           => 'rocket-admin/products/parts/view/asset/view',
                                                'use_route_match' => true,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            array(
                                'label'           => 'View Part Vehicles',
                                'route'           => 'rocket-admin/products/parts/vehicles',
                                'use_route_match' => true,
                            ),
                        ),
                    ),
                    array(
                        'label' => 'Vehicles',
                        'route' => 'rocket-admin/products/vehicles',
                        'order' => 205,
                        'pages' => array(
                            array(
                                'label'           => 'View Vehicle Parts',
                                'route'           => 'rocket-admin/products/vehicles/parts',
                                'use_route_match' => true,
                            ),
                        ),
                    ),
                    array(
                        'label' => 'Product Reviews',
                        'route' => 'rocket-admin/products/product-reviews',
                        'order' => 206,
                        'pages' => array(
                            array(
                                'label' => 'Create Review',
                                'route' => 'rocket-admin/products/product-reviews/create',
                            ),
                            array(
                                'label'           => 'Edit Review',
                                'route'           => 'rocket-admin/products/product-reviews/edit',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'Approve Review',
                                'route'           => 'rocket-admin/products/product-reviews/approve',
                                'use_route_match' => true,
                            ),
                        ),
                    ),
                    array(
                        'label'      => 'Changesets',
                        'route'      => 'rocket-admin/products/changesets',
                        'permission' => 'LundProducts\Controller\Changesets:index',
                        'order'      => 207,
                        'pages'      => array(
                            array(
                                'label'           => 'View Changeset',
                                'route'           => 'rocket-admin/products/changesets/view',
                                'use_route_match' => true,
                                'permission'      => 'LundProducts\Controller\Changesets:view',
                                'pages'           => array(
                                    array(
                                        'label'           => 'View Changeset Vehicles',
                                        'route'           => 'rocket-admin/products/changesets/view/viewvehicles',
                                        'use_route_match' => true,
                                        'permission'      => 'LundProducts\Controller\Changesets:viewvehicles',
                                    )
                                ),
                            ),
                        ),
                    ),
                    array(
                        'label'      => 'File Logs',
                        'route'      => 'rocket-admin/products/file-log',
                        'permission' => 'LundProducts\Controller\FileLog:index',
                        'order'      => 208,
                    ),
                    array(
                        'label'      => 'Manage Comparison Chart',
                        'route'      => 'rocket-admin/lund/comparison-chart',
                        'permission' => 'LundSite\Controller\ComparisonChart:index',
                        'order'      => 209,
                        'pages'      => array(
                            array(
                                'label'           => 'Create Comparison Chart',
                                'route'           => 'rocket-admin/lund/comparison-chart/create',
                                'permission'      => 'LundSite\Controller\ComparisonChart:create',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'Edit Comparison Chart',
                                'route'           => 'rocket-admin/lund/comparison-chart/edit',
                                'permission'      => 'LundSite\Controller\ComparisonChart:edit',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'View Comparison Chart',
                                'route'           => 'rocket-admin/lund/comparison-chart/view',
                                'permission'      => 'LundSite\Controller\ComparisonChart:view',
                                'use_route_match' => true,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
