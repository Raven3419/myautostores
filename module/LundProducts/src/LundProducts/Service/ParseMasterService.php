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
use PDO;
use RocketDam\Service\AssetService;

class ParseMasterService implements EventManagerAwareInterface
{
    /**
     * @var AssetService $assetService
     */
    protected $assetService;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /*
     * @var PDO
     */
    protected $connection = null;

    /*
     * @var Logger
     */
    protected $logger = null;

    /*
     * @var array
     */
    protected $cache = array(
        'brands_cache'             => array(),
        'product_categories_cache' => array(),
        'product_lines_cache'      => array(),
        'parts_cache'              => array(),
        'veh_year_cache'           => array(),
        'veh_make_cache'           => array(),
        'veh_model_cache'          => array(),
        'veh_class_cache'          => array(),
        'veh_submodel_cache'       => array(),
    );

    /*
     * @param AssetService $assetService
     * @param PDO          $connection
     * @param Logger       $logger
     */
    public function __construct(
        AssetService $assetService,
        PDO    $connection,
        Logger $logger
    )
    {
        $this->assetService = $assetService;
        $this->connection = $connection;
        $this->logger     = $logger;
    }

    /*
     * Find brand by name.
     *
     * @param  string $brand
     * @return array
     */
    public function findBrand($brand = null)
    {
        if ($this->existsInCache($brand, 'brands_cache')) {
            return $this->getFromCache($brand, 'brands_cache');
        }

        $foundBrand = $this->prepare('SELECT * FROM brands WHERE name = ' . $this->quote($brand) . ' LIMIT 1');
        $foundBrand->execute();

        $return = $foundBrand->fetch(PDO::FETCH_ASSOC);
        $this->addToCache($brand, 'brands_cache', $return);

        return $return;
    }

    /*
     * Insert brand.
     *
     * @param string $created_at
     * @param int    $deleted
     * @param int    $disabled
     * @param string $short_code
     * @param string $label
     * @param string $name
     * @param int    $parent_brand_id
     *
     * @return array
     */
    public function insertBrand($created_at = null, $deleted = 0, $disabled = 0, $short_code = null, $label = null, $name = null, $parent_brand_id = null)
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

        $name = str_replace('/\//', '-', $name);

        $return = array(
            'brand_id'        => null,
            'created_at'      => $created_at,
            'deleted'         => $deleted,
            'disabled'        => $disabled,
            'short_code'      => $short_code,
            'label'           => $label,
            'name'            => $name,
            'parent_brand_id' => $parent_brand_id
        );

        $brand = $this->prepare('INSERT INTO brands (created_at, deleted, disabled, short_code, label, name, parent_brand_id)
                                 VALUES (:created_at, :deleted, :disabled, :short_code, :label, :name, :parent_brand_id)');

        $brand->bindParam(':created_at', $return['created_at']);
        $brand->bindParam(':deleted', $return['deleted']);
        $brand->bindParam(':disabled', $return['disabled']);
        $brand->bindParam(':short_code', $return['short_code']);
        $brand->bindParam(':label', $return['label']);
        $brand->bindParam(':name', $return['name']);
        $brand->bindParam(':parent_brand_id', $return['parent_brand_id']);
        $brand->execute();

        $return['brand_id'] = $this->lastInsertId();

        return $return;
    }

    /*
     * Find product category by short code.
     *
     * @param string $product_category
     *
     * @return array
     */
    public function findProductCategory($product_category = null)
    {
        if ($this->existsInCache($product_category, 'product_categories_cache')) {
            return $this->getFromCache($product_category, 'product_categories_cache');
        }

        $foundProductCategory = $this->prepare('SELECT * FROM product_categories
                                                WHERE short_code = ' . $this->quote($product_category) . ' LIMIT 1');

        $foundProductCategory->execute();

        $return = $foundProductCategory->fetch(PDO::FETCH_ASSOC);

        $this->addToCache($product_category, 'product_categories_cache', $return);

        return $return;
    }

    /*
     * Insert product category.
     *
     * @param string $created_at
     * @param int    $deleted
     * @param int    $disabled
     * @param string $short_code
     * @param string $name
     *
     * @return array
     */
    public function insertProductCategory($created_at = null, $deleted = null, $disabled = null, $bpcs_code = null, $short_code = null, $name = null)
    {
        if (null == $created_at) {
            $created_at = date('Y-m-d H:i:s');
        }

        if (null == $deleted) {
            $deleted = 0;
        }

        if ($disabled == null) {
            $disabled = 0;
        }

        $pretty_name = preg_replace('/\//', '-', $name);

        $return = array('product_category_id' => null,
                        'created_at'          => $created_at,
                        'deleted'             => $deleted,
                        'disabled'            => $disabled,
                        'short_code'          => $short_code,
                        'bpcs_code'           => $bpcs_code,
                        'name'                => $pretty_name,
                        'display_name'        => $name);

        $pcInsert = $this->prepare('INSERT INTO product_categories (created_at, deleted, disabled, bpcs_code, short_code, name, display_name)
                                    VALUES (:created_at, :deleted, :disabled, :bpcs_code, :short_code, :name, :display_name)');
        $pcInsert->bindParam(':created_at', $return['created_at']);
        $pcInsert->bindParam(':deleted', $return['deleted']);
        $pcInsert->bindParam(':disabled', $return['disabled']);
        $pcInsert->bindParam(':short_code', $return['short_code']);
        $pcInsert->bindParam(':bpcs_code', $return['bpcs_code']);
        $pcInsert->bindParam(':name', $return['name']);
        $pcInsert->bindParam(':display_name', $return['display_name']);
        $pcInsert->execute();

        $return['product_category_id'] = $this->lastInsertId();

        return $return;
    }

    /*
     * Find brand_product_category relationship.
     *
     * @param int $product_category_id
     * @param int $brand_id
     *
     * @return array
     */
    public function findBrandProductCategory($product_category_id = null, $brand_id = null)
    {
        $pcBrandFound = $this->prepare('SELECT * FROM brand_product_category
                                        WHERE product_category_id = ' . $product_category_id . '
                                        AND brand_id = ' . $brand_id . ' LIMIT 1');
        $pcBrandFound->execute();

        return $pcBrandFound->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update part type
     *
     * @param int $part_id
     * @param int $part_type_id
     *
     * @return array
     */
    public function updatePartType($part_id = null, $part_type_id = null)
    {
	if ($part_type_id > 0) {
            $part = $this->prepare('UPDATE parts SET part_type_id = ' . $part_type_id . ' WHERE part_id = ' . $part_id . '');
            return $part->execute();
	} else {
	    return false;
        }
    }
    
    /*
     * Insert brand_product_category relationship.
     *
     * @param int $product_category_id
     * @param int $brand_id
     *
     * @return array
     */
    public function searchAAIA($base_vehicle_id = null)
    {
        $sql = 'SELECT BV.yearID, M.MakeName, MO.ModelName, VT.VehicleTypeName FROM aaia.BaseVehicle as BV, aaia.Make as M, aaia.Model as MO, aaia.VehicleType as VT
                WHERE BV.MakeID=M.MakeID and BV.ModelID=MO.ModelID and MO.VehicleTypeId=VT.VehicleTypeID and BV.BaseVehicleId = "'.$base_vehicle_id.'" LIMIT 1';
        
        $baseID = $this->prepare($sql);
        
        $baseID->execute();
        
        $tempArray = array();
        
        return $baseID->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * Insert brand_product_category relationship.
     *
     * @param int $product_category_id
     * @param int $brand_id
     *
     * @return array
     */
    public function insertBrandProductCategory($product_category_id = null, $brand_id = null)
    {

//echo 'INSERT INTO brand_product_category (product_category_id, brand_id, deleted, disabled) VALUES (' . $product_category_id . ', ' . $brand_id . ', 0, 0)';exit;
        $pcBrandFound = $this->prepare('INSERT INTO brand_product_category (product_category_id, brand_id, deleted, disabled)
                                        VALUES (' . $product_category_id . ', ' . $brand_id . ', 0, 1)');

        return $pcBrandFound->execute();
    }

    /*
     * Find product line.
     *
     * @param string $short_code
     * @param int    $brand_id
     *
     * @return array
     */
    public function findProductLine($short_code = null, $brand_id = null)
    {
        if ($this->existsInCache($short_code, 'product_lines_cache')) {
            return $this->getFromCache($short_code, 'product_lines_cache');
        }

        $foundProductLine = $this->prepare('SELECT * FROM product_lines
                                            WHERE short_code = ' . $this->quote($short_code) . '
                                            AND brand_id = ' . $brand_id . ' LIMIT 1');

        $foundProductLine->execute();
        $return = $foundProductLine->fetch(PDO::FETCH_ASSOC);

        $this->addToCache($short_code, 'product_lines_cache', $return);

        return $return;
    }

    /*
     * Insert product line.
     *
     * @param string $created_at
     * @param int    $deleted
     * @param int    $disabled
     * @param string $short_code
     * @param string $name
     * @param int    $product_category_id
     * @param int    $brand_id
     * @param int    $orig_brand_id
     *
     * @return array
     */
    public function insertProductLine($created_at = null, $deleted = null, $disabled = null,
                                      $bpcs_code = null, $short_code = null, $name = null, $product_category_id = null,
                                      $brand_id = null, $orig_brand_id = null, $description = null)
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

        $pretty_name = preg_replace('/\//', '-', $name);

        $return = array(
            'product_line_id'     => null,
            'created_at'          => $created_at,
            'deleted'             => $deleted,
            'disabled'            => $disabled,
            'short_code'          => $short_code,
            'bpcs_code'           => $bpcs_code,
            'name'                => $pretty_name,
            'display_name'        => $name,
            'product_category_id' => $product_category_id,
            'brand_id'            => $brand_id,
            'orig_brand_id'       => $orig_brand_id,
            'overview'            => $description,
            'website_overview'    => $description
        );

        $productLine = $this->prepare('INSERT INTO product_lines (created_at, deleted, disabled, bpcs_code, short_code, name, display_name, product_category_id, brand_id, orig_brand_id, overview, website_overview)
                                       VALUES (:created_at, :deleted, :disabled, :bpcs_code, :short_code, :name, :display_name, :product_category_id, :brand_id, :orig_brand_id, :overview, :website_overview)');

        $productLine->bindParam(':created_at', $return['created_at']);
        $productLine->bindParam(':deleted', $return['deleted']);
        $productLine->bindParam(':disabled', $return['disabled']);
        $productLine->bindParam(':short_code', $return['short_code']);
        $productLine->bindParam(':bpcs_code', $return['bpcs_code']);
        $productLine->bindParam(':name', $return['name']);
        $productLine->bindParam(':display_name', $return['display_name']);
        $productLine->bindParam(':product_category_id', $return['product_category_id']);
        $productLine->bindParam(':brand_id', $return['brand_id']);
        $productLine->bindParam(':orig_brand_id', $return['orig_brand_id']);
        $productLine->bindParam(':overview', $return['overview']);
        $productLine->bindParam(':website_overview', $return['website_overview']);
        $productLine->execute();

        $return['product_line_id'] = $this->lastInsertId();

        return $return;
    }

    /*
     * Find part.
     *
     * @param string $part_number
     * @param int    $product_line_id
     *
     * @return array
     */
    public function findPart($part_number = null)
    {
        if ($this->existsInCache($part_number, 'parts_cache')) {
            return $this->getFromCache($part_number, 'parts_cache');
        }

        $foundPart = $this->prepare('SELECT * FROM parts
                                     WHERE part_number = ' . $this->quote($part_number) . ' LIMIT 1');
        $foundPart->execute();
        $return = $foundPart->fetch(PDO::FETCH_ASSOC);

        $this->addToCache($part_number, 'parts_cache', $return);

        return $return;
    }

    /*
     * Insert part.
     *
     * @param string $created_at
     * @param int    $deleted
     * @param int    $disabled
     * @param string $part_number
     * @param string $jobber_price
     * @param string $msrp_price
     * @param string $sale_price
     * @param string $color
     * @param string $isheet
     * @param string $pop_code
     * @param string $upc_code
     * @param string $weight
     * @param string $height
     * @param string $width
     * @param string $length
     * @param int    $product_line_id
     * @param string $country_of_origin
     * @param int    $dima
     * @param int    $dimb
     * @param int    $dimc
     * @param int    $dimd
     * @param int    $dime
     * @param int    $dimf
     * @param int    $dimg
     * @param bool   $universal
     * @param int    $lookup_bedtype_id
     * @param string $bed_length
     * @param int	 $bed_length_id
     * @param string $flare_height
     * @param string $flare_tire_coverage
     * @param string $vehicle_type
     * @param string $no_drill
     * @param string $finish
     * @param string $style
     * @param string $material
     * @param string $material_thickness
     * @param string $sold_as
     * @param string $tube_shape
     * @param string $tube_size
     * @param string $warranty
     * @param string $tube_size
     * @param string $liquid_storage_capacity
     * @param string $box_style
     * @param string $box_opening_type
     *
     * @return array
     */
    public function insertPart($created_at = null, $deleted = null, $disabled = null, $part_number = null, $jobber_price = null,
                               $msrp_price = null, $sale_price = null, $color = null, $isheet = null,  $pop_code = null, $upc_code = null, $weight = null,
                               $height = null, $width = null, $length = null, $product_line_id = null, $country_of_origin = null, $status_code = null, $dima = null, $dimb = null, $dimc = null,
                               $dimd = null, $dime = null, $dimf = null, $dimg = null, $universal = false, $lookup_parttype_id = null, $lookup_number = null,
    						   $bed_length = null, $bed_length_id = null, $flare_height = null, $flare_tire_coverage = null, $vehicle_type = null, $no_drill = null, $finish = null, $style = null,
					    	   $material = null, $material_thickness = null, $sold_as = null, $tube_shape = null, $tube_size = null, $warranty = null, $liquid_storage_capacity = null, 
                               $box_style = null, $box_opening_type = null, $cut_required = null, $rear_flare_height = null, $rear_flare_tire_coverage = null, $stake_holes = null, $color_group = null,
                               $map_price = null, $saleable = null)
    {
        
        //echo " - ".$rear_flare_height." - ".$rear_flare_tire_coverage;exit;
        if (null == $created_at) {
            $created_at = date('Y-m-d H:i:s');
        }

        if (null == $deleted) {
            $deleted = 0;
        }

        if (null == $disabled) {
            $disabled = 0;
        }

        $return = array('part_id'           		=> null,
                        'created_at'        		=> $created_at,
                        'deleted'           		=> $deleted,
                        'disabled'          		=> $disabled,
                        'part_number'       		=> $part_number,
                        'jobber_price'      		=> $jobber_price,
                        'msrp_price'        		=> $msrp_price,
                        'sale_price'        		=> $sale_price,
                        'color'             		=> $color,
                        'isheet'            		=> $isheet,
                        'pop_code'          		=> $pop_code,
                        'upc_code'          		=> $upc_code,
                        'status'            		=> $status_code,
                        'weight'            		=> $weight,
                        'height'            		=> $height,
                        'width'             		=> $width,
                        'length'            		=> $length,
                        'product_line_id'   		=> $product_line_id,
                        'dima'              		=> $dima,
                        'dimb'              		=> $dimb,
                        'dimc'              		=> $dimc,
                        'dimd'              		=> $dimd,
                        'dime'              		=> $dime,
                        'dimf'              		=> $dimf,
                        'dimg'              		=> $dimg,
                        'universal'         		=> (($universal == true) ? 1 : 0),
                        'country_of_origin' 		=> $country_of_origin,
                        'part_type_id'      		=> ((trim($lookup_parttype_id) == '') ? null : $lookup_parttype_id),
                        'lookup_number'     		=> $lookup_number,    			
        			    'bed_length'        		=> $bed_length,
    					'bed_length_id'     		=> $bed_length_id,
        				'flare_height'				=> $flare_height,
        				'flare_tire_coverage'		=> $flare_tire_coverage,
        				'vehicle_type'				=> $vehicle_type,
        				'no_drill'					=> $no_drill,
		    			'finish'					=> $finish,
		    			'style'						=> $style,
		    			'material'					=> $material,
		    			'material_thickness'		=> $material_thickness,
		    			'sold_as'					=> $sold_as,
		    			'tube_shape'				=> $tube_shape,
		    			'tube_size'					=> $tube_size,
		    			'warranty'					=> $warranty,
		    			'liquid_storage_capacity' 	=> $liquid_storage_capacity,
		    			'box_style'					=> $box_style,
                        'box_opening_type'			=> $box_opening_type,
                        'cut_required'			    => $cut_required,
                        'rear_flare_height'			=> $rear_flare_height,
                        'rear_flare_tire_coverage'	=> $rear_flare_tire_coverage,
                        'stake_holes'			    => $stake_holes,
                        'color_group'			    => $color_group,
                        'map_price'			        => $map_price,
                        'saleable'			        => $saleable
        );

        //echo $part_number. " - ".$cut_required. " - ".$rear_flare_height. " - ".$rear_flare_tire_coverage. " - ".$stake_holes. " - ".$color_group;exit;
        $part = $this->prepare('INSERT INTO parts (created_at, deleted, disabled, part_number, jobber_price, msrp_price, sale_price, color, isheet, pop_code,
                                                   upc_code, status, weight, height, width, length, dima, dimb, dimc, dimd, dime, dimf, dimg, universal, product_line_id, country_of_origin,
                                                   part_type_id, lookup_number, bed_length, bed_length_id, flare_height, flare_tire_coverage, vehicle_type, no_drill, finish, style, material,
        							    		   material_thickness, sold_as, tube_shape, tube_size, warranty, liquid_storage_capacity, box_style, box_opening_type, cut_required,
                                                   rear_flare_height, rear_flare_tire_coverage, stake_holes, color_group, map_price, saleable)
                                VALUES (:created_at, :deleted, :disabled, :part_number, :jobber_price, :msrp_price, :sale_price, :color, :isheet, :pop_code,
                                        :upc_code, :status, :weight, :height, :width, :length, :dima, :dimb, :dimc, :dimd, :dime, :dimf, :dimg, :universal, :product_line_id, :country_of_origin,
                                        :part_type_id, :lookup_number, :bed_length, :bed_length_id, :flare_height, :flare_tire_coverage, :vehicle_type, :no_drill, :finish, :style, :material,
        							    :material_thickness, :sold_as, :tube_shape, :tube_size, :warranty, :liquid_storage_capacity, :box_style, :box_opening_type, :cut_required,
                                        :rear_flare_height, :rear_flare_tire_coverage, :stake_holes, :color_group, :map_price, :saleable)');

        /*
        echo "INSERT INTO parts (created_at, deleted, disabled, part_number, jobber_price, msrp_price, sale_price, color, isheet, pop_code,
                                                   upc_code, status, weight, height, width, length, dima, dimb, dimc, dimd, dime, dimf, dimg, universal, product_line_id, country_of_origin,
                                                   part_type_id, lookup_number, bed_length, bed_length_id, flare_height, flare_tire_coverage, vehicle_type, no_drill, finish, style, material,
        							    		   material_thickness, sold_as, tube_shape, tube_size, warranty, liquid_storage_capacity, box_style, box_opening_type, cut_required
                                                   rear_flare_height, rear_flare_tire_coverage, stake_holes, color_group)
                                VALUES ('".$return['created_at']."', '".$return['deleted']."', '".$return['disabled']."', '".$return['part_number']."', '".$return['jobber_price']."', '".$return['msrp_price']."', 
                                        '".$return['sale_price']."', '".$return['color']."', '".$return['isheet']."', '".$return['pop_code']."', '".$return['upc_code']."', '".$return['status']."',
                                        '".$return['weight']."', '".$return['height']."', '".$return['width']."', '".$return['length']."', '".$return['upc_code']."', '".$return['dimb']."',
                                        '".$return['dimc']."', '".$return['dimd']."', '".$return['dime']."', '".$return['dimf']."', '".$return['dimg']."', '".$return['universal']."',
                                        '".$return['product_line_id']."', '".$return['country_of_origin']."', '".$return['part_type_id']."', '".$return['lookup_number']."', '".$return['bed_length']."', '".$return['bed_length_id']."',
                                        '".$return['flare_height']."', '".$return['flare_tire_coverage']."', '".$return['vehicle_type']."', '".$return['no_drill']."', '".$return['finish']."', '".$return['style']."',
                                        '".$return['material']."', '".$return['material_thickness']."', '".$return['sold_as']."', '".$return['tube_shape']."', '".$return['tube_size']."', '".$return['warranty']."',
                                        '".$return['liquid_storage_capacity']."', '".$return['box_style']."', '".$return['box_opening_type']."', '".$return['cut_required']."', '".$return['rear_flare_height']."', '".$return['rear_flare_tire_coverage']."',
                                        '".$return['stake_holes']."', '".$return['color_group']."')";exit;
        
        */
        
        $part->bindParam(':created_at', $return['created_at']);
        $part->bindParam(':deleted', $return['deleted']);
        $part->bindParam(':disabled', $return['disabled']);
        $part->bindParam(':part_number', $return['part_number']);
        $part->bindParam(':jobber_price', $return['jobber_price']);
        $part->bindParam(':msrp_price', $return['msrp_price']);
        $part->bindParam(':sale_price', $return['sale_price']);
        $part->bindParam(':color', $return['color']);
        $part->bindParam(':isheet', $return['isheet']);
        $part->bindParam(':pop_code', $return['pop_code']);
        $part->bindParam(':upc_code', $return['upc_code']);
        $part->bindParam(':status', $return['status']);
        $part->bindParam(':weight', $return['weight']);
        $part->bindParam(':height', $return['height']);
        $part->bindParam(':width', $return['width']);
        $part->bindParam(':length', $return['length']);
        $part->bindParam(':product_line_id', $return['product_line_id']);
        $part->bindParam(':country_of_origin', $return['country_of_origin']);
        $part->bindParam(':dima', $return['dima']);
        $part->bindParam(':dimb', $return['dimb']);
        $part->bindParam(':dimc', $return['dimc']);
        $part->bindParam(':dimd', $return['dimd']);
        $part->bindParam(':dime', $return['dime']);
        $part->bindParam(':dimf', $return['dimf']);
        $part->bindParam(':dimg', $return['dimg']);
        $part->bindParam(':universal', $return['universal']);
        $part->bindParam(':part_type_id', $return['part_type_id']);
        $part->bindParam(':lookup_number', $return['lookup_number']);
    	$part->bindParam(':bed_length', $return['bed_length']);
    	$part->bindParam(':bed_length_id', $return['bed_length_id']);
        $part->bindParam(':flare_height', $return['flare_height']);
        $part->bindParam(':flare_tire_coverage', $return['flare_tire_coverage']);
        $part->bindParam(':vehicle_type', $return['vehicle_type']);
        $part->bindParam(':no_drill', $return['no_drill']);
        $part->bindParam(':finish', $return['finish']);
        $part->bindParam(':style', $return['style']);
        $part->bindParam(':material', $return['material']);
        $part->bindParam(':material_thickness', $return['material_thickness']);
        $part->bindParam(':sold_as', $return['sold_as']);
        $part->bindParam(':tube_shape', $return['tube_shape']);
        $part->bindParam(':tube_size', $return['tube_size']);
        $part->bindParam(':warranty', $return['warranty']);
        $part->bindParam(':liquid_storage_capacity', $return['liquid_storage_capacity']);
        $part->bindParam(':box_style', $return['box_style']);
        $part->bindParam(':box_opening_type', $return['box_opening_type']);
        $part->bindParam(':cut_required', $return['cut_required']);
        $part->bindParam(':rear_flare_height', $return['rear_flare_height']);
        $part->bindParam(':rear_flare_tire_coverage', $return['rear_flare_tire_coverage']);
        $part->bindParam(':stake_holes', $return['stake_holes']);
        $part->bindParam(':color_group', $return['color_group']);
        $part->bindParam(':map_price', $return['map_price']);
        $part->bindParam(':saleable', $return['saleable']);

        $part->execute();
        
        $return['part_id'] = $this->lastInsertId();

        return $return;
    }
    
    /*
     * Update part.
     *
     * @param int 	 $part_id
     * @param string $modified_at
     * @param int    $deleted
     * @param int    $disabled
     * @param string $part_number
     * @param string $jobber_price
     * @param string $msrp_price
     * @param string $sale_price
     * @param string $color
     * @param string $isheet
     * @param string $pop_code
     * @param string $upc_code
     * @param string $weight
     * @param string $height
     * @param string $width
     * @param string $length
     * @param int    $product_line_id
     * @param string $country_of_origin
     * @param int    $dima
     * @param int    $dimb
     * @param int    $dimc
     * @param int    $dimd
     * @param int    $dime
     * @param int    $dimf
     * @param int    $dimg
     * @param bool   $universal
     * @param int    $lookup_bedtype_id
     * @param string $bed_length
     * @param int	 $bed_length_id
     * @param string $flare_height
     * @param string $flare_tire_coverage
     * @param string $vehicle_type
     * @param string $no_drill
     * @param string $finish
     * @param string $style
     * @param string $material
     * @param string $material_thickness
     * @param string $sold_as
     * @param string $tube_shape
     * @param string $tube_size
     * @param string $warranty
     * @param string $tube_size
     * @param string $liquid_storage_capacity
     * @param string $box_style
     * @param string $box_opening_type
     *
     * @return array
     */
      
    public function updatePart($part_id = null, $modified_at = null, $deleted = null, $disabled = null, $part_number = null, $jobber_price = null,
    		$msrp_price = null, $color = null, $isheet = null,  $pop_code = null, $upc_code = null, $weight = null,
    		$height = null, $width = null, $length = null, $product_line_id = null, $country_of_origin = null, $status_code = null, $dima = null, $dimb = null, $dimc = null,
    		$dimd = null, $dime = null, $dimf = null, $dimg = null, $universal = false, $lookup_parttype_id = null, $lookup_number = null,
    		$bed_length = null, $bed_length_id = null, $flare_height = null, $flare_tire_coverage = null, $vehicle_type = null, $no_drill = null, $finish = null, $style = null,
    		$material = null, $material_thickness = null, $sold_as = null, $tube_shape = null, $tube_size = null, $warranty = null, $liquid_storage_capacity = null, 
            $box_style = null, $box_opening_type = null, $cut_required = null, $rear_flare_height = null, $rear_flare_tire_coverage = null, $stake_holes = null, $color_group = null,
            $map_price = null, $saleable = null)
    		
            
    {
    	
    	if (null == $modified_at) {
    		$modified_at = date('Y-m-d H:i:s');
    	}
    
    	if (null == $deleted) {
    		$deleted = 0;
    	}
    
    	if (null == $disabled) {
    		$disabled = 0;
    	}
    
    	$return = array('part_id'   		=> $part_id,
    			'modified_at'       		=> $modified_at,
    			'deleted'           		=> $deleted,
    			'disabled'          		=> $disabled,
    			'part_number'       		=> $part_number,
    			'jobber_price'      		=> $jobber_price,
    			'msrp_price'        		=> $msrp_price,
    			'color'             		=> $color,
    			'isheet'            		=> $isheet,
    			'pop_code'          		=> $pop_code,
    			'upc_code'          		=> $upc_code,
    			'status'            		=> $status_code,
    			'weight'            		=> $weight,
    			'height'            		=> $height,
    			'width'             		=> $width,
    			'length'            		=> $length,
    			'product_line_id'   		=> $product_line_id,
    			'dima'              		=> $dima,
    			'dimb'              		=> $dimb,
    			'dimc'              		=> $dimc,
    			'dimd'              		=> $dimd,
    			'dime'              		=> $dime,
    			'dimf'              		=> $dimf,
    			'dimg'              		=> $dimg,
    			'universal'         		=> (($universal == true) ? 1 : 0),
    			'country_of_origin' 		=> $country_of_origin,
    			'part_type_id'      		=> ((trim($lookup_parttype_id) == '') ? null : $lookup_parttype_id),
    			'lookup_number'     		=> $lookup_number,
    			'bed_length'        		=> $bed_length,
    			'bed_length_id'     		=> $bed_length_id,
    			'flare_height'      		=> $flare_height,
    			'flare_tire_coverage'		=> $flare_tire_coverage,
    			'vehicle_type'     			=> $vehicle_type,
    			'no_drill'					=> $no_drill,
    			'finish'					=> $finish,
    			'style'						=> $style,
    			'material'					=> $material,
    			'material_thickness'		=> $material_thickness,
    			'sold_as'					=> $sold_as,
    			'tube_shape'				=> $tube_shape,
    			'tube_size'					=> $tube_size,
    			'warranty'					=> $warranty,
    			'liquid_storage_capacity' 	=> $liquid_storage_capacity,
    			'box_style'					=> $box_style,
        	    'box_opening_type'			=> $box_opening_type,
        	    'cut_required'			    => $cut_required,
        	    'rear_flare_height'			=> $rear_flare_height,
        	    'rear_flare_tire_coverage'	=> $rear_flare_tire_coverage,
        	    'stake_holes'			    => $stake_holes,
        	    'color_group'			    => $color_group,
        	    'map_price'			        => $map_price,
        	    'saleable'			        => $saleable
    	    
    	);
    
    	$part = $this->prepare('UPDATE parts set modified_at = :modified_at, deleted = :deleted, disabled = :disabled, part_number = :part_number, 
    											 jobber_price = :jobber_price, msrp_price = :msrp_price, color = :color, 
    											 isheet = :isheet, pop_code = :pop_code, upc_code = :upc_code, status = :status, weight = :weight, 
    											 height = :height, width = :width, length = :length, dima = :dima, dimb = :dimb, dimc = :dimc, 
    											 dimd = :dimd, dime = :dime, dimf = :dimf, dimg = :dimg, universal = :universal, 
    			 								 product_line_id = :product_line_id, country_of_origin = :country_of_origin, part_type_id = :part_type_id, 
    											 lookup_number = :lookup_number, bed_length = :bed_length, bed_length_id = :bed_length_id, 
    											 flare_height = :flare_height, flare_tire_coverage = :flare_tire_coverage, vehicle_type = :vehicle_type, 
    											 no_drill = :no_drill, finish = :finish, style = :style, material = :material, 
    											 material_thickness = :material_thickness, sold_as = :sold_as, tube_shape = :tube_shape, tube_size = :tube_size,
    											 warranty = :warranty, liquid_storage_capacity = :liquid_storage_capacity, box_style = :box_style, 
    											 box_opening_type = :box_opening_type, cut_required = :cut_required, rear_flare_height = :rear_flare_height, 
    											 rear_flare_tire_coverage = :rear_flare_tire_coverage, stake_holes = :stake_holes, color_group = :color_group,
                                                 map_price = :map_price, saleable = :saleable
    							WHERE part_id = :part_id');
    	
    
    	$part->bindParam(':modified_at', $return['modified_at']);
    	$part->bindParam(':deleted', $return['deleted']);
    	$part->bindParam(':disabled', $return['disabled']);
    	$part->bindParam(':part_number', $return['part_number']);
    	$part->bindParam(':jobber_price', $return['jobber_price']);
    	$part->bindParam(':msrp_price', $return['msrp_price']);
    	$part->bindParam(':color', $return['color']);
    	$part->bindParam(':isheet', $return['isheet']);
    	$part->bindParam(':pop_code', $return['pop_code']);
    	$part->bindParam(':upc_code', $return['upc_code']);
    	$part->bindParam(':status', $return['status']);
    	$part->bindParam(':weight', $return['weight']);
    	$part->bindParam(':height', $return['height']);
    	$part->bindParam(':width', $return['width']);
    	$part->bindParam(':length', $return['length']);
    	$part->bindParam(':product_line_id', $return['product_line_id']);
    	$part->bindParam(':country_of_origin', $return['country_of_origin']);
    	$part->bindParam(':dima', $return['dima']);
    	$part->bindParam(':dimb', $return['dimb']);
    	$part->bindParam(':dimc', $return['dimc']);
    	$part->bindParam(':dimd', $return['dimd']);
    	$part->bindParam(':dime', $return['dime']);
    	$part->bindParam(':dimf', $return['dimf']);
    	$part->bindParam(':dimg', $return['dimg']);
    	$part->bindParam(':universal', $return['universal']);
    	$part->bindParam(':part_type_id', $return['part_type_id']);
    	$part->bindParam(':part_id', $return['part_id']);
    	$part->bindParam(':lookup_number', $return['lookup_number']);
    	$part->bindParam(':bed_length', $return['bed_length']);
    	$part->bindParam(':bed_length_id', $return['bed_length_id']);
    	$part->bindParam(':flare_height', $return['flare_height']);
    	$part->bindParam(':flare_tire_coverage', $return['flare_tire_coverage']);
    	$part->bindParam(':vehicle_type', $return['vehicle_type']);
    	$part->bindParam(':no_drill', $return['no_drill']);
    	$part->bindParam(':finish', $return['finish']);
    	$part->bindParam(':style', $return['style']);
    	$part->bindParam(':material', $return['material']);
    	$part->bindParam(':material_thickness', $return['material_thickness']);
    	$part->bindParam(':sold_as', $return['sold_as']);
    	$part->bindParam(':tube_shape', $return['tube_shape']);
    	$part->bindParam(':tube_size', $return['tube_size']);
    	$part->bindParam(':warranty', $return['warranty']);
    	$part->bindParam(':liquid_storage_capacity', $return['liquid_storage_capacity']);
    	$part->bindParam(':box_style', $return['box_style']);
    	$part->bindParam(':box_opening_type', $return['box_opening_type']);
    	$part->bindParam(':cut_required', $return['cut_required']);
    	$part->bindParam(':rear_flare_height', $return['rear_flare_height']);
    	$part->bindParam(':rear_flare_tire_coverage', $return['rear_flare_tire_coverage']);
    	$part->bindParam(':stake_holes', $return['stake_holes']);
    	$part->bindParam(':color_group', $return['color_group']);
    	$part->bindParam(':map_price', $return['map_price']);
    	$part->bindParam(':saleable', $return['saleable']);
    	$part->execute();
    
    	$return['part_id'] = $this->lastInsertId();
    
    	return $return;
    }


    /*
     * Disable part.
     *
     * @param int 	 $part_id
     * @param string $modified_at
     * @param int    $deleted
     * @param int    $disabled
     *
     * @return array
     */
    public function disablePart($part_id = null, $modified_at = null, $deleted = null, $disabled = null)
    {
    	if (null == $modified_at) {
    		$modified_at = date('Y-m-d H:i:s');
    	}
    
    	if (null == $deleted) {
    		$deleted = 0;
    	}
    
    	if (null == $disabled) {
    		$disabled = 0;
    	}
    
    	$return = array('part_id'   => $part_id,
    			'modified_at'       => $modified_at,
    			'deleted'           => $deleted,
    			'disabled'          => $disabled
    	);
    
    	$part = $this->prepare('UPDATE parts set modified_at = :modified_at, deleted = :deleted, disabled = :disabled
    							WHERE part_id = :part_id');
    	 
    
    	$part->bindParam(':modified_at', $return['modified_at']);
    	$part->bindParam(':deleted', $return['deleted']);
    	$part->bindParam(':disabled', $return['disabled']);
    	$part->bindParam(':part_id', $return['part_id']);
    	$part->execute();
    
    	$return['part_id'] = $this->lastInsertId();
    
    	return $return;
    }

    /*
     * Find veh_year.
     *
     * @param string $year
     *
     * @return array
     */
    public function findVehYear($year = null)
    {
        if ($this->existsInCache($year, 'veh_year_cache')) {
            return $this->getFromCache($year, 'veh_year_cache');
        }

        $foundVehYear = $this->prepare('SELECT * FROM veh_year
                                        WHERE name = ' . $this->quote((STRING)$year) . ' LIMIT 1');
        $foundVehYear->execute();
        $return = $foundVehYear->fetch(PDO::FETCH_ASSOC);

        $this->addToCache($year, 'veh_year_cache', $return);

        return $return;
    }

    /*
     * Insert veh_year.
     *
     * @param string $year
     *
     * @return array
     */
    public function insertVehYear($year = null)
    {
        $vehYearInsert = $this->prepare('INSERT INTO veh_year (name) VALUES (:name)');
        $vehYearInsert->bindParam(':name', $year);
        $vehYearInsert->execute();

        return array('veh_year_id' => $this->lastInsertId(),
                     'name'        => $year);
    }

    /*
     * Find veh_make.
     *
     * @param string $name
     *
     * @return array
     */
    public function findVehMake($name = null)
    {
        if ($this->existsInCache($name, 'veh_make_cache')) {
            return $this->getFromCache($name, 'veh_make_cache');
        }

        $foundVehMake = $this->prepare('SELECT * FROM veh_make
                                        WHERE name = ' . $this->quote($name) . ' LIMIT 1');
        $foundVehMake->execute();
        $return = $foundVehMake->fetch(PDO::FETCH_ASSOC);

        $this->addToCache($name, 'veh_make_cache', $return);

        return $return;
    }

    /*
     * Insert veh_make.
     *
     * @param string $name
     * @param string $short_code
     *
     * @return array
     */
    public function insertVehMake($name = null, $short_code = null)
    {
        $vehMakeInsert = $this->prepare('INSERT INTO veh_make (name, short_code) VALUES (:name, :short_code)');
        $vehMakeInsert->bindParam(':name', $name);
        $vehMakeInsert->bindParam(':short_code', $short_code);
        $vehMakeInsert->execute();

        return array('veh_make_id' => $this->lastInsertId(),
                     'name'        => $name,
                     'short_code'  => $short_code);
    }

    /*
     * Find veh_class.
     *
     * @param string $class
     *
     * @return array
     */
    public function findVehClass($class = null)
    {
        if ($this->existsInCache($class, 'veh_class_cache')) {
            return $this->getFromCache($class, 'veh_class_cache');
        }

        $foundVehClass = $this->prepare('SELECT * FROM veh_class
                                         WHERE short_code = ' . $this->quote($class) . ' LIMIT 1');
        $foundVehClass->execute();
        $return = $foundVehClass->fetch(PDO::FETCH_ASSOC);

        $this->addToCache($class, 'veh_class_cache', $return);

        return $return;
    }

    /*
     * Insert veh_class.
     *
     * @param string $name
     *
     * @return array
     */
    public function insertVehClass($name = null)
    {
        $vehClassInsert = $this->prepare('INSERT INTO veh_class (short_code) VALUES (:short_code)');
        $vehClassInsert->bindParam(':short_code', $name);
        $vehClassInsert->execute();

        return array('veh_class_id' => $this->lastInsertId(),
                     'name'         => $name);
    }

    /*
     * Find veh_model.
     *
     * @param string $name
     * @param string $makeId
     *
     * @return array
     */
    public function findVehModel($name = null, $makeId = null)
    {
        if ($this->existsInCache($name, 'veh_model_cache')) {
            return $this->getFromCache($name, 'veh_model_cache');
        }

        $foundVehModel = $this->prepare('SELECT * FROM veh_model
            WHERE name = ' . $this->quote($name) . ' 
            AND veh_make_id = ' . $this->quote($makeId) . '
            LIMIT 1');

        $foundVehModel->execute();
        $return = $foundVehModel->fetch(PDO::FETCH_ASSOC);

        $this->addToCache($name, 'veh_model_cache', $return);

        return $return;
    }

    /*
     * Insert veh_model.
     *
     * @param string $name
     * @param string $short_code
     * @param int    $veh_make_id
     * @param int    $veh_class_id
     *
     * @return array
     */
    public function insertVehModel($name = null, $short_code = null, $veh_make_id = null, $veh_class_id = null)
    {
        $vehModelInsert = $this->prepare('INSERT INTO veh_model (name, short_code, veh_make_id, veh_class_id)
                                          VALUES (:name, :short_code, :veh_make_id, :veh_class_id)');
        $vehModelInsert->bindParam(':name', $name);
        $vehModelInsert->bindParam(':short_code', $short_code);
        $vehModelInsert->bindParam(':veh_make_id', $veh_make_id);
        $vehModelInsert->bindParam(':veh_class_id', $veh_class_id);
        $vehModelInsert->execute();

        return array('veh_model_id' => $this->lastInsertId(),
                     'name'         => $name,
                     'short_code'   => $short_code,
                     'veh_make_id'  => $veh_make_id,
                     'veh_class_id' => $veh_class_id);
    }

    /*
     * Find veh_submodel.
     *
     * @param string $name
     * @param string $modelId
     *
     * @return array
     */
    public function findVehSubmodel($name = null, $modelId = null)
    {
        if ($this->existsInCache($name, 'veh_submodel_cache')) {
            return $this->getFromCache($name, 'veh_submodel_cache');
        }

        $foundVehSubmodel = $this->prepare('SELECT * FROM veh_submodel
            WHERE name = ' . $this->quote($name) . ' 
            AND veh_model_id = ' . $this->quote($modelId) . '
            LIMIT 1');

        $foundVehSubmodel->execute();
        $return = $foundVehSubmodel->fetch(PDO::FETCH_ASSOC);

        $this->addToCache($name, 'veh_submodel_cache', $return);

        return $return;
    }

    /*
     * Insert veh_submodel.
     *
     * @param string $name
     * @param string $short_code
     * @param int    $veh_model_id
     *
     * @return array
     */
    public function insertVehSubmodel($name = null, $short_code = null, $veh_model_id = null)
    {
        $vehSubmodelInsert = $this->prepare('INSERT INTO veh_submodel (name, short_code, veh_model_id)
                                             VALUES (:name, :short_code, :veh_model_id)');
        $vehSubmodelInsert->bindParam(':name', $name);
        $vehSubmodelInsert->bindParam(':short_code', $short_code);
        $vehSubmodelInsert->bindParam(':veh_model_id', $veh_model_id);
        $vehSubmodelInsert->execute();

        return array('veh_submodel_id' => $this->lastInsertId(),
                     'name'            => $name,
                     'short_code'      => $short_code,
                     'veh_model_id'    => $veh_model_id);
    }

    /*
     * Find veh_collection.
     *
     * @param int    $veh_year_id
     * @param int    $veh_make_id
     * @param int    $veh_model_id
     * @param string $submodel_name
     * @param int    $submodel_id
     * @param string $body_type
     *
     * @return array
     */
    public function findVehCollection($veh_year_id = null, $veh_make_id = null, $veh_model_id = null, $submodel_name = null, $submodel_id = null, $body_type = null)
    {
            
        $foundVehCollection = $this->prepare('SELECT * FROM veh_collection
                                              WHERE veh_year_id = ' . $veh_year_id . '
                                              AND veh_make_id = ' . $veh_make_id . '
                                              AND veh_model_id = ' . $veh_model_id . '
                                              ' . ((null != $submodel_name) ? 'AND veh_submodel_id = ' . $submodel_id : 'AND veh_submodel_id is null ') . '
                                              AND body_type = "' . $body_type . '"
                                              LIMIT 1');
        $foundVehCollection->execute();

        return $foundVehCollection->fetch(PDO::FETCH_ASSOC);
    }
    
    /*
     * Update veh_collection.
     *
     * @param int    $veh_year_id
     * @param int    $veh_make_id
     * @param int    $veh_model_id
     * @param string $submodel_name
     * @param int    $submodel_id
     * @param string $body_type
     * @param string $model_type
     *
     * @return array
     */
    public function updateVehCollection($veh_year_id = null, $veh_make_id = null, $veh_model_id = null, $submodel_name = null, $submodel_id = null, $body_type = null, $model_type = null, $base_veh_id = null, $fit_code_1= null,  $fit_code_1_desc= null,  $fit_code_2= null, $fit_code_2_desc= null, $fit_code_3= null, $fit_code_3_desc= null, $fit_code_4= null, $fit_code_4_desc= null, $fit_code_5= null, $fit_code_5_desc= null, $jeep_clearance= null)
    {
    	$vehUpdate = 'Update veh_collection set model_type = "' . $model_type . '"
	                                              ' . ((null != $base_veh_id) ? ', base_veh_id = "' . $base_veh_id . '"' : '') . '
	                                              ' . ((null != $fit_code_1) ? ', fit_code_1 = "' . $fit_code_1. '"' : '') . '
	                                              ' . ((null != $fit_code_1_desc) ? ', fit_code_1_desc = "' . $fit_code_1_desc. '"' : '') . '
	                                              ' . ((null != $fit_code_2) ? ', fit_code_2 = "' . $fit_code_2. '"' : '') . '
	                                              ' . ((null != $fit_code_2_desc) ? ', fit_code_2_desc = "' . $fit_code_2_desc. '"' : '') . '
	                                              ' . ((null != $fit_code_3) ? ', fit_code_3 = "' . $fit_code_3. '"' : '') . '
	                                              ' . ((null != $fit_code_3_desc) ? ', fit_code_3_desc = "' . $fit_code_3_desc. '"' : '') . '
	                                              ' . ((null != $fit_code_4) ? ', fit_code_4 = "' . $fit_code_4. '"' : '') . '
	                                              ' . ((null != $fit_code_4_desc) ? ', fit_code_4_desc = "' . $fit_code_4_desc. '"' : '') . '
	                                              ' . ((null != $fit_code_5) ? ', fit_code_5 = "' . $fit_code_5. '"' : '') . '
	                                              ' . ((null != $fit_code_5_desc) ? ', fit_code_5_desc = "' . $fit_code_5_desc. '"' : '') . '
	                                              ' . ((null != $jeep_clearance) ? ', jeep_clearance = "' . $jeep_clearance. '"' : '') . '
    											  WHERE veh_year_id = "' . $veh_year_id . '"
	                                              AND veh_make_id = "' . $veh_make_id . '"
	                                              AND veh_model_id = "' . $veh_model_id . '"
	                                              ' . ((null != $submodel_name) ? 'AND veh_submodel_id = ' . $submodel_id : '') . '
	                                              ' . ((null != $body_type) ? ' AND body_type = "' . $body_type . '"' : '') . '		
	                                              LIMIT 1';
    	
    	//echo $base_veh_id." - ";
    	
    	$updateVehCollection = $this->prepare($vehUpdate);
    	$updateVehCollection->execute();
    
    	//echo $vehUpdate;exit;
    	return true;
    
    }
    	
    /*
     * Insert veh_collection.
     *
     * @param int    $veh_year_id
     * @param int    $veh_make_id
     * @param int    $veh_model_id
     * @param string $submodel_name
     * @param int    $veh_submodel_id
     * @param int    $aaia_make_id
     * @param int    $aaia_model_id
     * @param int    $aaia_submodel_id
     * @param int    $aaia_body_type_id
     * @param string $aaia_body_type
     * @param int    $aaia_body_num_doors_id
     * @param int    $aaia_bed_type_id
     * @param string $aaia_bed_type
     * @param int	 $base_veh_id
     *
     * @return array
     */
    public function insertVehCollection($veh_year_id = null, $veh_make_id = null, $veh_model_id = null, $submodel_name = null, $veh_submodel_id = null, $aaia_make_id = null, $aaia_model_id = null, $aaia_submodel_id = null, $aaia_body_type_id = null, $aaia_body_type = null, $aaia_body_num_doors_id = null, $aaia_bed_type_id = null, $aaia_bed_type = null, $model_type = null, $base_veh_id = null, $fit_code_1= null,  $fit_code_1_desc= null,  $fit_code_2= null, $fit_code_2_desc= null, $fit_code_3= null, $fit_code_3_desc= null, $fit_code_4= null, $fit_code_4_desc= null, $fit_code_5= null, $fit_code_5_desc= null, $jeep_clearance= null)
    {
        if ($aaia_make_id == '') { $aaia_make_id = null; }
        if ($aaia_model_id == '') { $aaia_model_id = null; }
        if ($aaia_submodel_id == '') { $aaia_submodel_id = null; }
        if ($aaia_body_type_id == '') { $aaia_body_type_id = null; }
        if ($aaia_body_num_doors_id == '') { $aaia_body_num_doors_id = null; }
        if ($aaia_bed_type_id == '') { $aaia_bed_type_id = null; }
        if ($model_type == '') { $model_type = null; }
        if ($base_veh_id == '') { $base_veh_id = null; }
        if ($fit_code_1== '') { $fit_code_1= null; }
        if ($fit_code_1_desc== '') { $fit_code_1_desc= null; }
        if ($fit_code_2== '') { $fit_code_2= null; }
        if ($fit_code_2_desc== '') { $fit_code_2_desc= null; }
        if ($fit_code_3== '') { $fit_code_3= null; }
        if ($fit_code_3_desc== '') { $fit_code_3_desc= null; }
        if ($fit_code_4== '') { $fit_code_4= null; }
        if ($fit_code_4_desc== '') { $fit_code_4_desc= null; }
        if ($fit_code_5== '') { $fit_code_5= null; }
        if ($fit_code_5_desc== '') { $fit_code_5_desc= null; }
        if ($jeep_clearance== '') { $jeep_clearance= null; }
        
        
        
        //echo $base_veh_id." - ";
        $return = array(
            'veh_collection_id' => null,
            'veh_year_id'       => $veh_year_id,
            'veh_make_id'       => $veh_make_id,
            'veh_model_id'      => $veh_model_id,
            'veh_submodel_id'   => $veh_submodel_id,
            'make_id'           => $aaia_make_id,
            'model_id'          => $aaia_model_id,
            'submodel_id'       => $aaia_submodel_id,
            'body_type_id'      => $aaia_body_type_id,
            'body_type'         => $aaia_body_type,
            'body_num_doors_id' => $aaia_body_num_doors_id,
            'bed_type_id'       => $aaia_bed_type_id,
            'bed_type'          => $aaia_bed_type,
            'model_type'        => $model_type,
            'base_veh_id'		=> $base_veh_id,
            'fit_code_1'		=> $fit_code_1,
            'fit_code_1_desc'	=> $fit_code_1_desc,
            'fit_code_2'		=> $fit_code_2,
            'fit_code_2_desc'   => $fit_code_2_desc,
            'fit_code_3'		=> $fit_code_3,
            'fit_code_3_desc'	=> $fit_code_3_desc,
            'fit_code_4'		=> $fit_code_4,
            'fit_code_4_desc'	=> $fit_code_4_desc,
            'fit_code_5'		=> $fit_code_5,
            'fit_code_5_desc'	=> $fit_code_5_desc,
            'jeep_clearance'	=> $jeep_clearance,
        );

        
        
        $vehCollectionInsert = $this->prepare('INSERT INTO veh_collection (veh_make_id, veh_model_id, veh_year_id, veh_submodel_id, make_id, model_id, submodel_id, body_type_id, body_type, body_num_doors_id, bed_type_id, bed_type, model_type, base_veh_id, fit_code_1, fit_code_1_desc, fit_code_2, fit_code_2_desc, fit_code_3, fit_code_3_desc, fit_code_4, fit_code_4_desc, fit_code_5, fit_code_5_desc, jeep_clearance)
                                               VALUES (:veh_make_id, :veh_model_id, :veh_year_id, :veh_submodel_id, :make_id, :model_id, :submodel_id, :body_type_id, :body_type, :body_num_doors_id, :bed_type_id, :bed_type, :model_type, :base_veh_id, :fit_code_1, :fit_code_1_desc, :fit_code_2, :fit_code_2_desc, :fit_code_3, :fit_code_3_desc, :fit_code_4, :fit_code_4_desc, :fit_code_5, :fit_code_5_desc, :jeep_clearance)');
        $vehCollectionInsert->bindParam(':veh_make_id', $return['veh_make_id']);
        $vehCollectionInsert->bindParam(':veh_model_id', $return['veh_model_id']);
        $vehCollectionInsert->bindParam(':veh_year_id', $return['veh_year_id']);
        $vehCollectionInsert->bindParam(':veh_submodel_id', $return['veh_submodel_id']);
        $vehCollectionInsert->bindParam(':make_id', $return['make_id']);
        $vehCollectionInsert->bindParam(':model_id', $return['model_id']);
        $vehCollectionInsert->bindParam(':submodel_id', $return['submodel_id']);
        $vehCollectionInsert->bindParam(':body_type_id', $return['body_type_id']);
        $vehCollectionInsert->bindParam(':body_type', $return['body_type']);
        $vehCollectionInsert->bindParam(':body_num_doors_id', $return['body_num_doors_id']);
        $vehCollectionInsert->bindParam(':bed_type_id', $return['bed_type_id']);
        $vehCollectionInsert->bindParam(':bed_type', $return['bed_type']);
        $vehCollectionInsert->bindParam(':model_type', $return['model_type']);
        $vehCollectionInsert->bindParam('base_veh_id', $return['base_veh_id']);
        $vehCollectionInsert->bindParam('fit_code_1', $return['fit_code_1']);
        $vehCollectionInsert->bindParam('fit_code_1_desc', $return['fit_code_1_desc']);
        $vehCollectionInsert->bindParam('fit_code_2', $return['fit_code_2']);
        $vehCollectionInsert->bindParam('fit_code_2_desc', $return['fit_code_2_desc']);
        $vehCollectionInsert->bindParam('fit_code_3', $return['fit_code_3']);
        $vehCollectionInsert->bindParam('fit_code_3_desc', $return['fit_code_3_desc']);
        $vehCollectionInsert->bindParam('fit_code_4', $return['fit_code_4']);
        $vehCollectionInsert->bindParam('fit_code_4_desc', $return['fit_code_4_desc']);
        $vehCollectionInsert->bindParam('fit_code_5', $return['fit_code_5']);
        $vehCollectionInsert->bindParam('fit_code_5_desc', $return['fit_code_5_desc']);
        $vehCollectionInsert->bindParam('jeep_clearance', $return['jeep_clearance']);
        $vehCollectionInsert->execute();

        $return['veh_collection_id'] = $this->lastInsertId();

        return $return;
    }

    /*
     * Find part_veh_collection.
     *
     * @param int $part_id
     * @param int $veh_collection_id
     *
     * @return array
     */
    public function findPartVehCollection($part_id = null, $veh_collection_id = null)
    {

        $foundPartVehCollection = $this->prepare("SELECT * FROM part_veh_collection
                                                  WHERE part_id = '" . $part_id . "'
                                                  AND veh_collection_id = '" . $veh_collection_id . "'
                                                  LIMIT 1");
        $foundPartVehCollection->execute();

        return $foundPartVehCollection->fetch(PDO::FETCH_ASSOC);
    }
    
    /*
     * Find part_veh_collection.
     *
     * @param int $part_id
     * @param int $make_id
     * @param int $model_id
     *
     * @return array
     */
    public function findAllPartVehCollection($part_id = null, $seq_no = null)
    {
    	$vehCollectinIdArray = array();
    	$foundAllPartVehCollection = $this->prepare('SELECT distinct vy.name, pvc.part_veh_collection_id  FROM part_veh_collection as pvc, 
    												        veh_collection as vc, veh_year as vy
                                                  WHERE pvc.veh_collection_id = vc.veh_collection_id 
    											  AND vc.veh_year_id = vy.veh_year_id 
    											  AND pvc.part_id = ' . $part_id . '
    											  AND pvc.sequence = ' . $seq_no . '' );
    	$foundAllPartVehCollection->execute();
    	
    	$tempArray = array();
    	
    	while($row = $foundAllPartVehCollection->fetch(PDO::FETCH_ASSOC))
    	{
    		$tempArray = array($row['part_veh_collection_id'], $row['name']);
    		
    		array_push($vehCollectinIdArray, $tempArray);
    	}
    	
    	return $vehCollectinIdArray;
    }

    /*
     * Insert part_veh_collection.
     *
     * @param int    $part_id
     * @param int    $veh_collection_id
     * @param int    $seq_no
     * @param int    $changeset_detail_id
     * @param string $subdetail
     *
     * @return array
     */

    public function insertPartVehCollection($part_id = null, $veh_collection_id = null, $seq_no = null, $changeset_detail_id = null, $subdetail = null)
    {
        if ($seq_no == '') { $seq_no = null; }
        $insertPartVehCollection = $this->prepare('INSERT INTO part_veh_collection (part_id, veh_collection_id, sequence' . ((null == $changeset_detail_id) ? '' : ', changeset_detail_id') . ', subdetail)
                                                   VALUES (:part_id, :veh_collection_id, :seq_no' . ((null == $changeset_detail_id) ? '' : ', :changeset_detail_id') . ', :subdetail)');
        $insertPartVehCollection->bindParam(':part_id', $part_id);
        $insertPartVehCollection->bindParam(':veh_collection_id', $veh_collection_id);
        $insertPartVehCollection->bindParam(':seq_no', $seq_no);

        if (null != $changeset_detail_id) {
            $insertPartVehCollection->bindParam(':changeset_detail_id', $changeset_detail_id);
        }

        $insertPartVehCollection->bindParam(':subdetail', $subdetail);

        $insertPartVehCollection->execute();

        return array(
            'part_veh_collection_id' => $this->lastInsertId(),
            'part_id'                => $part_id,
            'veh_collection_id'      => $veh_collection_id,
            'seq_no'                 => $seq_no,
            'subdetail'              => $subdetail,
        );
    }

    /*
     * Update part_veh_collection.
     *
     * @param int    $part_id
     * @param int    $veh_collection_id
     * @param int    $seq_no
     * @param int    $changeset_detail_id
     * @param string $subdetail
     *
     * @return array
     */
    
    public function updatePartVehCollection($rowdata, $seq_no=null, $veh_submodel_subdetail=null)
    {
    	if($seq_no != null)
    	{
    	
    		$updatePartVehCollection = $this->prepare('UPDATE part_veh_collection set sequence = '.$seq_no .
    											  ' where part_veh_collection_id = '. $rowdata['part_veh_collection_id']);
    		$updatePartVehCollection->execute();
    	
    	}
    	
    	if($veh_submodel_subdetail != null)
    	{
    		
	    	$updatePartVehCollection2 = $this->prepare('UPDATE part_veh_collection set subdetail = "'.addslashes($veh_submodel_subdetail) .
	    											  '" where part_veh_collection_id = '. $rowdata['part_veh_collection_id']);
	    	$updatePartVehCollection2->execute();
    	
    	}
    }

    /*
     * Delete part_veh_collection.
     *
     * @param int $part_veh_collection_id
     *
     * @return string
     */
    public function deletePartVehCollection($part_veh_collection_id = null)
    {
    	$deletePartVehCollection = $this->prepare('DELETE from part_veh_collection where part_veh_collection_id = '. $part_veh_collection_id );
    	$deletePartVehCollection->execute();
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
     * @return \Zend\Log\Logger
     */
    public function getLogger()
    {
        return $this->logger;
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
     * @param string $key
     * @param string $cache_id
     *
     * @return boolean
     */
    private function existsInCache($key = null, $cache_id = null)
    {
        if (array_key_exists($cache_id, $this->cache)) {
            return false;
        }

        return array_key_exists($key, $this->cache[$cache_id]);
    }

    /*
     * @param string $key
     * @param string $cache_id
     *
     * @return array
     */
    private function getFromCache($key = null, $cache_id = null)
    {
        return $this->cache[$cache_id][$key];
    }

    /*
     * @param string $key
     * @param string $cache_id
     * @param array  $data
     *
     * @return void
     */
    private function addToCache($key = null, $cache_id = null, $data = array())
    {
        $this->cache[$cache_id][$key] = $data;
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
