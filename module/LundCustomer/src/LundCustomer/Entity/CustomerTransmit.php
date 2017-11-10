<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Entity
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
class CustomerTransmit implements CustomerTransmitInterface
{
    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $createdBy;

    /**
     * @var integer
     */
    protected $transmitId;

    /**
     * @var \LundCustomer\Entity\Customer
     */
    protected $customer;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $asset;

    /**
     * @var \LundProducts\Entity\Brands
     */
    protected $brand;

    /**
     * Set createdAt
     *
     * @param  \DateTime        $createdAt
     * @return CustomerTransmit
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param  string           $createdBy
     * @return CustomerTransmit
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Get transmitId
     *
     * @return integer
     */
    public function getTransmitId()
    {
        return $this->transmitId;
    }

    /**
     * Set customer
     *
     * @param  \LundCustomer\Entity\Customer $customer
     * @return CustomerTransmit
     */
    public function setCustomer(\LundCustomer\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \LundCustomer\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set asset
     *
     * @param  \RocketDam\Entity\Asset $asset
     * @return CustomerTransmit
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null)
    {
        $this->asset = $asset;

        return $this;
    }

    /**
     * Get asset
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * Set brand
     *
     * @param  \LundProducts\Entity\Brands $brand
     * @return CustomerTransmit
     */
    public function setBrand(\LundProducts\Entity\Brands $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \LundProducts\Entity\Brands
     */
    public function getBrand()
    {
        return $this->brand;
    }
}
