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
 * BrandProductCategory
 *
 * @see BrandProductCategoryInterface
 */
class BrandProductCategory implements BrandProductCategoryInterface
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
    protected $shortDescr;

    /**
     * @var string
     */
    protected $longDescr;

    /**
     * @var boolean
     */
    protected $displayStyles;

    /**
     * @var integer
     */
    protected $featured;

    /**
     * @var integer
     */
    protected $position;

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
     * @var integer
     */
    protected $brandProductCategoryId;

    /**
     * @var \LundProducts\Entity\Brands
     */
    protected $brand;

    /**
     * @var \LundProducts\Entity\ProductCategories
     */
    protected $productCategory;

    /**
     * Set createdAt
     *
     * @param  \DateTime         $createdAt
     * @return BrandProductCategory
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
     * @param  string            $createdBy
     * @return BrandProductCategory
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
     * @param  \DateTime         $modifiedAt
     * @return BrandProductCategory
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
     * @param  string            $modifiedBy
     * @return BrandProductCategory
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
     * @param  boolean           $deleted
     * @return BrandProductCategory
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
     * @param  boolean           $disabled
     * @return BrandProductCategory
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
     * Set shortDescr
     *
     * @param  string            $shortDescr
     * @return BrandProductCategory
     */
    public function setShortDescr($shortDescr)
    {
        $this->shortDescr = $shortDescr;

        return $this;
    }

    /**
     * Get shortDescr
     *
     * @return string
     */
    public function getShortDescr()
    {
        return $this->shortDescr;
    }

    /**
     * Set longDescr
     *
     * @param  string            $longDescr
     * @return BrandProductCategory
     */
    public function setLongDescr($longDescr)
    {
        $this->longDescr = $longDescr;

        return $this;
    }

    /**
     * Get longDescr
     *
     * @return string
     */
    public function getLongDescr()
    {
        return $this->longDescr;
    }

    /**
     * Set displayStyles
     *
     * @param  boolean           $displayStyles
     * @return BrandProductCategory
     */
    public function setDisplayStyles($displayStyles)
    {
        $this->displayStyles = $displayStyles;

        return $this;
    }

    /**
     * Get displayStyles
     *
     * @return boolean
     */
    public function getDisplayStyles()
    {
        return $this->displayStyles;
    }

    /**
     * Set featured
     *
     * @param  integer           $featured
     * @return BrandProductCategory
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return integer
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set position
     *
     * @param  integer           $position
     * @return BrandProductCategory
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
     * Set metaTitle
     *
     * @param  string            $metaTitle
     * @return BrandProductCategory
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
     * @param  string            $metaKeywords
     * @return BrandProductCategory
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
     * @param  string            $metaDescr
     * @return BrandProductCategory
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
     * Get brandProductCategoryId
     *
     * @return integer
     */
    public function getBrandProductCategoryId()
    {
        return $this->brandProductCategoryId;
    }

    /**
     * Set brand
     *
     * @param \LundProducts\Entity\Brands $brand
     * @return BrandProductCategory
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
     * Set productCategory
     *
     * @param \LundProducts\Entity\ProductCategories $productCategory
     * @return BrandProductCategory
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
}
