<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage ACES
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\Edgenet;

use LundProducts\Service\PartService;
use LundProducts\Service\ProductLineFeatureService;
use LundProducts\Repository\BrandsRepository;
use LundFeeds\Service\EdgenetService;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\ChangesetDetailsVehiclesService;
use SimpleXMLElement;
use DOMDocument;
use Exception;

class Edgenet implements EdgenetInterface
{
    /**
     * @var SimpleXMLElement
     */
    protected $xml = null;

    /**
     * @var PartService
     */
    protected $partService = null;

    /**
     * @var ProductLineFeatureService
     */
    protected $productLineFeatureService = null;

    /**
     * @var EdgenetService
     */
    protected $edgenetService = null;

    /**
     * @var int
     */
    protected $recordCount = 0;

    /**
     * @var BrandsRepository
     */
    protected $brandsRepository = null;

    /**
     * @var ChangesetsService
     */
    protected $changesetsService = null;

    /**
     * @var ChangesetDetailsService
     */
    protected $changesetDetailsService = null;

    /**
     * @var ChangesetDetailsVehiclesService
     */
    protected $changesetDetailsVehiclesService = null;

    /**
     * @var string
     */
    protected $brand = null;

    /**
     * @var string
     */
    protected $lundonly = null;

    /**
     * @var string
     */
    protected $generate = null;

    /**
     * @var int
     */
    protected $changeset_id = null;

    /**
     * @param PartService                     $partService
     * @param EdgenetService                  $edgenetService
     * @param ProductLineFeatureService   	  $productLineFeatureService
     * @param BrandsRepository                $brandsRepository
     * @param ChangesetsService               $changesetsService
     * @param ChangesetDetailsService         $changesetDetailsService
     * @param ChangesetDetailsVehiclesService $changesetDetaisVehiclesService
     * @param string                          $brand
     * @param string                          $generate
     * @param int                             $changeset_id
     */
    public function __construct(PartService      $partService = null,
                                EdgenetService   $edgenetService = null,
                                ProductLineFeatureService   $productLineFeatureService = null,
                                BrandsRepository $brandsRepository = null,
                                ChangesetsService $changesetsService = null,
                                ChangesetDetailsService $changesetDetailsService = null,
                                ChangesetDetailsVehiclesService $changesetDetailsVehiclesService = null,
                                $brand        = null,
                                $generate     = null,
                                $changeset_id = null)
    {
        if (null == $this->xml) {
        	
        	$this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><import></import>');
        	
        	$this->xml->addAttribute('xmlns:pr', 'urn:productregistry.bighammer.com/schema/import/2010/10');        	 
        	$this->xml->addAttribute('vendorId', 'b821e68d-ddaa-450c-bdc5-17e26ad6bf38');
        	$this->xml->addAttribute('xsi:schemaLocation', 'urn:productregistry.bighammer.com/schema/import/2010/10 http://productregistry.bighammer.com/schema/import/2010/10/Import.xsd     rn:productregistry.bighammer.com/schema/import/2010/10/19d43d09-55a1-4173-86fe-77c5588a5d80 http://productregistry.bighammer.com/schema/import/2010/10/19d43d09-55a1-4173-86fe-77c5588a5d80.xsd', 'http://www.w3.org/2001/XMLSchema-instance');
        	$this->xml->addAttribute('source', 'SST');
        	
        	/*
            $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><pr:import></pr:import>', LIBXML_NOERROR, false, 'xsi', true);
            $this->xml->addAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance', 'http://www.w3.org/2001/XMLSchema-instance');
            $this->xml->addAttribute('xmlns:pr', 'urn:productregistry.bighammer.com/schema/import/2010/10', 'http://www.w3.org/2001/XMLSchema-instance');
            $this->xml->addAttribute('vendorId', 'b821e68d-ddaa-450c-bdc5-17e26ad6bf38');
            $this->xml->addAttribute('xsi:schemaLocation', 'urn:productregistry.bighammer.com/schema/import/2010/10 http://productregistry.bighammer.com/schema/import/2010/10/Import.xsd     rn:productregistry.bighammer.com/schema/import/2010/10/19d43d09-55a1-4173-86fe-77c5588a5d80 http://productregistry.bighammer.com/schema/import/2010/10/19d43d09-55a1-4173-86fe-77c5588a5d80.xsd', 'http://www.w3.org/2001/XMLSchema-instance');
            $this->xml->addAttribute('source', 'SST');
            */
        }

        if (null != $partService) {
            if (null == $this->partService) {
                $this->partService = $partService;
            }
        }

        if (null != $productLineFeatureService) {
            if (null == $this->productLineFeatureService) {
                $this->productLineFeatureService = $productLineFeatureService;
            }
        }

        if (null != $edgenetService) {
            $this->edgenetService = $edgenetService;
        }

        if (null != $brandsRepository) {
            $this->brandsRepository = $brandsRepository;
        }

        if (null != $changesetsService) {
            $this->changesetsService = $changesetsService;
        }

        if (null != $changesetDetailsService) {
            $this->changesetDetailsService = $changesetDetailsService;
        }

        if (null != $changesetDetailsVehiclesService) {
            $this->changesetDetailsVehiclesService = $changesetDetailsVehiclesService;
        }

        if (null != $brand) {
            if ($brand == 'LUNDONLY') {
                $this->brand = $this->brandsRepository->findOneBy(['name' => 'LUND']);
                $this->lundonly = true;
            } else {
                $this->brand = $this->brandsRepository->findOneBy(['name' => trim(strtoupper($brand))]);
            }

            if (!$this->brand) {
                throw new Exception('Couldn\'t find brand \'' . $brand . '\'');
            }
        } else {
            $this->brand = null;
        }

        if (null != $generate) {
            $this->generate = $generate;
        }

        if (null != $changeset_id) {
            $this->changeset_id = $changeset_id;
        } else {
            $this->changeset_id = null;
        }
    }

    /**
     * @return void
     */
    public function getHeader()
    {
    }

    /**
     * @return void
     */
    public function getBody()
    {
        $partIdArray = array();

        $iterator = 1;

        $records = $this->partService->getAcesParts($this->brand, $this->generate, $this->changeset_id, $this->lundonly);
        
        $products = $this->xml->addChild('products');
        
        $defaultCatalogItem = $products->addChild('defaultCatalogItem');
        $defaultCatalogItem->addAttribute('location', '0025067000008');
        
        $targetMarket = $defaultCatalogItem->addChild('targetMarket');
        $targetMarket->addAttribute('countryCode', '840');
      
    	foreach ($records as $record) {
       		$vehicles = array();

			if(!$record->getDisabled()) {
				
				//if(!$record->getProductLine()->getDisabled()) {
					
				echo " Part Number - ".$record->getPartNumber()." - ";
				
				$product = $products->addChild('product');
				$product->addAttribute('state', 'active');
				$product->addAttribute('private', 'false');
				
				$productID = $product->addChild('productID', '00'.$record->getUpcCode());
				$productID->addAttribute('xsi:type', 'pr:A_0994d0f8-35e7-4a6d-9cd9-2ae97cd8b993', 'http://www.w3.org/2001/XMLSchema-instance');
				
				$productType = $product->addChild('productType');
				$add = $productType->addChild('add', 'GDSN');
				$add = $productType->addChild('add', 'Ezeedata Commerce');
				
				$assets = $product->addChild('assets');
				
				foreach ($record->getPartAsset() as $part_asset) {
					$partAsset = $part_asset->getAsset();
					
					$asset = $assets->addChild('asset', $partAsset->getFileName());
					$asset->addAttribute('name', 'Product Image');
					$asset->addAttribute('referenceType', 'Filename');
					$asset->addAttribute('id', '645296e8-a910-43c3-803c-b51d3f1d4a89');
					$asset->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				}
				
				$attributes = $product->addChild('attributes');
				
				$attribute = $attributes->addChild('attribute', $record->getPartNumber());
				$attribute->addAttribute('xsi:type', 'pr:A_cd250fb8-fb00-4f9d-813a-dea949605715', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'MFG Part #');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', $record->getProductLine()->getBrand()->getName());
				$attribute->addAttribute('xsi:type', 'pr:A_29d438d9-64f2-4623-8f4e-09f9368e93bb', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'MFG Brand Name');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', htmlspecialchars($record->getProductLine()->getName()));
				$attribute->addAttribute('xsi:type', 'pr:A_bda64a3f-507c-49de-883c-fa832c6539e7', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Product Name');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');

				$attribute = $attributes->addChild('attribute', 'BASE_UNIT_OR_EACH');
				$attribute->addAttribute('xsi:type', 'pr:A_694d3708-43e6-4c28-b01b-262b33d7eebe', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Packaging Level');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', $record->getPartNumber());
				$attribute->addAttribute('xsi:type', 'pr:A_54f9b50d-671d-4895-8f02-cd757999ec9e', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Internal Supplier Part #');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', $record->getPartNumber());
				$attribute->addAttribute('xsi:type', 'pr:A_2bce6533-87c7-4646-a3b7-d5efb49bf927', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'MFG Model #');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', substr($record->getProductLine()->getProductCategory()->getDisplayName(), 0, 35 ) );
				$attribute->addAttribute('xsi:type', 'pr:A_57fa45f9-9a71-4f7e-af1f-3e5cc97dc06b', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Short Description');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
			
				$attribute = $attributes->addChild('attribute', 'Y');
				$attribute->addAttribute('xsi:type', 'pr:A_4c7e4e19-1bfa-4841-b759-895d2efeb418', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Item is the Lowest Packaging Level');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', $record->getProductLine()->getProductCategory()->getCreatedAt()->format('Y-m-d'));
				$attribute->addAttribute('xsi:type', 'pr:A_173e8b0a-d22d-46ff-87c4-a4eae02da18e', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Market Availability Date');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', 'Lund International');
				$attribute->addAttribute('xsi:type', 'pr:A_37f3fed4-5bf3-4bf8-88bd-310bd2addb56', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'MFG Name');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', 'Lund International');
				$attribute->addAttribute('xsi:type', 'pr:A_42f50983-e03e-4503-8ed5-f1d3da062855', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Supplier Company Name');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', $record->getProductLine()->getMetaKeywords());
				$attribute->addAttribute('xsi:type', 'pr:A_2aac5537-9953-4527-a491-25ce5155d86c', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Search Keywords');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
	
				$mkcopy = strip_tags($record->getProductLine()->getOverview());
				//echo $mkcopy."-1- \n";
				$mkcopy = str_replace("\n", '', $mkcopy);
				$mkcopy = str_replace("\r", '', $mkcopy);
				$mkcopy = str_replace("&trade;", chr(153), $mkcopy);
				$mkcopy = str_replace("&reg;", "", $mkcopy);
				//$mkcopy = str_replace("&reg;", chr(174), $mkcopy);
				$mkcopy = str_replace("&#39;", chr(146), $mkcopy);
				$mkcopy = str_replace("&ndash;", chr(150), $mkcopy);
				$mkcopy = str_replace("&rsquo;", chr(39), $mkcopy);
				$mkcopy = str_replace("nbsp;", chr(32), $mkcopy);
				$mkcopy = str_replace("&quot;", "", $mkcopy);
				$mkcopy = str_replace("&amp;", chr(38), $mkcopy);
				$mkcopy = str_replace("\"", "", $mkcopy);
				$mkcopy = str_replace("'", chr(146), $mkcopy);
				
				$attribute = $attributes->addChild('attribute', htmlspecialchars($mkcopy));
				$attribute->addAttribute('xsi:type', 'pr:A_52e3af44-05b0-44e2-950d-431017fe9728', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Marketing Copy');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
								

				if(!empty($this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '1'))) {
					$attribute = $attributes->addChild('attribute', $this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '1')->getFeatureCopy());
					$attribute->addAttribute('xsi:type', 'pr:A_a2523cf4-a05f-4916-93a0-95026883babe', 'http://www.w3.org/2001/XMLSchema-instance');
					$attribute->addAttribute('name', 'Feature - Benefit Bullet 1');
					$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				}
				

				if(!empty($this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '2'))) {
					$attribute = $attributes->addChild('attribute', $this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '2')->getFeatureCopy());
					$attribute->addAttribute('xsi:type', 'pr:A_d157285a-f56a-4bfa-80eb-1fcecb6160e4', 'http://www.w3.org/2001/XMLSchema-instance');
					$attribute->addAttribute('name', 'Feature - Benefit Bullet 2');
					$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				}
				
				if(!empty($this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '3'))) {
					$attribute = $attributes->addChild('attribute', $this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '3')->getFeatureCopy());
					$attribute->addAttribute('xsi:type', 'pr:A_357c51e8-a649-44df-a56e-ae75227b5ba9', 'http://www.w3.org/2001/XMLSchema-instance');
					$attribute->addAttribute('name', 'Feature - Benefit Bullet 3');
					$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				}

				if(!empty($this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '4'))) {
					$attribute = $attributes->addChild('attribute', $this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '4')->getFeatureCopy());
					$attribute->addAttribute('xsi:type', 'pr:A_d74d3ae2-40f4-4aff-a6c5-f2926d968826', 'http://www.w3.org/2001/XMLSchema-instance');
					$attribute->addAttribute('name', 'Feature - Benefit Bullet 4');
					$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				}
				$attribute = $attributes->addChild('attribute', ($record->getHeight() == '0.00' ? '12.00' : $record->getHeight()));
				$attribute->addAttribute('xsi:type', 'pr:A_7f4f75eb-e94d-4786-ae07-f3dc2a2ce038', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Package Height');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', 'INH');
				$attribute->addAttribute('xsi:type', 'pr:A_e7e870ac-2a79-4a83-a76a-62920437499a', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Package Height UOM');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', ($record->getWidth() == '0.00' ? '12.00' : $record->getWidth()));
				$attribute->addAttribute('xsi:type', 'pr:A_e70b7eaa-6150-4f3b-abb3-5693b2995862', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Package Width');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', 'INH');
				$attribute->addAttribute('xsi:type', 'pr:A_5f7edd54-a66d-4309-a4d5-65e4868a062c', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Package Width UOM');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');		
							
				$attribute = $attributes->addChild('attribute', ($record->getLength() == '0.00' ? '12.00' : $record->getLength()));
				$attribute->addAttribute('xsi:type', 'pr:A_fc3653d1-74b5-41d4-95a3-93acc7e3c9c2', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Package Depth');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', 'INH');
				$attribute->addAttribute('xsi:type', 'pr:A_f4b91aa1-d925-4f03-847c-dc2e18f39125', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Package Depth UOM');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', ($record->getWeight() == '0.00' ? '5' : $record->getWeight()));
				$attribute->addAttribute('xsi:type', 'pr:A_fab13caf-792f-48df-9dbf-81446cd6e8a7', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Package Weight');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', 'LBR');
				$attribute->addAttribute('xsi:type', 'pr:A_f9d67d41-df67-4941-a86e-70276bd7f3e7', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Package Weight UOM');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	

				switch($record->getCountryOfOrigin()) {
					case 'TW' :
						$country = '158';
						break;
					case 'CA' :
						$country = '124';
						break;
					case 'CN' :
						$country = '156';
						break;
					case 'HK' :
						$country = '344';
						break;
					case 'ID' :
						$country = '360';
						$break;
					case 'IN' :
						$country = '356';
						break;
					default :
						$country = '840';
						break;
				}
				
				$attribute = $attributes->addChild('attribute', $country);
				$attribute->addAttribute('xsi:type', 'pr:A_8ecf0ae5-f846-47f6-99c0-43a83d12f346', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Country of Origin');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', '1');
				$attribute->addAttribute('xsi:type', 'pr:A_0d09ffd4-6a5e-4a6e-a291-ab5eb6eb28b7', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Net Package Quantity');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');		
							
				$attribute = $attributes->addChild('attribute', 'EA');
				$attribute->addAttribute('xsi:type', 'pr:A_16ce9941-9857-468d-8511-bde78a67ad4e', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Net Package Quantity UOM');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');		
							
				$attribute = $attributes->addChild('attribute', htmlspecialchars($record->getProductLine()->getName()));
				$attribute->addAttribute('xsi:type', 'pr:A_da4f2c98-15c3-4b69-91ac-4741b8ce9148', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Additional Description');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');		
							
				$attribute = $attributes->addChild('attribute', substr($record->getProductLine()->getProductCategory()->getDisplayName(), 0, 35 ) );
				$attribute->addAttribute('xsi:type', 'pr:A_fd30f376-f84a-40f5-96bb-5353efe6d4b3', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Functional Name');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');		
							
				$attribute = $attributes->addChild('attribute', $record->getPartNumber());
				$attribute->addAttribute('xsi:type', 'pr:A_fbd50b7e-a444-454f-ac72-be7b9d9860f2', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'modelNumber');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');		
							
				$attribute = $attributes->addChild('attribute', $record->getPartNumber());
				$attribute->addAttribute('xsi:type', 'pr:A_c72fc058-4640-4367-aca9-59a3917d98ed', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Additional Identifier');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');		
							
				$attribute = $attributes->addChild('attribute', '0025067000008');
				$attribute->addAttribute('xsi:type', 'pr:A_c6526658-54e5-4c69-9788-5e3171720c86', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Manufacturer GLN');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');		
							
				$attribute = $attributes->addChild('attribute', '0025067000008');
				$attribute->addAttribute('xsi:type', 'pr:A_bb605d62-fa1b-4f0b-a63b-681950283630', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Information Owner GLN');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');		
							
				$attribute = $attributes->addChild('attribute', 'Lund International');
				$attribute->addAttribute('xsi:type', 'pr:A_91fef33a-edee-40b9-bdb7-74c68695b2ea', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Information Owner Name');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', '0025067000008');
				$attribute->addAttribute('xsi:type', 'pr:A_43cd49d0-f9d1-40e6-9b9c-7cc2739be350', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Brand Owner GLN');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', 'Lund International');
				$attribute->addAttribute('xsi:type', 'pr:A_5b641a44-e387-4f0d-a00e-810481232f78', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Brand Owner Name');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');	
							
				$attribute = $attributes->addChild('attribute', 'GTIN_12');
				$attribute->addAttribute('xsi:type', 'pr:A_fc920885-8259-4189-92b3-51ea8a3ea83c', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'gs1TradeItemIdentificationKeyCode');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'UPC_A');
				$attribute->addAttribute('xsi:type', 'pr:A_8e7dbd9b-5a46-4144-8aea-88e3c7528f5d', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'dataCarrierTypeCode');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'N');
				$attribute->addAttribute('xsi:type', 'pr:A_06b9e7cc-c646-4670-bf6f-8188ac4b1f4e', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Has Item Been Recalled');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'Y');
				$attribute->addAttribute('xsi:type', 'pr:A_8b53213a-aa8c-41b1-b56d-8bf20d2a5961', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Item is Sold to the Consumer');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'Y');
				$attribute->addAttribute('xsi:type', 'pr:A_2bc62f00-387d-494d-a789-9233c4fbe891', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Item is Shipped at this Packaging Level');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'Y');
				$attribute->addAttribute('xsi:type', 'pr:A_ae7dd6c9-b569-4031-90f5-9378eca6b8fb', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Item is Invoiced at this Packaging Level');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'Y');
				$attribute->addAttribute('xsi:type', 'pr:A_f8157c34-4330-47b1-a07a-93e06a934288', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Item is Ordered at this Packaging Level');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'N');
				$attribute->addAttribute('xsi:type', 'pr:A_2912e80a-70c6-43f3-bbbd-a0fcd72ae972', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Package Quantity Can Vary');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'Y');
				$attribute->addAttribute('xsi:type', 'pr:A_2b6f08c7-59c3-43f8-b745-a37815514843', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Packaging is Returnable');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', date('Y-m-d'));
				$attribute->addAttribute('xsi:type', 'pr:A_bd2aebae-c898-47a8-9765-c38e339d21c5', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Information Effective Date');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', '1');
				$attribute->addAttribute('xsi:type', 'pr:A_69a59f4f-0a5e-4361-8f60-c6d8f0f3e8fa', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Minimum Order Quantity');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', '1');
				$attribute->addAttribute('xsi:type', 'pr:A_4c2bac6e-0728-43dd-8267-c8657007009d', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Multiple Order Quantity');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'EA');
				$attribute->addAttribute('xsi:type', 'pr:A_b7679ddb-b113-431a-872d-ce64f4d530a5', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Order UOM');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', '5');
				$attribute->addAttribute('xsi:type', 'pr:A_25e9534b-fd98-4951-bd1d-dbe58b28a483', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Order Lead Time');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'DAY');
				$attribute->addAttribute('xsi:type', 'pr:A_904a9b1d-a3f4-4821-be27-f31b787231f8', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Order Lead Time UOM');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'EA');
				$attribute->addAttribute('xsi:type', 'pr:A_1883168e-bf52-4563-980a-f437e648fbdd', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Selling UOM');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'CALL_FOR_AUTHORIZATION');
				$attribute->addAttribute('xsi:type', 'pr:A_f7b597a8-6586-4df1-88f2-94262c77f83f', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'returnGoodsPolicy');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', '4');
				$attribute->addAttribute('xsi:type', 'pr:A_bbdbeec5-151e-4e57-93f8-fd48b381b3c5', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Layers Per Pallet');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', '7');
				$attribute->addAttribute('xsi:type', 'pr:A_c993155e-5b77-4530-beab-fe4bacf6b42c', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Items Per Pallet Layer');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'BX');
				$attribute->addAttribute('xsi:type', 'pr:A_721b66ac-7340-4e1f-b958-d0b3e94f1f4d', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'packagingTypeCode');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'Box');
				$attribute->addAttribute('xsi:type', 'pr:A_749b42a3-ba79-46e5-abd4-435d02347f8a', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'packagingTypeDescription');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'CORRUGATED_BOARD_OTHER');
				$attribute->addAttribute('xsi:type', 'pr:A_0f48061c-b66d-453e-b722-711f48800a39', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'packagingMaterialCode');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'Cardboard');
				$attribute->addAttribute('xsi:type', 'pr:A_659acb21-a769-46b1-9dcc-6e4bd9a644a6', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'packagingMaterialDescription');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', '1');
				$attribute->addAttribute('xsi:type', 'pr:A_417b861e-ad29-4eb8-8b0d-231347bf4317', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'packagingMaterialCompositionQuantity');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'EA');
				$attribute->addAttribute('xsi:type', 'pr:A_a7f7bb73-71e6-4e7b-ba76-fd55b15a3491', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'packagingMaterialCompositonQuantityUOM');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', 'HARMONIZED_TARIFF_SCHEDULE_OF_THE_US');
				$attribute->addAttribute('xsi:type', 'pr:A_a4c705fe-310a-4630-9b23-aceff8e75e32', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'importClassificationType');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
							
				$attribute = $attributes->addChild('attribute', '3920.20.00');
				$attribute->addAttribute('xsi:type', 'pr:A_05c2c505-a57d-4a99-8deb-eb233b1055e0', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'importClassificationValue');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				echo $record->getProductLine()->getProductLineId()." - ";
				if(!empty($this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '5'))) {
							
					$attribute = $attributes->addChild('attribute', $this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '5')->getFeatureCopy());
					$attribute->addAttribute('xsi:type', 'pr:A_703be75e-f6c8-42ef-9458-c794d745941a', 'http://www.w3.org/2001/XMLSchema-instance');
					$attribute->addAttribute('name', 'Feature - Benefit Bullet 5');
					$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				}
				
				if(!empty($this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '6'))) {
				
				$attribute = $attributes->addChild('attribute', $this->productLineFeatureService->getFeatureByPosition($record->getProductLine(), '6')->getFeatureCopy());
				$attribute->addAttribute('xsi:type', 'pr:A_535f4985-cc34-4754-8cbe-dabde4a72dd7', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Feature - Benefit Bullet 6');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				}
				
				$attribute = $attributes->addChild('attribute');
				$attribute->addAttribute('xsi:type', 'pr:A_9df6fe91-5acd-4163-8276-f628b5faa8ba', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Warranty');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
				
				$attribute = $attributes->addChild('attribute', '0.00');
				$attribute->addAttribute('xsi:type', 'pr:A_4e3ac794-8aa9-4911-b064-17f221ccdb84', 'http://www.w3.org/2001/XMLSchema-instance');
				$attribute->addAttribute('name', 'Minimum Advertised Price');
				$attribute->addAttribute('language', '6c984dcb-7d5e-4de6-8b29-7223d8d35ce2');
		
           // }  
			}
     	}
         
        
    }

    /**
     * @return void
     */
    public function getFooter()
    {
    }

    /**
     * @return string
     */
    public function getXML()
    {
        $this->getBody();

        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;
        $dom->loadXML($this->xml->asXML());

        return $dom->saveXML();
    }

    /**
     * @param  string $location
     * @return void
     */
    public function saveXML($location = null)
    {
        $this->getBody();

        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;
        $dom->loadXML($this->xml->asXML());

        return $dom->save($location);
    }
}
