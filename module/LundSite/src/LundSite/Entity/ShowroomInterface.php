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
 * Showroom Interface
 */
interface ShowroomInterface
{
    /**
     * @param  \DateTime         $createdAt
     * @return Showroom
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string            $createdBy
     * @return Showroom
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime         $modifiedAt
     * @return Showroom
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string            $modifiedBy
     * @return Showroom
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean           $deleted
     * @return Showroom
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean           $disabled
     * @return Showroom
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string            $firstName
     * @return Showroom
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param  string            $lastName
     * @return Showroom
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param  string            $emailAddress
     * @return Showroom
     */
    public function setEmailAddress($emailAddress);

    /**
     * @return string
     */
    public function getEmailAddress();

    /**
     * @param  boolean           $haveTruck
     * @return Showroom
     */
    public function setHaveTruck($haveTruck);

    /**
     * @return boolean
     */
    public function getHaveTruck();

    /**
     * @param  boolean           $haveSuv
     * @return Showroom
     */
    public function setHaveSuv($haveSuv);

    /**
     * @return boolean
     */
    public function getHaveSuv();

    /**
     * @param  boolean           $haveCuv
     * @return Showroom
     */
    public function setHaveCuv($haveCuv);

    /**
     * @return boolean
     */
    public function getHaveCuv();

    /**
     * @param  boolean           $haveVan
     * @return Showroom
     */
    public function setHaveVan($haveVan);

    /**
     * @return boolean
     */
    public function getHaveVan();

    /**
     * @param  boolean           $haveCar
     * @return Showroom
     */
    public function setHaveCar($haveCar);

    /**
     * @return boolean
     */
    public function getHaveCar();

    /**
     * @param  boolean           $optin
     * @return Showroom
     */
    public function setOptin($optin);

    /**
     * @return boolean
     */
    public function getOptin();

    /**
     * @param  string            $comments
     * @return Showroom
     */
    public function setComments($comments);

    /**
     * @return string
     */
    public function getComments();

    /**
     * @return integer
     */
    public function getShowroomId();

    /**
     * @param  \RocketCms\Entity\Site $site
     * @return Showroom
     */
    public function setSite(\RocketCms\Entity\Site $site = null);

    /**
     * @return \RocketCms\Entity\Site
     */
    public function getSite();

    /**
     * @param  \RocketDam\Entity\Asset $asset
     * @return ProductCategories
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();
}
