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
    'navigation' => array(
        'admin' => array(
            array(
                'label'      => 'Accounts',
                'route'      => 'rocket-admin/accounts',
                'permission' => 'LundCustomer\Controller\Customer:index',
                'icon'       => 'icon-user',
                'order'      => 500,
                'pages'      => array(
                    array(
                        'label'      => 'Customers',
                        'route'      => 'rocket-admin/accounts/customer',
                        'permission' => 'LundCustomer\Controller\Customer:index',
                        'order'      => 501,
                        'pages'      => array(
                            array(
                                'label'           => 'Create Customer',
                                'route'           => 'rocket-admin/accounts/customer/create',
                                'permission'      => 'LundCustomer\Controller\Customer:create',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'Edit Customer',
                                'route'           => 'rocket-admin/accounts/customer/edit',
                                'permission'      => 'LundCustomer\Controller\Customer:edit',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'View Customer',
                                'route'           => 'rocket-admin/accounts/customer/view',
                                'permission'      => 'LundCustomer\Controller\Customer:view',
                                'use_route_match' => true,
                            ),
                        ),
                    ),
                    array(
                        'label'      => 'Retailers',
                        'route'      => 'rocket-admin/accounts/retailer',
                        'permission' => 'LundCustomer\Controller\Retailer:index',
                        'order'      => 502,
                        'pages'      => array(
                            array(
                                'label'           => 'Create Retailer',
                                'route'           => 'rocket-admin/accounts/retailer/create',
                                'permission'      => 'LundCustomer\Controller\Retailer:create',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'Edit Retailer',
                                'route'           => 'rocket-admin/accounts/retailer/edit',
                                'permission'      => 'LundCustomer\Controller\Retailer:edit',
                                'use_route_match' => true,
                            ),
                            array(
                                'label'           => 'View Retailer',
                                'route'           => 'rocket-admin/accounts/retailer/view',
                                'permission'      => 'LundCustomer\Controller\Retailer:view',
                                'use_route_match' => true,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
