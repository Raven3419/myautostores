<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Service;

use Zend\EventManager\Eventmanager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Log\Logger;
use RocketUser\Repository\UserRepositoryInterface;
use RocketUser\Entity\RbacRole;
use RocketAdmin\Service\MessageService;
use Doctrine\Common\Persistence\ObjectManager;
use PDO;
use DateTime;
use Zend\Mail;

class ParsePromoService implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /*
     * @var PDO
     */
    protected $connection = null;

    /*
     * @var Logger
     */
    protected $logger = null;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var MessageService
     */
    protected $messageService;

    /*
     * @param ObjectManager           $objectManager
     * @param PDO                     $connection
     * @param Logger                  $logger
     * @param UserRepositoryInterface $userRepository
     * @param MessageService          $messageService
     */
    public function __construct(
        ObjectManager           $objectManager,
        PDO                     $connection,
        Logger                  $logger,
        UserRepositoryInterface $userRepository,
        MessageService          $messageService
    )
    {
        $this->objectManager  = $objectManager;
        $this->connection     = $connection;
        $this->logger         = $logger;
        $this->userRepository = $userRepository;
        $this->messageService = $messageService;
    }

    /*
     * @param string $created_at
     * @param string $created_by
     * @param string $modified_at
     * @param string $modified_by
     * @param int    $deleted
     * @param int    $disabled
     *
     * @return []
     */
    public function createPromo($created_at = null, $created_by = null, $modified_at = null, $modified_by = null, $deleted = 0,
        $disabled = 0, $promoNumber = null, $promoLine = null)
    {
        if (null == $created_at) {
            $created_at = date('Y-m-d H:i:s');
        }

        if (null == $deleted) {
            $deleted = 0;
        }

        if (null == $disabled) {
            $disabled = 0;
        }


        $return = array(
            'changeset_id'    => null,
            'created_at'      => $created_at,
            'created_by'      => $created_by,
            'modified_at'     => $modified_at,
            'modified_by'     => $modified_by,
            'deleted'         => $deleted,
            'disabled'        => $disabled,
            'promo_number'    => $promoNumber,
            'promo_line'      => $promoLine,
        );

        $promo = $this->prepare('INSERT INTO promos (created_at, created_by, modified_at, modified_by, deleted, disabled, promo_line, promo_number)
                                     VALUES (:created_at, :created_by, :modified_at, :modified_by, :deleted, :disabled, :promo_line, :promo_number)');


        $promo->bindParam(':created_at', $return['created_at']);
        $promo->bindParam(':created_by', $return['created_by']);
        $promo->bindParam(':modified_at', $return['modified_at']);
        $promo->bindParam(':modified_by', $return['modified_by']);
        $promo->bindParam(':deleted', $return['deleted']);
        $promo->bindParam(':disabled', $return['disabled']);
        $promo->bindParam(':promo_number', $return['promo_number']);
        $promo->bindParam(':promo_line', $return['promo_line']);
        $promo->execute();

        $return['promo_id'] = $this->lastInsertId();

        return $return;
    }
    
    /*
     * Update part.
     *
     * @param int 	 $customerNumber
     * @param string $partNumber
     * @param string $itemClass
     * @param string $startDate
     * @param string $endDate
     * @param string $promoDesc
     * @param string $promoCode
     * @param string $price
     * @param string $percent
     * @param string $itemPromoPrice
     * @param string $itemPromoOff
     * @param string $itemClassPromo
     * @param string $itemPromo
     *
     * @return array
     */
    
    
    public function editPromo($promoId = null, $customerNumber = null, $partId = null, $productLineId = null, $startDate = null, $endDate = null, 
                              $promoDesc = null, $promoCode = null, $price = null, $percent = null, $promoPrice = null, 
                              $promoOff = null, $customerPromo = null, $itemClassPromo = null, $itemPromo = null, $description = null)
        
        
    {
        
        $modified_at = date('Y-m-d H:i:s');
        $deleted = 0;
        $disabled = 0;
        
        $return = array('promoId'       => $promoId,
            'modified_at'       		=> $modified_at,
            'deleted'           		=> $deleted,
            'disabled'          		=> $disabled,
            'customerNumber'       		=> $customerNumber,
            'partId'      		        => $partId,
            'productLineId'        		=> $productLineId,
            'startDate'        		    => $startDate,
            'endDate'             		=> $endDate,
            'promoDesc'            		=> $promoDesc,
            'promoCode'          		=> $promoCode,
            'price'          		    => $price,
            'percent'            		=> $percent,
            'promoPrice'                => $promoPrice,
            'promoOff'            	    => $promoOff,
            'customerPromo'             => $customerPromo,
            'itemClassPromo'            => $itemClassPromo,
            'itemPromo'   		        => $itemPromo,
            'description'   		    => $description
            
        );
        
        $part = $this->prepare('UPDATE promos set modified_at = :modified_at, deleted = :deleted, disabled = :disabled, customer_number = :customerNumber,
    											 part_id = :partId, product_line_id = :productLineId, start_date = :startDate, end_date = :endDate,
    											 promo_desc = :promoDesc, promo_code = :promoCode, price = :price, percent = :percent, promo_price = :promoPrice,
    											 promo_off = :promoOff, customer_promo = :customerPromo, item_class_promo = :itemClassPromo, item_promo = :itemPromo,
                                                 description = :description
    							WHERE promo_id = :promoId');
        
  
        $part->bindParam(':modified_at', $return['modified_at']);
        $part->bindParam(':deleted', $return['deleted']);
        $part->bindParam(':disabled', $return['disabled']);
        $part->bindParam(':customerNumber', $return['customerNumber']);
        $part->bindParam(':partId', $return['partId']);
        $part->bindParam(':productLineId', $return['productLineId']);
        $part->bindParam(':startDate', $return['startDate']);
        $part->bindParam(':endDate', $return['endDate']);
        $part->bindParam(':promoDesc', $return['promoDesc']);
        $part->bindParam(':promoCode', $return['promoCode']);
        $part->bindParam(':price', $return['price']);
        $part->bindParam(':percent', $return['percent']);
        $part->bindParam(':promoPrice', $return['promoPrice']);
        $part->bindParam(':promoOff', $return['promoOff']);
        $part->bindParam(':customerPromo', $return['customerPromo']);
        $part->bindParam(':itemClassPromo', $return['itemClassPromo']);
        $part->bindParam(':itemPromo', $return['itemPromo']);
        $part->bindParam(':description', $return['description']);
        $part->bindParam(':promoId', $return['promoId']);
        $part->execute();
        
        $return['promoId'] = $this->lastInsertId();
        
        return $return;
    }
    
    
    
    /*
     * Update part.
     *
     * @param int 	 $cartItemId
     * @param string $promoFlag
     * @param string $couponFlag
     * @param string $newPrice
     * @param string $promo
     *
     * @return array
     */
    
    
    public function editCartItem($cartItemId = null, $couponFlag= null, $newPrice = null, $promo = null, $promoFlag= null)      
    {
        
        
        
        $modified_at = date('Y-m-d H:i:s');
        $deleted = 0;
        $disabled = 0;
        
        $return = array('cartItemId'     => $cartItemId,
            'promoFlag'       		     => $promoFlag,
            'couponFlag'       		     => $couponFlag,
            'newPrice'           		 => $newPrice,
            'promo'          		     => $promo
            
        );
        
        
        $part = $this->prepare('UPDATE cart_item set promo_flag = :promoFlag, new_price = :newPrice, promo_id = :promo, coupon_flag = :couponFlag
    							WHERE cart_item_id = :cartItemId');
        
        
        $part->bindParam(':cartItemId', $return['cartItemId']);
        $part->bindParam(':couponFlag', $return['couponFlag']);
        $part->bindParam(':promoFlag', $return['promoFlag']);
        $part->bindParam(':newPrice', $return['newPrice']);
        $part->bindParam(':promo', $return['promo']);
        $part->execute();
       
        return $return;
    }
    
    
    public function editCart($cartId = null, $discountPromo= null)
    {
        
        $modified_at = date('Y-m-d H:i:s');
        $deleted = 0;
        $disabled = 0;
        
        $return = array('cartId'        => $cartId,
            'discountFlag'              => '1',
            'discountPromo'             => $discountPromo,
            
        );
        
        $part = $this->prepare('UPDATE cart set discount_flag = :discountFlag, promo_id = :discountPromo
    							WHERE cart_id = :cartId');
        
        
        $part->bindParam(':cartId', $return['cartId']);
        $part->bindParam(':discountFlag', $return['discountFlag']);
        $part->bindParam(':discountPromo', $return['discountPromo']);
        $part->execute();
        
        return $return;
    }
    
    
    public function getEcomSameAsBilling($ecomCustomerId = null)
    {
        
        
        $foundBrand = $this->prepare("select same_as_billing from ecom_customer where ecom_customer_id = '".$ecomCustomerId."' ");
        $foundBrand->execute();
        
        $return = $foundBrand->fetchAll();
        
        return $return;
    }
    
    
    public function getPromoByPromoCode($promoCode = null, $websiteId = null)
    {
        

        $foundBrand = $this->prepare("SELECT * from promos where deleted = 0 and disabled = 0 and promo_code = '".$promoCode."' and customer_number = '".$websiteId."'
                                                    and start_date < CURRENT_DATE() and end_date > CURRENT_DATE() and customer_promo = 'Y'");
        $foundBrand->execute();
        
        $return = $foundBrand->fetchAll();
        
        return $return;
    }
    
    
    public function getPromoByWebsiteId($websiteId = null)
    {
        
        
        $foundBrand = $this->prepare("SELECT * from promos where deleted = 0 and disabled = 0 and customer_number = '".$websiteId."'
                                                    and start_date < CURRENT_DATE() and end_date > CURRENT_DATE() and customer_promo = 'N'");
        $foundBrand->execute();
        
        $return = $foundBrand->fetchAll();
        
        return $return;
    }
    
    
    public function getPromoByPartId($websiteId = null, $partId = null)
    {
  
        $foundBrand = $this->prepare("SELECT * from promos where deleted = 0 and disabled = 0 and customer_number = '".$websiteId."'
                                                    and start_date < CURRENT_DATE() and end_date > CURRENT_DATE() and customer_promo = 'N'
                                                    and promo_price = 'Y' and promo_desc = 'LI' and part_id = '".$partId."'");
        $foundBrand->execute();
        
        $return = $foundBrand->fetchAll();
        
        return $return;
    }
    
    /*
     * Proxy method to PDO->beginTransaction()
     */
    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    /*
     * Proxy method to PDO->rollBack()
     */
    public function rollBack()
    {
        $this->connection->rollBack();
    }

    /*
     * Proxy method to PDO->commit()
     */
    public function commit()
    {
        $this->connection->commit();
    }

    /*
     * @param  string $sql
     * @return PDO
     */
    private function prepare($sql = null)
    {
        return $this->connection->prepare($sql);
    }

    /*
     * @param  string $quote
     * @return PDO
     */
    private function quote($quote = null)
    {
        return $this->connection->quote($quote);
    }

    /*
     * @return int
     */
    private function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /*
     * @return PDO
     */
    private function getPDOConnection()
    {
        return $this->connection;
    }

    /*
     * @return \Zend\Log\Logger
     */
    private function getLogger()
    {
        return $this->logger;
    }

    /**
     * setEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::setEventManager()
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__, get_class($this)));

        $this->eventManager = $eventManager;
    }

    /**
     * getEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::getEventManager()
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }

        return $this->eventManager;
    }
}
