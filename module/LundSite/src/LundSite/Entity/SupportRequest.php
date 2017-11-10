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
 * SupportRequest
 *
 * @see SupportRequestInterface
 */
class SupportRequest implements SupportRequestInterface
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
    protected $firstName;

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
    protected $vehicle;

    /**
     * @var string
     */
    protected $partNumber;

    /**
     * @var string
     */
    protected $wherePurchase;

    /**
     * @var string
     */
    protected $comments;

    /**
     * @var integer
     */
    protected $supportRequestId;

    /**
     * @var \RocketCms\Entity\Site
     */
    protected $site;

    /**
     * @var \RocketBase\Entity\State
     */
    protected $region;

    /**
     * @var \RocketBase\Entity\Country
     */
    protected $country;

    /**
     * Set createdAt
     *
     * @param  \DateTime      $createdAt
     * @return SupportRequest
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
     * @param  string         $createdBy
     * @return SupportRequest
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
     * @param  \DateTime      $modifiedAt
     * @return SupportRequest
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
     * @param  string         $modifiedBy
     * @return SupportRequest
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
     * @param  boolean        $deleted
     * @return SupportRequest
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
     * @param  boolean        $disabled
     * @return SupportRequest
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
     * Set firstName
     *
     * @param  string         $firstName
     * @return SupportRequest
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
     * Set lastName
     *
     * @param  string         $lastName
     * @return SupportRequest
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
     * @param  string         $emailAddress
     * @return SupportRequest
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
     * @param  string         $streetAddress
     * @return SupportRequest
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
     * @param  string         $extStreetAddress
     * @return SupportRequest
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
     * @param  string         $locality
     * @return SupportRequest
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
     * @param  string         $postCode
     * @return SupportRequest
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
     * @param  string         $phoneNumber
     * @return SupportRequest
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
     * Set vehicle
     *
     * @param  string         $vehicle
     * @return SupportRequest
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return string
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set partNumber
     *
     * @param  string         $partNumber
     * @return SupportRequest
     */
    public function setPartNumber($partNumber)
    {
        $this->partNumber = $partNumber;

        return $this;
    }

    /**
     * Get partNumber
     *
     * @return string
     */
    public function getPartNumber()
    {
        return $this->partNumber;
    }

    /**
     * Set wherePurchase
     *
     * @param  string         $wherePurchase
     * @return SupportRequest
     */
    public function setWherePurchase($wherePurchase)
    {
        $this->wherePurchase = $wherePurchase;

        return $this;
    }

    /**
     * Get wherePurchase
     *
     * @return string
     */
    public function getWherePurchase()
    {
        return $this->wherePurchase;
    }

    /**
     * Set comments
     *
     * @param  string         $comments
     * @return SupportRequest
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get supportRequestId
     *
     * @return integer
     */
    public function getSupportRequestId()
    {
        return $this->supportRequestId;
    }

    /**
     * Set site
     *
     * @param  \RocketCms\Entity\Site $site
     * @return SupportRequest
     */
    public function setSite(\RocketCms\Entity\Site $site = null)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return \RocketCms\Entity\Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set region
     *
     * @param  \RocketBase\Entity\State $region
     * @return SupportRequest
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
     * @return SupportRequest
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
}
