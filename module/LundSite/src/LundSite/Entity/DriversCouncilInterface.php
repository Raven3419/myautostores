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
 * DriversCouncil Interface
 */
interface DriversCouncilInterface
{
    /**
     * @param  \DateTime      $createdAt
     * @return DriversCouncil
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string         $createdBy
     * @return DriversCouncil
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime      $modifiedAt
     * @return DriversCouncil
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string         $modifiedBy
     * @return DriversCouncil
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean        $deleted
     * @return DriversCouncil
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean        $disabled
     * @return DriversCouncil
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string         $firstName
     * @return DriversCouncil
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param  string         $lastName
     * @return DriversCouncil
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param  string         $emailAddress
     * @return DriversCouncil
     */
    public function setEmailAddress($emailAddress);

    /**
     * @return string
     */
    public function getEmailAddress();

    /**
     * @param  string         $streetAddress
     * @return DriversCouncil
     */
    public function setStreetAddress($streetAddress);

    /**
     * @return string
     */
    public function getStreetAddress();

    /**
     * @param  string         $extStreetAddress
     * @return DriversCouncil
     */
    public function setExtStreetAddress($extStreetAddress);

    /**
     * @return string
     */
    public function getExtStreetAddress();

    /**
     * @param  string         $locality
     * @return DriversCouncil
     */
    public function setLocality($locality);

    /**
     * @return string
     */
    public function getLocality();

    /**
     * @param  string         $postCode
     * @return DriversCouncil
     */
    public function setPostCode($postCode);

    /**
     * @return string
     */
    public function getPostCode();

    /**
     * @param  boolean        $optin
     * @return DriversCouncil
     */
    public function setOptin($optin);

    /**
     * @return boolean
     */
    public function getOptin();

    /**
     * @return integer
     */
    public function getDriversCouncilId();

    /**
     * @param  \RocketCms\Entity\Site $site
     * @return DriversCouncil
     */
    public function setSite(\RocketCms\Entity\Site $site = null);

    /**
     * @return \RocketCms\Entity\Site
     */
    public function getSite();

    /**
     * @param  \RocketBase\Entity\State $region
     * @return DriversCouncil
     */
    public function setRegion(\RocketBase\Entity\State $region = null);

    /**
     * @return \RocketBase\Entity\State
     */
    public function getRegion();

    /**
     * @param  \RocketBase\Entity\Country $country
     * @return DriversCouncil
     */
    public function setCountry(\RocketBase\Entity\Country $country = null);

    /**
     * @return \RocketBase\Entity\Country
     */
    public function getCountry();
}
