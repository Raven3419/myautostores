<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer\Entity;

/**
 * Customer Interface
 */

interface CustomerInterface
{
    /**
     * @param  \DateTime $createdAt
     * @return Customer
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string   $createdBy
     * @return Customer
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime $modifiedAt
     * @return Customer
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string   $modifiedBy
     * @return Customer
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean  $deleted
     * @return Customer
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean  $disabled
     * @return Customer
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  integer  $custId
     * @return Customer
     */
    public function setCustId($custId);

    /**
     * @return integer
     */
    public function getCustId();

    /**
     * @param  string   $name
     * @return Customer
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param  boolean  $filePickup
     * @return Customer
     */
    public function setFilePickup($filePickup);

    /**
     * @return boolean
     */
    public function getFilePickup();

    /**
     * @param  boolean  $filePush
     * @return Customer
     */
    public function setFilePush($filePush);

    /**
     * @return boolean
     */
    public function getFilePush();

    /**
     * @param  string   $ftpSite
     * @return Customer
     */
    public function setFtpSite($ftpSite);

    /**
     * @return string
     */
    public function getFtpSite();

    /**
     * @param  string   $ftpUser
     * @return Customer
     */
    public function setFtpUser($ftpUser);

    /**
     * @return string
     */
    public function getFtpUser();

    /**
     * @param  string   $ftpPass
     * @return Customer
     */
    public function setFtpPass($ftpPass);

    /**
     * @return string
     */
    public function getFtpPass();

    /**
     * @param  string   $email
     * @return Customer
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param  string   $contactName
     * @return Customer
     */
    public function setContactName($contactName);

    /**
     * @return string
     */
    public function getContactName();

    /**
     * @param  string   $updateType
     * @return Customer
     */
    public function setUpdateType($updateType);

    /**
     * @return string
     */
    public function getUpdateType();

    /**
     * @param  string   $frequency
     * @return Customer
     */
    public function setFrequency($frequency);

    /**
     * @return string
     */
    public function getFrequency();

    /**
     * @param  \DateTime $lastUpdate
     * @return Customer
     */
    public function setLastUpdate($lastUpdate);

    /**
     * @return \DateTime
     */
    public function getLastUpdate();

    /**
     * @param  string   $acesVersion
     * @return Customer
     */
    public function setAcesVersion($acesVersion);

    /**
     * @return string
     */
    public function getAcesVersion();

    /**
     * @param  string   $piesVersion
     * @return Customer
     */
    public function setPiesVersion($piesVersion);

    /**
     * @return string
     */
    public function getPiesVersion();

    /**
     * @param  boolean  $lund
     * @return Customer
     */
    public function setLund($lund);

    /**
     * @return boolean
     */
    public function getLund();

    /**
     * @param  boolean  $dfmal
     * @return Customer
     */
    public function setDfmal($dfmal);

    /**
     * @return boolean
     */
    public function getDfmal();

    /**
     * @param  boolean  $avs
     * @return Customer
     */
    public function setAvs($avs);

    /**
     * @return boolean
     */
    public function getAvs();

    /**
     * @param  boolean  $tradesman
     * @return Customer
     */
    public function setTradesman($tradesman);

    /**
     * @return boolean
     */
    public function getTradesman();

    /**
     * @param  boolean  $lmp
     * @return Customer
     */
    public function setLmp($lmp);

    /**
     * @return boolean
     */
    public function getLmp();

    /**
     * @param  boolean  $amp
     * @return Customer
     */
    public function setAmp($amp);

    /**
     * @return boolean
     */
    public function getAmp();

    /**
     * @param  boolean  $htam
     * @return Customer
     */
    public function setHtam($htam);

    /**
     * @return boolean
     */
    public function getHtam();

    /**
     * @param  boolean  $belmor
     * @return Customer
     */
    public function setBelmor($belmor);

    /**
     * @return boolean
     */
    public function getBelmor();

    /**
     * @param  boolean  $lundAll
     * @return Customer
     */
    public function setLundAll($lundAll);

    /**
     * @return boolean
     */
    public function getLundAll();

    /**
     * @param  boolean  $rampage
     * @return Customer
     */
    public function setRampage($rampage);

    /**
     * @return boolean
     */
    public function getRampage();

    /**
     * @param  boolean  $bushwacker
     * @return Customer
     */
    public function setBushwacker($bushwacker);

    /**
     * @return boolean
     */
    public function getBushwacker();

    /**
     * @param  boolean  $stampede
     * @return Customer
     */
    public function setStampede($stampede);

    /**
     * @return boolean
     */
    public function getStampede();
    
    /**
     * @param  boolean  $tonnopro
     * @return Customer
     */
    public function setTonnopro($tonnopro);
    
    /**
     * @return boolean
     */
    public function getTonnopro();

    /**
     * @param  string   $imageType
     * @return Customer
     */
    public function setImageType($imageType);

    /**
     * @return string
     */
    public function getImageType();

    /**
     * @param  boolean  $renameImages
     * @return Customer
     */
    public function setRenameImages($renameImages);

    /**
     * @return boolean
     */
    public function getRenameImages();

    /**
     * @param  boolean  $acceptVideo
     * @return Customer
     */
    public function setAcceptVideo($acceptVideo);

    /**
     * @return boolean
     */
    public function getAcceptVideo();

    /**
     * @param  string   $videoType
     * @return Customer
     */
    public function setVideoType($videoType);

    /**
     * @return string
     */
    public function getVideoType();

    /**
     * @param  string   $customerOrDealer
     * @return Customer
     */
    public function setCustomerOrDealer($customerOrDealer);

    /**
     * @return string
     */
    public function getCustomerOrDealer();

    /**
     * @return integer
     */
    public function getCustomerId();

    /**
     * @param  \RocketUser\Entity\User $user
     * @return Customer
     */
    public function setUser(\RocketUser\Entity\User $user = null);

    /**
     * @return \RocketUser\Entity\User
     */
    public function getUser();
}
