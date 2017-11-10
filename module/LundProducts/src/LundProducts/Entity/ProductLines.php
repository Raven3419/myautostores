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
 * ProductLines
 *
 * @see ProductLinesInterface
 */
class ProductLines implements ProductLinesInterface
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
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $bpcsCode;

    /**
     * @var string
     */
    protected $shortCode;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $overview;

    /**
     * @var string
     */
    protected $websiteOverview;
    
    /**
     * @var string
     */
    protected $teaser;

    /**
     * @var integer
     */
    protected $position;

    /**
     * @var integer
     */
    protected $brandPosition;

    /**
     * @var integer
     */
    protected $totalCount;

    /**
     * @var integer
     */
    protected $saleable;

    /**
     * @var string
     */
    protected $installationVideo;

    /**
     * @var string
     */
    protected $metaTitle;

    /**
     * @var string
     */
    protected $metaKeywords;

    /**
     * @var string
     */
    protected $metaDescr;

    /**
     * @var string
     */
    protected $totalRating;

    /**
     * @var integer
     */
    protected $productLineId;

    /**
     * @var \LundProducts\Entity\ProductCategories
     */
    protected $productCategory;

    /**
     * @var \LundProducts\Entity\Brands
     */
    protected $brand;

    /**
     * @var \LundProducts\Entity\Brands
     */
    protected $origBrand;

    /**
     * @var \LundProducts\Entity\ProductLineAsset
     */
    protected $productLineAsset;

    /**
     * @var \LundSite\Entity\ComparisonChart
     */
    protected $comparisonChart;

    /**
     * Set createdAt
     *
     * @param  \DateTime    $createdAt
     * @return ProductLines
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
     * @param  string       $createdBy
     * @return ProductLines
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
     * @param  \DateTime    $modifiedAt
     * @return ProductLines
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
     * @param  string       $modifiedBy
     * @return ProductLines
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
     * @param  boolean      $deleted
     * @return ProductLines
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
     * @param  boolean      $disabled
     * @return ProductLines
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
     * Set name
     *
     * @param  string       $name
     * @return ProductLines
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
     * Set bpcsCode
     *
     * @param  string       $bpcsCode
     * @return ProductLines
     */
    public function setBpcsCode($bpcsCode)
    {
        $this->bpcsCode = $bpcsCode;

        return $this;
    }

    /**
     * Get bpcsCode
     *
     * @return string
     */
    public function getBpcsCode()
    {
        return $this->bpcsCode;
    }

    /**
     * Set shortCode
     *
     * @param  string       $shortCode
     * @return ProductLines
     */
    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * Get shortCode
     *
     * @return string
     */
    public function getShortCode()
    {
        return $this->shortCode;
    }

    /**
     * Set displayName
     *
     * @param  string $displayName
     * @return Brands
     */
    public function setDisplayname($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set overview
     *
     * @param  string       $overview
     * @return ProductLines
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * Get overview
     *
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Get websiteOverview
     *
     * @return string
     */
    public function getWebsiteOverview()
    {
        return $this->websiteOverview;
    }

    /**
     * Set websiteOverview
     *
     * @param  string       $websiteOverview
     * @return ProductLines
     */
    public function setWebsiteOverview($websiteOverview)
    {
        $this->websiteOverview = $websiteOverview;

        return $this;
    }
    
    /**
     * Get teaser
     *
     * @return string
     */
    public function getTeaser()
    {
        return $this->teaser;
    }
    
    /**
     * Set teaser
     *
     * @param  string       $teaser
     * @return ProductLines
     */
    public function setTeaser($teaser)
    {
        $this->teaser= $teaser;
        
        return $this;
    }

    /**
     * Set totalCount
     *
     * @param  integer      $totalCount
     * @return ProductLines
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    /**
     * Get totalCount
     *
     * @return integer
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * Set position
     *
     * @param  integer      $position
     * @return ProductLines
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set brandPosition
     *
     * @param  integer      $brandPosition
     * @return ProductLines
     */
    public function setBrandPosition($brandPosition)
    {
        $this->brandPosition = $brandPosition;

        return $this;
    }

    /**
     * Get brandPosition
     *
     * @return integer
     */
    public function getBrandPosition()
    {
        return $this->brandPosition;
    }

    /**
     * Set saleable
     *
     * @param  integer      $saleable
     * @return ProductLines
     */
    public function setSaleable($saleable)
    {
        $this->saleable = $saleable;

        return $this;
    }

    /**
     * Get saleable
     *
     * @return integer
     */
    public function getSaleable()
    {
        return $this->saleable;
    }

    /**
     * Set installationVideo
     *
     * @param  string       $installationVideo
     * @return ProductLines
     */
    public function setInstallationVideo($installationVideo)
    {
        $this->installationVideo = $installationVideo;

        return $this;
    }

    /**
     * Get installationVideo
     *
     * @return string
     */
    public function getInstallationVideo()
    {
        return $this->installationVideo;
    }

    /**
     * Set metaTitle
     *
     * @param  string       $metaTitle
     * @return ProductLines
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaKeywords
     *
     * @param  string       $metaKeywords
     * @return ProductLines
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set metaDescr
     *
     * @param  string       $metaDescr
     * @return ProductLines
     */
    public function setMetaDescr($metaDescr)
    {
        $this->metaDescr = $metaDescr;

        return $this;
    }

    /**
     * Get metaDescr
     *
     * @return string
     */
    public function getMetaDescr()
    {
        return $this->metaDescr;
    }

    /**
     * Set totalRating
     *
     * @param  string $totalRating
     * @return ProductLines
     */
    public function setTotalRating($totalRating)
    {
        $this->totalRating = $totalRating;

        return $this;
    }

    /**
     * Get totalRating
     *
     * @return string
     */
    public function getTotalRating()
    {
        return $this->totalRating;
    }

    /**
     * Get productLineId
     *
     * @return integer
     */
    public function getProductLineId()
    {
        return $this->productLineId;
    }

    /**
     * Set productCategory
     *
     * @param  \LundProducts\Entity\ProductCategories $productCategory
     * @return ProductLines
     */
    public function setProductCategory(\LundProducts\Entity\ProductCategories $productCategory = null)
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    /**
     * Get productCategory
     *
     * @return \LundProducts\Entity\ProductCategories
     */
    public function getProductCategory()
    {
        return $this->productCategory;
    }

    /**
     * Set brand
     *
     * @param  \LundProducts\Entity\Brands $brand
     * @return ProductLines
     */
    public function setBrand(\LundProducts\Entity\Brands $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \LundProducts\Entity\Brands
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set origBrand
     *
     * @param  \LundProducts\Entity\Brands $origBrand
     * @return ProductLines
     */
    public function setOrigBrand(\LundProducts\Entity\Brands $origBrand = null)
    {
        $this->origBrand = $origBrand;

        return $this;
    }

    /**
     * Get origBrand
     *
     * @return \LundProducts\Entity\Brands
     */
    public function getOrigBrand()
    {
        return $this->origBrand;
    }

    /**
     * Set comparisonChart
     *
     * @param  \LundSite\Entity\ComparisonChart $comparisonChart
     * @return ProductLines
     */
    public function setComparisonChart(\LundSite\Entity\ComparisonChart $comparisonChart = null)
    {
        $this->comparisonChart = $comparisonChart;

        return $this;
    }

    /**
     * Get comparisonChart
     *
     * @return \LundSite\Entity\ComparisonChart
     */
    public function getComparisonChart()
    {
        return $this->comparisonChart;
    }

    /**
     * Set productLineAsset
     *
     * @param  \LundProducts\Entity\ProductLineAsset $productLineAsset
     * @return ProductLines
     */
    public function setProductLineAsset(\LundProducts\Entity\ProductLineAsset $productLineAsset = null)
    {
        $this->productLineAsset = $productLineAsset;

        return $this;
    }

    /**
     * Get productLineAsset
     *
     * @return \LundProducts\Entity\ProductLineAsset
     */
    public function getProductLineAsset()
    {
        return $this->productLineAsset;
    }
}
