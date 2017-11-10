<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Entity
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer\Entity;

/**
 * Customer
 *
 * @see CustomerInterface
 */

class Customer implements CustomerInterface
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
     * @var integer
     */
    protected $custId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $filePickup;

    /**
     * @var boolean
     */
    protected $filePush;

    /**
     * @var string
     */
    protected $ftpSite;

    /*8
     * @var string
     */
    protected $ftpUser;

    /**
     * @var string
     */
    protected $ftpPass;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $contactName;

    /**
     * @var string
     */
    protected $updateType;

    /**
     * @var string
     */
    protected $frequency;

    /**
     * @var \DateTime
     */
    protected $lastUpdate;

    /**
     * @var string
     */
    protected $acesVersion;

    /**
     * @var string
     */
    protected $piesVersion;

    /**
     * @var boolean
     */
    protected $lund;

    /**
     * @var boolean
     */
    protected $dfmal;

    /**
     * @var boolean
     */
    protected $avs;

    /**
     * @var boolean
     */
    protected $nifty;

    /**
     * @var boolean
     */
    protected $tradesman;

    /**
     * @var boolean
     */
    protected $lmp;

    /**
     * @var boolean
     */
    protected $amp;

    /**
     * @var boolean
     */
    protected $htam;

    /**
     * @var boolean
     */
    protected $belmor;

    /**
     * @var boolean
     */
    protected $lundAll;

    /**
     * @var boolean
     */
    protected $rampage;

    /**
     * @var boolean
     */
    protected $bushwacker;

    /**
     * @var boolean
     */
    protected $stampede;
    
    /**
     * @var boolean
     */
    protected $tonnopro;

    /**
     * @var string
     */
    protected $imageType;

    /**
     * @var boolean
     */
    protected $renameImages;

    /**
     * @var boolean
     */
    protected $acceptVideo;

    /**
     * @var string
     */
    protected $videoType;

    /**
     * @var string
     */
    protected $customerOrDealer;

    /**
     * @var integer
     */
    protected $customerId;

    /**
     * @var \RocketUser\Entity\User
     */
    protected $user;

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Customer
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
     * @param  string   $createdBy
     * @return Customer
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
     * @param  \DateTime $modifiedAt
     * @return Customer
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
     * @param  string   $modifiedBy
     * @return Customer
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
     * @param  boolean  $deleted
     * @return Customer
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
     * @param  boolean  $disabled
     * @return Customer
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
     * Set custId
     *
     * @param  integer  $custId
     * @return Customer
     */
    public function setCustId($custId)
    {
        $this->custId = $custId;

        return $this;
    }

    /**
     * Get custId
     *
     * @return integer
     */
    public function getCustId()
    {
        return $this->custId;
    }

    /**
     * Set name
     *
     * @param  string   $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set filePickup
     *
     * @param  boolean  $filePickup
     * @return Customer
     */
    public function setFilePickup($filePickup)
    {
        $this->filePickup = $filePickup;

        return $this;
    }

    /**
     * Get filePickup
     *
     * @return boolean
     */
    public function getFilePickup()
    {
        return $this->filePickup;
    }

    /**
     * Set filePush
     *
     * @param  boolean  $filePush
     * @return Customer
     */
    public function setFilePush($filePush)
    {
        $this->filePush = $filePush;

        return $this;
    }

    /**
     * Get filePush
     *
     * @return boolean
     */
    public function getFilePush()
    {
        return $this->filePush;
    }

    /**
     * Set ftpSite
     *
     * @param  string   $ftpSite
     * @return Customer
     */
    public function setFtpSite($ftpSite)
    {
        $this->ftpSite = $ftpSite;

        return $this;
    }

    /**
     * Get ftpSite
     *
     * @return string
     */
    public function getFtpSite()
    {
        return $this->ftpSite;
    }

    /**
     * Set ftpUser
     *
     * @param  string   $ftpUser
     * @return Customer
     */
    public function setFtpUser($ftpUser)
    {
        $this->ftpUser = $ftpUser;

        return $this;
    }

    /**
     * Get ftpUser
     *
     * @return string
     */
    public function getFtpUser()
    {
        return $this->ftpUser;
    }

    /**
     * Set ftpPass
     *
     * @param  string   $ftpPass
     * @return Customer
     */
    public function setFtpPass($ftpPass)
    {
        $this->ftpPass = $ftpPass;

        return $this;
    }

    /**
     * Get ftpPass
     *
     * @return string
     */
    public function getFtpPass()
    {
        return $this->ftpPass;
    }

    /**
     * Set email
     *
     * @param  string   $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contactName
     *
     * @param  string   $contactName
     * @return Customer
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set updateType
     *
     * @param  string   $updateType
     * @return Customer
     */
    public function setUpdateType($updateType)
    {
        $this->updateType = $updateType;

        return $this;
    }

    /**
     * Get updateType
     *
     * @return string
     */
    public function getUpdateType()
    {
        return $this->updateType;
    }

    /**
     * Set customerOrDealer
     *
     * @param  string   $customerOrDealer
     * @return Customer
     */
    public function setCustomerOrDealer($customerOrDealer)
    {
        $this->customerOrDealer = $customerOrDealer;

        return $this;
    }

    /**
     * Get customerOrDealer
     *
     * @return string
     */
    public function getCustomerOrDealer()
    {
        return $this->customerOrDealer;
    }

    /**
     * Set frequency
     *
     * @param  string   $frequency
     * @return Customer
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set lastUpdate
     *
     * @param  \DateTime $lastUpdate
     * @return Customer
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set acesVersion
     *
     * @param  string   $acesVersion
     * @return Customer
     */
    public function setAcesVersion($acesVersion)
    {
        $this->acesVersion = $acesVersion;

        return $this;
    }

    /**
     * Get acesVersion
     *
     * @return string
     */
    public function getAcesVersion()
    {
        return $this->acesVersion;
    }

    /**
     * Set piesVersion
     *
     * @param  string   $piesVersion
     * @return Customer
     */
    public function setPiesVersion($piesVersion)
    {
        $this->piesVersion = $piesVersion;

        return $this;
    }

    /**
     * Get piesVersion
     *
     * @return string
     */
    public function getPiesVersion()
    {
        return $this->piesVersion;
    }

    /**
     * Set lund
     *
     * @param  boolean  $lund
     * @return Customer
     */
    public function setLund($lund)
    {
        $this->lund = $lund;

        return $this;
    }

    /**
     * Get lund
     *
     * @return boolean
     */
    public function getLund()
    {
        return $this->lund;
    }

    /**
     * Set dfmal
     *
     * @param  boolean  $dfmal
     * @return Customer
     */
    public function setDfmal($dfmal)
    {
        $this->dfmal = $dfmal;

        return $this;
    }

    /**
     * Get dfmal
     *
     * @return boolean
     */
    public function getDfmal()
    {
        return $this->dfmal;
    }

    /**
     * Set avs
     *
     * @param  boolean  $avs
     * @return Customer
     */
    public function setAvs($avs)
    {
        $this->avs = $avs;

        return $this;
    }

    /**
     * Get avs
     *
     * @return boolean
     */
    public function getAvs()
    {
        return $this->avs;
    }

    /**
     * Set nifty
     *
     * @param  boolean  $nifty
     * @return Customer
     */
    public function setNifty($nifty)
    {
        $this->nifty = $nifty;

        return $this;
    }

    /** Get nifty
     *
     * @return boolean
     */
    public function getNifty()
    {
        return $this->nifty;
    }

    /**
     * Set tradesman
     *
     * @param  boolean  $tradesman
     * @return Customer
     */
    public function setTradesman($tradesman)
    {
        $this->tradesman = $tradesman;

        return $this;
    }

    /**
     * Get tradesman
     *
     * @return boolean
     */
    public function getTradesman()
    {
        return $this->tradesman;
    }

    /**
     * Set lmp
     *
     * @param  boolean  $lmp
     * @return Customer
     */
    public function setLmp($lmp)
    {
        $this->lmp = $lmp;

        return $this;
    }

    /**
     * Get lmp
     *
     * @return boolean
     */
    public function getLmp()
    {
        return $this->lmp;
    }

    /**
     * Set amp
     *
     * @param  boolean  $amp
     * @return Customer
     */
    public function setAmp($amp)
    {
        $this->amp = $amp;

        return $this;
    }

    /**
     * Get amp
     *
     * @return boolean
     */
    public function getAmp()
    {
        return $this->amp;
    }

    /**
     * Set htam
     *
     * @param  boolean  $htam
     * @return Customer
     */
    public function setHtam($htam)
    {
        $this->htam = $htam;

        return $this;
    }

    /**
     * Get htam
     *
     * @return boolean
     */
    public function getHtam()
    {
        return $this->htam;
    }

    /**
     * Set belmor
     *
     * @param  boolean  $belmor
     * @return Customer
     */
    public function setBelmor($belmor)
    {
        $this->belmor = $belmor;

        return $this;
    }

    /**
     * Get belmor
     *
     * @return boolean
     */
    public function getBelmor()
    {
        return $this->belmor;
    }

    /**
     * Set lundAll
     *
     * @param  boolean  $lundAll
     * @return Customer
     */
    public function setLundAll($lundAll)
    {
        $this->lundAll = $lundAll;

        return $this;
    }

    /**
     * Get lundAll
     *
     * #return boolean
     */
    public function getLundAll()
    {
        return $this->lundAll;
    }

    /**
     * Set rampage
     *
     * @param  boolean  $rampage
     * @return Customer
     */
    public function setRampage($rampage)
    {
        $this->rampage = $rampage;

        return $this;
    }

    /**
     * Get rampage
     *
     * #return boolean
     */
    public function getRampage()
    {
        return $this->rampage;
    }

    /**
     * Set bushwacker
     *
     * @param  boolean  $bushwacker
     * @return Customer
     */
    public function setBushwacker($bushwacker)
    {
        $this->bushwacker = $bushwacker;

        return $this;
    }

    /**
     * Get bushwacker
     *
     * #return boolean
     */
    public function getBushwacker()
    {
        return $this->bushwacker;
    }

    /**
     * Set stampede
     *
     * @param  boolean  $stampede
     * @return Customer
     */
    public function setStampede($stampede)
    {
        $this->stampede = $stampede;

        return $this;
    }

    /**
     * Get stampede
     *
     * #return boolean
     */
    public function getStampede()
    {
        return $this->stampede;
    }
    
    /**
     * Set tonnopro
     *
     * @param  boolean  $tonnopro
     * @return Customer
     */
    public function setTonnopro($tonnopro)
    {
        $this->tonnopro = $tonnopro;
        
        return $this;
    }
    
    /**
     * Get tonnopro
     *
     * #return boolean
     */
    public function getTonnopro()
    {
        return $this->tonnopro;
    }

    /**
     * Set imageType
     *
     * @param  string   $imageType
     * @return Customer
     */
    public function setImageType($imageType)
    {
        $this->imageType = $imageType;

        return $this;
    }

    /**
     * Get imageType
     *
     * @return string
     */
    public function getImageType()
    {
        return $this->imageType;
    }

    /**
     * Set renameImages
     *
     * @param  boolean  $renameImages
     * @return Customer
     */
    public function setRenameImages($renameImages)
    {
        $this->renameImages = $renameImages;

        return $this;
    }

    /**
     * Get renameImages
     *
     * @return boolean
     */
    public function getRenameImages()
    {
        return $this->renameImages;
    }

    /**
     * Set acceptVideo
     *
     * @param  boolean  $acceptVideo
     * @return Customer
     */
    public function setAcceptVideo($acceptVideo)
    {
        $this->acceptVideo = $acceptVideo;

        return $this;
    }

    /**
     * Get acceptVideo
     *
     * @return boolean
     */
    public function getAcceptVideo()
    {
        return $this->acceptVideo;
    }

    /**
     * Set videoType
     *
     * @param  string   $videoType
     * @return Customer
     */
    public function setVideoType($videoType)
    {
        $this->videoType = $videoType;

        return $this;
    }

    /**
     * Get videoType
     *
     * @return string
     */
    public function getVideoType()
    {
        return $this->videoType;
    }

    /**
     * Get customerId
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set user
     *
     * @param  \RocketUser\Entity\User $user
     * @return Customer
     */
    public function setUser(\RocketUser\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \RocketUser\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
