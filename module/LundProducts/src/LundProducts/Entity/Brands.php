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
 * Brands
 *
 * @see BrandsInterface
 */
class Brands implements BrandsInterface
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
    protected $shortCode;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $aaiaid;

    /**
     * @var string
     */
    protected $html;

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
    protected $brandId;

    /**
     * @var \LundProducts\Entity\Brands
     */
    protected $parentBrand;

    /**
     * @var \LundProducts\Entity\BrandProductCategory
     */
    protected $brandProductCategory;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $asset;

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Brands
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
     * @param  string $createdBy
     * @return Brands
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
     * @param  \DateTime $modifiedAt
     * @return Brands
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
     * @param  string $modifiedBy
     * @return Brands
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
     * @param  boolean $deleted
     * @return Brands
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
     * @param  boolean $disabled
     * @return Brands
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
     * @param  string $name
     * @return Brands
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
     * Set shortCode
     *
     * @param  string $shortCode
     * @return Brands
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
     * Set label
     *
     * @param  string $label
     * @return Brands
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set aaiaid
     *
     * @param  string $aaiaid
     * @return Brands
     */
    public function setAaiaid($aaiaid)
    {
        $this->aaiaid = $aaiaid;

        return $this;
    }

    /**
     * Get aaiaid
     *
     * @return string
     */
    public function getAaiaid()
    {
        return $this->aaiaid;
    }

    /**
     * Set html
     *
     * @param  string $html
     * @return Brands
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set metaTitle
     *
     * @param  string            $metaTitle
     * @return ProductCategories
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
     * @return ProductCategories
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
     * @return ProductCategories
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
     * Get brandId
     *
     * @return integer
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * Set parentBrand
     *
     * @param  \LundProducts\Entity\Brands $parentBrand
     * @return Brands
     */
    public function setParentBrand(\LundProducts\Entity\Brands $parentBrand = null)
    {
        $this->parentBrand = $parentBrand;

        return $this;
    }

    /**
     * Get parentBrand
     *
     * @return \LundProducts\Entity\Brands
     */
    public function getParentBrand()
    {
        return $this->parentBrand;
    }

    /**
     * Set brandProductCategory
     *
     * @param  \LundProducts\Entity\BrandProductCategory $brandProductCategory
     * @return Brands
     */
    public function setBrandProductCategory(\LundProducts\Entity\BrandProductCategory $brandProductCategory = null)
    {
        $this->brandProductCategory = $brandProductCategory;

        return $this;
    }

    /**
     * Get brandProductCategory
     *
     * @return \LundProducts\Entity\BrandProductCategory
     */
    public function getBrandProductCategory()
    {
        return $this->brandProductCategory;
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
}
