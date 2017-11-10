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

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductLineAsset
 *
 * @see ProductLineAssetInterface
 */
class ProductLineAsset implements ProductLineAssetInterface
{
    /**
     * @var integer
     */
    protected $productLineAssetId;

    /**
     * @var \LundProducts\Entity\ProductLines
     */
    protected $productLine;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $asset;

    /**
     * @var integer
     */
    protected $assetSeq;

    /**
     * @var string
     */
    protected $assetType;

    /**
     * @var string
     */
    protected $videoType;

    /**
     * Set assetSeq
     *
     * @param  integer          $assetSeq
     * @return ProductLineAsset
     */
    public function setAssetSeq($assetSeq)
    {
        $this->assetSeq = $assetSeq;

        return $this;
    }

    /**
     * Get assetSeq
     *
     * @return integer
     */
    public function getAssetSeq()
    {
        return $this->assetSeq;
    }

    /**
     * Get productLineAssetId
     *
     * @return integer
     */
    public function getProductLineAssetId()
    {
        return $this->productLineAssetId;
    }

    /**
     * Set productLine
     *
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return ProductLineAsset
     */
    public function setProductLine(\LundProducts\Entity\ProductLines $productLine = null)
    {
        $this->productLine = $productLine;

        return $this;
    }

    /**
     * Get productLine
     *
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLine()
    {
        return $this->productLine;
    }

    /**
     * Set asset
     *
     * @param  \RocketDam\Entity\Asset $asset
     * @return ProductLineAsset
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
     * Set assetType
     *
     * @param  string           $assetType
     * @return ProductLineAsset
     */
    public function setAssetType($assetType)
    {
        $this->assetType = $assetType;

        return $this;
    }

    /**
     * Get assetType
     *
     * @return string
     */
    public function getAssetType()
    {
        return $this->assetType;
    }

    /**
     * Set videoType
     *
     * @param  string           $videoType
     * @return ProductLineAsset
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
}
