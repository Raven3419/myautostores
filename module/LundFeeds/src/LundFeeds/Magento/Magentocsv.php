<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage MAGENTO
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\Magento;

use LundProducts\Service\PartService;
use LundProducts\Repository\BrandsRepository;
use LundFeeds\Service\MagentoService;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\ChangesetDetailsVehiclesService;
use LundProducts\Service\ProductLineService;
use LundProducts\Service\ProductLineFeatureService;
use LundProducts\Service\BrandProductCategoryService;
use SimpleXMLElement;
use DOMDocument;
use Exception;

class Magentocsv implements MagentoInterface
{
    /**
     * @var PartService
     */
    protected $partService = null;

    /**
     * @var MagentoService
     */
    protected $magentoService = null;

    /**
     * @var int
     */
    protected $recordCount = null;

    /**
     * @var string
     */
    private $_magentoVersion = 'csv';

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
     * @var ProductLineService
     */
    protected $productLineService = null;
    
    /**
     * @var ProductLineFeatureService
     */
    protected $productLineFeatureService = null;
    
    /**
     * @var BrandProductCategoryService
     */
    protected $brandProductCategoryService = null;

    /**
     * @var string
     */
    protected $brand = null;

    /**
     * @var string
     */
    protected $brands = null;

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
     * @var []
     */
    protected $config = [];

    /**
     * @param PartService $partService
     * @param MagentoService $magentoService
     * @param BrandsRepository                $brandsRepository
     * @param ChangesetsService               $changesetsService
     * @param ChangesetDetailsService         $changesetDetailsService
     * @param ChangesetDetailsVehiclesService $changesetDetaisVehiclesService
     * @param ProductLineService 	  		  $productLineService
     * @param ProductLineFeatureService 	  $productLineFeatureService
     * @param BrandProductCategoryService 	  $brandProductCategoryService
     * @param string                          $brand
     * @param string                          $generate
     * @param int                             $changeset_id
     *
     * @return void
     */
    public function __construct(PartService      	$partService = null,
                                MagentoService      $magentoService = null,
                                BrandsRepository 	$brandsRepository = null,
                                ChangesetsService $changesetsService = null,
                                ChangesetDetailsService $changesetDetailsService = null,
                                ChangesetDetailsVehiclesService $changesetDetailsVehiclesService = null,
                                ProductLineService $productLineService = null,
                                ProductLineFeatureService $productLineFeatureService = null,
                                BrandProductCategoryService $brandProductCategoryService = null,
                                $brand        		= null,
                                $generate     		= null,
                                $changeset_id 		= null,
                                $config       		= null)
    {
        if (null != $partService) {
            if (null == $this->partService) {
                $this->partService = $partService;
            }
        }

        if (null != $magentoService) {
            $this->magentoService = $magentoService;
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

        if (null != $productLineService) {
            $this->productLineService = $productLineService;
        }

        if (null != $productLineFeatureService) {
            $this->productLineFeatureService = $productLineFeatureService;
        }

        if (null != $brandProductCategoryService) {
            $this->brandProductCategoryService = $brandProductCategoryService;
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

        if (null != $brand) {
        	$this->brands = $brand;
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

    public function getHeader()
    {
    }

    public function getPriceSheetSegment()
    {
    }

    public function getFooter()
    {
    }

    public function getXML()
    {
    }

    /**
     * @return void
     */
    public function getPartsBody($fp)
    {
    	$headerArray = array(
    		'Part Number',
    		'Part Disabled',
    		'Part Saleable',
    		'Year',
    		'Make',
    		'Model',
    		'SubModel',
    		'SubDetail',
    		'MSRP Price',
    		'Weight',
    		'Height',
    		'Width',
    		'Length',
    		'Flare Height',
    		'Flare Tire Coverage',
    		'Vehicle Type',
    		'Model Type',
    		'UPC Code',
    		'Country of Origin',
    		'I-Sheet',
    		'Part Lookup Number',
    		'POP Code',
    		'Bed Type',
    		'Bed Length',
    		'Color',
    		'Drilling Required',
    		'DIM_A',
    		'DIM_B',
    		'DIM_C',
    		'DIM_D',
   			'DIM_E',
   			'DIM_F',
    		'DIM_G',
    		//'Parts Meta Title',
    		//'Parts Meta Keywords',
   			//'Parts Meta Description',
    		'Brand Short Code',
    		'Product Category Short Code',
    		'Product Line Short Code',
   			'P01 - Off Vehicle',
   			'P03 - Lifestyle',
   			'P04 - Primary Photo',
   			'P05 - Closeup',
   			'P06 - Mounted',
     		'P07 - Unmounted',
    		'Finish',
    		'Style',
    		'Material',
   			'Material Thickness',
   			'Sold As',
    		'Oversize Shipping Required',
    		'Tube Shape',
    		'Tube Size',
   			//'Light Power Rating',
   			'Warranty',
    		'Liquid Storage Capacity',
    		'Box Style',
    		'Box Opening Type',
   			'Short Description',
   			'Product Category Code Secondary (Combo Kits)',
    		'Product Category Display Name Secondary',
    		'Interior Box Dimension',//needs to be removed
    		'MaintType'
    	);
    	 
    	
    	fputcsv($fp, $headerArray);
    	

    	if ($this->generate == 'full') 
    	{
	        
	        $records = $this->partService->getWebsiteParts($this->brand, $this->generate, null, $this->lundonly);
	
	        foreach ($records as $record) 
	        {
	        	$vehicles = array();
	        
	        	$partArray = array(
					$record->getPartNumber(),
		            ($record->getDisabled() == '1' ?  $record->getDisabled() : '0' ),
		           	'0',
		           	'0',
		           	'',
		           	'',
		           	'',
		           	'',
		            $record->getMsrpPrice(),
		            $record->getWeight(),
		            $record->getHeight(),
		            $record->getWidth(),
		            $record->getLength(),
	                $record->getFlareHeight(),
		            $record->getFlareTireCoverage(),
		            $record->getVehicleType(),
		            '',
		            $record->getUpcCode(),
		            $record->getCountryOfOrigin(),
		            $record->getIsheet(),
		            $record->getLookupNumber(),
		            $record->getPopCode(),
		            '',
		            $record->getBedLength(),
		            $record->getColor(),
				    $record->getNoDrill(),
		            $record->getDima(),
		            $record->getDimb(),
		            $record->getDimc(),
		            $record->getDimd(),
		            $record->getDime(),
		            $record->getDimf(),
		            $record->getDimg(),
					//'',
		            //'',
		            //'',
					$record->getProductLine()->getBrand()->getShortCode(),
		            $record->getProductLine()->getProductCategory()->getShortCode(),
		            $record->getProductLine()->getShortCode(),
		            		
		    	);
		
		
		    	$partAssetArray = array(
		         	'P01' => '',
		            'P03' => '',
		            'P04' => '',
		            'P05' => '',
		            'P06' => '',
		            'P07' => ''
		     	);
		    	
		        foreach ($record->getPartAsset() as $partAsset) 
		        {
		            $asset = $partAsset->getAsset();
		
		         	$partAssetArray[$partAsset->getPicType()] = $asset->getFileName();
		        }
		
		        ksort($partAssetArray);
		
		        foreach ($partAssetArray as $key => $value) 
		        {
		         	$partArray[] = $value;
		        }

		       	//$partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = '';
		        $partArray[] = 'Add';
		
		        fputcsv($fp, $partArray);
		            
		            
		        foreach ($record->getVehCollections() as $vehCollection) 
		        {
		        	$vehColl = $vehCollection->getVehCollection();
		            
		            $this_hash = (STRING)(($vehColl->getVehMake()) ? $vehColl->getVehMake()->getVehMakeId() : '') .
		           	(($vehColl->getVehModel()) ? '-' . $vehColl->getVehModel()->getVehModelId() : '') .
		           	(($vehColl->getVehSubmodel()) ? '-' . $vehColl->getVehSubmodel()->getVehSubmodelId() : '').
		           	(($vehColl->getBodyType()) ? '-' . $vehColl->getBodyType() : '');		         
		            $vehicles[$this_hash]['years'][]           	= $vehColl->getVehYear()->getName();
		           	$vehicles[$this_hash]['make_id']           	= $vehColl->getVehMake()->getName();
		           	$vehicles[$this_hash]['model_id']          	= $vehColl->getVehModel()->getName();
		           	$vehicles[$this_hash]['submodel_id']       	= (($vehColl->getVehSubmodel()) ? $vehColl->getVehSubmodel()->getName() : '');
		           	$vehicles[$this_hash]['body_type_id']      	= $vehColl->getBodyTypeId();
		           	$vehicles[$this_hash]['body_num_doors_id'] 	= $vehColl->getBodyNumDoorsId();
		           	$vehicles[$this_hash]['bed_type']       	= $vehColl->getBedType();
		           	$vehicles[$this_hash]['model_type']       	= $vehColl->getModelType();
		            
		           	$partVehicleCollection = $this->changesetsService->getPartVehicleCollection(
		          		$record->getPartId(),
		            	$vehCollection->getVehCollection()->getVehCollectionId()
		           	);
		            
		            if (null != $partVehicleCollection) 
		            {
		            	if (is_array($partVehicleCollection)) 
		            	{
		           			$partVehicleCollection = $partVehicleCollection[0];
		           		}
		           
		           		$vehicles[$this_hash]['subdetail'] = $partVehicleCollection->getSubdetail();
		            
		           	} else {
		           		$vehicles[$this_hash]['subdetail'] = '';
		           	}
		      	}
		            
		        foreach ($vehicles as $vehicle) 
		        {
		           	$years = [];
		            
		            // generate to/from years
		            foreach ($vehicle['years'] as $year) 
		            {
		            	$years[] = $year;
		            }
		            
		            for($y=0; $y<count($vehicle['years']); $y++)
		            {
		            
				     	$partArray = array(
				         	$record->getPartNumber(),
		                	($record->getDisabled() == '1' ?  $record->getDisabled() : '0' ),
				            '0',
				            $vehicle['years'][$y],
				            $vehicle['make_id'],
				            $vehicle['model_id'],
				            $vehicle['submodel_id'],
				            $vehicle['subdetail'],
				            $record->getMsrpPrice(),
				            $record->getWeight(),
				            $record->getHeight(),
				            $record->getWidth(),
				            $record->getLength(),
				            $record->getFlareHeight(),
				            $record->getFlareTireCoverage(),
				            '',
				            $vehicle['model_type'],
				            $record->getUpcCode(),
				            $record->getCountryOfOrigin(),
				            $record->getIsheet(),
				            $record->getLookupNumber(),
				            $record->getPopCode(),
				            $vehicle['bed_type'],
				            $record->getBedLength(),
				            $record->getColor(),
				            $record->getNoDrill(),
				            $record->getDima(),
				            $record->getDimb(),
				            $record->getDimc(),
				            $record->getDimd(),
				            $record->getDime(),
				            $record->getDimf(),
				            $record->getDimg(),
						    //'',
				            //'',
				            //'',
				            $record->getProductLine()->getBrand()->getShortCode(),
				            $record->getProductLine()->getProductCategory()->getShortCode(),
				            $record->getProductLine()->getShortCode(),
				            
				     	);
				            
				     	$partAssetArray = array(
				           	'P01' => '',
				            'P03' => '',
				            'P04' => '',
				            'P05' => '',
				            'P06' => '',
				            'P07' => ''
				    	);
				     	
				       	foreach ($record->getPartAsset() as $partAsset)
				        {
				        	$asset = $partAsset->getAsset();
				            
				           	$partAssetArray[$partAsset->getPicType()] = $asset->getFileName();
				        }
				            
				        ksort($partAssetArray);
				            
				        foreach ($partAssetArray as $key => $value)
				        {
				           	$partArray[] = $value;
				        }
				            
				        //$partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
				        $partArray[] = '';
		            	$partArray[] = '';
				        $partArray[] = 'Add';
				            
				        fputcsv($fp, $partArray);
				            
				            
				        //echo $record->getPartNumber()." - ";
				        //print_r($vehicles);
		            
		            }
		       	}
	        }
        }
        if ($this->generate == 'incr' && isset($this->changeset_id)) 
        {
        	$changeset_details = $this->changesetDetailsService->getChangesetDetailsByChangesetId($this->changeset_id);

        	foreach ($changeset_details as $record) 
        	{
        		if (null != $record->getParts()) {
        			$part = $record->getParts();
        		} else {
        			$part = $this->partService->getPartByPartNumber($record->getPartNumber());
        		}
        		 
        		$changeDetails = explode(",", $record->getChangeFileRow());
        		
        		//echo $record->getPartId();
        		//print_r($changeDetails);
        		//echo count($record)." - ";
        		//echo $record->getParts()->getPartNumber()." - ";
        		if($this->brands == $part->getProductLine()->getBrand()->getShortCode())
        		{
	        		//echo $record->getChange()." - ";
	        		
	        		if($changeDetails[6] == '"0.0"' || $changeDetails[6] == '"0"')
	        		{
		        		$vehicles = array();
		        			 
		        		$partArray = array(
		        			$part->getPartNumber(),
		        			($part->getDisabled() == '1' ?  $part->getDisabled() : '0' ),
		        			'0',
		        			'0',
		        			'',
		        			'',
		        			'',
		        			'',
		        			$part->getMsrpPrice(),
		        			$part->getWeight(),
		        			$part->getHeight(),
		        			$part->getWidth(),
		        			$part->getLength(),
		        			$part->getFlareHeight(),
		        			$part->getFlareTireCoverage(),
		        			$part->getVehicleType(),
		        			'',
		        			$part->getUpcCode(),
		        			$part->getCountryOfOrigin(),
		        			$part->getIsheet(),
		        			$part->getLookupNumber(),
		        			$part->getPopCode(),
		        			'',
		        			$part->getBedLength(),
		        			$part->getColor(),
		        			$part->getNoDrill(),
		        			$part->getDima(),
		        			$part->getDimb(),
		        			$part->getDimc(),
		        			$part->getDimd(),
		        			$part->getDime(),
		        			$part->getDimf(),
		        			$part->getDimg(),
		        			//'',
		        			//'',
		        			//'',
		        			$part->getProductLine()->getBrand()->getShortCode(),
		        			$part->getProductLine()->getProductCategory()->getShortCode(),
		        			$part->getProductLine()->getShortCode(),
		        		);
		        		
		        		
		        		$partAssetArray = array(
		        			'P01' => '',
		        			'P03' => '',
		        			'P04' => '',
		        			'P05' => '',
		        			'P06' => '',
		        			'P07' => ''
		        		);
		        			 
		        		foreach ($part->getPartAsset() as $partAsset)
		        		{
		        			$asset = $partAsset->getAsset();
		        		
		        			$partAssetArray[$partAsset->getPicType()] = $asset->getFileName();
		        		}
		        		
		        		ksort($partAssetArray);
		        		
		        		foreach ($partAssetArray as $key => $value)
		        		{
		        			$partArray[] = $value;
		        		}
		        		
		        		//$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = '';
		        		$partArray[] = $record->getChange();
		        		
		        		fputcsv($fp, $partArray);
		        		
	        		}
	        		else {
			       				$partArray = array(
			       					$part->getPartNumber(),
			       					($part->getDisabled() == '1' ?  $part->getDisabled() : '0' ),
			       					'0',
			       					str_replace('"', '', $changeDetails[6]),
			       					str_replace('"', '', $changeDetails[8]),
			       					str_replace('"', '', $changeDetails[9]),
			       					str_replace('"', '', $changeDetails[10]),
			       					str_replace('"', '', $changeDetails[11]),
			        				$part->getMsrpPrice(),
			        				$part->getWeight(),
			        				$part->getHeight(),
			        				$part->getWidth(),
			        				$part->getLength(),
			        				$part->getFlareHeight(),
			        				$part->getFlareTireCoverage(),
			        				'',
			       					str_replace('"', '', $changeDetails[46]),
			        				$part->getUpcCode(),
			        				$part->getCountryOfOrigin(),
			        				$part->getIsheet(),
			        				$part->getLookupNumber(),
			        				$part->getPopCode(),
			       					str_replace('"', '', $changeDetails[13]),
			        				$part->getBedLength(),
			        				$part->getColor(),
			        				$part->getNoDrill(),
			        				$part->getDima(),
			        				$part->getDimb(),
			        				$part->getDimc(),
			        				$part->getDimd(),
			        				$part->getDime(),
			        				$part->getDimf(),
			        				$part->getDimg(),
			        				//'',
			        				//'',
			        				//'',
			        				$part->getProductLine()->getBrand()->getShortCode(),
			        				$part->getProductLine()->getProductCategory()->getShortCode(),
			        				$part->getProductLine()->getShortCode(),
			        			
			       				);
		        		
			        			$partAssetArray = array(
			        				'P01' => '',
			        				'P03' => '',
			        				'P04' => '',
			        				'P05' => '',
			        				'P06' => '',
			        				'P07' => ''
			        			);
			        		
			        			foreach ($part->getPartAsset() as $partAsset)
			        			{
			        				$asset = $partAsset->getAsset();
			        		
			        				$partAssetArray[$partAsset->getPicType()] = $asset->getFileName();
			        			}
		        		
			        			ksort($partAssetArray);
			        		
			        			foreach ($partAssetArray as $key => $value)
			        			{
			        				$partArray[] = $value;
			        			}
			        		
			        			//$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = '';
			        			$partArray[] = $record->getChange();
			        		
			        			fputcsv($fp, $partArray);
			        		
			        		
			        			//echo $record->getPartNumber()." - ";
			        			///print_r($vehicles);exit;
			        		
			        		}
			        	}
	       			}
        		
        }
    }

    /**
     * @return void
     */
    public function getBrandsBody($fp)
    {
    	$headerArray = array(
	        'Product Line Display Name',
	        'Product Line Short Code',
	        'Product Line Disabled',
	        'Product Line Saleable',
	        'Product Line HTML',
	        'Product Line Description',
	        //'Product Line Meta Title',
	        //'Product Line Meta Keywords',
	        //'Product Line Meta Description',
	        'Product Line Feature - Benefits 1',
	        'Product Line Feature - Benefits 2',
	        'Product Line Feature - Benefits 3',
	        'Product Line Feature - Benefits 4',
	        'Product Line Feature - Benefits 5',
	        'Product Line Feature - Benefits 6',
	        'Product Line Feature - Benefits 7',
	        'Product Line Feature - Benefits 8',
	        'Product Line Feature - Benefits 9',
	        'Product Line Feature - Benefits 10',
	        'Product Line Feature - Benefits 11',
	        'Product Line Feature - Benefits 12',
	        'Product Line Feature - Benefits 13',
	        'Product Line Feature - Benefits 14',
	        'Product Line Feature - Benefits 15',
	        'Product Line Feature - Benefits 16',
	        'Product Line Feature - Benefits 17',
	        'Product Line Feature - Benefits 18',
	        'Product Line Feature - Benefits 19',
	        'Product Line Feature - Benefits 20',
	        'Product Line Install Video',
	        'Product Line V01 - video',
	        'Product Line V02 - video',
	        'Product Line V03 - video',	
	        'Product Line V04 - video',	
	        'Product Line V05 - video',	
	        'Product Line V06 - video',
	        'Product Category Display Name',
	        'Product Category Code',
	        'Product Category Disabled',
	        'Product Category Saleable',
	        'Product Category Media Asset',
	        'Brand Product Category Disabled',
	        'Brand Product Category Saleable',
	        'Brand Product Category Short Description',
	        'Brand Product Category Long Description',
	        'Brand Product Category Meta Title',
	        'Brand Product Category Meta Keywords',
	        'Brand Product Category Meta Description'
    	);
	        
		fputcsv($fp, $headerArray);
	
	 	$records = $this->productLineService->getAllProductLinesByBrand($this->brand);
	
	    // iterate through parts
        foreach ($records as $record) {
        	
			$brandArray = array(
	            $record->getDisplayName(),
	            $record->getShortCode(),
	        	($record->getDisabled() == '1' ?  $record->getDisabled() : '0' ),
	            ($record->getSaleable() == '1' ?  $record->getSaleable() : '0' ),
	            $record->getOverview(),
	            '',
	            //$record->getMetaTitle(),
	            //$record->getMetaKeywords(),
	            //$record->getMetaDescr(),
	        			
			);
		
			for($x=1; $x<21; $x++)
			{
				$features = $this->productLineFeatureService->getFeatureByPosition($record, $x);
				
				if($features)
				{
					$brandArray[] = $features->getFeatureCopy();
				}
				else 
				{
					$brandArray[] = '';
				}
			}
			//echo $record->getInstallationVideo(). ' - ';
			$brandArray[] = $record->getInstallationVideo();
			$brandArray[] = '';
			$brandArray[] = '';
			$brandArray[] = '';
			$brandArray[] = '';
			$brandArray[] = '';
			$brandArray[] = '';
			
			
			$brandRecords = $this->brandProductCategoryService->getCategoryByBrandAndCategory($this->brand, $record->getProductCategory());
			
			$newBrandArray = array(
				$record->getProductCategory()->getShortCode(),
				$record->getProductCategory()->getDisplayName(),
	        	($record->getProductCategory()->getDisabled() == '1' ?  $record->getProductCategory()->getDisabled() : '0' ),
				'1',
				(empty($record->getProductCategory()->getAsset()) ? '' : $record->getProductCategory()->getAsset()->getFileName()),	 			
				($brandRecords->getDisabled() == '1' ?  $brandRecords->getDisabled() : '0' ),
				'1',
				$brandRecords->getShortDescr(),
				$brandRecords->getLongDescr(),
				$brandRecords->getMetaTitle(),
				$brandRecords->getMetaKeywords(),
				$brandRecords->getMetaDescr()
				
			);	

			foreach ($newBrandArray as $key => $value)
			{
				$brandArray[] = $value;
			}
			
			fputcsv($fp, $brandArray);
        	       
	        
        }
    }

    /**
     * @param  string $location
     * @return void
     */
    public function savePartsCSV($location = null)
    {
        $fp = fopen($location, 'w');

        $this->getPartsBody($fp);

        fclose($fp);

        return true;
    }
    
    /**
     * @param  string $location
     * @return void
     */
    public function saveBrandsCSV($location = null)
    {
    	$fp = fopen($location, 'w');
    
    	$this->getBrandsBody($fp);
    
    	fclose($fp);
    
    	return true;
    }

    /**
     * @return string
     */
    private function _getMagentoVersion()
    {
        return $this->_magentoVersion;
    }
}
