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
 * Retailer Interface
 */
interface RetailerInterface
{
    /**
     * @param  \DateTime $createdAt
     * @return Retailer
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string   $createdBy
     * @return Retailer
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime $modifiedAt
     * @return Retailer
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string   $modifiedBy
     * @return Retailer
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean  $deleted
     * @return Retailer
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean  $disabled
     * @return Retailer
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string   $retailerType
     * @return Retailer
     */
    public function setRetailerType($retailerType);

    /**
     * @return string
     */
    public function getRetailerType();

    /**
     * @param  string   $companyName
     * @return Retailer
     */
    public function setCompanyName($companyName);

    /**
     * @return string
     */
    public function getCompanyName();

    /**
     * @param  string   $streetAddress
     * @return Retailer
     */
    public function setStreetAddress($streetAddress);

    /**
     * @return string
     */
    public function getStreetAddress();

    /**
     * @param  string   $extStreetAddress
     * @return Retailer
     */
    public function setExtStreetAddress($extStreetAddress);

    /**
     * @return string
     */
    public function getExtStreetAddress();

    /**
     * @param  string   $locality
     * @return Retailer
     */
    public function setLocality($locality);

    /**
     * @return string
     */
    public function getLocality();

    /**
     * @param  string   $postCode
     * @return Retailer
     */
    public function setPostCode($postCode);

    /**
     * @return string
     */
    public function getPostCode();

    /**
     * @param  string   $phoneNumber
     * @return Retailer
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * @return string
     */
    public function getPhoneNumber();

    /**
     * @param  string   $latitude
     * @return Retailer
     */
    public function setLatitude($latitude);

    /**
     * @return string
     */
    public function getLatitude();

    /**
     * @param  string   $longitude
     * @return Retailer
     */
    public function setLongitude($longitude);

    /**
     * @return string
     */
    public function getLongitude();

    /**
     * @param  string   $website
     * @return Retailer
     */
    public function setWebsite($website);

    /**
     * @return string
     */
    public function getWebsite();

    /**
     * @param  boolean  $discount
     * @return Retailer
     */
    public function setDiscount($discount);

    /**
     * @return boolean
     */
    public function getDiscount();

    /**
     * @param  string   $discountCopy
     * @return Retailer
     */
    public function setDiscountCopy($discountCopy);

    /**
     * @return string
     */
    public function getDiscountCopy();

    /**
     * @param  string   $discountUrl
     * @return Retailer
     */
    public function setDiscountUrl($discountUrl);

    /**
     * @return string
     */
    public function getDiscountUrl();

    /**
     * @return integer
     */
    public function getRetailerId();

    /**
     * @param  \RocketBase\Entity\State $region
     * @return Retailer
     */
    public function setRegion(\RocketBase\Entity\State $region = null);

    /**
     * @return \RocketBase\Entity\State
     */
    public function getRegion();

    /**
     * @param  \RocketBase\Entity\Country $country
     * @return Retailer
     */
    public function setCountry(\RocketBase\Entity\Country $country = null);

    /**
     * @return \RocketBase\Entity\Country
     */
    public function getCountry();

    /**
     * @param  \RocketDam\Entity\Asset $logoAsset
     * @return Retailer
     */
    public function setLogoAsset(\RocketDam\Entity\Asset $logoAsset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getLogoAsset();

    /**
     * @param  \RocketDam\Entity\Asset $discountAsset
     * @return Retailer
     */
    public function setDiscountAsset(\RocketDam\Entity\Asset $discountAsset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getDiscountAsset();

    /**
     * @param  \RocketDam\Entity\Asset $poiAsset
     * @return Retailer
     */
    public function setPoiAsset(\RocketDam\Entity\Asset $poiAsset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getPoiAsset();

    /**
     * @param  \LundProducts\Entity\Brands $brand
     * @return Retailer
     */
    public function addBrand(\LundProducts\Entity\Brands $brand);

    /**
     * @param \LundProducts\Entity\Brands $brand
     */
    public function removeBrand(\LundProducts\Entity\Brands $brand);

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrand();

    /**
     * @param  \RocketBase\Entity\Country $shipsCountry
     * @return Retailer
     */
    public function addShipsCountry(\RocketBase\Entity\Country $shipsCountry);

    /**
     * @param \RocketBase\Entity\Country $shipsCountry
     */
    public function removeShipsCountry(\RocketBase\Entity\Country $shipsCountry);

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShipsCountry();

    /**
     * @param  string   $customerOrDealer
     * @return Retailer
     */
    public function setCustomerOrDealer($customerOrDealer);

    /**
     * @return string
     */
    public function getCustomerOrDealer();

    /**
     * @param \LundCustomer\Entity\Customer $customerId
     */
    public function setCustomerId(\LundCustomer\Entity\Customer $customerId);

    /**
     * @return Retailer
     */
    public function getCustomerId();
}
