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
 * SupportRequest Interface
 */
interface SupportRequestInterface
{
    /**
     * @param  \DateTime      $createdAt
     * @return SupportRequest
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string         $createdBy
     * @return SupportRequest
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime      $modifiedAt
     * @return SupportRequest
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string         $modifiedBy
     * @return SupportRequest
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean        $deleted
     * @return SupportRequest
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean        $disabled
     * @return SupportRequest
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string         $firstName
     * @return SupportRequest
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param  string         $lastName
     * @return SupportRequest
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param  string         $emailAddress
     * @return SupportRequest
     */
    public function setEmailAddress($emailAddress);

    /**
     * @return string
     */
    public function getEmailAddress();

    /**
     * @param  string         $streetAddress
     * @return SupportRequest
     */
    public function setStreetAddress($streetAddress);

    /**
     * @return string
     */
    public function getStreetAddress();

    /**
     * @param  string         $extStreetAddress
     * @return SupportRequest
     */
    public function setExtStreetAddress($extStreetAddress);

    /**
     * @return string
     */
    public function getExtStreetAddress();

    /**
     * @param  string         $locality
     * @return SupportRequest
     */
    public function setLocality($locality);

    /**
     * @return string
     */
    public function getLocality();

    /**
     * @param  string         $postCode
     * @return SupportRequest
     */
    public function setPostCode($postCode);

    /**
     * @return string
     */
    public function getPostCode();

    /**
     * @param  string         $phoneNumber
     * @return SupportRequest
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * @return string
     */
    public function getPhoneNumber();

    /**
     * @param  string         $vehicle
     * @return SupportRequest
     */
    public function setVehicle($vehicle);

    /**
     * @return string
     */
    public function getVehicle();

    /**
     * @param  string         $partNumber
     * @return SupportRequest
     */
    public function setPartNumber($partNumber);

    /**
     * @return string
     */
    public function getPartNumber();

    /**
     * @param  string         $wherePurchase
     * @return SupportRequest
     */
    public function setWherePurchase($wherePurchase);

    /**
     * @return string
     */
    public function getWherePurchase();

    /**
     * @param  string         $comments
     * @return SupportRequest
     */
    public function setComments($comments);

    /**
     * @return string
     */
    public function getComments();

    /**
     * @return integer
     */
    public function getSupportRequestId();

    /**
     * @param  \RocketCms\Entity\Site $site
     * @return SupportRequest
     */
    public function setSite(\RocketCms\Entity\Site $site = null);

    /**
     * @return \RocketCms\Entity\Site
     */
    public function getSite();

    /**
     * @param  \RocketBase\Entity\State $region
     * @return SupportRequest
     */
    public function setRegion(\RocketBase\Entity\State $region = null);

    /**
     * @return \RocketBase\Entity\State
     */
    public function getRegion();

    /**
     * @param  \RocketBase\Entity\Country $country
     * @return SupportRequest
     */
    public function setCountry(\RocketBase\Entity\Country $country = null);

    /**
     * @return \RocketBase\Entity\Country
     */
    public function getCountry();
}
