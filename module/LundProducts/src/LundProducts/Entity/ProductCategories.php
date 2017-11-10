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
 * ProductCategories
 *
 * @see ProductCategoriesInterface
 */
class ProductCategories implements ProductCategoriesInterface
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
    protected $groupName;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var integer
     */
    protected $productCategoryId;

    /**
     * @var \LundProducts\Entity\BrandProductCategory
     */
    protected $brandProductCategory;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $asset;
    
    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $headerAsset;

    /**
     * Set createdAt
     *
     * @param  \DateTime         $createdAt
     * @return ProductCategories
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
     * @return ProductCategories
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
     * @return ProductCategories
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
     * @return ProductCategories
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
     * @return ProductCategories
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
     * @return ProductCategories
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
     * @param  string            $name
     * @return ProductCategories
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
     * @param  string            $shortCode
     * @return ProductCategories
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
     * Set groupName
     *
     * @param  string            $groupName
     * @return ProductCategories
     */
    public function setGroupName($groupName)
    {
        $this->groupName= $groupName;
        
        return $this;
    }
    
    /**
     * Get groupName
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
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
     * Get productCategoryId
     *
     * @return integer
     */
    public function getProductCategoryId()
    {
        return $this->productCategoryId;
    }

    /**
     * Set brandProductCategory
     *
     * @param  \LundProducts\Entity\BrandProductCategory $brandProductCategory
     * @return ProductCategories
     */
    public function setBrandProductCategory(\LundProducts\Entity\BrandProductCategory $brandProductCategory)
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
     * @return ProductCategories
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
     * Set headerAsset
     *
     * @param  \RocketDam\Entity\Asset $headerAsset
     * @return ProductCategories
     */
    public function setHeaderAsset(\RocketDam\Entity\Asset $headerAsset= null)
    {
        $this->headerAsset= $headerAsset;
        
        return $this;
    }
    
    /**
     * Get headerAsset
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getHeaderAsset()
    {
        return $this->headerAsset;
    }
}
