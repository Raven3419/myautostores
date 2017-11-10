<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Config
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer;

return array(
    'router' => array(
        'routes' => array(
            'rocket-admin' => array(
                'child_routes' => array(
                    'accounts' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/accounts',
                            'defaults' => array(
                                'controller' => 'LundCustomer\Controller\Customer',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes'  => array(
                            'customer' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/customer',
                                    'defaults' => array(
                                        'controller' => 'LundCustomer\Controller\Customer',
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
                                                'controller' => 'LundCustomer\Controller\Customer',
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
                                                'controller' => 'LundCustomer\Controller\Customer',
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
                                                'controller' => 'LundCustomer\Controller\Customer',
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
                                                'controller' => 'LundCustomer\Controller\Customer',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                        'may_terminate' => true,
                                        'child_routes' => array(
                                            'transmission' => array(
                                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                                'options' => array(
                                                    'route'    => '/transmission',
                                                    'defaults' => array(
                                                        'controller' => 'LundCustomer\Controller\Transmit',
                                                        'action'     => 'customer',
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                    'transmit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/transmit',
                                            'defaults' => array(
                                                'controller' => 'LundCustomer\Controller\Transmit',
                                                'action'     => 'index',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'retailer' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/retailer',
                                    'defaults' => array(
                                        'controller' => 'LundCustomer\Controller\Retailer',
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
                                                'controller' => 'LundCustomer\Controller\Retailer',
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
                                                'controller' => 'LundCustomer\Controller\Retailer',
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
                                                'controller' => 'LundCustomer\Controller\Retailer',
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
                                                'controller' => 'LundCustomer\Controller\Retailer',
                                                'action'     => 'view',
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
                'parse-customer' => array(
                    'options' => array(
                        'route'    => 'parse customer <filename>',
                        'defaults' => array(
                            'controller' => 'LundCustomer\Controller\Parse',
                            'action'     => 'parsecustomer'
                        )
                    )
                ),
                'monitor-customer' => array(
                    'options' => array(
                        'route'    => 'monitor customer <dirname>',
                        'defaults' => array(
                            'controller' => 'LundCustomer\Controller\Monitor',
                            'action'     => 'monitorcustomer',
                        )
                    )
                ),
                'transmit-customer' => array(
                    'options' => array(
                        'route'    => 'transmit customer <frequency>',
                        'defaults' => array(
                            'controller' => 'LundCustomer\Controller\Transmit',
                            'action'     => 'transmitcustomer',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
