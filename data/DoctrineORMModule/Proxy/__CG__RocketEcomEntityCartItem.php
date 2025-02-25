<?php

namespace DoctrineORMModule\Proxy\__CG__\RocketEcom\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CartItem extends \RocketEcom\Entity\CartItem implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', 'deleted', 'disabled', 'productId', 'quantity', 'description', 'price', 'newPrice', 'promoFlag', 'couponFlag', 'weight', 'length', 'height', 'width', 'upcCode', 'productLinesAsset', 'cartItemId', 'cart', 'parts', 'promo');
        }

        return array('__isInitialized__', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', 'deleted', 'disabled', 'productId', 'quantity', 'description', 'price', 'newPrice', 'promoFlag', 'couponFlag', 'weight', 'length', 'height', 'width', 'upcCode', 'productLinesAsset', 'cartItemId', 'cart', 'parts', 'promo');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CartItem $proxy) {
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
    public function setProductId($productId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProductId', array($productId));

        return parent::setProductId($productId);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductId', array());

        return parent::getProductId();
    }

    /**
     * {@inheritDoc}
     */
    public function setQuantity($quantity)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setQuantity', array($quantity));

        return parent::setQuantity($quantity);
    }

    /**
     * {@inheritDoc}
     */
    public function getQuantity()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQuantity', array());

        return parent::getQuantity();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', array($description));

        return parent::setDescription($description);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', array());

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrice($price)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrice', array($price));

        return parent::setPrice($price);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrice', array());

        return parent::getPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setNewPrice($newPrice)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNewPrice', array($newPrice));

        return parent::setNewPrice($newPrice);
    }

    /**
     * {@inheritDoc}
     */
    public function getNewPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNewPrice', array());

        return parent::getNewPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setPromoFlag($promoFlag)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPromoFlag', array($promoFlag));

        return parent::setPromoFlag($promoFlag);
    }

    /**
     * {@inheritDoc}
     */
    public function getPromoFlag()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPromoFlag', array());

        return parent::getPromoFlag();
    }

    /**
     * {@inheritDoc}
     */
    public function setCouponFlag($couponFlag)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCouponFlag', array($couponFlag));

        return parent::setCouponFlag($couponFlag);
    }

    /**
     * {@inheritDoc}
     */
    public function getCouponFlag()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCouponFlag', array());

        return parent::getCouponFlag();
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
    public function getCartItemId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getCartItemId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCartItemId', array());

        return parent::getCartItemId();
    }

    /**
     * {@inheritDoc}
     */
    public function setCart(\RocketEcom\Entity\Cart $cart = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCart', array($cart));

        return parent::setCart($cart);
    }

    /**
     * {@inheritDoc}
     */
    public function getCart()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCart', array());

        return parent::getCart();
    }

    /**
     * {@inheritDoc}
     */
    public function setParts(\LundProducts\Entity\Parts $parts = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParts', array($parts));

        return parent::setParts($parts);
    }

    /**
     * {@inheritDoc}
     */
    public function getParts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParts', array());

        return parent::getParts();
    }

    /**
     * {@inheritDoc}
     */
    public function setPromo(\LundProducts\Entity\Promo $promo = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPromo', array($promo));

        return parent::setPromo($promo);
    }

    /**
     * {@inheritDoc}
     */
    public function getPromo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPromo', array());

        return parent::getPromo();
    }

    /**
     * {@inheritDoc}
     */
    public function setProductLinesAsset($productLinesAsset)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProductLinesAsset', array($productLinesAsset));

        return parent::setProductLinesAsset($productLinesAsset);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductLinesAsset()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductLinesAsset', array());

        return parent::getProductLinesAsset();
    }

}
