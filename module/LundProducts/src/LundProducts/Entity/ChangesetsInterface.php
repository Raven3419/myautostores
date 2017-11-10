<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Entity;

/**
 * Changesets interface
 */
interface ChangesetsInterface
{
    /**
     * @param  \DateTime  $createdAt
     * @return Changesets
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string     $createdBy
     * @return Changesets
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime  $modifiedAt
     * @return Changesets
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string     $modifiedBy
     * @return Changesets
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean    $deleted
     * @return Changesets
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean    $disabled
     * @return Changesets
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * Set approved
     *
     * @param  boolean    $approved
     * @return Changesets
     */
    public function setApproved($approved);

    /**
     * Get approved
     *
     * @return boolean
     */
    public function getApproved();

    /**
     * Set deployed
     *
     * @param  boolean    $deployed
     * @return Changesets
     */
    public function setDeployed($deployed);

    /**
     * Get deployed
     *
     * @return boolean
     */
    public function getDeployed();

    /**
     * @param  \DateTime  $uploadedAt
     * @return Changesets
     */
    public function setUploadedAt($uploadedAt);

    /**
     * Get uploadedAt
     *
     * @return \DateTime
     */
    public function getUploadedAt();

    /**
     * @param  string     $summary
     * @return Changesets
     */
    public function setSummary($summary);

    /**
     * @return string
     */
    public function getSummary();

    /**
     * @param  string     $uploadLocation
     * @return Changesets
     */
    public function setUploadLocation($uploadLocation);

    /**
     * @return string
     */
    public function getUploadLocation();

    /**
     * @return integer
     */
    public function getChangesetId();

    /**
     * Add changesetDetails
     *
     * @param  \LundProducts\Entity\ChangesetDetails $changesetDetails
     * @return Changesets
     */
    public function addChangesetDetail(\LundProducts\Entity\ChangesetDetails $changesetDetails);

    /**
     * Remove changesetDetails
     *
     * @param \LundProducts\Entity\ChangesetDetails $changesetDetails
     */
    public function removeChangesetDetail(\LundProducts\Entity\ChangesetDetails $changesetDetails);

    /**
     * Get changesetDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChangesetDetails();

    /**
     * Set asset
     *
     * @param  \RocketDam\Entity\Asset $asset
     * @return Changesets
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * Get asset
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();
}
