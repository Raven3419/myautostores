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
 * ProductLineAsset Interface
 */
interface ProductLineAssetInterface
{
    /**
     * @param  integer          $assetSeq
     * @return ProductLineAsset
     */
    public function setAssetSeq($assetSeq);

    /**
     * @return integer
     */
    public function getAssetSeq();

    /**
     * @return integer
     */
    public function getProductLineAssetId();

    /**
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return ProductLineAsset
     */
    public function setProductLine(\LundProducts\Entity\ProductLines $productLine = null);

    /**
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLine();

    /**
     * @param  \RocketDam\Entity\Asset $asset
     * @return ProductLineAsset
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();

    /**
     * @param  string           $assetType
     * @return ProductLineAsset
     */
    public function setAssetType($assetType);

    /**
     * @return string
     */
    public function getAssetType();

    /**
     * @param  string           $videoType
     * @return ProductLineAsset
     */
    public function setVideoType($videoType);

    /**
     * @return string
     */
    public function getVideoType();
}
