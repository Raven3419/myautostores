<?php

namespace DoctrineORMModule\Proxy\__CG__\LundProducts\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class ProductCategories extends \LundProducts\Entity\ProductCategories implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', 'deleted', 'disabled', 'name', 'bpcsCode', 'shortCode', 'groupName', 'displayName', 'productCategoryId', 'brandProductCategory', 'asset', 'headerAsset');
        }

        return array('__isInitialized__', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', 'deleted', 'disabled', 'name', 'bpcsCode', 'shortCode', 'groupName', 'displayName', 'productCategoryId', 'brandProductCategory', 'asset', 'headerAsset');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (ProductCategories $proxy) {
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
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setBpcsCode($bpcsCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBpcsCode', array($bpcsCode));

        return parent::setBpcsCode($bpcsCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getBpcsCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBpcsCode', array());

        return parent::getBpcsCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setShortCode($shortCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShortCode', array($shortCode));

        return parent::setShortCode($shortCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getShortCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShortCode', array());

        return parent::getShortCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setGroupName($groupName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGroupName', array($groupName));

        return parent::setGroupName($groupName);
    }

    /**
     * {@inheritDoc}
     */
    public function getGroupName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGroupName', array());

        return parent::getGroupName();
    }

    /**
     * {@inheritDoc}
     */
    public function setDisplayname($displayName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDisplayname', array($displayName));

        return parent::setDisplayname($displayName);
    }

    /**
     * {@inheritDoc}
     */
    public function getDisplayName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDisplayName', array());

        return parent::getDisplayName();
    }

    /**
     * {@inheritDoc}
     */
    public function getProductCategoryId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getProductCategoryId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductCategoryId', array());

        return parent::getProductCategoryId();
    }

    /**
     * {@inheritDoc}
     */
    public function setBrandProductCategory(\LundProducts\Entity\BrandProductCategory $brandProductCategory)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBrandProductCategory', array($brandProductCategory));

        return parent::setBrandProductCategory($brandProductCategory);
    }

    /**
     * {@inheritDoc}
     */
    public function getBrandProductCategory()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBrandProductCategory', array());

        return parent::getBrandProductCategory();
    }

    /**
     * {@inheritDoc}
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAsset', array($asset));

        return parent::setAsset($asset);
    }

    /**
     * {@inheritDoc}
     */
    public function getAsset()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAsset', array());

        return parent::getAsset();
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaderAsset(\RocketDam\Entity\Asset $headerAsset = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHeaderAsset', array($headerAsset));

        return parent::setHeaderAsset($headerAsset);
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaderAsset()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHeaderAsset', array());

        return parent::getHeaderAsset();
    }

}
