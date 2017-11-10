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
 * Brands interface
 */
interface BrandsInterface
{
    /**
     * @param  \DateTime $createdAt
     * @return Brands
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string $createdBy
     * @return Brands
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime $modifiedAt
     * @return Brands
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string $modifiedBy
     * @return Brands
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean $deleted
     * @return Brands
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean $disabled
     * @return Brands
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string $name
     * @return Brands
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param  string $shortCode
     * @return Brands
     */
    public function setShortCode($shortCode);

    /**
     * @return string
     */
    public function getShortCode();

    /**
     * @param  string $label
     * @return Brands
     */
    public function setLabel($label);

    /**
     * @return string
     */
    public function getLabel();

    /**
     * Set aaiaid
     *
     * @param  string $aaiaid
     * @return Brands
     */
    public function setAaiaid($aaiaid);

    /**
     * Get aaiaid
     *
     * @return string
     */
    public function getAaiaid();

    /**
     * Set html
     *
     * @param  string $html
     * @return Brands
     */
    public function setHtml($html);

    /**
     * Get html
     *
     * @return string
     */
    public function getHtml();

    /**
     * @param  string            $metaTitle
     * @return ProductCategories
     */
    public function setMetaTitle($metaTitle);

    /**
     * @return string
     */
    public function getMetaTitle();

    /**
     * @param  string            $metaKeywords
     * @return ProductCategories
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * @return string
     */
    public function getMetaKeywords();

    /**
     * @param  string            $metaDescr
     * @return ProductCategories
     */
    public function setMetaDescr($metaDescr);

    /**
     * @return integer
     */
    public function getBrandId();

    /**
     * @param  \LundProducts\Entity\Brands $parentBrand
     * @return Brands
     */
    public function setParentBrand(\LundProducts\Entity\Brands $parentBrand = null);

    /**
     * @return \LundProducts\Entity\Brands
     */
    public function getParentBrand();

    /**
     * @param  \LundProducts\Entity\NramdProductCategory $brandProductCategory
     * @return Brands
     */
    public function setBrandProductCategory(\LundProducts\Entity\BrandProductCategory $brandProductCategory);

    /**
     * @return \LundProducts\Entity\BrandProductCategory
     */
    public function getBrandProductCategory();

    /**
     * @param  \RocketDam\Entity\Asset $asset
     * @return PartAsset
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();
}
