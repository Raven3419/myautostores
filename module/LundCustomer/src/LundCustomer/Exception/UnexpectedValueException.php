<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Exception
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundCustomer\Exception;

class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface
{
    /**
    * @param mixed $customer
    * @return UnexpectedValueException
    */
    public static function invalidCustomerEntity($customer)
    {
        return new static(
            sprintf(
                '%s does not implement LundCustomer\Entity\CustomerInterface',
                is_object($customer) ? get_class($customer) : gettype($customer)
            )
        );
    }

    /**
    * @param mixed $customerTransmit
    * @return UnexpectedValueException
    */
    public static function invalidCustomerTransmitEntity($customerTransmit)
    {
        return new static(
            sprintf(
                '%s does not implement LundCustomer\Entity\CustomerTransmitInterface',
                is_object($customerTransmit) ? get_class($customerTransmit) : gettype($customerTransmit)
            )
        );
    }

    /**
    * @param mixed $retailer
    * @return UnexpectedValueException
    */
    public static function invalidRetailerEntity($retailer)
    {
        return new static(
            sprintf(
                '%s does not implement LundCustomer\Entity\RetailerInterface',
                is_object($retailer) ? get_class($retailer) : gettype($retailer)
            )
        );
    }
}
