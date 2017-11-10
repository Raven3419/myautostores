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
 * ProductLines interface
 */
interface ProductLinesInterface
{
    /**
     * @param  \DateTime    $createdAt
     * @return ProductLines
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string       $createdBy
     * @return ProductLines
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime    $modifiedAt
     * @return ProductLines
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string       $modifiedBy
     * @return ProductLines
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean      $deleted
     * @return ProductLines
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean      $disabled
     * @return ProductLines
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string       $name
     * @return ProductLines
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param  string       $bpcsCode
     * @return ProductLines
     */
    public function setBpcsCode($bpcsCode);

    /**
     * @return string
     */
    public function getBpcsCode();

    /**
     * @param  string       $shortCode
     * @return ProductLines
     */
    public function setShortCode($shortCode);

    /**
     * @return string
     */
    public function getShortCode();

    /**
     * @param  string $displayName
     * @return Brands
     */
    public function setDisplayName($displayName);

    /**
     * @return string
     */
    public function getDisplayName();

    /**
     * @param  string       $overview
     * @return ProductLines
     */
    public function setOverview($overview);

    /**
     * @return string
     */
    public function getOverview();

    /**
     * @param  string       $websiteOverview
     * @return ProductLines
     */
    public function setWebsiteOverview($websiteOverview);

    /**
     * @return string
     */
    public function getWebsiteOverview();
    
    /**
     * @param  string       $teaser
     * @return ProductLines
     */
    public function setTeaser($teaser);
    
    /**
     * @return string
     */
    public function getTeaser();

    /**
     * @param  integer      $position
     * @return ProductLines
     */
    public function setPosition($position);

    /**
     * @return integer
     */
    public function getPosition();

    /**
     * @param  integer      $brandPosition
     * @return ProductLines
     */
    public function setBrandPosition($brandPosition);

    /**
     * @return integer
     */
    public function getBrandPosition();

    /**
     * @param  integer      $saleable
     * @return ProductLines
     */
    public function setSaleable($saleable);

    /**
     * @return integer
     */
    public function getSaleable();

    /**
     * @param  string       $installationVideo
     * @return ProductLines
     */
    public function setInstallationVideo($installationVideo);

    /**
     * @return string
     */
    public function getInstallationVideo();

    /**
     * @param  string       $metaTitle
     * @return ProductLines
     */
    public function setMetaTitle($metaTitle);

    /**
     * @return string
     */
    public function getMetaTitle();

    /**
     * @param  string       $metaKeywords
     * @return ProductLines
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * @return string
     */
    public function getMetaKeywords();

    /**
     * @param  string       $metaDescr
     * @return ProductLines
     */
    public function setMetaDescr($metaDescr);

    /**
     * @return string
     */
    public function getMetaDescr();

    /**
     * @param  string $totalRating
     * @return ProductLines
     */
    public function setTotalRating($totalRating);

    /**
     * @return string
     */
    public function getTotalRating();

    /**
     * @param  integer      $totalCount
     * @return ProductLines
     */
    public function setTotalCount($totalCount);

    /**
     * @return integer
     */
    public function getTotalCount();

    /**
     * @return integer
     */
    public function getProductLineId();

    /**
     * @param  \LundSite\Entity\ComparisonChart $comparisonChart
     * @return ProductLines
     */
    public function setComparisonChart(\LundSite\Entity\ComparisonChart $comparisonChart = null);

    /**
     * @return \LundSite\Entity\ComparisonChart
     */
    public function getComparisonChart();

    /**
     * @param  \LundProducts\Entity\ProductCategories $productCategory
     * @return ProductLines
     */
    public function setProductCategory(\LundProducts\Entity\ProductCategories $productCategory = null);

    /**
     * @return \LundProducts\Entity\ProductCategories
     */
    public function getProductCategory();

    /**
     * @param  \LundProducts\Entity\Brands $brand
     * @return ProductLines
     */
    public function setBrand(\LundProducts\Entity\Brands $brand = null);

    /**
     * @return \LundProducts\Entity\Brands
     */
    public function getBrand();

    /**
     * @param  \LundProducts\Entity\Brands $origBrand
     * @return ProductLines
     */
    public function setOrigBrand(\LundProducts\Entity\Brands $origBrand = null);

    /**
     * @return \LundProducts\Entity\Brands
     */
    public function getOrigBrand();

    /**
     * @param  \LundProducts\Entity\ProductLineAsset $productLineAsset
     * @return ProductLines
     */
    public function setProductLineAsset(\LundProducts\Entity\ProductLineAsset $productLineAsset = null);

    /**
     * @return \LundProducts\Entity\ProductLineAsset
     */
    public function getProductLineAsset();
}
