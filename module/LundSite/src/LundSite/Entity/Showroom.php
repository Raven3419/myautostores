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
 * Showroom
 *
 * @see ShowroomInterface
 */
class Showroom implements ShowroomInterface
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
     * @var boolean
     */
    protected $haveTruck;

    /**
     * @var boolean
     */
    protected $haveSuv;

    /**
     * @var boolean
     */
    protected $haveCuv;

    /**
     * @var boolean
     */
    protected $haveVan;

    /**
     * @var boolean
     */
    protected $haveCar;

    /**
     * @var boolean
     */
    protected $optin;

    /**
     * @var string
     */
    protected $comments;

    /**
     * @var integer
     */
    protected $showroomId;

    /**
     * @var \RocketCms\Entity\Site
     */
    protected $site;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $asset;

    /**
     * Set createdAt
     *
     * @param  \DateTime         $createdAt
     * @return Showroom
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
     * @param  string            $createdBy
     * @return Showroom
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
     * @param  \DateTime         $modifiedAt
     * @return Showroom
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
     * @param  string            $modifiedBy
     * @return Showroom
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
     * @param  boolean           $deleted
     * @return Showroom
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
     * @param  boolean           $disabled
     * @return Showroom
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
     * @param  string            $firstName
     * @return Showroom
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
     * @param  string            $lastName
     * @return Showroom
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
     * @param  string            $emailAddress
     * @return Showroom
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
     * Set haveTruck
     *
     * @param  boolean           $haveTruck
     * @return Showroom
     */
    public function setHaveTruck($haveTruck)
    {
        $this->haveTruck = $haveTruck;

        return $this;
    }

    /**
     * Get haveTruck
     *
     * @return boolean
     */
    public function getHaveTruck()
    {
        return $this->haveTruck;
    }

    /**
     * Set haveSuv
     *
     * @param  boolean           $haveSuv
     * @return Showroom
     */
    public function setHaveSuv($haveSuv)
    {
        $this->haveSuv = $haveSuv;

        return $this;
    }

    /**
     * Get haveSuv
     *
     * @return boolean
     */
    public function getHaveSuv()
    {
        return $this->haveSuv;
    }

    /**
     * Set haveCuv
     *
     * @param  boolean           $haveCuv
     * @return Showroom
     */
    public function setHaveCuv($haveCuv)
    {
        $this->haveCuv = $haveCuv;

        return $this;
    }

    /**
     * Get haveCuv
     *
     * @return boolean
     */
    public function getHaveCuv()
    {
        return $this->haveCuv;
    }

    /**
     * Set haveVan
     *
     * @param  boolean           $haveVan
     * @return Showroom
     */
    public function setHaveVan($haveVan)
    {
        $this->haveVan = $haveVan;

        return $this;
    }

    /**
     * Get haveVan
     *
     * @return boolean
     */
    public function getHaveVan()
    {
        return $this->haveVan;
    }

    /**
     * Set haveCar
     *
     * @param  boolean           $haveCar
     * @return Showroom
     */
    public function setHaveCar($haveCar)
    {
        $this->haveCar = $haveCar;

        return $this;
    }

    /**
     * Get haveCar
     *
     * @return boolean
     */
    public function getHaveCar()
    {
        return $this->haveCar;
    }

    /**
     * Set optin
     *
     * @param  boolean           $optin
     * @return Showroom
     */
    public function setOptin($optin)
    {
        $this->optin = $optin;

        return $this;
    }

    /**
     * Get optin
     *
     * @return boolean
     */
    public function getOptin()
    {
        return $this->optin;
    }

    /**
     * Set comments
     *
     * @param  string            $comments
     * @return Showroom
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
     * Get showroomId
     *
     * @return integer
     */
    public function getShowroomId()
    {
        return $this->showroomId;
    }

    /**
     * Set site
     *
     * @param  \RocketCms\Entity\Site $site
     * @return Showroom
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
     * Set asset
     *
     * @param  \RocketDam\Entity\Asset $asset
     * @return ProductCategories
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null)
    {
        $this->asset = $asset;

        return $this;
    }

    /**
     * Get asset
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset()
    {
        return $this->asset;
    }
}
