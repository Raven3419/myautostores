<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Entity
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\Entity;

/**
 * ProductRegistration
 *
 * @see ProductRegistrationInterface
 */
class ProductRegistration implements ProductRegistrationInterface
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
    protected $title;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $middleInitial;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $emailAddress;

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
     * @var \RocketBase\Entity\State
     */
    protected $region;

    /**
     * @var string
     */
    protected $postCode;

    /**
     * @var \RocketBase\Entity\Country
     */
    protected $country;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var \LundProducts\Entity\ProductCategories
     */
    protected $productCategory;

    /**
     * @var string
     */
    protected $upcCode;   

    /**
     * @var integer
     */
    protected $productRegistrationId;
    
   
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime           $createdAt
     * @return ProductRegistration
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
     * @param  string              $createdBy
     * @return ProductRegistration
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
     * @param  \DateTime           $modifiedAt
     * @return ProductRegistration
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
     * @param  string              $modifiedBy
     * @return ProductRegistration
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
     * @param  boolean             $deleted
     * @return ProductRegistration
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
     * @param  boolean             $disabled
     * @return ProductRegistration
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
     * Set title
     *
     * @param  string              $title
     * @return ProductRegistration
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set firstName
     *
     * @param  string              $firstName
     * @return ProductRegistration
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleInitial
     *
     * @param  string              $middleInitial
     * @return ProductRegistration
     */
    public function setMiddleInitial($middleInitial)
    {
        $this->middleInitial = $middleInitial;

        return $this;
    }

    /**
     * Get middleInitial
     *
     * @return string
     */
    public function getMiddleInitial()
    {
        return $this->middleInitial;
    }

    /**
     * Set lastName
     *
     * @param  string              $lastName
     * @return ProductRegistration
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set emailAddress
     *
     * @param  string              $emailAddress
     * @return ProductRegistration
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set streetAddress
     *
     * @param  string              $streetAddress
     * @return ProductRegistration
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
     * @param  string              $extStreetAddress
     * @return ProductRegistration
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
     * @param  string              $locality
     * @return ProductRegistration
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
     * Set region
     *
     * @param  \RocketBase\Entity\State $region
     * @return ProductRegistration
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
     * Set postCode
     *
     * @param  string              $postCode
     * @return ProductRegistration
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
     * Set country
     *
     * @param  \RocketBase\Entity\Country $country
     * @return ProductRegistration
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
     * Set phoneNumber
     *
     * @param  string              $phoneNumber
     * @return ProductRegistration
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
     * Set productCategory
     *
     * @param  \LundProducts\Entity\ProductCategories $productCategory
     * @return ProductRegistration
     */
    public function setProductCategory(\LundProducts\Entity\ProductCategories $productCategory = null)
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    /**
     * Get productCategory
     *
     * @return \LundProducts\Entity\ProductCategories
     */
    public function getProductCategory()
    {
        return $this->productCategory;
    }

    /**
     * Set upcCode
     *
     * @param  string              $upcCode
     * @return ProductRegistration
     */
    public function setUpcCode($upcCode)
    {
        $this->upcCode = $upcCode;

        return $this;
    }

    /**
     * Get upcCode
     *
     * @return string
     */
    public function getUpcCode()
    {
        return $this->upcCode;
    }

    /**
     * Get productRegistrationId
     *
     * @return integer
     */
    public function getProductRegistrationId()
    {
        return $this->productRegistrationId;
    }
}
