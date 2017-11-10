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
    'router' => array(
        'routes' => array(
            'rocket-admin' => array(
                'child_routes' => array(
                    'order-system' => array(
                        'child_routes'  => array(
                            'order' => array(
                                'child_routes' => array(
                                    'view' => array(
                                        'child_routes'  => array(
                                            'order-item' => array(
                                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                'options' => array(
                                                    'route'    => '/order-item',
                                                    'defaults' => array(
                                                        'controller' => 'LundProducts\Controller\OrderItem',
                                                        'action'     => 'index',
                                                    ),
                                                ),
                                                'may_terminate' => true,
                                                'child_routes'  => array(
                                                    'create' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                        'options' => array(
                                                            'route'   => '/create',
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\OrderItem',
                                                                'action'     => 'create',
                                                            ),
                                                        ),
                                                    ),
                                                    'edit' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'       => '/edit/:orderitemid',
                                                            'constraints' => array(
                                                                'orderitemid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\OrderItem',
                                                                'action'     => 'edit',
                                                                'orderitemid'   => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'delete' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'       => '/delete/:orderitemid',
                                                            'constraints' => array(
                                                                'orderitemid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\OrderItem',
                                                                'action'     => 'delete',
                                                                'orderitemid'   => 0,
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'imagine' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/imagine/:hash/:width/:height',
                            'constraints' => array(
                                'hash' => '[a-zA-Z0-9\-_|]*',
                                'width' => '[0-9]*',
                                'height' => '[0-9]*',
                            ),
                            'defaults' => array(
                                'controller' => 'LundProducts\Controller\Imagine',
                                'action' => 'index',
                                'hash' => 0,
                                'width' => 0,
                                'height' => 0,
                            ),
                        ),
                    ),
                    'products' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/products',
                            'defaults' => array(
                                'controller' => 'LundProducts\Controller\Changesets',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes'  => array(
                            'brands' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/brands',
                                    'defaults' => array(
                                        'controller' => 'LundProducts\Controller\Brands',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundProducts\Controller\Brands',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Brands',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Brands',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Brands',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                        'may_terminate' => true,
                                        'child_routes' => array(
                                            'product-category' => array(
                                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                'options' => array(
                                                    'route'    => '/productcategory',
                                                    'defaults' => array(
                                                        'controller' => 'LundProducts\Controller\BrandProductCategory',
                                                        'action'     => 'index',
                                                    ),
                                                ),
                                                'may_terminate' => true,
                                                'child_routes' => array(
                                                    'create' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                        'options' => array(
                                                            'route'   => '/create',
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\BrandProductCategory',
                                                                'action'     => 'create',
                                                            ),
                                                        ),
                                                    ),
                                                    'edit' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/edit/:brandproductcategoryid',
                                                            'constraints' => array(
                                                                'brandproductcategoryid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\BrandProductCategory',
                                                                'action'     => 'edit',
                                                                'brandproductcategoryid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'view' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/view/:brandproductcategoryid',
                                                            'constraints' => array(
                                                                'brandproductcategoryid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\BrandProductCategory',
                                                                'action'     => 'view',
                                                                'brandproductcategoryid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'delete' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/delete/:brandproductcategoryid',
                                                            'constraints' => array(
                                                                'brandproductcategoryid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\BrandProductCategory',
                                                                'action'     => 'delete',
                                                                'brandproductcategoryid' => 0,
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'product-categories' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/productcategories',
                                    'defaults' => array(
                                        'controller' => 'LundProducts\Controller\ProductCategories',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundProducts\Controller\ProductCategories',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\ProductCategories',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\ProductCategories',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\ProductCategories',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'product-lines' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/productlines',
                                    'defaults' => array(
                                        'controller' => 'LundProducts\Controller\ProductLines',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundProducts\Controller\ProductLines',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\ProductLines',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\ProductLines',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\ProductLines',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                        'may_terminate' => true,
                                        'child_routes' => array(
                                            'asset' => array(
                                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                'options' => array(
                                                    'route'    => '/asset',
                                                    'defaults' => array(
                                                        'controller' => 'LundProducts\Controller\ProductLineAsset',
                                                        'action'     => 'index',
                                                    ),
                                                ),
                                                'may_terminate' => true,
                                                'child_routes' => array(
                                                    'create' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                        'options' => array(
                                                            'route'   => '/create',
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineAsset',
                                                                'action'     => 'create',
                                                            ),
                                                        ),
                                                    ),
                                                    'edit' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/edit/:productlineassetid',
                                                            'constraints' => array(
                                                                'productlineassetid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineAsset',
                                                                'action'     => 'edit',
                                                                'productlineassetid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'view' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/view/:productlineassetid',
                                                            'constraints' => array(
                                                                'productlineassetid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineAsset',
                                                                'action'     => 'view',
                                                                'productlineassetid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'delete' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/delete/:productlineassetid',
                                                            'constraints' => array(
                                                                'productlineassetid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineAsset',
                                                                'action'     => 'delete',
                                                                'productlineassetid' => 0,
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'feature' => array(
                                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                'options' => array(
                                                    'route'    => '/feature',
                                                    'defaults' => array(
                                                        'controller' => 'LundProducts\Controller\ProductLineFeature',
                                                        'action'     => 'index',
                                                    ),
                                                ),
                                                'may_terminate' => true,
                                                'child_routes' => array(
                                                    'create' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                        'options' => array(
                                                            'route'   => '/create',
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineFeature',
                                                                'action'     => 'create',
                                                            ),
                                                        ),
                                                    ),
                                                    'edit' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/edit/:productlinefeatureid',
                                                            'constraints' => array(
                                                                'productlinefeatureid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineFeature',
                                                                'action'     => 'edit',
                                                                'productlinefeatureid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'view' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/view/:productlinefeatureid',
                                                            'constraints' => array(
                                                                'productlinefeatureid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineFeature',
                                                                'action'     => 'view',
                                                                'productlinefeatureid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'delete' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/delete/:productlinefeatureid',
                                                            'constraints' => array(
                                                                'productlinefeatureid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineFeature',
                                                                'action'     => 'delete',
                                                                'productlinefeatureid' => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'rank-up' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/rank-up/:productlinefeatureid',
                                                            'constraints' => array(
                                                                'productlinefeatureid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineFeature',
                                                                'action'     => 'rank-up',
                                                                'productlinefeatureid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'rank-down' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/rank-down/:productlinefeatureid',
                                                            'constraints' => array(
                                                                'productlinefeatureid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\ProductLineFeature',
                                                                'action'     => 'rank-down',
                                                                'productlinefeatureid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'parts' => array(
                                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                'options' => array(
                                                    'route'    => '/parts',
                                                    'defaults' => array(
                                                        'controller' => 'LundProducts\Controller\ProductLines',
                                                        'action'     => 'parts',
                                                    ),
                                                ),
                                                'may_terminate' => true,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'file-log' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/filelog',
                                    'defaults' => array(
                                        'controller' => 'LundProducts\Controller\FileLog',
                                        'action'     => 'index',
                                    ),
                                ),
                            ),
                            'changesets' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/changesets',
                                    'defaults' => array(
                                        'controller' => 'LundProducts\Controller\Changesets',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Changesets',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                        'may_terminate' => true,
                                        'child_routes' => array(
                                           'viewvehicles' => array(
                                                'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                'options' => array(
                                                    'route'       => '/viewvehicles/:changesetdetailid',
                                                    'constraints' => array(
                                                        'changesetdetailid' => '[0-9]*',
                                                    ),
                                                    'defaults'    => array(
                                                        'controller'        => 'LundProducts\Controller\Changesets',
                                                        'action'            => 'viewvehicles',
                                                        'changesetdetailid' => 0,
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                    'approve' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/approve/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Changesets',
                                                'action'     => 'approve',
                                                'id'         => 0,
                                            ),
                                        ),
                                        'may_terminate' => true,
                                    ),
                                    'deploy' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/deploy/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Changesets',
                                                'action'     => 'deploy',
                                                'id'         => 0,
                                            ),
                                        ),
                                        'may_terminate' => true,
                                    ),
                                    'deny' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/deny/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Changesets',
                                                'action'     => 'deny',
                                                'id'         => 0,
                                            ),
                                        ),
                                        'may_terminate' => true,
                                    ),
                                ),
                            ),
                            'parts' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/parts',
                                    'defaults' => array(
                                        'controller' => 'LundProducts\Controller\Parts',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'upload' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/upload',
                                            'defaults' => array(
                                                'controller' => 'LundProducts\Controller\Parts',
                                                'action'     => 'upload',
                                            ),
                                        ),
                                    ),
                                    'process' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/process',
                                            'defaults' => array(
                                                'controller' => 'LundProducts\Controller\Parts',
                                                'action'     => 'process',
                                            ),
                                        ),
                                    ),
                                    'disable' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/disable/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Parts',
                                                'action'     => 'disable',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Parts',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                        'may_terminate' => true,
                                        'child_routes' => array(
                                            'asset' => array(
                                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                'options' => array(
                                                    'route'    => '/asset',
                                                    'defaults' => array(
                                                        'controller' => 'LundProducts\Controller\PartAsset',
                                                        'action'     => 'index',
                                                    ),
                                                ),
                                                'may_terminate' => true,
                                                'child_routes' => array(
                                                    'create' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                        'options' => array(
                                                            'route'   => '/create',
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\PartAsset',
                                                                'action'     => 'create',
                                                            ),
                                                        ),
                                                    ),
                                                    'edit' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/edit/:partassetid',
                                                            'constraints' => array(
                                                                'partassetid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\PartAsset',
                                                                'action'     => 'edit',
                                                                'partassetid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'view' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/view/:partassetid',
                                                            'constraints' => array(
                                                                'partassetid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\PartAsset',
                                                                'action'     => 'view',
                                                                'partassetid'    => 0,
                                                            ),
                                                        ),
                                                    ),
                                                    'delete' => array(
                                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                                        'options' => array(
                                                            'route'   => '/delete/:partassetid',
                                                            'constraints' => array(
                                                                'partassetid' => '[0-9]*',
                                                            ),
                                                            'defaults' => array(
                                                                'controller' => 'LundProducts\Controller\PartAsset',
                                                                'action'     => 'delete',
                                                                'partassetid' => 0,
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                    'vehicles' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/vehicles/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controlers' => 'LundProducts\Controller\Parts',
                                                'action'     => 'vehicles',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'vehicles' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/vehicles',
                                    'defaults' => array(
                                        'controller' => 'LundProducts\Controller\Vehicles',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'parts' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/parts/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\Vehicles',
                                                'action'     => 'parts',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'product-reviews' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/productreviews',
                                    'defaults' => array(
                                        'controller' => 'LundProducts\Controller\ProductReviews',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundProducts\Controller\ProductReviews',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\ProductReviews',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\ProductReviews',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'approve' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/approve/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundProducts\Controller\ProductReviews',
                                                'action'     => 'approve',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'parse-master' => array(
                    'options' => array(
                        'route'    => 'parse master <filename> [<from_iteration>] [<to_iteration>]',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parsemaster'
                        )
                    )
                ),
                'parse-supplement' => array(
                    'options' => array(
                        'route'    => 'parse supplement <filename>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parsesupplement'
                        )
                    )
                ),
                'parse-sdcpies' => array(
                    'options' => array(
                        'route'    => 'parse sdcpies <filename>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parsesdcpies'
                        )
                    )
                ),
                'parse-sdcaces' => array(
                    'options' => array(
                        'route'    => 'parse sdcaces <filename>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parsesdcaces'
                        )
                    )
                ),
                'parse-promo' => array(
                    'options' => array(
                        'route'    => 'parse promo <filename>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parsepromo'
                        )
                    )
                ),
                'parse-assetmigration' => array(
                    'options' => array(
                        'route'    => 'parse assetmigration [<brand>] <filename>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parseassetmigration'
                        )
                    )
                ),
                'parse-copymigration' => array(
                    'options' => array(
                        'route'    => 'parse copymigration [<brand>] <filename>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parsecopymigration'
                        )
                    )
                ),
                'parse-plassetmigration' => array(
                    'options' => array(
                        'route'    => 'parse plassetmigration [<brand>] <filename>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parseplassetmigration'
                        )
                    )
                ),
                'parse-reviewmigration' => array(
                    'options' => array(
                        'route'    => 'parse reviewmigration <filename>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parsereviewmigration'
                        )
                    )
                ),
                'monitor-supplement' => array(
                    'options' => array(
                        'route'    => 'monitor supplement <dirname>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Monitor',
                            'action'     => 'monitorsupplement'
                        )
                    )
                ),
                'monitor-sdcpies' => array(
                    'options' => array(
                        'route'    => 'monitor sdcpies <dirname>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Monitor',
                            'action'     => 'monitorsdcpies'
                        )
                    )
                ),
                'monitor-sdcaces' => array(
                    'options' => array(
                        'route'    => 'monitor sdcaces <dirname>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Monitor',
                            'action'     => 'monitorsdcaces'
                        )
                    )
                ),
                'monitor-promo' => array(
                    'options' => array(
                        'route'    => 'monitor promo <dirname>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Monitor',
                            'action'     => 'monitorpromo'
                        )
                    )
                ),
                'monitor-master' => array(
                    'options' => array(
                        'route'    => 'monitor master <dirname>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Monitor',
                            'action'     => 'monitormaster'
                        )
                    )
                ),
                'monitor-assets' => array(
                    'options' => array(
                        'route'    => 'monitor assets <dirname>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Monitor',
                            'action'     => 'monitorassets'
                        )
                    )
                ),
                'parse-assets' => array(
                    'options' => array(
                        'route'    => 'parse assets <dirname>',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Parse',
                            'action'     => 'parseassets'
                        )
                    )
                ),
                'generate-amazon' => array(
                    'options' => array(
                        'route'    => 'generate amazon [<brand>] (full|incr):generate [<changeset_id>]',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Generate',
                            'action'     => 'generateamazon'
                        )
                    )
                ),
                'generate-customer' => array(
                    'options' => array(
                        'route'    => 'generate customer [<brand>] (full|incr):generate [<changeset_id>]',
                        'defaults' => array(
                            'controller' => 'LundProducts\Controller\Generate',
                            'action'     => 'generatecustomer'
                        )
                    )
                ),
            ),
        ),
    ),
);
