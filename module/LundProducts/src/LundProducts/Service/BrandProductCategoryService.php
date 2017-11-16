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

use RocketUser\Entity\UserInterface;
use LundProducts\Entity\BrandProductCategory;
use LundProducts\Entity\BrandProductCategoryInterface;
use LundProducts\Entity\BrandsInterface;
use LundProducts\Entity\ProductCategoriesInterface;
use LundProducts\Repository\BrandProductCategoryRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use LundProducts\Repository\BrandsRepositoryInterface;
use LundProducts\Repository\ProductCategoriesRepositoryInterface;
use LundProducts\Form\BrandProductCategoryForm;
use LundProducts\Options\LundProductsOptionsInterface;
use LundProducts\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use PDO;

/**
 * Service managing the management of brand product categorys.
 */
class BrandProductCategoryService implements EventManagerAwareInterface
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
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var BrandProductCategoryRepositoryInterface
     */
    protected $brandProductCategoryRepository;

    /**
     * @var BrandsRepositoryInterface
     */
    protected $brandRepository;

    /**
     * @var ProductCategoriesRepositoryInterface
     */
    protected $productCategoryRepository;

    /**
     * @var BrandProductCategoryForm
     */
    protected $brandProductCategoryForm;

    /**
     * @var LundProductsOptionsInterface
     */
    protected $options;

    /**
     * @var BrandProductCategoryInterface
     */
    protected $brandProductCategoryPrototype;

    /**
     * @param ObjectManager                       $objectManager
     * @param UserRepositoryInterface             $userRepository
     * @param BrandProductCategoryRepositoryInterface $brandProductCategoryRepository
     * @param BrandsRepositoryInterface     $brandRepository
     * @param ProductCategoriesRepositoryInterface            $productCategoryRepository
     * @param FormInterface                       $brandProductCategoryForm
     * @param LundProductsOptionsInterface        $options
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        BrandProductCategoryRepositoryInterface $brandProductCategoryRepository,
        BrandsRepositoryInterface $brandRepository,
        ProductCategoriesRepositoryInterface $productCategoryRepository,
        FormInterface $brandProductCategoryForm,
        LundProductsOptionsInterface $options,
        PDO $connection
    ) {
        $this->objectManager  = $objectManager;
        $this->userRepository = $userRepository;
        $this->brandProductCategoryRepository = $brandProductCategoryRepository;
        $this->brandRepository     = $brandRepository;
        $this->productCategoryRepository     = $productCategoryRepository;
        $this->brandProductCategoryForm       = $brandProductCategoryForm;
        $this->options        = $options;
        $this->connection = $connection;
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
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getBrandProductCategory($recordId)
    {
        return $this->brandProductCategoryRepository->find($recordId);
    }

    /**
     * Return a list of active brand product categories
     *
     * @return BrandProductCategoryInterface
     */
    public function getBrandProductCategories()
    {
        return $this->brandProductCategoryRepository->findBy(
            array(
                'deleted' => false,
                'disabled' => false,
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return a list of brand product categories for a brand
     *
     * @param  BrandsInterface     $brand
     * @return BrandProductCategoryInterface
     */
    public function getBrandProductCategoriesByBrand(BrandsInterface $brand)
    {
        return $this->brandProductCategoryRepository->findBy(
            array(
                'brand' => $brand->getBrandId(),
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return a list of active brand product categories for a brand
     *
     * @param  BrandsInterface     $brand
     * @return BrandProductCategoryInterface
     */
    public function getActiveBrandProductCategoriesByBrand(BrandsInterface $brand)
    {
        return $this->brandProductCategoryRepository->findBy(
            array(
                'brand' => $brand->getBrandId(),
                'deleted' => false,
                'disabled' => false,
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return a list of active brand product categories for a brand
     *
     * @param  BrandsInterface     $brand
     * @return BrandProductCategoryInterface
     */
    public function getProductCategory()
    {
        return $this->brandProductCategoryRepository->findBy(
            array(
                'deleted' => false,
                'disabled' => false,
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return product line by brand product category
     *
     * @return string 
     */
    public function getVehicleProductCategory($year, $make, $model, $brand, $submodel=null)
    {
 
    	$brands = implode("', '", $brand);

    	/*
    	echo "select distinct pc.*, bpc.short_descr, bpc.position from veh_collection as vc, part_veh_collection as pvc,
			 parts as p, product_lines as pl, product_categories as pc, brand_product_category as bpc
			where vc.veh_year_id = '".$year."' and vc.veh_make_id = '".$make."' and vc.veh_model_id = '".$model."'".
			((null != $submodel)? ' and vc.veh_submodel_id = '.$submodel : '')
			." and vc.veh_collection_id=pvc.veh_collection_id and pvc.part_id=p.part_id
			and p.product_line_id=pl.product_line_id and pl.product_category_id=pc.product_category_id
			and bpc.product_category_id = pc.product_category_id and pl.brand_id in ('".$brands."')
			and p.deleted = '0' and p.disabled = 0 and pl.deleted = '0' and pl.disabled = 0
			and pc.deleted = '0' and pc.disabled = 0 and bpc.deleted = '0' and bpc.disabled = 0
			order by bpc.position";exit;
        
		*/
    	
    	$foundBrand = $this->prepare("select distinct pc.*, bpc.short_descr, bpc.position from veh_collection as vc, part_veh_collection as pvc,
			 parts as p, product_lines as pl, product_categories as pc, brand_product_category as bpc
			where vc.veh_year_id = '".$year."' and vc.veh_make_id = '".$make."' and vc.veh_model_id = '".$model."'".
			((null != $submodel)? ' and vc.veh_submodel_id = '.$submodel : '')
			." and vc.veh_collection_id=pvc.veh_collection_id and pvc.part_id=p.part_id
			and p.product_line_id=pl.product_line_id and pl.product_category_id=pc.product_category_id
			and bpc.product_category_id = pc.product_category_id and pl.brand_id in ('".$brands."')
			and p.deleted = '0' and p.disabled = 0 and pl.deleted = '0' and pl.disabled = 0
			and pc.deleted = '0' and pc.disabled = 0 and bpc.deleted = '0' and bpc.disabled = 0
			order by bpc.position");
    
    			
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
  
    	
    	return $return; 

    }

    /**
     * Return product line by brand product category
     *
     * @return string 
     */
    public function getVehicleProductCategoryOrder($year, $make, $model, $brand, $submodel=null)
    {
 
    	$brands = implode("', '", $brand);
/*
    	echo "select distinct pc.*, a.hash, bpc.short_descr from veh_collection as vc, part_veh_collection as pvc,
			 parts as p, product_lines as pl, product_categories as pc, brand_product_category as bpc, asset as a
			where vc.veh_year_id = '".$year."' and vc.veh_make_id = '".$make."' and vc.veh_model_id = '".$model."'".
			((null != $submodel)? ' and vc.veh_submodel_id = '.$submodel : '')
			." and vc.veh_collection_id=pvc.veh_collection_id and pvc.part_id=p.part_id
    		and a.asset_id = pc.asset_id
			and p.product_line_id=pl.product_line_id and pl.product_category_id=pc.product_category_id
			and bpc.product_category_id = pc.product_category_id and pl.brand_id in ('".$brands."')
			and p.deleted = '0' and p.disabled = 0 and pl.deleted = '0' and pl.disabled = 0
			and pc.deleted = '0' and pc.disabled = 0 and bpc.deleted = '0' and bpc.disabled = 0
			order by bpc.position";exit;
*/					
    	$foundBrand = $this->prepare("select distinct pc.*, a.hash, bpc.short_descr from veh_collection as vc, part_veh_collection as pvc,
			 parts as p, product_lines as pl, product_categories as pc, brand_product_category as bpc, asset as a
			where vc.veh_year_id = '".$year."' and vc.veh_make_id = '".$make."' and vc.veh_model_id = '".$model."'".
			((null != $submodel)? ' and vc.veh_submodel_id = '.$submodel : '')
			." and vc.veh_collection_id=pvc.veh_collection_id and pvc.part_id=p.part_id
    		and a.asset_id = pc.asset_id
			and p.product_line_id=pl.product_line_id and pl.product_category_id=pc.product_category_id
			and bpc.product_category_id = pc.product_category_id and pl.brand_id in ('".$brands."')
			and p.deleted = '0' and p.disabled = 0 and pl.deleted = '0' and pl.disabled = 0
			and pc.deleted = '0' and pc.disabled = 0 and bpc.deleted = '0' and bpc.disabled = 0
			order by pc.display_name");
    
    			
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
  
    	
    	return $return; 

    }

    /**
     * Return product line by brand product category
     *
     * @return string 
     */
    public function getUnviersalVehicleProductCategory($brand, $modelType)
    {
 
    	$brands = implode("', '", $brand);
    	$modelTypes = implode("', '", $modelType);
/*
    	echo "select distinct pc.*, a.hash, bpc.short_descr from veh_collection as vc, part_veh_collection as pvc,
			 parts as p, product_lines as pl, product_categories as pc, brand_product_category as bpc, asset as a
			where vc.veh_year_id = '".$year."' and vc.veh_make_id = '".$make."' and vc.veh_model_id = '".$model."' 
			and vc.veh_collection_id=pvc.veh_collection_id and pvc.part_id=p.part_id
    		and a.asset_id = pc.asset_id
			and p.product_line_id=pl.product_line_id and pl.product_category_id=pc.product_category_id
			and bpc.product_category_id = pc.product_category_id and pl.brand_id in ('".$brands."')
			and p.deleted = '0' and p.disabled = 0 and pl.deleted = '0' and pl.disabled = 0
			and pc.deleted = '0' and pc.disabled = 0 and bpc.deleted = '0' and bpc.disabled = 0
			order by bpc.position";exit;
*/					
    	$foundBrand = $this->prepare("select distinct pc.*, a.hash, bpc.short_descr, bpc.position  from veh_collection as vc, part_veh_collection as pvc,
			 parts as p, product_lines as pl, product_categories as pc, brand_product_category as bpc, asset as a
			where vc.veh_year_id = '".$year."' and vc.veh_make_id = '".$make."' and vc.veh_model_id = '".$model."' 
			and vc.veh_collection_id=pvc.veh_collection_id and pvc.part_id=p.part_id
    		and a.asset_id = pc.asset_id
			and p.product_line_id=pl.product_line_id and pl.product_category_id=pc.product_category_id
			and bpc.product_category_id = pc.product_category_id and pl.brand_id in ('".$brands."')
			and p.deleted = '0' and p.disabled = 0 and pl.deleted = '0' and pl.disabled = 0
			and pc.deleted = '0' and pc.disabled = 0 and bpc.deleted = '0' and bpc.disabled = 0
			order by bpc.position");
    
    			
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
  
    	
    	return $return; 

    }

    /**
     * Return product line by brand product category
     *
     * @return string 
     */
    public function getAllVehicleProductCategory($brand = null, $category = null)
    {
        
		$brands = implode("', '", $brand);
		
		/*
		echo "select distinct pc.*, a.hash, bpc.short_descr, bpc.position 
            from product_categories as pc, brand_product_category as bpc, asset as a
			where bpc.product_category_id = pc.product_category_id and bpc.brand_id in ('".$brands."')
			and a.asset_id = pc.asset_id
			and pc.deleted = '0' and pc.disabled = '0' and bpc.deleted = '0' and bpc.disabled = '0'
			order by bpc.position";exit;
		*/
		
    	$foundBrand = $this->prepare("select distinct pc.display_name, pc.group_name, bpc.short_descr, bpc.position 
            from product_categories as pc, brand_product_category as bpc
			where bpc.product_category_id = pc.product_category_id and bpc.brand_id in ('".$brands."')
			and pc.deleted = '0' and pc.disabled = '0' and bpc.deleted = '0' and bpc.disabled = '0'
			order by pc.group_name, bpc.position;");
    	
    			
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
  
    	
    	return $return; 

    }

    /**
     * Return product line by brand product category
     *
     * @return string 
     */
    public function getAllVehicleProductCategoryOrder($brand, $category=null)
    {
		$brands = implode("', '", $brand);
	
    	$foundBrand = $this->prepare("select distinct pc.*, a.hash, bpc.short_descr from product_categories as pc, brand_product_category as bpc,
			 asset as a
			where bpc.product_category_id = pc.product_category_id and bpc.brand_id in ('".$brands."')
			and a.asset_id = pc.asset_id
			and pc.deleted = '0' and pc.disabled = '0' and bpc.deleted = '0' and bpc.disabled = '0'
			order by pc.display_name;");
    	
    			
    	$foundBrand->execute();
    	
    	$return = $foundBrand->fetchAll();
  
    	
    	return $return; 

    }

    /**
     * Return a list of brand product categories for a product category
     *
     * @param  ProductCategoriesInterface            $productCategory
     * @return BrandProductCategoryInterface
     */
    public function getBrandProductCategoryByProductCategory(ProductCategoriesInterface $productCategory)
    {
        return $this->brandProductCategoryRepository->findBy(
            array(
                'productCategory' => $productCategory->getProductCategoryId(),
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return a brand product category record
     *
     * @param BrandsInterface                $brand
     * @param ProductCategoriesInterface     $productCategory
     * @return BrandProductCategoryInterface
     */
    public function getCategoryByBrandAndCategory(ProductCategoriesInterface $productCategory)
    {
        return $this->brandProductCategoryRepository->findOneBy(
            array(
                'productCategory' => $productCategory->getProductCategoryId(),
            )
        );
    }

    /**
     * Return boolean on duplicate check
     *
     * @param  BrandsInterface $brand
     * @param  ProductCategoriesInterface        $productCategory
     * @return boolean
     */
    public function duplicateCheck(BrandsInterface $brand, ProductCategoriesInterface $productCategory)
    {
        return $this->brandProductCategoryRepository->findBy(
            array(
                'brand'  => $brand->getBrandId(),
                'productCategory' => $productCategory->getProductCategoryId(),
            )
        );
    }

    /**
     * Return create brand product category form
     *
     * @return BrandProductCategoryForm
     */
    public function getCreateBrandProductCategoryForm()
    {
        $this->brandProductCategoryForm->bind(clone $this->getBrandProductCategoryPrototype());

        return $this->brandProductCategoryForm;
    }

    /**
     * Return edit brand product category form
     *
     * @param  string               $brandProductCategoryId
     * @return BrandProductCategoryForm
     */
    public function getEditBrandProductCategoryForm($brandProductCategoryId)
    {
        $brandProductCategory = $this->brandProductCategoryRepository->find($brandProductCategoryId);

        $this->brandProductCategoryForm->bind($brandProductCategory);

        return $this->brandProductCategoryForm;
    }

    /**
     * Create a new brand product category relationship
     *
     * @param  BrandsInterface          $brand
     * @param  ProductCategoriesInterface                 $productCategory
     * @param  string                             $createdBy
     * @param  boolean                            $disabled
     * @param  boolean                            $displayStyles
     * @param  boolean                            $featured
     * @param  integer                            $position
     * @param  string                             $shortDescr
     * @param  string                             $longDescr
     * @param  string                             $metaTitle
     * @param  string                             $metakeywords
     * @param  string                             $metaDescr
     * @return null|BrandProductCategoryInterface
     */
    public function create(
        BrandsInterface $brand,
        ProductCategoriesInterface $productCategory,
        $createdBy = null,
        $disabled = null,
        $displayStyles = null,
        $featured = null,
        $position = null,
        $shortDescr = null,
        $longDescr = null,
        $metaTitle = null,
        $metaKeywords = null,
        $metaDescr = null)
    {
        $brandProductCategory = clone $this->getBrandProductCategoryPrototype();
        $brandProductCategory->setBrand($brand)
            ->setProductCategory($productCategory)
            ->setCreatedBy($createdBy)
            ->setDisabled($disabled)
            ->setDisplayStyles($displayStyles)
            ->setFeatured($featured)
            ->setPosition($position)
            ->setShortDescr($shortDescr)
            ->setLongDescr($longDescr)
            ->setMetaTitle($metaTitle)
            ->setMetaKeywords($metaKeywords)
            ->setMetaDescr($metaDescr);

        $this->objectManager->persist($brandProductCategory);
        $this->objectManager->flush();

        return $brandProductCategory;
    }

    /**
     * Flush entitymanager
     */
    public function flushObject()
    {
        $this->objectManager->clear();
    }

    /**
     * Creates a new brand product category.
     *
     * @param  UserInterface                      $identity
     * @param  BrandsInterface                    $brand
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|BrandProductCategoryInterface
     */
    public function createRecord(UserInterface $identity, BrandsInterface $brand, \Zend\Stdlib\Parameters $data)
    {
        $this->brandProductCategoryForm->bind(clone $this->getBrandProductCategoryPrototype());
        $this->brandProductCategoryForm->setData($data);

        if (!$this->brandProductCategoryForm->isValid()) {
            return null;
        }

        $brandProductCategory = $this->brandProductCategoryForm->getData();

        if (!$brandProductCategory instanceof BrandProductCategoryInterface) {
            throw Exception\UnexpectedValueException::invalidBrandProductCategoryEntity($brandProductCategory);
        }

        $brandProductCategory->setBrand($brand)
            ->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($brandProductCategory);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new BrandProductCategoryEvent('brandProductCategoryCreated', $brandProductCategory));

        return $brandProductCategory;
    }

    /**
     * Edit an existing brand product category.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  BrandProductCategoryInterface          $brandProductCategory
     * @throws Exception\UnexpectedValueException
     * @return null|BrandProductCategoryInterface
     */
    public function editRecord(UserInterface $identity, \Zend\Stdlib\Parameters $data, BrandProductCategoryInterface $brandProductCategory)
    {
        $this->brandProductCategoryForm->bind($brandProductCategory);
        $this->brandProductCategoryForm->setData($data);

        if (!$this->brandProductCategoryForm->isValid()) {
            return null;
        }

        $brandProductCategory = $this->brandProductCategoryForm->getData();

        if (!$brandProductCategory instanceof BrandProductCategoryInterface) {
            throw Exception\UnexpectedValueException::invalidBrandProductCategoryEntity($brandProductCategory);
        }

        $brandProductCategory->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new BrandProductCategoryEvent('brandProductCategoryEdited', $brandProductCategory));

        return $brandProductCategory;
    }

    /**
     * Delete an existing brand product category.
     *
     * @param  UserInterface                      $identity
     * @param  BrandProductCategoryInterface          $brandProductCategory
     * @throws Exception\UnexpectedValueException
     * @return null|BrandProductCategoryInterface
     */
    public function delete(UserInterface $identity, BrandProductCategoryInterface $brandProductCategory)
    {
        if (!$brandProductCategory instanceof BrandProductCategoryInterface) {
            throw Exception\UnexpectedValueException::invalidBrandProductCategoryEntity($brandProductCategory);
        }

        $this->objectManager->remove($brandProductCategory);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new BrandProductCategoryEvent('brandProductCategoryDeleted', $brandProductCategory));

        return $brandProductCategory;
    }

    /**
     * @return BrandProductCategoryInterface
     */
    public function getBrandProductCategoryPrototype()
    {
        if ($this->brandProductCategoryPrototype === null) {
            $this->setBrandProductCategoryPrototype(new BrandProductCategory());
        }

        return $this->brandProductCategoryPrototype;
    }

    /**
     * @param  BrandProductCategoryInterface $brandProductCategoryPrototype
     * @return BrandProductCategoryService
     */
    public function setBrandProductCategoryPrototype(BrandProductCategoryInterface $brandProductCategoryPrototype)
    {
        $this->brandProductCategoryPrototype = $brandProductCategoryPrototype;

        return $this;
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
