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
 * BrandProductCategory interface
 */
interface BrandProductCategoryInterface
{
    /**
     * @param  \DateTime         $createdAt
     * @return BrandProductCategory
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string            $createdBy
     * @return BrandProductCategory
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime         $modifiedAt
     * @return BrandProductCategory
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string            $modifiedBy
     * @return BrandProductCategory
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean           $deleted
     * @return BrandProductCategory
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean           $disabled
     * @return BrandProductCategory
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string            $shortDescr
     * @return BrandProductCategory
     */
    public function setShortDescr($shortDescr);

    /**
     * @return string
     */
    public function getShortDescr();

    /**
     * @param  string            $longDescr
     * @return BrandProductCategory
     */
    public function setLongDescr($longDescr);

    /**
     * @return string
     */
    public function getLongDescr();

    /**
     * @param  boolean           $displayStyles
     * @return BrandProductCategory
     */
    public function setDisplayStyles($displayStyles);

    /**
     * @return boolean
     */
    public function getDisplayStyles();

    /**
     * @param  integer           $featured
     * @return BrandProductCategory
     */
    public function setFeatured($featured);

    /**
     * @return integer
     */
    public function getFeatured();

    /**
     * @param  integer           $position
     * @return BrandProductCategory
     */
    public function setPosition($position);

    /**
     * @return integer
     */
    public function getPosition();

    /**
     * @param  string            $metaTitle
     * @return BrandProductCategory
     */
    public function setMetaTitle($metaTitle);

    /**
     * @return string
     */
    public function getMetaTitle();

    /**
     * @param  string            $metaKeywords
     * @return BrandProductCategory
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * @return string
     */
    public function getMetaKeywords();

    /**
     * @param  string            $metaDescr
     * @return BrandProductCategory
     */
    public function setMetaDescr($metaDescr);

    /**
     * @return string
     */
    public function getMetaDescr();

    /**
     * @return integer
     */
    public function getBrandProductCategoryId();

    /**
     * @param \LundProducts\Entity\Brands $brand
     * @return BrandProductCategory
     */
    public function setBrand(\LundProducts\Entity\Brands $brand = null);

    /**
     * @return \LundProducts\Entity\Brands
     */
    public function getBrand();

    /**
     * @param \LundProducts\Entity\ProductCategories $productCategory
     * @return BrandProductCategory
     */
    public function setProductCategory(\LundProducts\Entity\ProductCategories $productCategory = null);

    /**
     * @return \LundProducts\Entity\ProductCategories
     */
    public function getProductCategory();
}
