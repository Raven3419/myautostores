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
    'factories' => array(
        'LundCustomer\Controller\Customer' 		=> 'LundCustomer\Controller\Factory\CustomerControllerFactory',
        'LundCustomer\Controller\Parse'    		=> 'LundCustomer\Controller\Factory\ParseControllerFactory',
        'LundCustomer\Controller\Transmit' 		=> 'LundCustomer\Controller\Factory\TransmitControllerFactory',
        'LundCustomer\Controller\Monitor'  		=> 'LundCustomer\Controller\Factory\MonitorControllerFactory',
        'LundCustomer\Controller\Retailer' 		=> 'LundCustomer\Controller\Factory\RetailerControllerFactory',
    ),
);
