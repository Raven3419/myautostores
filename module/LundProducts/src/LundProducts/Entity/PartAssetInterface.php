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
 * PartAsset Interface
 */
interface PartAssetInterface
{
    /**
     * @param  string    $amazonName
     * @return PartAsset
     */
    public function setAmazonName($amazonName);

    /**
     * @return string
     */
    public function getAmazonName();

    /**
     * @param  integer   $assetSeq
     * @return PartAsset
     */
    public function setAssetSeq($assetSeq);

    /**
     * @return integer
     */
    public function getAssetSeq();

    /**
     * @param  string    $picType
     * @return PartAsset
     */
    public function setPicType($picType);

    /**
     * @return string
     */
    public function getPicType();

    /**
     * @return integer
     */
    public function getPartAssetId();

    /**
     * @param  \LundProducts\Entity\Parts $part
     * @return PartAsset
     */
    public function setPart(\LundProducts\Entity\Parts $part = null);

    /**
     * @return \LundProducts\Entity\Parts
     */
    public function getPart();

    /**
     * @param  \RocketDam\Entity\Asset $asset
     * @return PartAsset
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();

    /**
     * @param  string    $assetType
     * @return PartAsset
     */
    public function setAssetType($assetType);

    /**
     * @return string
     */
    public function getAssetType();

    /**
     * @param  string    $videoType
     * @return PartAsset
     */
    public function setVideoType($videoType);

    /**
     * @return string
     */
    public function getVideoType();
}
