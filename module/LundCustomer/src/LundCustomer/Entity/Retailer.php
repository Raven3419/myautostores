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
 * Retailer
 *
 * @see RetailerInterface
 */
class Retailer implements RetailerInterface
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
     * @var \DateTime
     */
    protected $modifiedAt;

    /**
     * @var string
     */
    protected $modifiedBy;

    /**
     * @var boolean
     */
    protected $deleted;

    /**
     * @var boolean
     */
    protected $disabled;

    /**
     * @var string
     */
    protected $retailerType;

    /**
     * @var string
     */
    protected $companyName;

    /**
     * @var string
     */
    protected $streetAddress;

    /**
     * @var string
     */
    protected $extStreetAddress;

    /**
     * @var string
     */
    protected $locality;

    /**
     * @var string
     */
    protected $postCode;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $latitude;

    /**
     * @var string
     */
    protected $longitude;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var boolean
     */
    protected $discount;

    /**
     * @var string
     */
    protected $discountCopy;

    /**
     * @var string
     */
    protected $discountUrl;

    /**
     * @var integer
     */
    protected $retailerId;

    /**
     * @var \RocketBase\Entity\State
     */
    protected $region;

    /**
     * @var \RocketBase\Entity\Country
     */
    protected $country;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $logoAsset;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $discountAsset;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $poiAsset;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $brand;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $shipsCountry;

    /**
     * @var string
     */
    protected $customerOrDealer;

    /**
     * @var \LundCustomer\Entity\Customer
     */
    protected $customerId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->brand = new \Doctrine\Common\Collections\ArrayCollection();
        $this->shipsCountry = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Retailer
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
     * @param  string   $createdBy
     * @return Retailer
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
     * Set modifiedAt
     *
     * @param  \DateTime $modifiedAt
     * @return Retailer
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set modifiedBy
     *
     * @param  string   $modifiedBy
     * @return Retailer
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return string
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Set deleted
     *
     * @param  boolean  $deleted
     * @return Retailer
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set disabled
     *
     * @param  boolean  $disabled
     * @return Retailer
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set retailerType
     *
     * @param  string   $retailerType
     * @return Retailer
     */
    public function setRetailerType($retailerType)
    {
        $this->retailerType = $retailerType;

        return $this;
    }

    /**
     * Get retailerType
     *
     * @return string
     */
    public function getRetailerType()
    {
        return $this->retailerType;
    }

    /**
     * Set companyName
     *
     * @param  string   $companyName
     * @return Retailer
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set streetAddress
     *
     * @param  string   $streetAddress
     * @return Retailer
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * Get streetAddress
     *
     * @return string
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * Set extStreetAddress
     *
     * @param  string   $extStreetAddress
     * @return Retailer
     */
    public function setExtStreetAddress($extStreetAddress)
    {
        $this->extStreetAddress = $extStreetAddress;

        return $this;
    }

    /**
     * Get extStreetAddress
     *
     * @return string
     */
    public function getExtStreetAddress()
    {
        return $this->extStreetAddress;
    }

    /**
     * Set locality
     *
     * @param  string   $locality
     * @return Retailer
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set postCode
     *
     * @param  string   $postCode
     * @return Retailer
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set phoneNumber
     *
     * @param  string   $phoneNumber
     * @return Retailer
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set latitude
     *
     * @param  string   $latitude
     * @return Retailer
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param  string   $longitude
     * @return Retailer
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set website
     *
     * @param  string   $website
     * @return Retailer
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set discount
     *
     * @param  boolean  $discount
     * @return Retailer
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return boolean
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set discountCopy
     *
     * @param  string   $discountCopy
     * @return Retailer
     */
    public function setDiscountCopy($discountCopy)
    {
        $this->discountCopy = $discountCopy;

        return $this;
    }

    /**
     * Get discountCopy
     *
     * @return string
     */
    public function getDiscountCopy()
    {
        return $this->discountCopy;
    }

    /**
     * Set discountUrl
     *
     * @param  string   $discountUrl
     * @return Retailer
     */
    public function setDiscountUrl($discountUrl)
    {
        $this->discountUrl = $discountUrl;

        return $this;
    }

    /**
     * Get discountUrl
     *
     * @return string
     */
    public function getDiscountUrl()
    {
        return $this->discountUrl;
    }

    /**
     * Get retailerId
     *
     * @return integer
     */
    public function getRetailerId()
    {
        return $this->retailerId;
    }

    /**
     * Set region
     *
     * @param  \RocketBase\Entity\State $region
     * @return Retailer
     */
    public function setRegion(\RocketBase\Entity\State $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \RocketBase\Entity\State
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set country
     *
     * @param  \RocketBase\Entity\Country $country
     * @return Retailer
     */
    public function setCountry(\RocketBase\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \RocketBase\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set logoAsset
     *
     * @param  \RocketDam\Entity\Asset $logoAsset
     * @return Retailer
     */
    public function setLogoAsset(\RocketDam\Entity\Asset $logoAsset = null)
    {
        $this->logoAsset = $logoAsset;

        return $this;
    }

    /**
     * Get logoAsset
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getLogoAsset()
    {
        return $this->logoAsset;
    }

    /**
     * Set discountAsset
     *
     * @param  \RocketDam\Entity\Asset $discountAsset
     * @return Retailer
     */
    public function setDiscountAsset(\RocketDam\Entity\Asset $discountAsset = null)
    {
        $this->discountAsset = $discountAsset;

        return $this;
    }

    /**
     * Get discountAsset
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getDiscountAsset()
    {
        return $this->discountAsset;
    }

    /**
     * Set poiAsset
     *
     * @param  \RocketDam\Entity\Asset $poiAsset
     * @return Retailer
     */
    public function setPoiAsset(\RocketDam\Entity\Asset $poiAsset = null)
    {
        $this->poiAsset = $poiAsset;

        return $this;
    }

    /**
     * Get poiAsset
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getPoiAsset()
    {
        return $this->poiAsset;
    }

    /**
     * Add brand
     *
     * @param  \LundProducts\Entity\Brands $brand
     * @return Retailer
     */
    public function addBrand(\LundProducts\Entity\Brands $brand)
    {
        $this->brand[] = $brand;

        return $this;
    }

    /**
     * Remove brand
     *
     * @param \LundProducts\Entity\Brands $brand
     */
    public function removeBrand(\LundProducts\Entity\Brands $brand)
    {
        $this->brand->removeElement($brand);
    }

    /**
     * Get brand
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add shipsCountry
     *
     * @param  \RocketBase\Entity\Country $shipsCountry
     * @return Retailer
     */
    public function addShipsCountry(\RocketBase\Entity\Country $shipsCountry)
    {
        $this->shipsCountry[] = $shipsCountry;

        return $this;
    }

    /**
     * Remove shipsCountry
     *
     * @param \RocketBase\Entity\Country $shipsCountry
     */
    public function removeShipsCountry(\RocketBase\Entity\Country $shipsCountry)
    {
        $this->shipsCountry->removeElement($shipsCountry);
    }

    /**
     * Get shipsCountry
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShipsCountry()
    {
        return $this->shipsCountry;
    }

    /**
     * Set customerOrDealer
     *
     * @param  string   $customerOrDealer
     * @return Customer
     */
    public function setCustomerOrDealer($customerOrDealer)
    {
        $this->customerOrDealer = $customerOrDealer;

        return $this;
    }

    /**
     * Get customerOrDealer
     *
     * @return string
     */
    public function getCustomerOrDealer()
    {
        return $this->customerOrDealer;
    }
    
    


    /**
     * Set customerId
     *
     * @param  string   $customerId
     * @return Customer
     */
    public function setCustomerId(\LundCustomer\Entity\Customer $customerId)
    {
    	$this->customerId = $customerId;
    
    	return $this;
    }
    
    /**
     * Get customerOrDealer
     *
     * @return string
     */
    public function getCustomerId()
    {
    	return $this->customerId;
    }
}
