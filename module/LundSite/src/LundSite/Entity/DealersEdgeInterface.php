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
 * DealersEdge Interface
 */
interface DealersEdgeInterface
{
    /**
     * @param  \DateTime   $createdAt
     * @return DealersEdge
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string      $createdBy
     * @return DealersEdge
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime   $modifiedAt
     * @return DealersEdge
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string      $modifiedBy
     * @return DealersEdge
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean     $deleted
     * @return DealersEdge
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean     $disabled
     * @return DealersEdge
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string      $firstName
     * @return DealersEdge
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param  string      $lastName
     * @return DealersEdge
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param  string      $emailAddress
     * @return DealersEdge
     */
    public function setEmailAddress($emailAddress);

    /**
     * @return string
     */
    public function getEmailAddress();

    /**
     * @param  string      $companyName
     * @return DealersEdge
     */
    public function setCompanyName($companyName);

    /**
     * @return string
     */
    public function getCompanyName();

    /**
     * @param  string      $streetAddress
     * @return DealersEdge
     */
    public function setStreetAddress($streetAddress);

    /**
     * @return string
     */
    public function getStreetAddress();

    /**
     * @param  string      $extStreetAddress
     * @return DealersEdge
     */
    public function setExtStreetAddress($extStreetAddress);

    /**
     * @return string
     */
    public function getExtStreetAddress();

    /**
     * @param  string      $locality
     * @return DealersEdge
     */
    public function setLocality($locality);

    /**
     * @return string
     */
    public function getLocality();

    /**
     * @param  string      $postCode
     * @return DealersEdge
     */
    public function setPostCode($postCode);

    /**
     * @return string
     */
    public function getPostCode();

    /**
     * @param  string      $phoneNumber
     * @return DealersEdge
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * @return string
     */
    public function getPhoneNumber();

    /**
     * @param  string      $faxNumber
     * @return DealersEdge
     */
    public function setFaxNumber($faxNumber);

    /**
     * @return string
     */
    public function getFaxNumber();

    /**
     * @param  string      $distributor
     * @return DealersEdge
     */
    public function setDistributor($distributor);

    /**
     * @return string
     */
    public function getDistributor();

    /**
     * @param  boolean     $existingDealer
     * @return DealersEdge
     */
    public function setExistingDealer($existingDealer);

    /**
     * @return boolean
     */
    public function getExistingDealer();

    /**
     * @param  string      $brands
     * @return DealersEdge
     */
    public function setBrands($brands);

    /**
     * @return string
     */
    public function getBrands();

    /**
     * @return integer
     */
    public function getDealersEdgeId();

    /**
     * @param  \RocketCms\Entity\Site $site
     * @return DealersEdge
     */
    public function setSite(\RocketCms\Entity\Site $site = null);

    /**
     * @return \RocketCms\Entity\Site
     */
    public function getSite();

    /**
     * @param  \RocketBase\Entity\State $region
     * @return DealersEdge
     */
    public function setRegion(\RocketBase\Entity\State $region = null);

    /**
     * @return \RocketBase\Entity\State
     */
    public function getRegion();

    /**
     * @param  \RocketBase\Entity\Country $country
     * @return DealersEdge
     */
    public function setCountry(\RocketBase\Entity\Country $country = null);

    /**
     * @return \RocketBase\Entity\Country
     */
    public function getCountry();
}
