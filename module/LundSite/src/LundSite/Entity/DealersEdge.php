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
 * DealersEdge
 *
 * @see DealersEdgeInterface
 */
class DealersEdge implements DealersEdgeInterface
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
    protected $faxNumber;

    /**
     * @var string
     */
    protected $distributor;

    /**
     * @var boolean
     */
    protected $existingDealer;

    /**
     * @var string
     */
    protected $brands;

    /**
     * @var integer
     */
    protected $dealersEdgeId;

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
     * @param  \DateTime   $createdAt
     * @return DealersEdge
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
     * @param  string      $createdBy
     * @return DealersEdge
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
     * @param  \DateTime   $modifiedAt
     * @return DealersEdge
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
     * @param  string      $modifiedBy
     * @return DealersEdge
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
     * @param  boolean     $deleted
     * @return DealersEdge
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
     * @param  boolean     $disabled
     * @return DealersEdge
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
     * @param  string      $firstName
     * @return DealersEdge
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
     * @param  string      $lastName
     * @return DealersEdge
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
     * @param  string      $emailAddress
     * @return DealersEdge
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
     * Set companyName
     *
     * @param  string      $companyName
     * @return DealersEdge
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
     * @param  string      $streetAddress
     * @return DealersEdge
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
     * @param  string      $extStreetAddress
     * @return DealersEdge
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
     * @param  string      $locality
     * @return DealersEdge
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
     * @param  string      $postCode
     * @return DealersEdge
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
     * @param  string      $phoneNumber
     * @return DealersEdge
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
     * Set faxNumber
     *
     * @param  string      $faxNumber
     * @return DealersEdge
     */
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    /**
     * Get faxNumber
     *
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }

    /**
     * Set distributor
     *
     * @param  string      $distributor
     * @return DealersEdge
     */
    public function setDistributor($distributor)
    {
        $this->distributor = $distributor;

        return $this;
    }

    /**
     * Get distributor
     *
     * @return string
     */
    public function getDistributor()
    {
        return $this->distributor;
    }

    /**
     * Set existingDealer
     *
     * @param  boolean     $existingDealer
     * @return DealersEdge
     */
    public function setExistingDealer($existingDealer)
    {
        $this->existingDealer = $existingDealer;

        return $this;
    }

    /**
     * Get existingDealer
     *
     * @return boolean
     */
    public function getExistingDealer()
    {
        return $this->existingDealer;
    }

    /**
     * Set brands
     *
     * @param  string      $brands
     * @return DealersEdge
     */
    public function setBrands($brands)
    {
        $this->brands = $brands;

        return $this;
    }

    /**
     * Get brands
     *
     * @return string
     */
    public function getBrands()
    {
        return $this->brands;
    }

    /**
     * Get dealersEdgeId
     *
     * @return integer
     */
    public function getDealersEdgeId()
    {
        return $this->dealersEdgeId;
    }

    /**
     * Set site
     *
     * @param  \RocketCms\Entity\Site $site
     * @return DealersEdge
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
     * @return DealersEdge
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
     * @return DealersEdge
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
