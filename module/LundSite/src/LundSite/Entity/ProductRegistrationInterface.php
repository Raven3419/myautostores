<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\Entity;

/**
 * ProductRegistration Interface
 */
interface ProductRegistrationInterface
{
    /**
     * @param  \DateTime           $createdAt
     * @return ProductRegistration
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string              $createdBy
     * @return ProductRegistration
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime           $modifiedAt
     * @return ProductRegistration
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string              $modifiedBy
     * @return ProductRegistration
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean             $deleted
     * @return ProductRegistration
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean             $disabled
     * @return ProductRegistration
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string              $title
     * @return ProductRegistration
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param  string              $firstName
     * @return ProductRegistration
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param  string              $middleInitial
     * @return ProductRegistration
     */
    public function setMiddleInitial($middleInitial);

    /**
     * @return string
     */
    public function getMiddleInitial();

    /**
     * @param  string              $lastName
     * @return ProductRegistration
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param  string              $emailAddress
     * @return ProductRegistration
     */
    public function setEmailAddress($emailAddress);

    /**
     * @return string
     */
    public function getEmailAddress();

    /**
     * @param  string              $streetAddress
     * @return ProductRegistration
     */
    public function setStreetAddress($streetAddress);

    /**
     * @return string
     */
    public function getStreetAddress();

    /**
     * @param  string              $extStreetAddress
     * @return ProductRegistration
     */
    public function setExtStreetAddress($extStreetAddress);

    /**
     * @return string
     */
    public function getExtStreetAddress();

    /**
     * @param  string              $locality
     * @return ProductRegistration
     */
    public function setLocality($locality);

    /**
     * @return string
     */
    public function getLocality();
    
    /**
     * @param  \RocketBase\Entity\State $region
     * @return ProductRegistration
    */
    public function setRegion(\RocketBase\Entity\State $region = null);
    
    /**
     * @return \RocketBase\Entity\State
    */
    public function getRegion();

    /**
     * @param  string              $postCode
     * @return ProductRegistration
     */
    public function setPostCode($postCode);

    /**
     * @return string
     */
    public function getPostCode();
    
    /**
     * @param  \RocketBase\Entity\Country $country
     * @return ProductRegistration
    */
    public function setCountry(\RocketBase\Entity\Country $country = null);
    
    /**
     * @return \RocketBase\Entity\Country
    */
    public function getCountry();

    /**
     * @param  string              $phoneNumber
     * @return ProductRegistration
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * @return string
     */
    public function getPhoneNumber();
    
    /**
     * @param  \LundProducts\Entity\ProductCategories $productCategory
     * @return ProductRegistration
    */
    public function setProductCategory(\LundProducts\Entity\ProductCategories $productCategory = null);
    
    /**
     * @return \LundProducts\Entity\ProductCategories
    */
    public function getProductCategory();

    /**
     * @param  string              $upcCode
     * @return ProductRegistration
     */
    public function setUpcCode($upcCode);

    /**
     * @return string
     */
    public function getUpcCode();
    
    /**
     * @return integer
    */
    public function getProductRegistrationId();
}
