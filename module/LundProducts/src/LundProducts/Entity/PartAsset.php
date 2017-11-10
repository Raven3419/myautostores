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
 * PartAsset
 *
 * @see PartAssetInterface
 */
class PartAsset implements PartAssetInterface
{
    /**
     * @var string
     */
    protected $amazonName;

    /**
     * @var string
     */
    protected $picType;

    /**
     * @var integer
     */
    protected $partAssetId;

    /**
     * @var \LundProducts\Entity\Parts
     */
    protected $part;

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
     * Set amazonName
     *
     * @param  string    $amazonName
     * @return PartAsset
     */
    public function setAmazonName($amazonName)
    {
        $this->amazonName = $amazonName;

        return $this;
    }

    /**
     * Get amazonName
     *
     * @return string
     */
    public function getAmazonName()
    {
        return $this->amazonName;
    }

    /**
     * Set assetSeq
     *
     * @param  integer   $assetSeq
     * @return PartAsset
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
     * Set picType
     *
     * @param  string    $picType
     * @return PartAsset
     */
    public function setPicType($picType)
    {
        $this->picType = $picType;

        return $this;
    }

    /**
     * Get picType
     *
     * @return string
     */
    public function getPicType()
    {
        return $this->picType;
    }

    /**
     * Get partAssetId
     *
     * @return integer
     */
    public function getPartAssetId()
    {
        return $this->partAssetId;
    }

    /**
     * Set part
     *
     * @param  \LundProducts\Entity\Parts $part
     * @return PartAsset
     */
    public function setPart(\LundProducts\Entity\Parts $part = null)
    {
        $this->part = $part;

        return $this;
    }

    /**
     * Get part
     *
     * @return \LundProducts\Entity\Parts
     */
    public function getPart()
    {
        return $this->part;
    }

    /**
     * Set asset
     *
     * @param  \RocketDam\Entity\Asset $asset
     * @return PartAsset
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
     * @param  string    $assetType
     * @return PartAsset
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
     * @param  string    $videoType
     * @return PartAsset
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
