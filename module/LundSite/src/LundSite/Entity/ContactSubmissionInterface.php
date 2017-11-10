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
 * ContactSubmission Interface
 */
interface ContactSubmissionInterface
{
    /**
     * @param  \DateTime         $createdAt
     * @return ContactSubmission
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string            $createdBy
     * @return ContactSubmission
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime         $modifiedAt
     * @return ContactSubmission
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string            $modifiedBy
     * @return ContactSubmission
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean           $deleted
     * @return ContactSubmission
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean           $disabled
     * @return ContactSubmission
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string            $firstName
     * @return ContactSubmission
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param  string            $lastName
     * @return ContactSubmission
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param  string            $emailAddress
     * @return ContactSubmission
     */
    public function setEmailAddress($emailAddress);

    /**
     * @return string
     */
    public function getEmailAddress();

    /**
     * @param  string            $streetAddress
     * @return ContactSubmission
     */
    public function setStreetAddress($streetAddress);

    /**
     * @return string
     */
    public function getStreetAddress();

    /**
     * @param  string            $extStreetAddress
     * @return ContactSubmission
     */
    public function setExtStreetAddress($extStreetAddress);

    /**
     * @return string
     */
    public function getExtStreetAddress();

    /**
     * @param  string            $locality
     * @return ContactSubmission
     */
    public function setLocality($locality);

    /**
     * @return string
     */
    public function getLocality();

    /**
     * @param  string            $postCode
     * @return ContactSubmission
     */
    public function setPostCode($postCode);

    /**
     * @return string
     */
    public function getPostCode();

    /**
     * @param  string            $phoneNumber
     * @return ContactSubmission
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * @return string
     */
    public function getPhoneNumber();

    /**
     * @param  string            $comments
     * @return ContactSubmission
     */
    public function setComments($comments);

    /**
     * @return string
     */
    public function getComments();

    /**
     * @return integer
     */
    public function getContactSubmissionId();

    /**
     * @param  \RocketCms\Entity\Site $site
     * @return ContactSubmission
     */
    public function setSite(\RocketCms\Entity\Site $site = null);

    /**
     * @return \RocketCms\Entity\Site
     */
    public function getSite();

    /**
     * @param  \RocketBase\Entity\State $region
     * @return ContactSubmission
     */
    public function setRegion(\RocketBase\Entity\State $region = null);

    /**
     * @return \RocketBase\Entity\State
     */
    public function getRegion();

    /**
     * @param  \RocketBase\Entity\Country $country
     * @return ContactSubmission
     */
    public function setCountry(\RocketBase\Entity\Country $country = null);

    /**
     * @return \RocketBase\Entity\Country
     */
    public function getCountry();
}
