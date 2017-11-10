<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundCustomer\Service;

use LundCustomer\Entity\CustomerInterface;
use Zend\EventManager\Event;

/**
 * Customer events.
 */
class CustomerEvent extends Event
{
    const EVENT_CUSTOMER_CREATED = 'customerCreated';
    const EVENT_CUSTOMER_EDITED  = 'customerEdited';
    const EVENT_CUSTOMER_DELETED = 'customerDeleted';

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @param string            $name
     * @param CustomerInterface $customer
     */
    public function __construct($name, CustomerInterface $customer)
    {
        parent::__construct($name);
        $this->customer = $customer;
    }

    /**
     * @param  CustomerInterface $customer
     * @return CustomerEvent
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
