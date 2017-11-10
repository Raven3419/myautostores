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
 * ProductCategories interface
 */
interface ProductCategoriesInterface
{
    /**
     * @param  \DateTime         $createdAt
     * @return ProductCategories
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string            $createdBy
     * @return ProductCategories
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime         $modifiedAt
     * @return ProductCategories
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string            $modifiedBy
     * @return ProductCategories
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean           $deleted
     * @return ProductCategories
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean           $disabled
     * @return ProductCategories
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string            $name
     * @return ProductCategories
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
     * @param  string            $shortCode
     * @return ProductCategories
     */
    public function setShortCode($shortCode);

    /**
     * @return string
     */
    public function getGroupName();
    
    /**
     * @param  string            $groupName
     * @return ProductCategories
     */
    public function setGroupName($groupName);
    
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
     * @return integer
     */
    public function getProductCategoryId();

    /**
     * @param  \LundProducts\Entity\BrandProductCategory  $brandProductCategory
     * @return ProductCategories
     */
    public function setBrandProductCategory(\LundProducts\Entity\BrandProductCategory $brandProductCategory);

    /**
     * @return \LundProducts\Entity\BrandProductCategory
     */
    public function getBrandProductCategory();

    /**
     * @param  \RocketDam\Entity\Asset $asset
     * @return ProductCategories
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();
    
    /**
     * @param  \RocketDam\Entity\Asset $headerAsset
     * @return ProductCategories
     */
    public function setHeaderAsset(\RocketDam\Entity\Asset $headerAsset= null);
    
    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getHeaderAsset();
}
