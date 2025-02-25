<?php

namespace DoctrineORMModule\Proxy\__CG__\LundProducts\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Parts extends \LundProducts\Entity\Parts implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', 'deleted', 'disabled', 'partNumber', 'partVariant', 'productClass', 'detail', 'jobberPrice', 'msrpPrice', 'salePrice', 'shippingPrice', 'color', 'popCode', 'upcCode', 'status', 'weight', 'height', 'width', 'length', 'universal', 'countryOfOrigin', 'dima', 'dimb', 'dimc', 'dimd', 'dime', 'dimf', 'dimg', 'partTypeId', 'lookupNumber', 'bedLength', 'bedLengthId', 'flareHeight', 'flareTireCoverage', 'vehicleType', 'noDrill', 'metaTitle', 'metaKeywords', 'metaDescr', 'partId', 'vehCollections', 'partAsset', 'productLine', 'parentPart', 'isheet', 'finish', 'style', 'material', 'materialThickness', 'soldAs', 'tubeShape', 'tubeSize', 'warranty', 'liquidStorageCapacity', 'boxStyle', 'boxOpeningType', 'cutRequired', 'rearFlareHeight', 'rearFlareTireCoverage', 'stakeHoles', 'colorGroup', 'mapPrice', 'saleable');
        }

        return array('__isInitialized__', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', 'deleted', 'disabled', 'partNumber', 'partVariant', 'productClass', 'detail', 'jobberPrice', 'msrpPrice', 'salePrice', 'shippingPrice', 'color', 'popCode', 'upcCode', 'status', 'weight', 'height', 'width', 'length', 'universal', 'countryOfOrigin', 'dima', 'dimb', 'dimc', 'dimd', 'dime', 'dimf', 'dimg', 'partTypeId', 'lookupNumber', 'bedLength', 'bedLengthId', 'flareHeight', 'flareTireCoverage', 'vehicleType', 'noDrill', 'metaTitle', 'metaKeywords', 'metaDescr', 'partId', 'vehCollections', 'partAsset', 'productLine', 'parentPart', 'isheet', 'finish', 'style', 'material', 'materialThickness', 'soldAs', 'tubeShape', 'tubeSize', 'warranty', 'liquidStorageCapacity', 'boxStyle', 'boxOpeningType', 'cutRequired', 'rearFlareHeight', 'rearFlareTireCoverage', 'stakeHoles', 'colorGroup', 'mapPrice', 'saleable');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Parts $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function setCreatedAt($createdAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedAt', array($createdAt));

        return parent::setCreatedAt($createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedAt', array());

        return parent::getCreatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedBy($createdBy)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedBy', array($createdBy));

        return parent::setCreatedBy($createdBy);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedBy', array());

        return parent::getCreatedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function setModifiedAt($modifiedAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModifiedAt', array($modifiedAt));

        return parent::setModifiedAt($modifiedAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getModifiedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModifiedAt', array());

        return parent::getModifiedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setModifiedBy($modifiedBy)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModifiedBy', array($modifiedBy));

        return parent::setModifiedBy($modifiedBy);
    }

    /**
     * {@inheritDoc}
     */
    public function getModifiedBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModifiedBy', array());

        return parent::getModifiedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function setDeleted($deleted)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDeleted', array($deleted));

        return parent::setDeleted($deleted);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeleted()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeleted', array());

        return parent::getDeleted();
    }

    /**
     * {@inheritDoc}
     */
    public function setDisabled($disabled)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDisabled', array($disabled));

        return parent::setDisabled($disabled);
    }

    /**
     * {@inheritDoc}
     */
    public function getDisabled()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDisabled', array());

        return parent::getDisabled();
    }

    /**
     * {@inheritDoc}
     */
    public function setPartNumber($partNumber)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPartNumber', array($partNumber));

        return parent::setPartNumber($partNumber);
    }

    /**
     * {@inheritDoc}
     */
    public function getPartNumber()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPartNumber', array());

        return parent::getPartNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function setPartVariant($partVariant)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPartVariant', array($partVariant));

        return parent::setPartVariant($partVariant);
    }

    /**
     * {@inheritDoc}
     */
    public function getPartVariant()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPartVariant', array());

        return parent::getPartVariant();
    }

    /**
     * {@inheritDoc}
     */
    public function setProductClass($productClass)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProductClass', array($productClass));

        return parent::setProductClass($productClass);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductClass()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductClass', array());

        return parent::getProductClass();
    }

    /**
     * {@inheritDoc}
     */
    public function setDetail($detail)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDetail', array($detail));

        return parent::setDetail($detail);
    }

    /**
     * {@inheritDoc}
     */
    public function getDetail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDetail', array());

        return parent::getDetail();
    }

    /**
     * {@inheritDoc}
     */
    public function setJobberPrice($jobberPrice)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setJobberPrice', array($jobberPrice));

        return parent::setJobberPrice($jobberPrice);
    }

    /**
     * {@inheritDoc}
     */
    public function getJobberPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getJobberPrice', array());

        return parent::getJobberPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setMsrpPrice($msrpPrice)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMsrpPrice', array($msrpPrice));

        return parent::setMsrpPrice($msrpPrice);
    }

    /**
     * {@inheritDoc}
     */
    public function getMsrpPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMsrpPrice', array());

        return parent::getMsrpPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setSalePrice($salePrice)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSalePrice', array($salePrice));

        return parent::setSalePrice($salePrice);
    }

    /**
     * {@inheritDoc}
     */
    public function getSalePrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSalePrice', array());

        return parent::getSalePrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setShippingPrice($shippingPrice)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShippingPrice', array($shippingPrice));

        return parent::setShippingPrice($shippingPrice);
    }

    /**
     * {@inheritDoc}
     */
    public function getShippingPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShippingPrice', array());

        return parent::getShippingPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setColor($color)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setColor', array($color));

        return parent::setColor($color);
    }

    /**
     * {@inheritDoc}
     */
    public function getColor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getColor', array());

        return parent::getColor();
    }

    /**
     * {@inheritDoc}
     */
    public function setPopCode($popCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPopCode', array($popCode));

        return parent::setPopCode($popCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getPopCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPopCode', array());

        return parent::getPopCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpcCode($upcCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpcCode', array($upcCode));

        return parent::setUpcCode($upcCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpcCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpcCode', array());

        return parent::getUpcCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($status));

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setWeight($weight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWeight', array($weight));

        return parent::setWeight($weight);
    }

    /**
     * {@inheritDoc}
     */
    public function getWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWeight', array());

        return parent::getWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setHeight($height)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHeight', array($height));

        return parent::setHeight($height);
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHeight', array());

        return parent::getHeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setWidth($width)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWidth', array($width));

        return parent::setWidth($width);
    }

    /**
     * {@inheritDoc}
     */
    public function getWidth()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWidth', array());

        return parent::getWidth();
    }

    /**
     * {@inheritDoc}
     */
    public function setLength($length)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLength', array($length));

        return parent::setLength($length);
    }

    /**
     * {@inheritDoc}
     */
    public function getLength()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLength', array());

        return parent::getLength();
    }

    /**
     * {@inheritDoc}
     */
    public function setUniversal($universal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUniversal', array($universal));

        return parent::setUniversal($universal);
    }

    /**
     * {@inheritDoc}
     */
    public function getUniversal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUniversal', array());

        return parent::getUniversal();
    }

    /**
     * {@inheritDoc}
     */
    public function setCountryOfOrigin($countryOfOrigin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCountryOfOrigin', array($countryOfOrigin));

        return parent::setCountryOfOrigin($countryOfOrigin);
    }

    /**
     * {@inheritDoc}
     */
    public function getCountryOfOrigin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCountryOfOrigin', array());

        return parent::getCountryOfOrigin();
    }

    /**
     * {@inheritDoc}
     */
    public function setDima($dima)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDima', array($dima));

        return parent::setDima($dima);
    }

    /**
     * {@inheritDoc}
     */
    public function getDima()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDima', array());

        return parent::getDima();
    }

    /**
     * {@inheritDoc}
     */
    public function setDimb($dimb)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDimb', array($dimb));

        return parent::setDimb($dimb);
    }

    /**
     * {@inheritDoc}
     */
    public function getDimb()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDimb', array());

        return parent::getDimb();
    }

    /**
     * {@inheritDoc}
     */
    public function setDimc($dimc)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDimc', array($dimc));

        return parent::setDimc($dimc);
    }

    /**
     * {@inheritDoc}
     */
    public function getDimc()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDimc', array());

        return parent::getDimc();
    }

    /**
     * {@inheritDoc}
     */
    public function setDimd($dimd)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDimd', array($dimd));

        return parent::setDimd($dimd);
    }

    /**
     * {@inheritDoc}
     */
    public function getDimd()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDimd', array());

        return parent::getDimd();
    }

    /**
     * {@inheritDoc}
     */
    public function setDime($dime)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDime', array($dime));

        return parent::setDime($dime);
    }

    /**
     * {@inheritDoc}
     */
    public function getDime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDime', array());

        return parent::getDime();
    }

    /**
     * {@inheritDoc}
     */
    public function setDimf($dimf)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDimf', array($dimf));

        return parent::setDimf($dimf);
    }

    /**
     * {@inheritDoc}
     */
    public function getDimf()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDimf', array());

        return parent::getDimf();
    }

    /**
     * {@inheritDoc}
     */
    public function setDimg($dimg)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDimg', array($dimg));

        return parent::setDimg($dimg);
    }

    /**
     * {@inheritDoc}
     */
    public function getDimg()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDimg', array());

        return parent::getDimg();
    }

    /**
     * {@inheritDoc}
     */
    public function setPartTypeId($partTypeId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPartTypeId', array($partTypeId));

        return parent::setPartTypeId($partTypeId);
    }

    /**
     * {@inheritDoc}
     */
    public function getPartTypeId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPartTypeId', array());

        return parent::getPartTypeId();
    }

    /**
     * {@inheritDoc}
     */
    public function setLookupNumber($lookupNumber)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLookupNumber', array($lookupNumber));

        return parent::setLookupNumber($lookupNumber);
    }

    /**
     * {@inheritDoc}
     */
    public function getLookupNumber()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLookupNumber', array());

        return parent::getLookupNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function setBedLength($bedLength)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBedLength', array($bedLength));

        return parent::setBedLength($bedLength);
    }

    /**
     * {@inheritDoc}
     */
    public function getBedLength()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBedLength', array());

        return parent::getBedLength();
    }

    /**
     * {@inheritDoc}
     */
    public function setBedLengthId($partTypeId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBedLengthId', array($partTypeId));

        return parent::setBedLengthId($partTypeId);
    }

    /**
     * {@inheritDoc}
     */
    public function getBedLengthId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBedLengthId', array());

        return parent::getBedLengthId();
    }

    /**
     * {@inheritDoc}
     */
    public function setFlareHeight($flareHeight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFlareHeight', array($flareHeight));

        return parent::setFlareHeight($flareHeight);
    }

    /**
     * {@inheritDoc}
     */
    public function getFlareHeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFlareHeight', array());

        return parent::getFlareHeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setFlareTireCoverage($flareTireCoverage)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFlareTireCoverage', array($flareTireCoverage));

        return parent::setFlareTireCoverage($flareTireCoverage);
    }

    /**
     * {@inheritDoc}
     */
    public function getFlareTireCoverage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFlareTireCoverage', array());

        return parent::getFlareTireCoverage();
    }

    /**
     * {@inheritDoc}
     */
    public function setVehicleType($vehicleType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVehicleType', array($vehicleType));

        return parent::setVehicleType($vehicleType);
    }

    /**
     * {@inheritDoc}
     */
    public function getVehicleType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVehicleType', array());

        return parent::getVehicleType();
    }

    /**
     * {@inheritDoc}
     */
    public function setNoDrill($noDrill)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNoDrill', array($noDrill));

        return parent::setNoDrill($noDrill);
    }

    /**
     * {@inheritDoc}
     */
    public function getNoDrill()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNoDrill', array());

        return parent::getNoDrill();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetaTitle($metaTitle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetaTitle', array($metaTitle));

        return parent::setMetaTitle($metaTitle);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaTitle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetaTitle', array());

        return parent::getMetaTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetaKeywords($metaKeywords)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetaKeywords', array($metaKeywords));

        return parent::setMetaKeywords($metaKeywords);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaKeywords()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetaKeywords', array());

        return parent::getMetaKeywords();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetaDescr($metaDescr)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetaDescr', array($metaDescr));

        return parent::setMetaDescr($metaDescr);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaDescr()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetaDescr', array());

        return parent::getMetaDescr();
    }

    /**
     * {@inheritDoc}
     */
    public function getPartId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getPartId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPartId', array());

        return parent::getPartId();
    }

    /**
     * {@inheritDoc}
     */
    public function addVehCollection(\LundProducts\Entity\PartVehCollection $vehCollections)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addVehCollection', array($vehCollections));

        return parent::addVehCollection($vehCollections);
    }

    /**
     * {@inheritDoc}
     */
    public function removeVehCollection(\LundProducts\Entity\PartVehCollection $vehCollections)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeVehCollection', array($vehCollections));

        return parent::removeVehCollection($vehCollections);
    }

    /**
     * {@inheritDoc}
     */
    public function getVehCollections()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVehCollections', array());

        return parent::getVehCollections();
    }

    /**
     * {@inheritDoc}
     */
    public function addPartAsset(\LundProducts\Entity\PartAsset $partAsset)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPartAsset', array($partAsset));

        return parent::addPartAsset($partAsset);
    }

    /**
     * {@inheritDoc}
     */
    public function removePartAsset(\LundProducts\Entity\PartAsset $partAsset)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removePartAsset', array($partAsset));

        return parent::removePartAsset($partAsset);
    }

    /**
     * {@inheritDoc}
     */
    public function getPartAsset()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPartAsset', array());

        return parent::getPartAsset();
    }

    /**
     * {@inheritDoc}
     */
    public function setProductLine(\LundProducts\Entity\ProductLines $productLine = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProductLine', array($productLine));

        return parent::setProductLine($productLine);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductLine()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductLine', array());

        return parent::getProductLine();
    }

    /**
     * {@inheritDoc}
     */
    public function setParentPart(\LundProducts\Entity\Parts $parentPart = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParentPart', array($parentPart));

        return parent::setParentPart($parentPart);
    }

    /**
     * {@inheritDoc}
     */
    public function getParentPart()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParentPart', array());

        return parent::getParentPart();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsheet($isheet = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsheet', array($isheet));

        return parent::setIsheet($isheet);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsheet()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsheet', array());

        return parent::getIsheet();
    }

    /**
     * {@inheritDoc}
     */
    public function setFinish($finish = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFinish', array($finish));

        return parent::setFinish($finish);
    }

    /**
     * {@inheritDoc}
     */
    public function getFinish()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFinish', array());

        return parent::getFinish();
    }

    /**
     * {@inheritDoc}
     */
    public function setStyle($style = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStyle', array($style));

        return parent::setStyle($style);
    }

    /**
     * {@inheritDoc}
     */
    public function getStyle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStyle', array());

        return parent::getStyle();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaterial($material = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaterial', array($material));

        return parent::setMaterial($material);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaterial()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaterial', array());

        return parent::getMaterial();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaterialThickness($materialThickness)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaterialThickness', array($materialThickness));

        return parent::setMaterialThickness($materialThickness);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaterialThickness()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaterialThickness', array());

        return parent::getMaterialThickness();
    }

    /**
     * {@inheritDoc}
     */
    public function setSoldAs($soldAs = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSoldAs', array($soldAs));

        return parent::setSoldAs($soldAs);
    }

    /**
     * {@inheritDoc}
     */
    public function getSoldAs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSoldAs', array());

        return parent::getSoldAs();
    }

    /**
     * {@inheritDoc}
     */
    public function setTubeShape($tubeShape = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTubeShape', array($tubeShape));

        return parent::setTubeShape($tubeShape);
    }

    /**
     * {@inheritDoc}
     */
    public function getTubeShape()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTubeShape', array());

        return parent::getTubeShape();
    }

    /**
     * {@inheritDoc}
     */
    public function setTubeSize($tubeSize)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTubeSize', array($tubeSize));

        return parent::setTubeSize($tubeSize);
    }

    /**
     * {@inheritDoc}
     */
    public function getTubeSize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTubeSize', array());

        return parent::getTubeSize();
    }

    /**
     * {@inheritDoc}
     */
    public function setWarranty($warranty = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWarranty', array($warranty));

        return parent::setWarranty($warranty);
    }

    /**
     * {@inheritDoc}
     */
    public function getWarranty()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWarranty', array());

        return parent::getWarranty();
    }

    /**
     * {@inheritDoc}
     */
    public function setLiquidStorageCapacity($liquidStorageCapacity)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLiquidStorageCapacity', array($liquidStorageCapacity));

        return parent::setLiquidStorageCapacity($liquidStorageCapacity);
    }

    /**
     * {@inheritDoc}
     */
    public function getLiquidStorageCapacity()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLiquidStorageCapacity', array());

        return parent::getLiquidStorageCapacity();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoxStyle($boxStyle = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoxStyle', array($boxStyle));

        return parent::setBoxStyle($boxStyle);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoxStyle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoxStyle', array());

        return parent::getBoxStyle();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoxOpeningType($boxOpeningType = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoxOpeningType', array($boxOpeningType));

        return parent::setBoxOpeningType($boxOpeningType);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoxOpeningType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoxOpeningType', array());

        return parent::getBoxOpeningType();
    }

    /**
     * {@inheritDoc}
     */
    public function setCutRequired($cutRequired = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCutRequired', array($cutRequired));

        return parent::setCutRequired($cutRequired);
    }

    /**
     * {@inheritDoc}
     */
    public function getCutRequired()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCutRequired', array());

        return parent::getCutRequired();
    }

    /**
     * {@inheritDoc}
     */
    public function setRearFlareHeight($rearFlareHeight = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRearFlareHeight', array($rearFlareHeight));

        return parent::setRearFlareHeight($rearFlareHeight);
    }

    /**
     * {@inheritDoc}
     */
    public function getRearFlareHeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRearFlareHeight', array());

        return parent::getRearFlareHeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setRearFlareTireCoverage($rearFlareTireCoverage = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRearFlareTireCoverage', array($rearFlareTireCoverage));

        return parent::setRearFlareTireCoverage($rearFlareTireCoverage);
    }

    /**
     * {@inheritDoc}
     */
    public function getRearFlareTireCoverage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRearFlareTireCoverage', array());

        return parent::getRearFlareTireCoverage();
    }

    /**
     * {@inheritDoc}
     */
    public function setStakeHoles($stakeHoles = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStakeHoles', array($stakeHoles));

        return parent::setStakeHoles($stakeHoles);
    }

    /**
     * {@inheritDoc}
     */
    public function getStakeHoles()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStakeHoles', array());

        return parent::getStakeHoles();
    }

    /**
     * {@inheritDoc}
     */
    public function setColorGroup($colorGroup = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setColorGroup', array($colorGroup));

        return parent::setColorGroup($colorGroup);
    }

    /**
     * {@inheritDoc}
     */
    public function getColorGroup()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getColorGroup', array());

        return parent::getColorGroup();
    }

    /**
     * {@inheritDoc}
     */
    public function setMapPrice($mapPrice)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMapPrice', array($mapPrice));

        return parent::setMapPrice($mapPrice);
    }

    /**
     * {@inheritDoc}
     */
    public function getMapPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMapPrice', array());

        return parent::getMapPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setSaleable($saleable)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSaleable', array($saleable));

        return parent::setSaleable($saleable);
    }

    /**
     * {@inheritDoc}
     */
    public function getSaleable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSaleable', array());

        return parent::getSaleable();
    }

}
