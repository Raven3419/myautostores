<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage PIES
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\PIES;

use LundProducts\Service\PartService;
use LundProducts\Repository\BrandsRepository;
use LundFeeds\Service\PiesService;
use SimpleXMLElement;
use DOMDocument;
use Exception;

class PIES65 implements PiesInterface
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
     * @var Pieservice
     */
    protected $piesService = null;

    /**
     * @var int
     */
    protected $recordCount = null;

    /**
     * @var float
     */
    private $_piesVersion = 6.5;

    /**
     * @var BrandsRepository
     */
    protected $brandsRepository = null;

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
     * @var array
     * TODO: manually update with current price sheet data
     */
    protected $_priceSheet = ['number'     => '99209',
                              'name'       => '99209-MAR14',
                              'zone'  => 'Eastern', // Y-m-d
                              'effective'  => '2014-03-01', // Y-m-d
                              'expiration' => '2025-03-01']; // Y-m-d
   
    /**
     * @var []
     */
    protected $config = [];

    /**
     * @param PartService $partService
     * @param PiesService $piesService
     *
     * @return void
     */
    public function __construct(PartService      $partService = null,
                                PiesService      $piesService = null,
                                BrandsRepository $brandsRepository = null,
                                $brand        = null,
                                $generate     = null,
                                $changeset_id = null,
                                $config       = null)
    {
        if (null == $this->xml) {
            $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><PIES xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://www.aftermarket.org/eCommerce/Pies"></PIES>');

            // test file?
            $this->xml->addChild('TestFile', 'false'); // TODO: Toggle on for development mode
        }

        if (null != $partService) {
            if (null == $this->partService) {
                $this->partService = $partService;
            }
        }

        if (null != $piesService) {
            $this->piesService = $piesService;
        }

        if (null != $brandsRepository) {
            $this->brandsRepository = $brandsRepository;
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
        }

        if (null != $config) {
            $this->config = $config;
        }
    }

    private function _getPriceSheet()
    {
        return $this->_priceSheet;
    }

    /**
     * @return void
     */
    public function getHeader()
    {
        $header = $this->xml->addChild('Header');
        $header->addChild('PIESVersion', (STRING)$this->_getPiesVersion());
        $header->addChild('SubmissionType', ($this->generate == 'full' ? 'FULL' : 'NET')); // TODO: Toggle to incremental
        $header->addChild('BlanketEffectiveDate', date('Y-m-d'));
        $header->addChild('ChangesSinceDate', date('Y-m-d'));
        
        $header->addChild('ParentDUNSNumber', '14-851-0928');
        $header->addChild('ParentGLN', '0025067000008');
		$header->addChild('ParentAAIAID', 'BLHW'); // if brand is not null, use that brand, else, use BLHW for parent code/brand
        
		$header->addChild('BrandOwnerDUNS', '14-851-0928');
		$header->addChild('BrandOwnerGLN', '0025067000008');
		$header->addChild('BrandOwnerAAIAID', 'BLHW'); // if brand is not null, use that brand, else, use BLHW for parent code/brand

		$header->addChild('CurrencyCode', 'USD');
		$header->addChild('LanguageCode', 'EN');
        $header->addChild('TechnicalContact', 'Trina Wilson');
        $header->addChild('ContactEmail', 'webit@thesmartdata.com');
    }

    /**
     * @return void
     */
    public function getPriceSheetSegment()
    {
        $latest_pricesheet = $this->_getPriceSheet();

        $pricesheets = $this->xml->addChild('PriceSheets');

        $pricesheet = $pricesheets->addChild('PriceSheet');
        $pricesheet->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value

        $pricesheet->addChild('PriceSheetNumber', $latest_pricesheet['number']);
        $pricesheet->addChild('PriceSheetName', $latest_pricesheet['name']);
        $pricesheet->addChild('CurrencyCode', 'USD');
        $pricesheet->addChild('PriceZone', $latest_pricesheet['zone']);
        $pricesheet->addChild('EffectiveDate', $latest_pricesheet['effective']);
        $pricesheet->addChild('ExpirationDate', $latest_pricesheet['expiration']);
    }
    
    /**
     * @return void
     */
    public function getMarketingSegment()
    {
    	$latest_marketingCopy = $this->_getMarketingCopy();
    
    	$marketingCopy = $this->xml->addChild('MarketingCopy');
    
    	$marketCopy = $marketingCopy->addChild('MarketCopy');
    	
    	$marketCopyContent = $marketCopy->addChild('MarketCopyContent', 'TESTING MARKETING COPY');
    	
    	$marketCopyContent->addAttribute('MaintenanceType', 'A');
    	$marketCopyContent->addAttribute('MarketCopyCode', 'BRD');
    	$marketCopyContent->addAttribute('MarketCopyReference', ((null != $this->brand) ? $this->brand->getAaiaid() : 'BLHW'));
    	$marketCopyContent->addAttribute('MarketCopySubCode', 'PSG');
    	$marketCopyContent->addAttribute('MarketCopySubCodeReference', '123');
    	$marketCopyContent->addAttribute('MarketCopyType', 'GCC');
    	$marketCopyContent->addAttribute('RecordSequence', '1');
    	$marketCopyContent->addAttribute('LanguageCode', 'EN');
    
    	$digitalAssets = $marketCopy->addChild('DigitalAssets');
    	
    	$digitalFileInformation = $marketCopy->addChild('DigitalFileInformation');
    	$digitalFileInformation->addAttribute('MaintenanceType', 'A');
    	$digitalFileInformation->addAttribute('AssetID', '1');
    	$digitalFileInformation->addAttribute('LanguageCode', 'EN');
    	

    	$digitalFileInformation->addChild('FileName', 'TESTING');
    	$digitalFileInformation->addChild('AssetType', 'LGO');
    	$digitalFileInformation->addChild('FileType', 'TESTING');
    	$digitalFileInformation->addChild('Representation', 'A');
    	$digitalFileInformation->addChild('Background', 'WHI');
    	$digitalFileInformation->addChild('OrientationView', 'FRO');
    	$digitalFileInformation->addChild('URI', 'TESTING');
    	$digitalFileInformation->addChild('FileDateModified', $latest_marketingCopy['modified']);
    	$digitalFileInformation->addChild('EffectiveDate', $latest_marketingCopy['expiration']);
    	
    }

    /**
     * @return void
     */
    public function getBody($fp = null)
    {
        $records = $this->partService->getAcesParts($this->brand, $this->generate, $this->changeset_id, $this->lundonly);

        $latest_pricesheet = $this->_getPriceSheet();
        $items             = $this->xml->addChild('Items');
        $iterator          = 1;

        // iterate through parts
        foreach ($records as $record) {
        	if(!$record->getDisabled())
        	{
        		//if($record->getPartNumber() == '12003'){
        		
        			//print_r($record->getProductLine()->getProductLineId());exit;
	            $item = $items->addChild('Item');
	
	            // - A: Additive
	            // - C: Change
	            $item->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	
	            $item->addChild('HazardousMaterialCode', 'N');
	            $ItemLevelGTIN = $item->addChild('ItemLevelGTIN', '00'.$record->getUpcCode());
	            $ItemLevelGTIN->addAttribute('GTINQualifier', 'UP');
	            
	            
	            $item->addChild('PartNumber', $record->getPartNumber());
	            if ($this->brand->getShortCode() == 'LUND') {
	                $item->addChild('BrandAAIAID', $record->getProductLine()->getBrand()->getAaiaid());
	                $item->addChild('BrandLabel', $record->getProductLine()->getBrand()->getLabel());
	            } else if($this->brand->getShortCode() == 'AVS') {
	                $item->addChild('BrandAAIAID', $record->getProductLine()->getOrigBrand()->getAaiaid());
	                $item->addChild('BrandLabel', 'Auto Ventshade (AVS)');
	            } else {
	                $item->addChild('BrandAAIAID', $record->getProductLine()->getOrigBrand()->getAaiaid());
	                $item->addChild('BrandLabel', $record->getProductLine()->getOrigBrand()->getLabel());
	            }
	            
	            
	            
	            $item->addChild('ACESApplications', 'Y');
	            $ItemQuantitySize = $item->addChild('ItemQuantitySize', '10000');
	            $ItemQuantitySize->addAttribute('UOM', 'EA');
	             
	            $item->addChild('ContainerType', 'BX');
	            $QuantityPerApplication = $item->addChild('QuantityPerApplication', '1');
	            $QuantityPerApplication->addAttribute('Qualifier', 'NOR');
	            $QuantityPerApplication->addAttribute('UOM', 'EA');
	             
	            
	            $item->addChild('ItemEffectiveDate', $latest_pricesheet['effective']);
	            $item->addChild('AvailableDate', $latest_pricesheet['effective']);
	            $MinimumOrderQuantity = $item->addChild('MinimumOrderQuantity', '1');
	            $MinimumOrderQuantity->addAttribute('UOM', 'EA');
	
	            $item->addChild('PartTerminologyID', $record->getPartTypeId());
	
	            $descriptions = $item->addChild('Descriptions');
	
	            $prod_name_long = $descriptions->addChild('Description'); //, $record->getProductLine()->getName()); // Grab Product Line name
	            $prod_name_long->Description = $this->brand->getShortCode().' - '.substr(htmlspecialchars($record->getProductLine()->getName()), 0, 80);
	            $prod_name_long->addAttribute('LanguageCode', 'EN');
	            $prod_name_long->addAttribute('MaintenanceType', 'A'); 
	            $prod_name_long->addAttribute('DescriptionCode', 'DES');
	            
	            $prod_name_short = $descriptions->addChild('Description'); //, $record->getProductLine()->getName()); // Grab Product Line name
	            $prod_name_short->Description = substr(htmlspecialchars($record->getProductLine()->getName()), 0, 20);
	            $prod_name_short->addAttribute('LanguageCode', 'EN');
	            $prod_name_short->addAttribute('MaintenanceType', 'A');
	            $prod_name_short->addAttribute('DescriptionCode', 'SHO');
	            
	            $prod_name_ext = $descriptions->addChild('Description'); //, $record->getProductLine()->getName()); // Grab Product Line name
	            $prod_name_ext->Description = $this->brand->getShortCode().' - '.substr(htmlspecialchars($record->getProductLine()->getName()), 0, 80);
	            $prod_name_ext->addAttribute('LanguageCode', 'EN');
	            $prod_name_ext->addAttribute('MaintenanceType', 'A');
	            $prod_name_ext->addAttribute('DescriptionCode', 'EXT');
	            
	            $prod_name_invoice = $descriptions->addChild('Description'); //, $record->getProductLine()->getName()); // Grab Product Line name
	            $prod_name_invoice->Description = substr(htmlspecialchars($record->getProductLine()->getName()), 0, 20);
	            $prod_name_invoice->addAttribute('LanguageCode', 'EN');
	            $prod_name_invoice->addAttribute('MaintenanceType', 'A');
	            $prod_name_invoice->addAttribute('DescriptionCode', 'INV');
	
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
//echo $mkcopy."-2- \n";exit;
			    $marketing_copy = $descriptions->addChild('Description');
	            $marketing_copy->Description = substr($mkcopy, 0, 1998);
	            $marketing_copy->addAttribute('LanguageCode', 'EN');
	            $marketing_copy->addAttribute('MaintenanceType', 'A');
	            $marketing_copy->AddAttribute('DescriptionCode', 'MKT');
	            
	            $associated_comments = $descriptions->addChild('Description');
	            $associated_comments->Description = substr($mkcopy, 0, 1998);
	            $associated_comments->addAttribute('LanguageCode', 'EN');
	            $associated_comments->addAttribute('MaintenanceType', 'A');
	            $associated_comments->AddAttribute('DescriptionCode', 'ASC');
	            
	            $application_summary = $descriptions->addChild('Description');
	            $application_summary->Description = substr($mkcopy, 0, 1998);
	            $application_summary->addAttribute('LanguageCode', 'EN');
	            $application_summary->addAttribute('MaintenanceType', 'A');
	            $application_summary->AddAttribute('DescriptionCode', 'ASM');
	
	            $prices = $item->addChild('Prices');
	
	            // generate Jobber Price, PriceType="JBR"
	            $jobber = $prices->addChild('Pricing');
	            $jobber->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $jobber->addAttribute('PriceType', 'JBR');
	            
	            $jobber->addChild('PriceSheetNumber', $latest_pricesheet['number']);
	            $jobber->addChild('CurrencyCode', 'USD');
	            $jobber->addChild('EffectiveDate', $latest_pricesheet['effective']);
	            $jobber->addChild('ExpirationDate', $latest_pricesheet['expiration']);
	            $jobber_uom = $jobber->addChild('Price', $record->getJobberPrice());
	            $jobber_uom->addAttribute('UOM', 'PE'); // EA....I think that's what we need
	            
	            // generate MSRP Price, PriceType="RET", Retail
	            $msrp = $prices->addChild('Pricing');
	            $msrp->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $msrp->addAttribute('PriceType', 'RET');
	            
	            $msrp->addChild('PriceSheetNumber', $latest_pricesheet['number']);
	            $msrp->addChild('CurrencyCode', 'USD');
	            $msrp->addChild('EffectiveDate', $latest_pricesheet['effective']);
	            $msrp->addChild('ExpirationDate', $latest_pricesheet['expiration']);
	            $msrp_uom = $msrp->addChild('Price', $record->getMsrpPrice());
	            $msrp_uom->addAttribute('UOM', 'PE'); // EA....I think that's what we need
	            
	            $expi = $item->addChild('ExtendedInformation');
	            
	            if ($record->getCountryOfOrigin() == 'USA') {
	            	$country = 'US';
	            } else if ($record->getCountryOfOrigin() == 'CANADA') {
	            	$country = 'CA';
	            } else if ($record->getCountryOfOrigin() == 'CHINA') {
	            	$country = 'CN';
	            } else if ($record->getCountryOfOrigin() == 'TAIWAN') {
	            	$country = 'TW';
	            }
	            $expiSeg1 = $expi->addChild('ExtendedProductInformation', $record->getCountryOfOrigin());
	            $expiSeg1->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg1->addAttribute('LanguageCode', 'EN');
	            $expiSeg1->addAttribute('EXPICode', 'CTO');
	            
	            $expiSeg2 = $expi->addChild('ExtendedProductInformation', '2');
	            $expiSeg2->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg2->addAttribute('LanguageCode', 'EN');
	            $expiSeg2->addAttribute('EXPICode', 'LIF');
	            
	            $expiSeg3 = $expi->addChild('ExtendedProductInformation', 'N');
	            $expiSeg3->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg3->addAttribute('LanguageCode', 'EN');
	            $expiSeg3->addAttribute('EXPICode', 'MSR');
	            
	            $expiSeg4 = $expi->addChild('ExtendedProductInformation', 'N');
	            $expiSeg4->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg4->addAttribute('LanguageCode', 'EN');
	            $expiSeg4->addAttribute('EXPICode', 'REF');
	            
	            $expiSeg5 = $expi->addChild('ExtendedProductInformation', 'N');
	            $expiSeg5->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg5->addAttribute('LanguageCode', 'EN');
	            $expiSeg5->addAttribute('EXPICode', 'REM');
	            
	            $expiSeg6 = $expi->addChild('ExtendedProductInformation', 'Limit Lifetime');
	            $expiSeg6->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg6->addAttribute('LanguageCode', 'EN');
	            $expiSeg6->addAttribute('EXPICode', 'WS1');
	            
	            $expiSeg7 = $expi->addChild('ExtendedProductInformation', 'TX');
	            $expiSeg7->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg7->addAttribute('LanguageCode', 'EN');
	            $expiSeg7->addAttribute('EXPICode', 'WS2');
	            
	            $expiSeg8 = $expi->addChild('ExtendedProductInformation', '60');
	            $expiSeg8->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg8->addAttribute('LanguageCode', 'EN');
	            $expiSeg8->addAttribute('EXPICode', 'WT1');
	            
	            $expiSeg9 = $expi->addChild('ExtendedProductInformation', 'MO');
	            $expiSeg9->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg9->addAttribute('LanguageCode', 'EN');
	            $expiSeg9->addAttribute('EXPICode', 'WT2');
	            
	            $expiSeg9 = $expi->addChild('ExtendedProductInformation', '1');
	            $expiSeg9->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg9->addAttribute('LanguageCode', 'EN');
	            $expiSeg9->addAttribute('EXPICode', 'EMS');
	            
	            $expiSeg10 = $expi->addChild('ExtendedProductInformation', 'B');
	            $expiSeg10->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg10->addAttribute('LanguageCode', 'EN');
	            $expiSeg10->addAttribute('EXPICode', 'NAF');
	            
	            $expiSeg11 = $expi->addChild('ExtendedProductInformation', 'A');
	            $expiSeg11->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg11->addAttribute('LanguageCode', 'EN');
	            $expiSeg11->addAttribute('EXPICode', 'NPC');
	            
	            $expiSeg12 = $expi->addChild('ExtendedProductInformation', 'Top 60% of Product Group Sales Value');
	            $expiSeg12->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg12->addAttribute('LanguageCode', 'EN');
	            $expiSeg12->addAttribute('EXPICode', 'NPD');
	            
	            $expiSeg12 = $expi->addChild('ExtendedProductInformation', '8708295060');
	            $expiSeg12->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $expiSeg12->addAttribute('LanguageCode', 'EN');
	            $expiSeg12->addAttribute('EXPICode', 'HSB');
	            
	            //$prod_name_ext = $descriptions->addChild('Description'); //, $record->getProductLine()->getName()); // Grab Product Line name
	            //$prod_name_ext->Description = $this->brand->getShortCode().' - '.substr($record->getProductLine()->getName(), 0, 80);
	            //$record->getProductLine()->getName().' - '.$record->getPartNumber()
	            
	            // Product Attributes
	            $productAttributs = $item->addChild('ProductAttributes');
	            $productAttribut = $productAttributs->addChild('ProductAttribute', addslashes(htmlspecialchars($record->getProductLine()->getName())).' - '.$record->getPartNumber());
	            $productAttribut->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
	            $productAttribut->addAttribute('AttributeID', 'Title');
	            $productAttribut->addAttribute('PADBAttribute', 'N');
	            
	            // Packaging
	            $packaging = $item->addChild('Packages');
	            $package = $packaging->addChild('Package');
	            $package->addAttribute('MaintenanceType', 'A');
	            $package->addChild('PackageLevelGTIN', '00'.$record->getUpcCode());
	            $package->addChild('PackageBarCodeCharacters', $record->getUpcCode());
	            $package->addChild('PackageUOM', 'EA');
	            $package->addChild('QuantityofEaches', '1');
	             		 
	            $dimensions = $package->addChild('Dimensions');
	            $dimensions->addAttribute('UOM', 'IN');
	            $dimensions->addChild('Height', ($record->getHeight() == '0.00' ? '12.00' : $record->getHeight()) );
	            $dimensions->addChild('Width', ($record->getWidth() == '0.00' ? '12.00' : $record->getWidth()) );
	            $dimensions->addChild('Length', ($record->getLength() == '0.00' ? '12.00' : $record->getLength()) );
	            
	            $weights = $package->addChild('Weights');
	            $weights->addAttribute('UOM', 'PG');
	            $weights->addChild('Weight', ($record->getWeight() == '0.00' ? '5' : $record->getWeight()) );
	            
	            if ($record->getHeight() != '0.00') {
	            	$dimWeight = $record->getHeight()*$record->getWidth()*$record->getLength()/194;
	            	$weights->addChild('DimensionalWeight', round($dimWeight, 2));
	            }
	            
		            $assets = $item->addChild('DigitalAssets');
		            
		            foreach ($record->getPartAsset() as $part_asset) {
		            	$asset = $part_asset->getAsset();
		            
		            	$digital = $assets->addChild('DigitalFileInformation');
		            	$digital->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
		            	$digital->addAttribute('LanguageCode', 'EN');
		            
		            	$digital->addChild('FileName', $asset->getFileName());
		            	$digital->addChild('AssetType', $part_asset->getPicType());
		            
		            	$filename = explode('.', $asset->getFileName());
		            	$digital->addChild('FileType', strtoupper($filename[count($filename) - 1])); // TODO: TIF, JPG, EPS, GIF, BMP, PNG, PDF, DOC, XLS - split out file name
		            
		            	// Always 'A'
		            	$digital->addChild('Representation', 'A');
		            
		            	// asset.size
		            	$fileSize = round($asset->getSize()/1024);
		            	$digital->addChild('FileSize', $fileSize);
		            
		                // TODO: which one? DPI: 72, 96, 300, 600, 800, 1200
		           		$digital->addChild('Resolution', '72');
		            
		        		// always 'RGB'
		            	$digital->addChild('ColorMode', 'RGB');
		            
		            	// asset dimensions parent, shows ex. in doc
		          		$dimensions = $digital->addChild('AssetDimensions');
		           		$dimensions->addAttribute('UOM', 'PX');
		            
		           		// asset.height
		         		$dimensions->addChild('AssetHeight', $asset->getHeight());
		            
		        		// asset.width
		       			$dimensions->addChild('AssetWidth', $asset->getWidth());
		            
		           		// RR IS hosting images, going to track impressions... via JG.
		            	$digital->addChild('URI', 'http://' . $this->config['part_asset_path'] . $asset->getFilePath());
		            	$digital->addChild('FileDateModified', (null != $asset->getModifiedAt() ? $asset->getModifiedAt()->format('Y-m-d') : $asset->getCreatedAt()->format('Y-m-d'))); // TODO: grab last modified date, populate with today's date?
		        	
		            }
		            echo $record->getPartNumber(). " - ";
		            
		            $brandAsset = $record->getProductLine()->getBrand()->getAsset()->getFileName();
		            
		            $digital = $assets->addChild('DigitalFileInformation');
		            $digital->addAttribute('MaintenanceType', 'A'); // TODO: Change to valid change value
		            $digital->addAttribute('LanguageCode', 'EN');
		            
		            $digital->addChild('FileName', $brandAsset);
		            $digital->addChild('AssetType', 'LGO');
		            $digital->addChild('FileType', 'PNG');
		            $digital->addChild('Representation', 'A');
		            
		            
	            
		      		if (null != $record->getIsheet()) {
		            	$digital = $assets->addChild('DigitalFileInformation');
		           		$digital->addAttribute('MaintenanceType', 'A');
		            	$digital->addAttribute('LanguageCode', 'EN');
		            	$digital->addChild('FileName', addslashes(htmlspecialchars($record->getIsheet())) . '.pdf');
		            	$digital->addChild('AssetType', 'ISG');
		            	$digital->addChild('FileType', 'PDF');
		            	$digital->addChild('Represenation', 'A');
		            	$digital->addChild('URI', 'http://' . $this->config['part_asset_path'] . 'library/products/isheets/' . addslashes(htmlspecialchars($record->getIsheet())) . '.pdf');
		            }
	            
	            
	            //echo $record->getPartNumber()." - ";
	            ++$iterator;
	      	  //}
        	}
        }

        // assign record count for getFooter to utilize via getXML(), saveXML()
        $this->recordCount = count($records);
    }

    /**
     * @return void
     */
    public function getFooter()
    {
        $footer = $this->xml->addChild('Trailer');
        $footer->addChild('ItemCount', $this->recordCount);
        $footer->addChild('TransactionDate', date('Y-m-d'));
    }

    /**
     * @return string
     */
    public function getXML()
    {
        $this->getHeader();
        $this->getPriceSheetSegment();
        $this->getBody();
        $this->getFooter();

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
        $this->getHeader();
        $this->getPriceSheetSegment();
        $this->getBody();
        $this->getFooter();

        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;
        $dom->loadXML(utf8_encode($this->xml->asXML()));

        return $dom->save($location);
    }

    /**
     * @return float
     */
    private function _getPiesVersion()
    {
        return $this->_piesVersion;
    }
}
