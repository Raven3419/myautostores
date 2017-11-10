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

use LundCustomer\Entity\RetailerInterface;
use Zend\EventManager\Event;

/**
 * Retailer events.
 */
class RetailerEvent extends Event
{
    const EVENT_RETAILER_CREATED = 'retailerCreated';
    const EVENT_RETAILER_EDITED  = 'retailerEdited';
    const EVENT_RETAILER_DELETED = 'retailerDeleted';

    /**
     * @var RetailerInterface
     */
    protected $retailer;

    /**
     * @param string            $name
     * @param RetailerInterface $retailer
     */
    public function __construct($name, RetailerInterface $retailer)
    {
        parent::__construct($name);
        $this->retailer = $retailer;
    }

    /**
     * @param  RetailerInterface $retailer
     * @return RetailerEvent
     */
    public function setRetailer($retailer)
    {
        $this->retailer = $retailer;

        return $this;
    }

    /**
     * @return RetailerInterface
     */
    public function getRetailer()
    {
        return $this->retailer;
    }
}
