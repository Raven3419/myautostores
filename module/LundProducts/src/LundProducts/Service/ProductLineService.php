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
use Zend\Form\FormInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\ProductLines;
use LundProducts\Repository\ProductLinesRepositoryInterface;
use LundProducts\Form\ProductLineForm;
use LundProducts\Entity\ProductLinesInterface;
use RocketUser\Entity\User;
use DateTime;
use PDO;
use LundProducts\Service\ProductLineFeatureService;

class ProductLineService implements EventManagerAwareInterface
{

    /*
     * @var PDO
     */
    protected $connection = null;
    
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /*
     * @var ProductLineForm
     */
    protected $productLineForm;

    /**
     * @var ProdcuctLinesInterface
     */
    protected $productLinesPrototype;

    /**
     * @var ProductLineFEatureService
     */
    protected $productLineFeatureService;

    /**
     * @param ObjectManager
     * @param ObjectRepository
     * @param ProductLineForm
     * @param ProductLineFeatureService
     */
    public function __construct(ObjectManager                   $objectManager,
                                ProductLinesRepositoryInterface $repository,
                                ProductLineForm                 $productLineForm,
                                ProductLineFeatureService       $productLineFeatureService,
        						PDO    							$connection)
    {
        $this->objectManager   = $objectManager;
        $this->repository      = $repository;
        $this->productLineForm = $productLineForm;
        $this->productLineFeatureService = $productLineFeatureService;
        $this->connection = $connection;
    }

    /**
     * Return count of active product lines
     *
     * @return integer
     */
    public function getCount()
    {
        $dql = 'SELECT COUNT(p) FROM LundProducts\Entity\ProductLines p WHERE p.deleted = :deleted';
        $q = $this->objectManager->createQuery($dql);
        $q->setParameters(array('deleted' => 0));

        return $q->getSingleScalarResult();
    }

    /*
     * @param  string $sql
     * @return PDO
     */
    private function prepare($sql = null)
    {
        return $this->connection->prepare($sql);
    }

    /**
     * @return mixed
     */
    public function getProductLineCat($category)
	{
        return $this->repository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'productCategory' => $category->getProductCategoryId(),
            ),
            array(
                'position' => 'ASC',
            )
        );
    }
    
    /**
     * @return mixed
     */
    public function getSubModel($subModel, $model)
    {
        
        $foundBrand = $this->prepare("select distinct vs.*
										from veh_submodel as vs
										where vs.name = '".$subModel."'
                                        and vs.veh_model_id = '".$model[0]['veh_model_id']."'
    									");
        $foundBrand->execute();
        
        $return = $foundBrand->fetchAll();
        
        return $return;
    }

    /**
     * @return mixed
     */
    public function getProductLineByCategoryComparison($category)
	{
    	$foundBrand = $this->prepare("select distinct cc.* , a.file_path, pl.brand_id, pc.display_name
										from comparison_chart as cc, product_lines as pl, asset as a, product_categories as pc
										where pl.product_category_id = '".$category."'
										and pl.comparison_chart_id = cc.comparison_chart_id 
										and pl.product_category_id = pc.product_category_id
										and a.asset_id = cc.asset_id
										and cc.disabled ='0'
										and cc.deleted = '0'
										order by cc.name;
    									");
    	$foundBrand->execute();
    	 
    	$return = $foundBrand->fetchAll();
    
    	return $return;
    }
    
    
    /**
     * Return product line by brand product category
     *
     * @return string
     */
    public function getCategoryForCart($brand=null, $year=null, $make=null, $model=null, $submodel=null, $category=null)
    {
        
        $brands = implode("', '", $brand);
        /*
        echo "select pc.display_name as PC_Display, pc.name as PC_Name, pl.display_name as PL_Display, pl.name as PL_Name, pl.teaser as teaser, pl.website_overview as html, pl.product_line_id as product_line_id, b.name as brand, bpc.short_descr as short_descr,
    			bpc.long_descr as long_descr, a.hash as hash, p.color_group, p.bed_length, p.finish, p.style, p.material, p.sold_as, p.tube_size, p.tube_shape, p.liquid_storage_capacity, p.box_style, p.box_opening_type,  pl.position, pl.total_rating, p.color_group, bpc.meta_title, bpc.meta_keywords, bpc.meta_descr
										from brand_product_category as bpc, product_categories as pc, product_lines as pl, brands as b, product_line_asset as pla, asset as a, parts as p, part_veh_collection as pvc, veh_collection as vc
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = bpc.product_category_id
										and pl.brand_id = b.brand_id
										and pl.product_line_id = pla.product_line_id
										and pla.asset_id = a.asset_id
										and pla.asset_seq = '1'
										and bpc.disabled = '0' and bpc.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
										and p.product_line_id = pl.product_line_id
										and p.part_id = pvc.part_id
										and pvc.veh_collection_id = vc.veh_collection_id
    									and vc.veh_year_id = '".$year."'
    									and vc.veh_make_id = '".$make."'
    									and vc.veh_model_id = '".$model."'
    									and b.brand_id in ('".$brands."')
    									".(!empty($category)? " and pc.display_name not in ($category)" : "" )."
    									and p.saleable = '1'
    									".(!empty($submodel)? " and vc.veh_submodel_id = '$submodel'" : "" )."
    									";exit;
        */
        $foundBrand = $this->prepare("select pc.display_name as PC_Display, pc.name as PC_Name, pl.display_name as PL_Display, pl.name as PL_Name, pl.teaser as teaser, pl.website_overview as html, pl.product_line_id as product_line_id, b.name as brand, bpc.short_descr as short_descr,
    			bpc.long_descr as long_descr, a.hash as hash, p.color_group, p.bed_length, p.finish, p.style, p.material, p.sold_as, p.tube_size, p.tube_shape, p.liquid_storage_capacity, p.box_style, p.box_opening_type,  pl.position, pl.total_rating, p.color_group, bpc.meta_title, bpc.meta_keywords, bpc.meta_descr
										from brand_product_category as bpc, product_categories as pc, product_lines as pl, brands as b, product_line_asset as pla, asset as a, parts as p, part_veh_collection as pvc, veh_collection as vc
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = bpc.product_category_id
										and pl.brand_id = b.brand_id
										and pl.product_line_id = pla.product_line_id
										and pla.asset_id = a.asset_id
										and pla.asset_seq = '1'
										and bpc.disabled = '0' and bpc.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
										and p.product_line_id = pl.product_line_id
										and p.part_id = pvc.part_id
										and pvc.veh_collection_id = vc.veh_collection_id
    									and vc.veh_year_id = '".$year."'
    									and vc.veh_make_id = '".$make."'
    									and vc.veh_model_id = '".$model."'
    									and b.brand_id in ('".$brands."')
    									".(!empty($category)? " and pc.display_name not in ($category)" : "" )."
    									and p.saleable = '1'
    									".(!empty($submodel)? " and vc.veh_submodel_id = '$submodel'" : "" )."
    									");
        $foundBrand->execute();
        
        $return = $foundBrand->fetchAll();
        
        
        return $return;
    }
    

    /**
     * Return product line by brand product category
     *
     * @return string
     */
    public function getCategoryBrandProductCategory($category=null, $year=null, $make=null, $model=null, $brand=null, $sort=null, $color=null, $finish=null, $style=null, $price=null)
    {
        $colors  = null;
        $finishs = null;
        $styles  = null;
        $prices  = null;
        
    	switch($sort)
    	{
    		case 1:
    			$sortText = 'ORDER BY pl.position asc';
    			break;
    		case 2:
    			$sortText = 'ORDER BY pl.display_name asc';
    			break;
    		case 3:
    			$sortText = 'ORDER BY pl.display_name desc';
    			break;
    		default:
    			$sortText = '';
    			break;
    	}
    	
    	$brands = implode("', '", $brand);
    	
    	
    	if(null != $color)
    	{
        	if($color['all'] != 'on')
        	{
        	    $color = array_keys($color);
        	    
        	    for($x=0; $x<count($color); $x++)
        	    {
        	        $colors .= $color[$x]."','";
        	    }
        	}
    	}
    	
    	if(null != $finish)
    	{
        	if($finish['all'] != 'on')
        	{
        	    $finish = array_keys($finish);
        	    for($x=0; $x<count($finish); $x++)
        	    {
        	        $finishs .= $finish[$x]."','";
        	    }
        	}
    	}
    	
    	if(null != $style)
    	{
        	if($style['all'] != 'on')
        	{
        	    $style = array_keys($style);
        	    for($x=0; $x<count($style); $x++)
        	    {
        	        $styles .= $style[$x]."','";
        	    }
        	}
    	}
    	
    	if(null != $price)
    	{
        	if($price['all'] != 'on')
        	{
        	    $price = array_keys($price);
        	    
        	    for($x=0; $x<count($price); $x++)
        	    {
        	        $allPrices = explode("-",$price[$x]);
        	        if($x==0) {
        	            $prices .= " and p.sale_price between '".$allPrices['0']."' and '".$allPrices['1']."' ";
        	        } else {
        	            $prices .= " or p.sale_price between '".$allPrices['0']."' and '".$allPrices['1']."' ";
        	        }
        	        //$prices .= $price[$x]."','";
        	    }
        	}
    	}

    	/*
    	echo "select pc.display_name as PC_Display, pc.name as PC_Name, pl.display_name as PL_Display, pl.name as PL_Name, pl.teaser as teaser, pl.website_overview as html, pl.product_line_id as product_line_id, b.name as brand, bpc.short_descr as short_descr, p.sale_price,
    			bpc.long_descr as long_descr, a.hash as hash, a.file_name as fileName, p.color_group, p.bed_length, p.finish, p.style, p.material, p.sold_as, p.tube_size, p.tube_shape, p.liquid_storage_capacity, p.box_style, p.box_opening_type,  pl.position, pl.total_rating, pl.total_count, p.color_group, bpc.meta_title, bpc.meta_keywords, bpc.meta_descr
										from brand_product_category as bpc, product_categories as pc, brands as b, parts as p, part_veh_collection as pvc, veh_collection as vc, product_lines as pl
                                        LEFT JOIN product_line_asset as pla on pla.product_line_id = pl.product_line_id
                                        LEFT JOIN asset as a on a.asset_id = pla.asset_id
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = bpc.product_category_id
										and pl.brand_id = b.brand_id
										and bpc.disabled = '0' and bpc.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
										and p.product_line_id = pl.product_line_id
										and p.part_id = pvc.part_id
										and pvc.veh_collection_id = vc.veh_collection_id
    									and vc.veh_year_id = '".$year."'
    									and vc.veh_make_id = '".$make."'
    									and vc.veh_model_id = '".$model."'
    									and b.brand_id in ('".$brands."')
    									".(!empty($category)? " and pc.display_name = '$category'" : "" )."
    									".((null != $colors) ? " and p.color in ('".substr($colors, 0, -3)."') " : "" )."
    									".((null != $finishs) ? " and p.finish in ('".substr($finishs, 0, -3)."') " : "" )."
    									".((null != $styles) ? " and p.style in ('".substr($styles, 0, -3)."') " : "" )."
    									".((null != $prices) ? $prices : "")."
    									".$sortText."
    									";
    	*/
    	
    	$foundBrand = $this->prepare("select pc.display_name as PC_Display, pc.name as PC_Name, pl.display_name as PL_Display, pl.name as PL_Name, pl.teaser as teaser, pl.website_overview as html, pl.product_line_id as product_line_id, b.name as brand, bpc.short_descr as short_descr, p.sale_price,
    			bpc.long_descr as long_descr, a.hash as hash, a.file_name as fileName, p.color_group, p.color, p.bed_length, p.finish, p.style, p.material, p.sold_as, p.tube_size, p.tube_shape, p.liquid_storage_capacity, p.box_style, p.box_opening_type,  pl.position, pl.total_rating, pl.total_count, p.color_group, bpc.meta_title, bpc.meta_keywords, bpc.meta_descr
										from brand_product_category as bpc, product_categories as pc, brands as b, parts as p, part_veh_collection as pvc, veh_collection as vc, product_lines as pl
                                        LEFT JOIN product_line_asset as pla on pla.product_line_id = pl.product_line_id
                                        LEFT JOIN asset as a on a.asset_id = pla.asset_id
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = bpc.product_category_id
										and pl.brand_id = b.brand_id
										and bpc.disabled = '0' and bpc.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
										and p.product_line_id = pl.product_line_id
										and p.part_id = pvc.part_id
										and pvc.veh_collection_id = vc.veh_collection_id
    									and vc.veh_year_id = '".$year."'
    									and vc.veh_make_id = '".$make."'
    									and vc.veh_model_id = '".$model."'
    									and b.brand_id in ('".$brands."')
    									".(!empty($category)? " and pc.display_name = '$category'" : "" )."
    									".((null != $colors) ? " and p.color in ('".substr($colors, 0, -3)."') " : "" )."
    									".((null != $finishs) ? " and p.finish in ('".substr($finishs, 0, -3)."') " : "" )."
    									".((null != $styles) ? " and p.style in ('".substr($styles, 0, -3)."') " : "" )."
    									".((null != $prices) ? $prices : "")."
    									".$sortText."
    									");
    	$foundBrand->execute();
    	 
    	$return = $foundBrand->fetchAll();
    
    	 
    	return $return;
    }
    
    
    /**
     * Return product line by brand product category
     *
     * @return string 
     */
    public function getVehType($vehType, $make=null, $brand=null, $sort=null, $color=null, $bedLength=null, $finish=null, $style=null, $material=null, $soldAs=null, $tubeSize=null, $tubeShape=null, $liquidStorageCapacity=null, $boxStyle=null, $boxOpeningType=null)
    {

    	switch($sort)
    	{
    		case 1:
    			$sortText = 'ORDER BY pl.position asc';
    			break;
    		case 2:
    			$sortText = 'ORDER BY pl.total_rating asc';
    			break;
    		case 3:
    			$sortText = 'ORDER BY pl.display_name asc';
    			break;
    		case 4:
    			$sortText = 'ORDER BY pl.display_name desc';
    			break;
    		default:
    			$sortText = 'ORDER BY pl.position asc';
    			break;
    	}
    	
    	$vehTypes = implode("', '", $vehType);
    	$brands = implode("', '", $brand);
    	
        /*
    	echo "select distinct vc.veh_make_id, pl.display_name as PL_Display, pc.display_name as PC_Display, pc.name as PC_Name, pl.name as PL_Name, pl.teaser as teaser, pl.website_overview as html, pl.product_line_id as product_line_id, b.name as brand,
    			bpc.short_descr as short_descr, bpc.long_descr as long_descr, a.hash as hash, a2.file_name as file_name, p.color_group, p.bed_length, p.finish, p.style, p.material, p.sold_as, p.tube_size, p.tube_shape, p.liquid_storage_capacity, p.box_style, p.box_opening_type,  pl.position, pl.total_rating, p.color_group
										from brand_product_category as bpc, brands as b, parts as p, part_veh_collection as pvc, veh_collection as vc, product_lines as pl
                                        left join product_line_asset as pla on pl.product_line_id = pla.product_line_id and pla.asset_seq = '1'
                                        left join asset as a on pla.asset_id = a.asset_id,
                                        product_categories as pc
                                        left join asset as a2 on pc.header_asset_id = a2.asset_id   	    
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = bpc.product_category_id
										and pl.brand_id = b.brand_id
										and pl.product_line_id = p.product_line_id
										and bpc.disabled = '0' and bpc.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
						    			and pvc.part_id = p.part_id
										and pvc.veh_collection_id = vc.veh_collection_id
    									".((count($brands) != '0' )? " and b.brand_id in ('".$brands."') " : "" )."
										".(!empty($make)? " and vc.veh_make_id = '$make'" : "" )."
										and p.vehicle_type in ('".$vehTypes."')
    									".(!empty($color)? " and p.color_group = '$color'" : "" )."
    									".(!empty($bedLength)? " and p.bed_length = '$bedLength'" : "" )."
    									".(!empty($finish)? " and p.finish = '$finish'" : "" )."
    									".(!empty($style)? " and p.style = '$style'" : "" )."
    									".(!empty($material)? " and p.material = '$material'" : "" )."
    									".(!empty($soldAs)? " and p.sold_as = '$soldAs'" : "" )."
    									".(!empty($tubeSize)? " and p.tube_size = '$tubeSize'" : "" )."
    									".(!empty($tubeShape)? " and p.tube_shape = '$tubeShape'" : "" )."
    									".(!empty($liquidStorageCapacity)? " and p.liquid_storage_capacity = '$liquidStorageCapacity'" : "" )."
    									".(!empty($boxStyle)? " and p.box_style = '$boxStyle'" : "" )."
    									".(!empty($boxOpeningType)? " and p.box_opening_type = '$boxOpeningType'" : "" )."
    									".$sortText."
    									";exit;
    	*/
    	
    	
    	$foundBrand = $this->prepare("select distinct vc.veh_make_id, pl.display_name as PL_Display, pc.display_name as PC_Display, pc.name as PC_Name, pl.name as PL_Name, pl.teaser as teaser, pl.website_overview as html, pl.product_line_id as product_line_id, b.name as brand, p.sale_price,
    			bpc.short_descr as short_descr, bpc.long_descr as long_descr, a.hash as hash, a.file_name as fileName, a2.file_name as file_name, p.color_group, p.bed_length, p.finish, p.style, p.material, p.sold_as, p.tube_size, p.tube_shape, p.liquid_storage_capacity, p.box_style, p.box_opening_type,  pl.position, pl.total_rating, p.color_group
										from brand_product_category as bpc, brands as b, parts as p, part_veh_collection as pvc, veh_collection as vc, product_lines as pl
                                        left join product_line_asset as pla on pl.product_line_id = pla.product_line_id and pla.asset_seq = '1'
                                        left join asset as a on pla.asset_id = a.asset_id,
                                        product_categories as pc
                                        left join asset as a2 on pc.header_asset_id = a2.asset_id
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = bpc.product_category_id
										and pl.brand_id = b.brand_id
										and pl.product_line_id = p.product_line_id
										and bpc.disabled = '0' and bpc.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
						    			and pvc.part_id = p.part_id
										and pvc.veh_collection_id = vc.veh_collection_id
    									".((count($brands) != '0' )? " and b.brand_id in ('".$brands."') " : "" )."
										".(!empty($make)? " and vc.veh_make_id = '$make'" : "" )."
										and p.vehicle_type in ('".$vehTypes."')
    									".(!empty($color)? " and p.color_group = '$color'" : "" )."
    									".(!empty($bedLength)? " and p.bed_length = '$bedLength'" : "" )."
    									".(!empty($finish)? " and p.finish = '$finish'" : "" )."
    									".(!empty($style)? " and p.style = '$style'" : "" )."
    									".(!empty($material)? " and p.material = '$material'" : "" )."
    									".(!empty($soldAs)? " and p.sold_as = '$soldAs'" : "" )."
    									".(!empty($tubeSize)? " and p.tube_size = '$tubeSize'" : "" )."
    									".(!empty($tubeShape)? " and p.tube_shape = '$tubeShape'" : "" )."
    									".(!empty($liquidStorageCapacity)? " and p.liquid_storage_capacity = '$liquidStorageCapacity'" : "" )."
    									".(!empty($boxStyle)? " and p.box_style = '$boxStyle'" : "" )."
    									".(!empty($boxOpeningType)? " and p.box_opening_type = '$boxOpeningType'" : "" )."
    									".$sortText."
    									");
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
  
    	
    	return $return;
    }
    
    
    /**
     * Return product line by brand product category
     *
     * @return string
     */
    public function getProductLines($number = null)
    {
        $foundBrand = $this->prepare("select distinct pl.display_name as PL_Display, pc.display_name as PC_Display, pc.name as PC_Name, pl.name as PL_Name, pl.website_overview as html, pl.teaser, p.sale_price,
    			pl.product_line_id as product_line_id, b.name as brand, bpc.short_descr as short_descr, bpc.long_descr as long_descr, pl.position, pl.total_rating, pl.total_count, bpc.meta_title, bpc.meta_keywords, bpc.meta_descr,
    			a.hash as hash, a.file_name as fileName, a2.file_name as file_name, p.color, p.finish, p.style
										from brand_product_category as bpc, brands as b, parts as p, product_lines as pl
										left join product_line_asset as pla on pl.product_line_id = pla.product_line_id and pla.asset_seq = '1'
                                        left join asset as a on pla.asset_id = a.asset_id,
                                        product_categories as pc
                                        left join asset as a2 on pc.header_asset_id = a2.asset_id
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = pc.product_category_id
										and pl.brand_id = b.brand_id
										and bpc.disabled = '0' and bpc.deleted = '0'
										and p.disabled = '0' and p.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
										and p.product_line_id = pl.product_line_id
                                        order by rand() limit ".$number);
        $foundBrand->execute();
        
        $return = $foundBrand->fetchAll();
        
        //echo count($return);exit;
        
        return $return;
    }
    
    public function getProductLineAssets($productLineId) 
    {
        $foundBrand = $this->prepare("select distinct a.file_name as fileName
										from product_lines as pl
										left join product_line_asset as pla on pl.product_line_id = pla.product_line_id and pla.asset_seq = '1'
                                        left join asset as a on pla.asset_id = a.asset_id
										where pl.disabled = '0' and pl.deleted = '0'
										and pl.product_line_id = '".$productLineId."'
                                        ");
        $foundBrand->execute();
        
        $return = $foundBrand->fetchAll();
        
        //echo count($return);exit;
        
        return $return;
   
    }
    
    /**
     * Return product line by brand product category
     *
     * @return string 
     */
    public function getBrandProductCategory($category, $brand, $sort=null, $color=null, $finish=null, $style=null, $price=null)
    {
        $colors = null;
        $finishs = null;
        $styles = null;
        $prices = null;
        $brands = null;
        
    	switch($sort)
    	{
    		case 1:
    			$sortText = ' ORDER BY pl.position asc';
    			break;
    		case 2:
    		    $sortText = ' ORDER BY pl.display_name asc';
    		    break;
    		case 3:
    		    $sortText = ' ORDER BY pl.display_name desc';
    		    break;
    		case 4:
    			$sortText = ' ORDER BY pl.total_rating asc';
    			break;
    		default:
    			$sortText = ' ORDER BY pl.position asc';
    			break;
    	}
    	
    	
    	$brands = implode("', '", $brand);
    	
    	if(null != $color)
    	{
        	if($color['all'] != 'on')
        	{
        	    $color = array_keys($color);
        	    
        	    for($x=0; $x<count($color); $x++)
        	    {
        	        $colors .= $color[$x]."','";
        	    }
        	}
    	}
    	
    	if(null != $finish)
    	{
        	if($finish['all'] != 'on')
        	{
        	    $finish = array_keys($finish);
        	    for($x=0; $x<count($finish); $x++)
        	    {
        	        $finishs .= $finish[$x]."','";
        	    }
    	}
    	}
    	
    	if(null != $style)
    	{
        	if($style['all'] != 'on')
        	{
        	    $style = array_keys($style);
        	    for($x=0; $x<count($style); $x++)
        	    {
        	        $styles .= $style[$x]."','";
        	    }
        	}
    	}
    	
    	if(null != $price)
    	{
        	if($price['all'] != 'on')
        	{
        	    $price = array_keys($price);
        	    
        	    for($x=0; $x<count($price); $x++)
        	    {
        	        $allPrices = explode("-",$price[$x]);
        	        if($x==0) {
        	           $prices .= " and p.sale_price between '".$allPrices['0']."' and '".$allPrices['1']."' ";
        	        } else {
        	            $prices .= " or p.sale_price between '".$allPrices['0']."' and '".$allPrices['1']."' ";
        	        }
        	        //$prices .= $price[$x]."','";
        	    }
        	}
    	}
    	
    	
    /*
    	echo $brands;
    	
    	echo "select distinct pc.display_name as PC_Display, pc.name as PC_Name, pl.display_name as PL_Display, pl.name as PL_Name, pl.website_overview as html,  p.sale_price,
    			pl.product_line_id as product_line_id, b.name as brand, bpc.short_descr as short_descr, bpc.long_descr as long_descr, pl.position, pl.total_rating, pl.total_count, bpc.meta_title, bpc.meta_keywords, bpc.meta_descr,
    			a.hash as hash, a.file_name as fileName, a2.file_name as file_name, p.color, p.finish, p.style
										from brand_product_category as bpc, brands as b, parts as p, product_lines as pl
										left join product_line_asset as pla on pl.product_line_id = pla.product_line_id and pla.asset_seq = '1'
                                        left join asset as a on pla.asset_id = a.asset_id,
                                        product_categories as pc
                                        left join asset as a2 on pc.header_asset_id = a2.asset_id
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = pc.product_category_id
										and pl.brand_id = b.brand_id
										and bpc.disabled = '0' and bpc.deleted = '0'
										and p.disabled = '0' and p.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
    									and b.brand_id in ('".$brands."')
										and pc.display_name = '".htmlspecialchars($category)."'
										and p.product_line_id = pl.product_line_id
    									".((null != $colors) ? " and p.color in ('".substr($colors, 0, -3)."') " : "" )."
    									".((null != $finishs) ? " and p.finish in ('".substr($finishs, 0, -3)."') " : "" )."
    									".((null != $styles) ? " and p.style in ('".substr($styles, 0, -3)."') " : "" )."
    									".((null != $prices) ? $prices : "")."
    									".$sortText."
                                        ";
    	//exit;
    	*/
    	
    	$foundBrand = $this->prepare("select distinct pc.display_name as PC_Display, pc.name as PC_Name, pl.display_name as PL_Display, pl.name as PL_Name, pl.website_overview as html,  p.sale_price,
    			pl.product_line_id as product_line_id, b.name as brand, bpc.short_descr as short_descr, bpc.long_descr as long_descr, pl.position, pl.total_rating, pl.total_count, bpc.meta_title, bpc.meta_keywords, bpc.meta_descr,
    			a.hash as hash, a.file_name as fileName, a2.file_name as file_name, p.color, p.finish, p.style
										from brand_product_category as bpc, brands as b, parts as p, product_lines as pl
										left join product_line_asset as pla on pl.product_line_id = pla.product_line_id and pla.asset_seq = '1'
                                        left join asset as a on pla.asset_id = a.asset_id,
                                        product_categories as pc
                                        left join asset as a2 on pc.header_asset_id = a2.asset_id
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = pc.product_category_id
										and pl.brand_id = b.brand_id
										and bpc.disabled = '0' and bpc.deleted = '0'
										and p.disabled = '0' and p.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
    									and b.brand_id in ('".$brands."')
										and pc.display_name = '".htmlspecialchars($category)."'
										and p.product_line_id = pl.product_line_id
    									".((null != $colors) ? " and p.color in ('".substr($colors, 0, -3)."') " : "" )."
    									".((null != $finishs) ? " and p.finish in ('".substr($finishs, 0, -3)."') " : "" )."
    									".((null != $styles) ? " and p.style in ('".substr($styles, 0, -3)."') " : "" )."
    									".((null != $prices) ? $prices : "")."
    									".$sortText."
                                        ");
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
    	
    	//echo count($return);exit;
  
    	return $return;
    }
    
    /**
     * Return product line by brand product category
     *
     * @return string 
     */
    public function getBrandProductCategoryLike($category, $brand, $sort=null, $color=null, $bedLength=null, $finish=null, $style=null, $material=null, $soldAs=null, $tubeSize=null, $tubeShape=null, $liquidStorageCapacity=null, $boxStyle=null, $boxOpeningType=null)
    {
    	switch($sort)
    	{
    		case 1:
    			$sortText = 'ORDER BY pl.position asc';
    			break;
    		case 2:
    			$sortText = 'ORDER BY pl.rating asc';
    			break;
    		case 3:
    			$sortText = 'ORDER BY pl.display_name asc';
    			break;
    		case 4:
    			$sortText = 'ORDER BY pl.display_name desc';
    			break;
    		default:
    			$sortText = 'ORDER BY pl.position asc';
    			break;
    	}
    	
    	$brands = implode("', '", $brand);
    	
    	/*
    	echo "select distinct pc.display_name as PC_Display, pc.name as PC_Name, pl.display_name as PL_Display, pl.name as PL_Name, pl.website_overview as html, 
    			pl.product_line_id as product_line_id, b.name as brand, bpc.short_descr as short_descr, bpc.long_descr as long_descr, 
    			a.hash as hash, p.color, p.bed_length, p.finish, p.style, p.material, p.sold_as, p.tube_size, p.tube_shape, p.liquid_storage_capacity, p.box_style, p.box_opening_type
										from brand_product_category as bpc, product_categories as pc, product_lines as pl, brands as b, product_line_asset as pla, asset as a, parts as p
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = pc.product_category_id
										and pl.brand_id = b.brand_id
										and pl.product_line_id = pla.product_line_id
										and pla.asset_id = a.asset_id
										and pla.asset_seq = '1'
										and bpc.disabled = '0' and bpc.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
    									and b.brand_id in ('".$brands."')
										and pc.display_name like '%".$category."%'
										and p.product_line_id = pl.product_line_id
    									".(!empty($color)? " and p.color = '$color'" : "" )."
    									".(!empty($bedLength)? " and p.bed_length = '$bedLength'" : "" )."
    									".(!empty($finish)? " and p.finish = '$finish'" : "" )."
    									".(!empty($style)? " and p.style = '$style'" : "" )."
    									".(!empty($material)? " and p.material = '$material'" : "" )."
    									".(!empty($soldAs)? " and p.sold_as = '$soldAs'" : "" )."
    									".(!empty($tubeSize)? " and p.tube_size = '$tubeSize'" : "" )."
    									".(!empty($tubeShape)? " and p.tube_shape = '$tubeShape'" : "" )."
    									".(!empty($liquidStorageCapacity)? " and p.liquid_storage_capacity = '$liquidStorageCapacity'" : "" )."
    									".(!empty($boxStyle)? " and p.box_style = '$boxStyle'" : "" )."
    									".(!empty($boxOpeningType)? " and p.box_opening_type = '$boxOpeningType'" : "" )."
    									".$sortText."
    									";
    		*/
    	
    	$foundBrand = $this->prepare("select distinct pc.display_name as PC_Display, pc.name as PC_Name, pl.display_name as PL_Display, pl.name as PL_Name, pl.website_overview as html, pl.teaser as teaser, 
    			pl.product_line_id as product_line_id, b.name as brand, bpc.short_descr as short_descr, bpc.long_descr as long_descr, pl.position, 
    			a.hash as hash, p.color, p.bed_length, p.finish, p.style, p.material, p.sold_as, p.tube_size, p.tube_shape, p.liquid_storage_capacity, p.box_style, p.box_opening_type
										from brand_product_category as bpc, product_categories as pc, product_lines as pl, brands as b, product_line_asset as pla, asset as a, parts as p
										where pc.product_category_id = bpc.product_category_id
										and pl.product_category_id = pc.product_category_id
										and pl.brand_id = b.brand_id
										and pl.product_line_id = pla.product_line_id
										and pla.asset_id = a.asset_id
										and pla.asset_seq = '1'
										and bpc.disabled = '0' and bpc.deleted = '0'
										and pc.disabled = '0' and pc.deleted = '0'
										and pl.disabled = '0' and pl.deleted = '0'
    									and b.brand_id in ('".$brands."')
										and pl.meta_keywords like '%".$category."%'
										and p.product_line_id = pl.product_line_id
    									".(!empty($color)? " and p.color = '$color'" : "" )."
    									".(!empty($bedLength)? " and p.bed_length = '$bedLength'" : "" )."
    									".(!empty($finish)? " and p.finish = '$finish'" : "" )."
    									".(!empty($style)? " and p.style = '$style'" : "" )."
    									".(!empty($material)? " and p.material = '$material'" : "" )."
    									".(!empty($soldAs)? " and p.sold_as = '$soldAs'" : "" )."
    									".(!empty($tubeSize)? " and p.tube_size = '$tubeSize'" : "" )."
    									".(!empty($tubeShape)? " and p.tube_shape = '$tubeShape'" : "" )."
    									".(!empty($liquidStorageCapacity)? " and p.liquid_storage_capacity = '$liquidStorageCapacity'" : "" )."
    									".(!empty($boxStyle)? " and p.box_style = '$boxStyle'" : "" )."
    									".(!empty($boxOpeningType)? " and p.box_opening_type = '$boxOpeningType'" : "" )."
    									".$sortText."
    									");
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
  
    	return $return;
    }
    
    /**
     * Return product line features by vehicle type
     *
     * @return string 
     */
    public function getFeatureByVehicleType($brand, $vehArray, $make)
    {
    	$vehArrays = implode("', '", $vehArray);
    	$brands = implode("', '", $brand);
    	$foundBrand = $this->prepare("select distinct plf.*
										from product_categories as pc, 
										     product_lines as pl, 
										     product_line_feature as plf,
										     brands as b
										where pl.brand_id = b.brand_id 
										and pl.product_category_id = pc.product_category_id 
										and pc.disabled = '0' 
										and pc.deleted = '0' 
										and pl.disabled = '0' 
										and pl.deleted = '0' 
										and plf.feature_seq in ('1', '2')
										and b.brand_id in ('".$brands."')
										ORDER BY plf.product_line_id asc, plf.feature_seq asc
    									");
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
  
    	return $return;
    }
    
    /**
     * Return product line features by brand product category
     *
     * @return string 
     */
    public function getBrandProductLineFeature($category, $brand, $productLines=null)
    {
    	
    	$brands = implode("', '", $brand);
    	$foundBrand = $this->prepare("select distinct plf.*
										from product_categories as pc, 
										     product_lines as pl, 
										     product_line_feature as plf,
										     brands as b
										where pl.brand_id = b.brand_id 
										and pl.product_category_id = pc.product_category_id 
										and pc.disabled = '0' 
										and pc.deleted = '0' 
										and pl.disabled = '0' 
										and pl.deleted = '0' 
										and plf.feature_seq in ('1', '2')
										and b.brand_id in ('".$brands."')
										and pc.display_name = '".$category."'
    		    						".(($productLines == '')? '' : "and veh_submodel.name = '$productLines'" )."
										ORDER BY plf.product_line_id asc, plf.feature_seq asc
    									");
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
  
    	return $return;
    }


    /**
     * Return product line features by brand product category
     *
     * @return string
     */
    public function getBrandProductLineFeatureLike($category, $brand, $productLines=null)
    {
    	 
    	$brands = implode("', '", $brand);
    	$foundBrand = $this->prepare("select distinct plf.*
										from product_categories as pc,
										     product_lines as pl,
										     product_line_feature as plf,
										     brands as b
										where pl.brand_id = b.brand_id
										and pl.product_category_id = pc.product_category_id
										and pc.disabled = '0'
										and pc.deleted = '0'
										and pl.disabled = '0'
										and pl.deleted = '0'
										and plf.feature_seq in ('1', '2')
										and b.brand_id in ('".$brands."')
										and pc.display_name like '%".$category."%'
    		    						".(($productLines == '')? '' : "and veh_submodel.name = '$productLines'" )."
										ORDER BY plf.product_line_id asc, plf.feature_seq asc
    									");
    	$foundBrand->execute();
    	 
    	$return = $foundBrand->fetchAll();
    
    	return $return;
    }
    
    /**
     * Return product lines by name
     *
     * @param \LundProducts\Entity\BrandsInterface
     * @return ProductLinesInterface|null
     */
    public function getPriceRange($name)
    {
        
        $foundBrand = $this->prepare("select MIN(sale_price) as min, MAX(sale_price) as max from parts as p, product_lines as pl									
										where pl.product_line_id = p.product_line_id
                                        and p.disabled = 0
                                        and p.deleted = 0
                                        and pl.disabled = 0 
                                        and pl.deleted = 0 
                                        and pl.display_name in ('".$name."')");
        $foundBrand->execute();
        
        $return = $foundBrand->fetchAll();
        
        return $return;
    }
    
    /**
     * Return product line features by brand product category
     *
     * @return string
     */
    public function getAllBrandProductLineFeature($productLines=null)
    {
    	 
    	$foundBrand = $this->prepare("select distinct plf.*
										from product_line_feature as plf
										where plf.product_line_id = '".$productLines."'
										ORDER BY plf.feature_seq asc
    									");
    	$foundBrand->execute();
    	 
    	$return = $foundBrand->fetchAll();
    
    	return $return;
    }

    /**
     * @return mixed
     */
    public function getActiveProductLines()
    {
        return $this->repository->findBy(
            array('deleted'  => false),
            array('name' => 'ASC')
        );
    }

    /**
     * @return mixed
     */
    public function getFrontActiveProductLines()
    {
        return $this->repository->findBy(
            array(
                'deleted' => false,
                'disabled' => false,
            ),
            array(
                'name' => 'ASC',
            )
        );
    }

    /**
     * Return product lines by brand
     *
     * @param \LundProducts\Entity\BrandsInterface
     * @return ProductLinesInterface|null
     */
    public function getProductLinesByBrand(\LundProducts\Entity\BrandsInterface $brand)
    {
        return $this->repository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'brand'    => $brand->getBrandId(),
            ),
            array(
                'brandPosition' => 'ASC',
            )
        );
    }

    /**
     * Return product lines by name
     *
     * @param \LundProducts\Entity\BrandsInterface
     * @return ProductLinesInterface|null
     */
    public function getProductLinesByName($name)
    {
        return $this->repository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'displayName'    => $name,
            ),
            array(
                'brandPosition' => 'ASC',
            )
        );
    }
    
    /**
     * Return product lines by brand
     *
     * @param \LundProducts\Entity\BrandsInterface
     * @return ProductLinesInterface|null
     */
    public function getAllProductLinesByBrand(\LundProducts\Entity\BrandsInterface $brand)
    {
    	return $this->repository->findBy(
    			array(
    					'deleted'  => false,
    					'brand'    => $brand->getBrandId(),
    			),
    			array(
    					'productLineId' => 'ASC',
    			)
    	);
    }

    /**
     * Return product lines by product category
     *
     * @param \LundProducts\Entity\ProductCategoriesInterface
     * @param \LundProducts\Entity\BrandsInterface
     * @return ProductLinesInterface|null
     */
    public function getProductLinesByCategory(\LundProducts\Entity\ProductCategoriesInterface $category, \LundProducts\Entity\BrandsInterface $brand)
    {
        return $this->repository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'productCategory' => $category->getProductCategoryId(),
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return product line by name
     *
     * @param  string                     $name
     * @return ProductLinesInterface|null
     */
    public function getProductLineByName($name = null)
    {
        return $this->repository->findOneBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'name'     => $name,
            )
        );
    }

    /**
     * Return product line by name
     *
     * @param  string                     $name
     * @return ProductLinesInterface|null
     */
    public function getProductLineByQuery($name = null)
    {
        return $this->repository->findByQuery(
            array(
                'deleted'  => false,
                'disabled' => false,
                'name'     => $name,
            )
        );
    }

    /**
     * Return view ProductLineForm
     *
     * @param  string          $productLineId
     * @return ProductLineForm
     */
    public function getViewProductLineForm($productLineId)
    {
        $productLine = $this->repository->find($productLineId);

        $this->productLineForm->bind($productLine);

        return $this->productLineForm;
    }

    /**
     * Return create ProductLineForm
     *
     * @return ProductLineForm
     */
    public function getCreateProductLineForm()
    {
        $this->productLineForm->bind(clone $this->getProductLinesPrototype());

        return $this->productLineForm;
    }

    /**
     * Return edit ProductLineForm
     *
     * @param  string          $productLineId
     * @return ProductLineForm
     */
    public function getEditProductLineForm($productLineId)
    {
        $productLine = $this->repository->find($productLineId);

        $this->productLineForm->bind($productLine);

        return $this->productLineForm;
    }

    /**
     * @return ProductLinesInterface
     */
    public function getProductLinesPrototype()
    {
        if ($this->productLinesPrototype === null) {
            $this->setProductLinesPrototype(new ProductLines());
        }

        return $this->productLinesPrototype;
    }

    /**
     * @param  ProductLinesInterface $productLinesPrototype
     * @return ProductLineService
     */
    public function setProductLinesPrototype(ProductLinesInterface $productLinesPrototype)
    {
        $this->productLinesPrototype = $productLinesPrototype;

        return $this;
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getProductLine($recordId)
    {
        return $this->repository->find($recordId);
    }

    /**
     * @param \Admin\Entity\ProductLines $recordEntity
     * @param \Admin\Entity\User         $usersEntity
     *
     * @return \Admin\Entity\ProductLines $recordEntity
     */
    public function createProductLine(ProductLines $recordEntity, User $usersEntity)
    {
        $recordEntity->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($usersEntity->getUsername())
            ->setDeleted(false)
            ->setDisabled(false);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\ProductLines $recordEntity
     * @param array                             $features
     *
     * @return \LundProducts\Entity\ProductLines
     */
    public function editProductLineCopy(ProductLines $recordEntity, $features = null)
    {
        if (is_array($features)) {
            $iterator = 1;
            foreach ($features as $feature) {
                if (strlen($feature)>1) {
                    $this->productLineFeatureService->create($recordEntity, $iterator, $feature);
                    $iterator++;
                }
            }
        }

        $recordEntity->setModifiedAt(new DateTime('now'));
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \Admin\Entity\ProductLines $recordEntity
     * @param \Admin\Entity\User         $usersEntity
     *
     * @return \Admin\Entity\ProductLines $recordEntity
     */
    public function editProductLine(ProductLines $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername());
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \Admin\Entity\ProductLines $recordEntity
     * @param \Admin\Entity\User         $usersEntity
     *
     * @return \Admin\Entity\ProductLines $recordEntity
     */
    public function deleteProductLine(ProductLines $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername())
            ->setDeleted(true)
            ->setDisabled(true);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @return void
     */
    public function flushCache()
    {
        $cacheDriver = $this->objectManager->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('productlines_find_active');
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
