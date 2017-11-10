<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Entity
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Entity;

/**
 * Changesets
 *
 * @see ChangesetsInterface
 */
class Changesets implements ChangesetsInterface
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
     * @var boolean
     */
    protected $approved;

    /**
     * @var boolean
     */
    protected $deployed;

    /**
     * @var \DateTime
     */
    protected $uploadedAt;

    /**
     * @var string
     */
    protected $summary;

    /**
     * @var string
     */
    protected $uploadLocation;

    /**
     * @var integer
     */
    protected $changesetId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $changesetDetails;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $asset;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->changesetDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime  $createdAt
     * @return Changesets
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
     * @param  string     $createdBy
     * @return Changesets
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
     * @param  \DateTime  $modifiedAt
     * @return Changesets
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
     * @param  string     $modifiedBy
     * @return Changesets
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
     * @param  boolean    $deleted
     * @return Changesets
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
     * @param  boolean    $disabled
     * @return Changesets
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
     * Set approved
     *
     * @param  boolean    $approved
     * @return Changesets
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set deployed
     *
     * @param  boolean    $deployed
     * @return Changesets
     */
    public function setDeployed($deployed)
    {
        $this->deployed = $deployed;

        return $this;
    }

    /**
     * Get deployed
     *
     * @return boolean
     */
    public function getDeployed()
    {
        return $this->deployed;
    }

    /**
     * Set uploadedAt
     *
     * @param  \DateTime  $uploadedAt
     * @return Changesets
     */
    public function setUploadedAt($uploadedAt)
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }

    /**
     * Get uploadedAt
     *
     * @return \DateTime
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    /**
     * Set summary
     *
     * @param  string     $summary
     * @return Changesets
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set uploadLocation
     *
     * @param  string     $uploadLocation
     * @return Changesets
     */
    public function setUploadLocation($uploadLocation)
    {
        $this->uploadLocation = $uploadLocation;

        return $this;
    }

    /**
     * Get uploadLocation
     *
     * @return string
     */
    public function getUploadLocation()
    {
        return $this->uploadLocation;
    }

    /**
     * Get changesetId
     *
     * @return integer
     */
    public function getChangesetId()
    {
        return $this->changesetId;
    }

    /**
     * Add changesetDetails
     *
     * @param  \LundProducts\Entity\ChangesetDetails $changesetDetails
     * @return Changesets
     */
    public function addChangesetDetail(\LundProducts\Entity\ChangesetDetails $changesetDetails)
    {
        $this->changesetDetails[] = $changesetDetails;

        return $this;
    }

    /**
     * Remove changesetDetails
     *
     * @param \LundProducts\Entity\ChangesetDetails $changesetDetails
     */
    public function removeChangesetDetail(\LundProducts\Entity\ChangesetDetails $changesetDetails)
    {
        $this->changesetDetails->removeElement($changesetDetails);
    }

    /**
     * Get changesetDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChangesetDetails()
    {
        return $this->changesetDetails;
    }

    /**
     * Set asset
     *
     * @param  \RocketDam\Entity\Asset $asset
     * @return Changesets
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
