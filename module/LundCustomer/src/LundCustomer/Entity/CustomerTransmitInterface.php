<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer\Entity;

/**
 * CustomerTransmit
 *
 * @see CustomerTransmitInterface
 */
interface CustomerTransmitInterface
{
    /**
     * @param  \DateTime        $createdAt
     * @return CustomerTransmit
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string           $createdBy
     * @return CustomerTransmit
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @return integer
     */
    public function getTransmitId();

    /**
     * @param  \LundCustomer\Entity\Customer $customer
     * @return CustomerTransmit
     */
    public function setCustomer(\LundCustomer\Entity\Customer $customer = null);

    /**
     * @return \LundCustomer\Entity\Customer
     */
    public function getCustomer();

    /**
     * @param  \RocketDam\Entity\Asset $asset
     * @return CustomerTransmit
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();

    /**
     * @param  \LundProducts\Entity\Brands $brand
     * @return CustomerTransmit
     */
    public function setBrand(\LundProducts\Entity\Brands $brand = null);

    /**
     * @return \LundProducts\Entity\Brands
     */
    public function getBrand();
}
