<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Service;

use LundSite\Entity\CustomerReviewInterface;
use Zend\EventManager\Event;

/**
 * CustomerReview events.
 */
class CustomerReviewEvent extends Event
{
    const EVENT_CUSTOMERREVIEW_CREATED = 'customerReviewCreated';
    const EVENT_CUSTOMERREVIEW_EDITED  = 'customerReviewEdited';
    const EVENT_CUSTOMERREVIEW_DELETED = 'customerReviewDeleted';

    /**
     * @var CustomerReviewInterface
     */
    protected $customerReview;

    /**
     * @param string               $name
     * @param CustomerReviewInterface $customerReview
     */
    public function __construct($name, CustomerReviewInterface $customerReview)
    {
        parent::__construct($name);
        $this->customerReview = $customerReview;
    }

    /**
     * @param  CustomerReviewInterface $customerReview
     * @return CustomerReviewEvent
     */
    public function setCustomerReview($customerReview)
    {
        $this->customerReview = $customerReview;

        return $this;
    }

    /**
     * @return CustomerReviewInterface
     */
    public function getCustomerReview()
    {
        return $this->customerReview;
    }
}
