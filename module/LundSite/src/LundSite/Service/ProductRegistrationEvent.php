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

use LundSite\Entity\ProductRegistrationInterface;
use Zend\EventManager\Event;

/**
 * ProductRegistration events.
 */
class ProductRegistrationEvent extends Event
{
    const EVENT_PRODUCTREGISTRATION_CREATED = 'productRegistrationCreated';
    const EVENT_PRODUCTREGISTRATION_EDITED  = 'productRegistrationEdited';
    const EVENT_PRODUCTREGISTRATION_DELETED = 'productRegistrationDeleted';

    /**
     * @var ProductRegistrationInterface
     */
    protected $productRegistration;

    /**
     * @param string               $name
     * @param ProductRegistrationInterface $productRegistration
     */
    public function __construct($name, ProductRegistrationInterface $productRegistration)
    {
        parent::__construct($name);
        $this->productRegistration = $productRegistration;
    }

    /**
     * @param  ProductRegistrationInterface $productRegistration
     * @return ProductRegistrationEvent
     */
    public function setProductRegistration($productRegistration)
    {
        $this->productRegistration = $productRegistration;

        return $this;
    }

    /**
     * @return ProductRegistrationInterface
     */
    public function getProductRegistration()
    {
        return $this->productRegistration;
    }
}
