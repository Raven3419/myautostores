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
        'LundCustomer\Form\CustomerForm'              		=> 'LundCustomer\Form\Factory\CustomerFormFactory',
        'LundCustomer\Form\Fieldset\CustomerFieldset' 		=> 'LundCustomer\Form\Fieldset\Factory\CustomerFieldsetFactory',
        'LundCustomer\Form\RetailerForm'              		=> 'LundCustomer\Form\Factory\RetailerFormFactory',
        'LundCustomer\Form\Fieldset\RetailerFieldset' 		=> 'LundCustomer\Form\Fieldset\Factory\RetailerFieldsetFactory',
    ),
);
