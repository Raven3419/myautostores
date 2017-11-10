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
 * FileLog
 *
 * @see FileLogInterface
 */
class FileLog implements FileLogInterface
{
    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $brand;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var integer
     */
    protected $fileLogId;

    /**
     * @var \LundProducts\Entity\Changesets
     */
    protected $changesets;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $asset;

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return FileLog
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
     * Set brand
     *
     * @param  string  $brand
     * @return FileLog
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set type
     *
     * @param  string  $type
     * @return FileLog
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get fileLogId
     *
     * @return integer
     */
    public function getFileLogId()
    {
        return $this->fileLogId;
    }

    /**
     * Set asset
     *
     * @param  \RocketDam\Entity\Asset $asset
     * @return FileLog
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

    /**
     * Set changesets
     *
     * @param  \LundProducts\Entity\Changesets $changesets
     * @return FileLog
     */
    public function setChangesets(\LundProducts\Entity\Changesets $changesets = null)
    {
        $this->changesets = $changesets;

        return $this;
    }

    /**
     * Get changesets
     *
     * @return \LundProducts\Entity\Changesets
     */
    public function getChangesets()
    {
        return $this->changesets;
    }
}
