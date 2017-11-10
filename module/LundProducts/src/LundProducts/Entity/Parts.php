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
 * Parts
 *
 * @see PartsInterface
 */
class Parts implements PartsInterface
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
    protected $partNumber;

    /**
     * @var string
     */
    protected $partVariant;

    /**
     * @var string
     */
    protected $productClass;

    /**
     * @var string
     */
    protected $detail;

    /**
     * @var string
     */
    protected $jobberPrice;

    /**
     * @var string
     */
    protected $msrpPrice;

    /**
     * @var string
     */
    protected $salePrice;

    /**
     * @var string
     */
    protected $shippingPrice;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var string
     */
    protected $popCode;

    /**
     * @var string
     */
    protected $upcCode;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $weight;

    /**
     * @var string
     */
    protected $height;

    /**
     * @var string
     */
    protected $width;

    /**
     * @var string
     */
    protected $length;

    /**
     * @var boolean
     */
    protected $universal;

    /**
     * @var string
     */
    protected $countryOfOrigin;

    /**
     * @var string
     */
    protected $dima;

    /**
     * @var string
     */
    protected $dimb;

    /**
     * @var string
     */
    protected $dimc;

    /**
     * @var string
     */
    protected $dimd;

    /**
     * @var string
     */
    protected $dime;

    /**
     * @var string
     */
    protected $dimf;

    /**
     * @var string
     */
    protected $dimg;

    /**
     * @var integer
     */
    protected $partTypeId;

    /**
     * @var string
     */
    protected $lookupNumber;

    /**
     * @var string
     */
    protected $bedLength;

    /**
     * @var integer
     */
    protected $bedLengthId;

    /**
     * @var string
     */
    protected $flareHeight;

    /**
     * @var string
     */
    protected $flareTireCoverage;

    /**
     * @var string
     */
    protected $vehicleType;

    /**
     * @var string
     */
    protected $noDrill;

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
    protected $partId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $vehCollections;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $partAsset;

    /**
     * @var \LundProducts\Entity\ProductLines
     */
    protected $productLine;

    /**
     * @var \LundProducts\Entity\Parts
     */
    protected $parentPart;

    /**
     * @var string
     */
    protected $isheet;

    /**
     * @var string
     */
    protected $finish;

    /**
     * @var string
     */
    protected $style;

    /**
     * @var string
     */
    protected $material;

    /**
     * @var integer
     */
    protected $materialThickness;

    /**
     * @var string
     */
    protected $soldAs;

    /**
     * @var string
     */
    protected $tubeShape;

    /**
     * @var integer
     */
    protected $tubeSize;

    /**
     * @var string
     */
    protected $warranty;

    /**
     * @var integer
     */
    protected $liquidStorageCapacity;

    /**
     * @var string
     */
    protected $boxStyle;

    /**
     * @var string
     */
    protected $boxOpeningType;
    
    /**
     * @var string
     */
    protected $cutRequired;
    
    /**
     * @var integer
     */
    protected $rearFlareHeight;
    
    /**
     * @var integer
     */
    protected $rearFlareTireCoverage;
    
    /**
     * @var string
     */
    protected $stakeHoles;
    
    /**
     * @var string
     */
    protected $colorGroup;
    
    /**
     * @var string
     */
    protected $mapPrice;
    
    /**
     * @var boolean
     */
    protected $saleable;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vehCollections = new \Doctrine\Common\Collections\ArrayCollection();
        $this->partAsset = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Parts
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
     * @return Parts
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
     * @return Parts
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
     * @return Parts
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
     * @return Parts
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
     * @return Parts
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
     * Set partNumber
     *
     * @param  string $partNumber
     * @return Parts
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
     * Set partVariant
     *
     * @param  string $partVariant
     * @return Parts
     */
    public function setPartVariant($partVariant)
    {
        $this->partVariant = $partVariant;

        return $this;
    }

    /**
     * Get partVariant
     *
     * @return string
     */
    public function getPartVariant()
    {
        return $this->partVariant;
    }

    /**
     * Set productClass
     *
     * @param  string $productClass
     * @return Parts
     */
    public function setProductClass($productClass)
    {
        $this->productClass = $productClass;

        return $this;
    }

    /**
     * Get productClass
     *
     * @return string
     */
    public function getProductClass()
    {
        return $this->productClass;
    }

    /**
     * Set detail
     *
     * @param  string $detail
     * @return Parts
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set jobberPrice
     *
     * @param  string $jobberPrice
     * @return Parts
     */
    public function setJobberPrice($jobberPrice)
    {
        $this->jobberPrice = $jobberPrice;

        return $this;
    }

    /**
     * Get jobberPrice
     *
     * @return string
     */
    public function getJobberPrice()
    {
        return $this->jobberPrice;
    }

    /**
     * Set msrpPrice
     *
     * @param  string $msrpPrice
     * @return Parts
     */
    public function setMsrpPrice($msrpPrice)
    {
        $this->msrpPrice = $msrpPrice;

        return $this;
    }

    /**
     * Get msrpPrice
     *
     * @return string
     */
    public function getMsrpPrice()
    {
        return $this->msrpPrice;
    }

    /**
     * Set salePrice
     *
     * @param  string $salePrice
     * @return Parts
     */
    public function setSalePrice($salePrice)
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    /**
     * Get salePrice
     *
     * @return string
     */
    public function getSalePrice()
    {
        return $this->salePrice;
    }

    /**
     * Set shippingPrice
     *
     * @param  string $shippingPrice
     * @return Parts
     */
    public function setShippingPrice($shippingPrice)
    {
        $this->shippingPrice = $shippingPrice;

        return $this;
    }

    /**
     * Get shippingPrice
     *
     * @return string
     */
    public function getShippingPrice()
    {
        return $this->shippingPrice;
    }

    /**
     * Set color
     *
     * @param  string $color
     * @return Parts
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set popCode
     *
     * @param  string $popCode
     * @return Parts
     */
    public function setPopCode($popCode)
    {
        $this->popCode = $popCode;

        return $this;
    }

    /**
     * Get popCode
     *
     * @return string
     */
    public function getPopCode()
    {
        return $this->popCode;
    }

    /**
     * Set upcCode
     *
     * @param  string $upcCode
     * @return Parts
     */
    public function setUpcCode($upcCode)
    {
        $this->upcCode = $upcCode;

        return $this;
    }

    /**
     * Get upcCode
     *
     * @return string
     */
    public function getUpcCode()
    {
        return $this->upcCode;
    }

    /**
     * Set status
     *
     * @param  string $status
     * @return Parts
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set weight
     *
     * @param  string $weight
     * @return Parts
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set height
     *
     * @param  string $height
     * @return Parts
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set width
     *
     * @param  string $width
     * @return Parts
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set length
     *
     * @param  string $length
     * @return Parts
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return string
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set universal
     *
     * @param  boolean $universal
     * @return Parts
     */
    public function setUniversal($universal)
    {
        $this->universal = $universal;

        return $this;
    }

    /**
     * Get universal
     *
     * @return boolean
     */
    public function getUniversal()
    {
        return $this->universal;
    }

    /**
     * Set countryOfOrigin
     *
     * @param  string $countryOfOrigin
     * @return Parts
     */
    public function setCountryOfOrigin($countryOfOrigin)
    {
        $this->countryOfOrigin = $countryOfOrigin;

        return $this;
    }

    /**
     * Get countryOfOrigin
     *
     * @return string
     */
    public function getCountryOfOrigin()
    {
        return $this->countryOfOrigin;
    }

    /**
     * Set dima
     *
     * @param  string $dima
     * @return Parts
     */
    public function setDima($dima)
    {
        $this->dima = $dima;

        return $this;
    }

    /**
     * Get dima
     *
     * @return string
     */
    public function getDima()
    {
        return $this->dima;
    }

    /**
     * Set dimb
     *
     * @param  string $dimb
     * @return Parts
     */
    public function setDimb($dimb)
    {
        $this->dimb = $dimb;

        return $this;
    }

    /**
     * Get dimb
     *
     * @return string
     */
    public function getDimb()
    {
        return $this->dimb;
    }

    /**
     * Set dimc
     *
     * @param  string $dimc
     * @return Parts
     */
    public function setDimc($dimc)
    {
        $this->dimc = $dimc;

        return $this;
    }

    /**
     * Get dimc
     *
     * @return string
     */
    public function getDimc()
    {
        return $this->dimc;
    }

    /**
     * Set dimd
     *
     * @param  string $dimd
     * @return Parts
     */
    public function setDimd($dimd)
    {
        $this->dimd = $dimd;

        return $this;
    }

    /**
     * Get dimd
     *
     * @return string
     */
    public function getDimd()
    {
        return $this->dimd;
    }

    /**
     * Set dime
     *
     * @param  string $dime
     * @return Parts
     */
    public function setDime($dime)
    {
        $this->dime = $dime;

        return $this;
    }

    /**
     * Get dime
     *
     * @return string
     */
    public function getDime()
    {
        return $this->dime;
    }

    /**
     * Set dimf
     *
     * @param  string $dimf
     * @return Parts
     */
    public function setDimf($dimf)
    {
        $this->dimf = $dimf;

        return $this;
    }

    /**
     * Get dimf
     *
     * @return string
     */
    public function getDimf()
    {
        return $this->dimf;
    }

    /**
     * Set dimg
     *
     * @param  string $dimg
     * @return Parts
     */
    public function setDimg($dimg)
    {
        $this->dimg = $dimg;

        return $this;
    }

    /**
     * Get dimg
     *
     * @return string
     */
    public function getDimg()
    {
        return $this->dimg;
    }

    /**
     * Set partTypeId
     *
     * @param  integer $partTypeId
     * @return Parts
     */
    public function setPartTypeId($partTypeId)
    {
        $this->partTypeId = $partTypeId;

        return $this;
    }

    /**
     * Get partTypeId
     *
     * @return integer
     */
    public function getPartTypeId()
    {
        return $this->partTypeId;
    }

    /**
     * Set lookup_number
     *
     * @param  string $lookup_number
     * @return Parts
     */
    public function setLookupNumber($lookupNumber)
    {
        $this->lookupNumber = $lookupNumber;

        return $this;
    }

    /**
     * Get lookup_number
     *
     * @return string
     */
    public function getLookupNumber()
    {
        return $this->lookupNumber;
    }

    /**
     * Set bed_length
     *
     * @param  string $bedLength
     * @return Parts
     */
    public function setBedLength($bedLength)
    {
        $this->bedLength = $bedLength;

        return $this;
    }

    /**
     * Get bed_length
     *
     * @return string
     */
    public function getBedLength()
    {
        return $this->bedLength;
    }

    /**
     * Set BedLengthId
     *
     * @param  integer $partTypeId
     * @return Parts
     */
    public function setBedLengthId($partTypeId)
    {
        $this->bedLengthId = $bedLengthId;

        return $this;
    }

    /**
     * Get BedLengthId
     *
     * @return integer
     */
    public function getBedLengthId()
    {
        return $this->bedLengthId;
    }

    /**
     * Set flareHeight
     *
     * @param  string $flareHeight
     * @return Parts
     */
    public function setFlareHeight($flareHeight)
    {
        $this->flareHeight = $flareHeight;

        return $this;
    }

    /**
     * Get flareHeight
     *
     * @return string
     */
    public function getFlareHeight()
    {
        return $this->flareHeight;
    }

    /**
     * Set flareTireCoverage
     *
     * @param  string $flareTireCoverage
     * @return Parts
     */
    public function setFlareTireCoverage($flareTireCoverage)
    {
        $this->flareTireCoverage = $flareTireCoverage;

        return $this;
    }

    /**
     * Get flareTireCoverage
     *
     * @return string
     */
    public function getFlareTireCoverage()
    {
        return $this->flareTireCoverage;
    }

    /**
     * Set vehicleType
     *
     * @param  string $vehicleType
     * @return Parts
     */
    public function setVehicleType($vehicleType)
    {
        $this->vehicleType = $vehicleType;

        return $this;
    }

    /**
     * Get vehicleType
     *
     * @return string
     */
    public function getVehicleType()
    {
        return $this->vehicleType;
    }

    /**
     * Set noDrill
     *
     * @param  string $noDrill
     * @return Parts
     */
    public function setNoDrill($noDrill)
    {
        $this->noDrill = $noDrill;

        return $this;
    }

    /**
     * Get noDrill
     *
     * @return string
     */
    public function getNoDrill()
    {
        return $this->noDrill;
    }

    /**
     * Set metaTitle
     *
     * @param  string            $metaTitle
     * @return Parts
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
     * @return Parts
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
     * @return Parts
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
     * Get partId
     *
     * @return integer
     */
    public function getPartId()
    {
        return $this->partId;
    }

    /**
     * Add vehCollections
     *
     * @param  \LundProducts\Entity\PartVehCollection $vehCollections
     * @return Parts
     */
    public function addVehCollection(\LundProducts\Entity\PartVehCollection $vehCollections)
    {
        $this->vehCollections[] = $vehCollections;

        return $this;
    }

    /**
     * Remove vehCollections
     *
     * @param \LundProducts\Entity\PartVehCollection $vehCollections
     */
    public function removeVehCollection(\LundProducts\Entity\PartVehCollection $vehCollections)
    {
        $this->vehCollections->removeElement($vehCollections);
    }

    /**
     * Get vehCollections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehCollections()
    {
        return $this->vehCollections;
    }

    /**
     * Add partAsset
     *
     * @param  \LundProducts\Entity\PartAsset $partAsset
     * @return Parts
     */
    public function addPartAsset(\LundProducts\Entity\PartAsset $partAsset)
    {
        $this->partAsset[] = $partAsset;

        return $this;
    }

    /**
     * Remove partAsset
     *
     * @param \LundProducts\Entity\PartAsset $partAsset
     */
    public function removePartAsset(\LundProducts\Entity\PartAsset $partAsset)
    {
        $this->partAsset->removeElement($partAsset);
    }

    /**
     * Get partAsset
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartAsset()
    {
        return $this->partAsset;
    }

    /**
     * Set productLine
     *
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return Parts
     */
    public function setProductLine(\LundProducts\Entity\ProductLines $productLine = null)
    {
        $this->productLine = $productLine;

        return $this;
    }

    /**
     * Get productLine
     *
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLine()
    {
        return $this->productLine;
    }

    /**
     * Set parentPart
     *
     * @param  \LundProducts\Entity\Parts $parentPart
     * @return Parts
     */
    public function setParentPart(\LundProducts\Entity\Parts $parentPart = null)
    {
        $this->parentPart = $parentPart;

        return $this;
    }

    /**
     * Get parentPart
     *
     * @return \LundProducts\Entity\Parts
     */
    public function getParentPart()
    {
        return $this->parentPart;
    }

    /**
     * Set isheet
     *
     * @param  string $isheet
     * @return Parts
     */
    public function setIsheet($isheet = null)
    {
        $this->isheet = $isheet;

        return $this;
    }

    /**
     * Get isheet
     *
     * @return string
     */
    public function getIsheet()
    {
        return $this->isheet;
    }

    /**
     * Set finish
     *
     * @param  string $finish
     * @return Parts
     */
    public function setFinish($finish = null)
    {
        $this->finish = $finish;

        return $this;
    }

    /**
     * Get finish
     *
     * @return string
     */
    public function getFinish()
    {
        return $this->finish;
    }

    /**
     * Set style
     *
     * @param  string $style
     * @return Parts
     */
    public function setStyle($style = null)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set material
     *
     * @param  string $material
     * @return Parts
     */
    public function setMaterial($material = null)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return string
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set materialThickness
     *
     * @param  integer $materialThickness
     * @return Parts
     */
    public function setMaterialThickness($materialThickness)
    {
        $this->materialThickness = $materialThickness;

        return $this;
    }

    /**
     * Get materialThickness
     *
     * @return integer
     */
    public function getMaterialThickness()
    {
        return $this->materialThickness;
    }

    /**
     * Set soldAs
     *
     * @param  string $soldAs
     * @return Parts
     */
    public function setSoldAs($soldAs = null)
    {
        $this->soldAs = $soldAs;

        return $this;
    }

    /**
     * Get soldAs
     *
     * @return string
     */
    public function getSoldAs()
    {
        return $this->soldAs;
    }

    /**
     * Set tubeShape
     *
     * @param  string $tubeShape
     * @return Parts
     */
    public function setTubeShape($tubeShape = null)
    {
        $this->tubeShape = $tubeShape;

        return $this;
    }

    /**
     * Get tubeShape
     *
     * @return string
     */
    public function getTubeShape()
    {
        return $this->tubeShape;
    }

    /**
     * Set tubeSize
     *
     * @param  integer $tubeSize
     * @return Parts
     */
    public function setTubeSize($tubeSize)
    {
        $this->tubeSize = $tubeSize;

        return $this;
    }

    /**
     * Get tubeSize
     *
     * @return integer
     */
    public function getTubeSize()
    {
        return $this->tubeSize;
    }

    /**
     * Set warranty
     *
     * @param  string $warranty
     * @return Parts
     */
    public function setWarranty($warranty = null)
    {
        $this->warranty = $warranty;

        return $this;
    }

    /**
     * Get warranty
     *
     * @return string
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Set liquidStorageCapacity
     *
     * @param  integer $liquidStorageCapacity
     * @return Parts
     */
    public function setLiquidStorageCapacity($liquidStorageCapacity)
    {
        $this->liquidStorageCapacity = $liquidStorageCapacity;

        return $this;
    }

    /**
     * Get liquidStorageCapacity
     *
     * @return integer
     */
    public function getLiquidStorageCapacity()
    {
        return $this->liquidStorageCapacity;
    }

    /**
     * Set boxStyle
     *
     * @param  string $boxStyle
     * @return Parts
     */
    public function setBoxStyle($boxStyle = null)
    {
        $this->boxStyle = $boxStyle;

        return $this;
    }

    /**
     * Get boxStyle
     *
     * @return string
     */
    public function getBoxStyle()
    {
        return $this->boxStyle;
    }

    /**
     * Set boxOpeningType
     *
     * @param  string $boxOpeningType
     * @return Parts
     */
    public function setBoxOpeningType($boxOpeningType = null)
    {
        $this->boxOpeningType = $boxOpeningType;

        return $this;
    }

    /**
     * Get boxOpeningType
     *
     * @return string
     */
    public function getBoxOpeningType()
    {
        return $this->boxOpeningType;
    }
    
    /**
     * Set cutRequired
     *
     * @param  string $cutRequired
     * @return Parts
     */
    public function setCutRequired($cutRequired= null)
    {
        $this->cutRequired= $cutRequired;
        
        return $this;
    }
    
    /**
     * Get cutRequired
     *
     * @return string
     */
    public function getCutRequired()
    {
        return $this->cutRequired;
    }
    
    /**
     * Set rearFlareHeight
     *
     * @param  integer $rearFlareHeight
     * @return Parts
     */
    public function setRearFlareHeight($rearFlareHeight= null)
    {
        $this->rearFlareHeight= $rearFlareHeight;
        
        return $this;
    }
    
    /**
     * Get rearFlareHeight
     *
     * @return integer
     */
    public function getRearFlareHeight()
    {
        return $this->rearFlareHeight;
    }
    
    /**
     * Set rearFlareTireCoverage
     *
     * @param  integer $rearFlareTireCoverage
     * @return Parts
     */
    public function setRearFlareTireCoverage($rearFlareTireCoverage= null)
    {
        $this->rearFlareTireCoverage= $rearFlareTireCoverage;
        
        return $this;
    }
    
    /**
     * Get rearFlareTireCoverage
     *
     * @return integer
     */
    public function getRearFlareTireCoverage()
    {
        return $this->rearFlareTireCoverage;
    }
    
    /**
     * Set stakeHoles
     *
     * @param  string $stakeHoles
     * @return Parts
     */
    public function setStakeHoles($stakeHoles= null)
    {
        $this->stakeHoles= $stakeHoles;
        
        return $this;
    }
    
    /**
     * Get stakeHoles
     *
     * @return string
     */
    public function getStakeHoles()
    {
        return $this->stakeHoles;
    }
    
    /**
     * Set colorGroup
     *
     * @param  string $colorGroup
     * @return Parts
     */
    public function setColorGroup($colorGroup= null)
    {
        $this->colorGroup= $colorGroup;
        
        return $this;
    }
    
    /**
     * Get colorGroup
     *
     * @return string
     */
    public function getColorGroup()
    {
        return $this->colorGroup;
    }
    
    /**
     * Set mapPrice
     *
     * @param  string $mapPrice
     * @return Parts
     */
    public function setMapPrice($mapPrice)
    {
        $this->mapPrice= $mapPrice;
        
        return $this;
    }
    
    /**
     * Get mapPrice
     *
     * @return string
     */
    public function getMapPrice()
    {
        return $this->mapPrice;
    }
    
    /**
     * Set saleable
     *
     * @param  boolean $saleable
     * @return Parts
     */
    public function setSaleable($saleable)
    {
        $this->saleable= $saleable;
        
        return $this;
    }
    
    /**
     * Get saleable
     *
     * @return boolean
     */
    public function getSaleable()
    {
        return $this->saleable;
    }
}
