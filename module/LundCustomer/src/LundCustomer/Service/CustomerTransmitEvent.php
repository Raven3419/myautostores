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

use LundCustomer\Entity\CustomerTransmitInterface;
use Zend\EventManager\Event;

/**
 * CustomerTransmit events.
 */
class CustomerTransmitEvent extends Event
{
    const EVENT_CUSTOMERTRANSMIT_CREATED = 'customerTransmitCreated';

    /**
     * @var CustomerTransmitInterface
     */
    protected $customerTransmit;

    /**
     * @param string                    $name
     * @param CustomerTransmitInterface $customerTransmit
     */
    public function __construct($name, CustomerTransmitInterface $customerTransmit)
    {
        parent::__construct($name);
        $this->customerTransmit = $customerTransmit;
    }

    /**
     * @param  CustomerTransmitInterface $customerTransmit
     * @return CustomerTransmitEvent
     */
    public function setCustomerTransmit($customerTransmit)
    {
        $this->customerTransmit = $customerTransmit;

        return $this;
    }

    /**
     * @return CustomerTransmitInterface
     */
    public function getCustomerTransmit()
    {
        return $this->customerTransmit;
    }
}
