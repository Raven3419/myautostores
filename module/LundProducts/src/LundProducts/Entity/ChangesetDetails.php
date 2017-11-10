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
 * ChangesetDetails
 *
 * @see ChangesetDetailsInterface
 */
class ChangesetDetails implements ChangesetDetailsInterface
{
    /**
     * @var string
     */
    protected $partNumber;

    /**
     * @var string
     */
    protected $brandLabel;

    /**
     * @var string
     */
    protected $productCategoryLabel;

    /**
     * @var string
     */
    protected $productLineLabel;

    /**
     * @var integer
     */
    protected $partId;

    /**
     * @var boolean
     */
    protected $appChanged;

    /**
     * @var boolean
     */
    protected $statusChanged;

    /**
     * @var boolean
     */
    protected $countryChanged;

    /**
     * @var boolean
     */
    protected $popChanged;

    /**
     * @var boolean
     */
    protected $colorChanged;

    /**
     * @var boolean
     */
    protected $dimsChanged;

    /**
     * @var boolean
     */
    protected $classChanged;

    /**
     * @var boolean
     */
    protected $imageChanged;
    
    /**
     * @var boolean
     */
    protected $yearChanged;

    /**
     * @var string
     */
    protected $change;

    /**
     * @var string
     */
    protected $changeFileRow;

    /**
     * @var integer
     */
    protected $changesetDetailId;

    /**
     * @var \LundProducts\Entity\Parts
     */
    protected $parts;

    /**
     * @var \LundProducts\Entity\Brands
     */
    protected $brand;

    /**
     * @var \LundProducts\Entity\ProductCategories
     */
    protected $productCategories;

    /**
     * @var \LundProducts\Entity\ProductLines
     */
    protected $productLines;

    /**
     * @var \LundProducts\Entity\Changesets
     */
    protected $changesets;

    /**
     * @var \LundProducts\Entity\Parts
     */
    protected $part;

    /**
     * Set partNumber
     *
     * @param  string           $partNumber
     * @return ChangesetDetails
     */
    public function setPartNumber($partNumber)
    {
        $this->partNumber = $partNumber;

        return $this;
    }

    /**
     * Get partNumber
     *
     * @return string
     */
    public function getPartNumber()
    {
        return $this->partNumber;
    }

    /**
     * Set brandLabel
     *
     * @param  string           $brandLabel
     * @return ChangesetDetails
     */
    public function setBrandLabel($brandLabel)
    {
        $this->brandLabel = $brandLabel;

        return $this;
    }

    /**
     * Get brandLabel
     *
     * @return string
     */
    public function getBrandLabel()
    {
        return $this->brandLabel;
    }

    /**
     * Set productCategoryLabel
     *
     * @param  string           $productCategoryLabel
     * @return ChangesetDetails
     */
    public function setProductCategoryLabel($productCategoryLabel)
    {
        $this->productCategoryLabel = $productCategoryLabel;

        return $this;
    }

    /**
     * Get productCategoryLabel
     *
     * @return string
     */
    public function getProductCategoryLabel()
    {
        return $this->productCategoryLabel;
    }

    /**
     * Set productLineLabel
     *
     * @param  string           $productLineLabel
     * @return ChangesetDetails
     */
    public function setProductLineLabel($productLineLabel)
    {
        $this->productLineLabel = $productLineLabel;

        return $this;
    }

    /**
     * Get productLineLabel
     *
     * @return string
     */
    public function getProductLineLabel()
    {
        return $this->productLineLabel;
    }

    /**
     * Set partId
     *
     * @param  integer          $partId
     * @return ChangesetDetails
     */
    public function setPartId($partId)
    {
        $this->partId = $partId;

        return $this;
    }

    /**
     * Get partId
     *
     * @return integer
     */
    public function getPartId()
    {
        return $this->partId;
    }

    /**
     * Set appChanged
     *
     * @param  string           $appChanged
     * @return ChangesetDetails
     */
    public function setAppChanged($appChanged)
    {
        $this->appChanged = $appChanged;

        return $this;
    }

    /**
     * Get appChanged
     *
     * @return string
     */
    public function getAppChanged()
    {
        return $this->appChanged;
    }

    /**
     * Set statusChanged
     *
     * @param  string           $statusChanged
     * @return ChangesetDetails
     */
    public function setStatusChanged($statusChanged)
    {
        $this->statusChanged = $statusChanged;

        return $this;
    }

    /**
     * Get statusChanged
     *
     * @return string
     */
    public function getStatusChanged()
    {
        return $this->statusChanged;
    }

    /**
     * Set countryChanged
     *
     * @param  string           $countryChanged
     * @return ChangesetDetails
     */
    public function setCountryChanged($countryChanged)
    {
        $this->countryChanged = $countryChanged;

        return $this;
    }

    /**
     * Get countryChanged
     *
     * @return string
     */
    public function getCountryChanged()
    {
        return $this->countryChanged;
    }

    /**
     * Set popChanged
     *
     * @param  string           $popChanged
     * @return ChangesetDetails
     */
    public function setPopChanged($popChanged)
    {
        $this->popChanged = $popChanged;

        return $this;
    }

    /**
     * Get popChanged
     *
     * @return string
     */
    public function getPopChanged()
    {
        return $this->popChanged;
    }

    /**
     * Set colorChanged
     *
     * @param  string           $colorChanged
     * @return ChangesetDetails
     */
    public function setColorChanged($colorChanged)
    {
        $this->colorChanged = $colorChanged;

        return $this;
    }

    /**
     * Get colorChanged
     *
     * @return string
     */
    public function getColorChanged()
    {
        return $this->colorChanged;
    }

    /**
     * Set dimsChanged
     *
     * @param  string           $dimsChanged
     * @return ChangesetDetails
     */
    public function setDimsChanged($dimsChanged)
    {
        $this->dimsChanged = $dimsChanged;

        return $this;
    }

    /**
     * Get dimsChanged
     *
     * @return string
     */
    public function getDimsChanged()
    {
        return $this->dimsChanged;
    }

    /**
     * Set classChanged
     *
     * @param  string           $classChanged
     * @return ChangesetDetails
     */
    public function setClassChanged($classChanged)
    {
        $this->classChanged = $classChanged;

        return $this;
    }

    /**
     * Get classChanged
     *
     * @return string
     */
    public function getClassChanged()
    {
        return $this->classChanged;
    }

    /**
     * Set imageChanged
     *
     * @param  string           $imageChanged
     * @return ChangesetDetails
     */
    public function setImageChanged($imageChanged)
    {
        $this->imageChanged = $imageChanged;

        return $this;
    }

    /**
     * Get imageChanged
     *
     * @return string
     */
    public function getImageChanged()
    {
        return $this->imageChanged;
    }

    /**
     * Set yearChanged
     *
     * @param  string           $yearChanged
     * @return ChangesetDetails
     */
    public function setYearChanged($yearChanged)
    {
    	$this->yearChanged = $yearChanged;
    
    	return $this;
    }
    
    /**
     * Get yearChanged
     *
     * @return string
     */
    public function getYearChanged()
    {
    	return $this->yearChanged;
    }
    
    /**
     * Set change
     *
     * @param  string           $change
     * @return ChangesetDetails
     */
    public function setChange($change)
    {
        $this->change = $change;

        return $this;
    }

    /**
     * Get change
     *
     * @return string
     */
    public function getChange()
    {
        return $this->change;
    }

    /**
     * Set changeFileRow
     *
     * @param  string           $changeFileRow
     * @return ChangesetDetails
     */
    public function setChangeFileRow($changeFileRow)
    {
        $this->changeFileRow = $changeFileRow;

        return $this;
    }

    /**
     * Get changeFileRow
     *
     * @return string
     */
    public function getChangeFileRow()
    {
        return $this->changeFileRow;
    }

    /**
     * Get changesetDetailId
     *
     * @return integer
     */
    public function getChangesetDetailId()
    {
        return $this->changesetDetailId;
    }

    /**
     * Set parts
     *
     * @param  \LundProducts\Entity\Parts $parts
     * @return ChangesetDetails
     */
    public function setParts(\LundProducts\Entity\Parts $parts = null)
    {
        $this->parts = $parts;

        return $this;
    }

    /**
     * Get parts
     *
     * @return \LundProducts\Entity\Parts
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * Set brand
     *
     * @param  \LundProducts\Entity\Brands $brand
     * @return ChangesetDetails
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
     * Set productCategories
     *
     * @param  \LundProducts\Entity\ProductCategories $productCategories
     * @return ChangesetDetails
     */
    public function setProductCategories(\LundProducts\Entity\ProductCategories $productCategories = null)
    {
        $this->productCategories = $productCategories;

        return $this;
    }

    /**
     * Get productCategories
     *
     * @return \LundProducts\Entity\ProductCategories
     */
    public function getProductCategories()
    {
        return $this->productCategories;
    }

    /**
     * Set productLines
     *
     * @param  \LundProducts\Entity\ProductLines $productLines
     * @return ChangesetDetails
     */
    public function setProductLines(\LundProducts\Entity\ProductLines $productLines = null)
    {
        $this->productLines = $productLines;

        return $this;
    }

    /**
     * Get productLines
     *
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLines()
    {
        return $this->productLines;
    }

    /**
     * Set changesets
     *
     * @param  \LundProducts\Entity\Changesets $changesets
     * @return ChangesetDetails
     */
    public function setChangesets(\LundProducts\Entity\Changesets $changesets = null)
    {
        $this->changesets = $changesets;

        return $this;
    }

    /**
     * Get changesets
     *
     * @return \LundProducts\Entity\Changesets
     */
    public function getChangesets()
    {
        return $this->changesets;
    }

    /**
     * Set part
     *
     * @param  \LundProducts\Entity\Parts $part
     * @return ChangesetDetails
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
}
