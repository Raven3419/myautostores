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
 * FileLog interface
 */
interface FileLogInterface
{
    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return FileLog
     */
    public function setCreatedAt($createdAt);

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set brand
     *
     * @param  string  $brand
     * @return FileLog
     */
    public function setBrand($brand);

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand();

    /**
     * Set type
     *
     * @param  string  $type
     * @return FileLog
     */
    public function setType($type);

    /**
     * Get type
     *
     * @return string
     */
    public function getType();

    /**
     * Get fileLogId
     *
     * @return integer
     */
    public function getFileLogId();

    /**
     * Set asset
     *
     * @param  \RocketDam\Entity\Asset $asset
     * @return FileLog
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * Get asset
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();

    /**
     * Set changesets
     *
     * @param  \LundProducts\Entity\Changesets $changesets
     * @return FileLog
     */
    public function setChangesets(\LundProducts\Entity\Changesets $changesets = null);

    /**
     * Get changesets
     *
     * @return \LundProducts\Entity\Changesets
     */
    public function getChangesets();
}
