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
 * ChangesetDetails interface
 */
interface ChangesetDetailsInterface
{
    /**
     * Set partNumber
     *
     * @param  string           $partNumber
     * @return ChangesetDetails
     */
    public function setPartNumber($partNumber);

    /**
     * Get partNumber
     *
     * @return string
     */
    public function getPartNumber();

    /**
     * Set brandLabel
     *
     * @param  string           $brandLabel
     * @return ChangesetDetails
     */
    public function setBrandLabel($brandLabel);

    /**
     * Get brandLabel
     *
     * @return string
     */
    public function getBrandLabel();

    /**
     * Set productCategoryLabel
     *
     * @param  string           $productCategoryLabel
     * @return ChangesetDetails
     */
    public function setProductCategoryLabel($productCategoryLabel);

    /**
     * Get productCategoryLabel
     *
     * @return string
     */
    public function getProductCategoryLabel();

    /**
     * Set productLineLabel
     *
     * @param  string           $productLineLabel
     * @return ChangesetDetails
     */
    public function setProductLineLabel($productLineLabel);

    /**
     * Get productLineLabel
     *
     * @return string
     */
    public function getProductLineLabel();

    /**
     * Set partId
     *
     * @param  integer          $partId
     * @return ChangesetDetails
     */
    public function setPartId($partId);

    /**
     * Get partId
     *
     * @return integer
     */
    public function getPartId();

    /**
     * Set appChanged
     *
     * @param  boolean          $appChanged
     * @return ChangesetDetails
     */
    public function setAppChanged($appChanged);

    /**
     * Get sappChanged
     *
     * @return boolean
     */
    public function getAppChanged();

    /**
     * Set statusChanged
     *
     * @param  boolean          $statusChanged
     * @return ChangesetDetails
     */
    public function setStatusChanged($statusChanged);

    /**
     * Get statusChanged
     *
     * @return boolean
     */
    public function getStatusChanged();

    /**
     * Set countryChanged
     *
     * @param  boolean          $countryChanged
     * @return ChangesetDetails
     */
    public function setCountryChanged($countryChanged);

    /**
     * Get countryChanged
     *
     * @return boolean
     */
    public function getCountryChanged();

    /**
     * Set popChanged
     *
     * @param  boolean          $popChanged
     * @return ChangesetDetails
     */
    public function setPopChanged($popChanged);

    /**
     * Get popChanged
     *
     * @return boolean
     */
    public function getPopChanged();

    /**
     * Set colorChanged
     *
     * @param  boolean          $colorChanged
     * @return ChangesetDetails
     */
    public function setColorChanged($colorChanged);

    /**
     * Get colorChanged
     *
     * @return boolean
     */
    public function getColorChanged();

    /**
     * Set dimsChanged
     *
     * @param  boolean          $dimsChanged
     * @return ChangesetDetails
     */
    public function setDimsChanged($dimsChanged);

    /**
     * Get dimsChanged
     *
     * @return boolean
     */
    public function getDimsChanged();

    /**
     * Set classChanged
     *
     * @param  boolean          $classChanged
     * @return ChangesetDetails
     */
    public function setClassChanged($classChanged);

    /**
     * Get classChanged
     *
     * @return boolean
     */
    public function getClassChanged();

    /**
     * Set imageChanged
     *
     * @param  boolean          $imageChanged
     * @return ChangesetDetails
     */
    public function setImageChanged($imageChanged);

    /**
     * Get imageChanged
     *
     * @return boolean
     */
    public function getImageChanged();
    
    /**
     * Set yearChanged
     *
     * @param  boolean          $yearChanged
     * @return ChangesetDetails
     */
    public function setYearChanged($yearChanged);
    
    /**
     * Get yearChanged
     *
     * @return boolean
    */
    public function getYearChanged();

    /**
     * Set change
     *
     * @param  string           $change
     * @return ChangesetDetails
     */
    public function setChange($change);

    /**
     * Get change
     *
     * @return string
     */
    public function getChange();

    /**
     * Set changeFileRow
     *
     * @param  string           $changeFileRow
     * @return ChangesetDetails
     */
    public function setChangeFileRow($changeFileRow);

    /**
     * Get changeFileRow
     *
     * @return string
     */
    public function getChangeFileRow();

    /**
     * Get changesetDetailId
     *
     * @return integer
     */
    public function getChangesetDetailId();

    /**
     * Set parts
     *
     * @param  \LundProducts\Entity\Parts $parts
     * @return ChangesetDetails
     */
    public function setParts(\LundProducts\Entity\Parts $parts = null);

    /**
     * Get parts
     *
     * @return \LundProducts\Entity\Parts
     */
    public function getParts();

    /**
     * Set brand
     *
     * @param  \LundProducts\Entity\Brands $brand
     * @return ChangesetDetails
     */
    public function setBrand(\LundProducts\Entity\Brands $brand = null);

    /**
     * Get brand
     *
     * @return \LundProducts\Entity\Brands
     */
    public function getBrand();

    /**
     * Set productCategories
     *
     * @param  \LundProducts\Entity\ProductCategories $productCategories
     * @return ChangesetDetails
     */
    public function setProductCategories(\LundProducts\Entity\ProductCategories $productCategories = null);

    /**
     * Get productCategories
     *
     * @return \LundProducts\Entity\ProductCategories
     */
    public function getProductCategories();

    /**
     * Set productLines
     *
     * @param  \LundProducts\Entity\ProductLines $productLines
     * @return ChangesetDetails
     */
    public function setProductLines(\LundProducts\Entity\ProductLines $productLines = null);

    /**
     * Get productLines
     *
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLines();

    /**
     * Set changesets
     *
     * @param  \LundProducts\Entity\Changesets $changesets
     * @return ChangesetDetails
     */
    public function setChangesets(\LundProducts\Entity\Changesets $changesets = null);

    /**
     * Get changesets
     *
     * @return \LundProducts\Entity\Changesets
     */
    public function getChangesets();

    /**
     * Set part
     *
     * @param  \LundProducts\Entity\Parts $part
     * @return ChangesetDetails
     */
    public function setPart(\LundProducts\Entity\Parts $part = null);

    /**
     * Get part
     *
     * @return \LundProducts\Entity\Parts
     */
    public function getPart();
}
