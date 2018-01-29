<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/com for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Repository;

use LundProducts\Repository\PartsRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;
use RocketUser\Entity\UserInterface;
use LundProducts\Entity\BrandsInterface;
use LundProducts\Entity\PartsInterface;
use LundProducts\Entity\ChangesetDetailsInterface;
use LundProducts\Repository\ChangsetsRepository;
use LundProducts\Entity\ProductLinesInterface;
use LundProducts\Service\ParseMasterService;
use PDO;
use Zend\Log\Logger;
use DateTime;

/**
 * Parts Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class PartsRepository implements PartsRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var PDO
     */
    protected $connection = null;

    /**
     * @var ObjectRepository
     */
    protected $partsRepository;

    /*
     * @var Logger
     */
    protected $logger = null;

    /**
     * @var ParseMasterService
     */
    protected $masterService;

    /**
     * @var ChangesetsRepository
     */
    protected $changesetsRepository;

    /**
     * @param ObjectManager    		$objectManager
     * @param ObjectRepository 		$partsRepository
     * @param ParseMasterService   	$masterService
     * @param PDO          	   		$connection
     */
    public function __construct(
        ObjectManager        	$objectManager,
        ObjectRepository     	$partsRepository,
        PDO    				 	$connection,
        Logger 				 	$logger,
        ChangesetsRepository 	$changesetsRepository,
   		ParseMasterService  	$masterService)
    {
        $this->objectManager        = $objectManager;
        $this->partsRepository      = $partsRepository;
        $this->connection 			= $connection;
        $this->changesetsRepository = $changesetsRepository;
        $this->logger     			= $logger;
        $this->masterService      	= $masterService;
    }

    /**
     * Return all active records
     *
     * @return Parts
     */
    public function findActive($limit = null, $offset = null, $orderBy = array(), $sSearch = null)
    {
        $query = $this->objectManager->createQueryBuilder('r');
        $query = $this->buildQuery($query);

        if (((INT)$limit >= 0) && ((INT)$offset >= 0)) {
            $query->setFirstResult($offset)
                  ->setMaxResults($limit);
        }

        if ($sSearch != null) {
            $query = $this->buildWhere($query, $sSearch);
        }

        if ($orderBy) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $query->getQuery()
                     ->useResultCache(true, 7200, 'parts_find_active')
                     ->getResult();
    }

    /**
     * @param BrandsInterface|null $brand
     * @param int|null             $changeset_id
     * @param string               $lundonly
     * @param string               $generate
     *
     * @return PartsInterface[]
     */
    public function findWebsiteParts($brand = null, $changeset_id = null, $lundonly = null, $generate = null)
    {
        $query = $this->objectManager->createQueryBuilder('r');
        $query = $this->buildQuery($query);

        $forceAnd = null;

        if (null != $brand) {
            // filter by given brand
            if ($brand->getName() == 'LUND' && null == $lundonly) {
            	$query->where('r.disabled=0 AND r.deleted = 0 AND r.status != 55 AND r.productLine IN (SELECT pl2.productLineId FROM LundProducts\Entity\ProductLines pl2 WHERE pl2.brand = (SELECT b.brandId FROM LundProducts\Entity\Brands b WHERE b.name = \'' . $brand->getName() . '\'))');
                $forceAnd = true;
            } else {
            	$query->where('r.disabled=0 AND r.deleted = 0 AND r.status != 55 AND r.productLine IN (SELECT pl2.productLineId FROM LundProducts\Entity\ProductLines pl2 WHERE pl2.origBrand = (SELECT b.brandId FROM LundProducts\Entity\Brands b WHERE b.name = \'' . $brand->getName() . '\'))');
                $forceAnd = true;
            }
        }

        if (null != $changeset_id && null != $generate && $generate != 'full') {
            $changeset            = $this->changesetsRepository->find($changeset_id);
            $changeset_detail_ids = [];

            if ((INT)$changeset_id > 0) {
                foreach ($changeset->getChangesetDetails() as $detail) {
                    $changeset_detail_ids[] = $detail->getChangesetDetailId();
                }

                // generate by changeset_id
                if ($forceAnd) {
                    $query->andWhere('r.partId IN (SELECT pl3.partId FROM LundProducts\Entity\ChangesetDetails pl3 where pl3.changesetDetailId IN (' . implode(',', $changeset_detail_ids) . '))');
                } else {
                    $query->where('r.partId IN (SELECT pl3.partId FROM LundProducts\Entity\ChangesetDetails pl3 where pl3.changesetDetailId IN (' . implode(',', $changeset_detail_ids) . '))');
                }
            }
        }

        $sql = $query->getQuery()
                     ->useResultCache(true, 7200, 'parts_find_aces_'.$brand->getName().'_'.$changeset_id)
                     ->getResult();
        

        //echo $query->__toString();exit;
        
        return $sql;
    }

    /**
     * @param BrandsInterface|null $brand
     * @param int|null             $changeset_id
     * @param string               $lundonly
     * @param string               $generate
     *
     * @return PartsInterface[]
     */
    public function findAcesParts($brand = null, $changeset_id = null, $lundonly = null, $generate = null)
    {
        $query = $this->objectManager->createQueryBuilder('r');
        $query = $this->buildQuery($query);

        $forceAnd = null;

        if (null != $brand) {
            // filter by given brand
            if ($brand->getName() == 'LUND' && null == $lundonly) {
                $query->where('r.disabled=0 AND r.deleted = 0 AND r.productLine IN (SELECT pl2.productLineId FROM LundProducts\Entity\ProductLines pl2 WHERE pl2.brand = (SELECT b.brandId FROM LundProducts\Entity\Brands b WHERE b.name = \'' . $brand->getName() . '\'))');
                $forceAnd = true;
            } else {
                $query->where('r.disabled=0 AND r.deleted = 0 AND r.productLine IN (SELECT pl2.productLineId FROM LundProducts\Entity\ProductLines pl2 WHERE pl2.origBrand = (SELECT b.brandId FROM LundProducts\Entity\Brands b WHERE b.name = \'' . $brand->getName() . '\'))');
                $forceAnd = true;
            }
        }

        if (null != $changeset_id && null != $generate && $generate != 'full') {
            $changeset            = $this->changesetsRepository->find($changeset_id);
            $changeset_detail_ids = [];

            if ((INT)$changeset_id > 0) {
                foreach ($changeset->getChangesetDetails() as $detail) {
                    $changeset_detail_ids[] = $detail->getChangesetDetailId();
                }

                // generate by changeset_id
                if ($forceAnd) {
                    $query->andWhere('r.partId IN (SELECT pl3.partId FROM LundProducts\Entity\ChangesetDetails pl3 where pl3.changesetDetailId IN (' . implode(',', $changeset_detail_ids) . '))');
                } else {
                    $query->where('r.partId IN (SELECT pl3.partId FROM LundProducts\Entity\ChangesetDetails pl3 where pl3.changesetDetailId IN (' . implode(',', $changeset_detail_ids) . '))');
                }
            }
        }

        $sql = $query->getQuery()
                     ->useResultCache(true, 7200, 'parts_find_aces_'.$brand->getName().'_'.$changeset_id)
                     ->getResult();
        

        //echo $query->__toString();exit;
        
        return $sql;
    }

    /*
     * @return mixed
     */
    public function buildQuery($query)
    {
        $query->select(array('r', 'pl'))
              ->from('LundProducts\Entity\Parts', 'r')
              ->where('r.deleted = false')
              ->where('r.disabled = false')
              ->leftJoin('r.productLine', 'pl');

        return $query;
    }

    /*
     * @return mixed
     */
    public function buildWhere($query = null, $sSearch = null)
    {
        $query->where(
            $query->expr()->orX(
                $query->expr()->like('r.partNumber', '?1'),
                $query->expr()->like('r.partVariant', '?1'),
                $query->expr()->like('r.msrpPrice', '?1'),
                $query->expr()->like('pl.name', '?1')
            )
        )->setParameter(1, '%' . $sSearch . '%');

        return $query;
    }

    /**
     * return total rows in parts table, for datatables JSON pagination primarily
     *
     * @return mixed
     */
    public function getTotalRows($sSearch = null)
    {
        $query = $this->objectManager->createQueryBuilder();
        $query = $this->buildQuery($query);
        $query->add('select', 'COUNT(r.partId)');

        if (null != $sSearch) {
            $query = $this->buildWhere($query, $sSearch);
        }

        return $query->getQuery()
                     ->useResultCache(true, 7200, 'parts_get_total_rows')
                     ->getSingleScalarResult();
    }

    /*
     * Update existing Parts Status
     *
     * @param  PartsInterface            $part
     * @param  ChangesetDetailsInterface $details
     * @param  array                     $rowData
     * @return null|PartsInterface
     */
    public function editStatus(
        PartsInterface            $part,
        ChangesetDetailsInterface $details,
        $rowData = array())
    {
        $part->setModifiedAt(new DateTime('now'))
             ->setModifiedBy('system')
             ->setStatus(trim($rowData[34]));

        $this->objectManager->flush();
        
        $updateStatus = 'UPDATE parts set status = "'. trim($rowData[34]) .
        				'", modified_by =  "system", modified_at =  now()
        				where part_id = '. $part->getPartId();
        
        $updatePartStatus = $this->prepare($updateStatus);
        $updatePartStatus->execute();

        return $part;
    }

    /*
     * Update existing Parts Country
     *
     * @param  PartsInterface            $part
     * @param  ChangesetDetailsInterface $details
     * @param  array                     $rowData
     * @return null|PartsInterface
     */
    public function editCountry(
        PartsInterface            $part,
        ChangesetDetailsInterface $details,
        $rowData = array())
    {
        $part->setModifiedAt(new DateTime('now'))
             ->setModifiedBy('system')
             ->setCountryOfOrigin(trim($rowData[31]));

        $this->objectManager->flush();
        
        $updateCountry = 'UPDATE parts set country_of_origin = "'. trim($rowData[31]) .
        				 '", modified_by =  "system", modified_at =  now()
        				 where part_id = '. $part->getPartId();
        
        $updatePartCountry = $this->prepare($updateCountry);
        $updatePartCountry->execute();

        return $part;
    }

    /*
     * Update existing Parts Pop
     *
     * @param  PartsInterface            $part
     * @param  ChangesetDetailsInterface $details
     * @param  array                     $rowData
     * @return null|PartsInterface
     */
    public function editPop(
        PartsInterface            $part,
        ChangesetDetailsInterface $details,
        $rowData = array())
    {
        $part->setModifiedAt(new DateTime('now'))
             ->setModifiedBy('system')
             ->setPopCode(trim($rowData[17]));

        $this->objectManager->flush();
        

        $updatePop = 'UPDATE parts set pop_code = "'. trim($rowData[17]) .
        		'", modified_by =  "system", modified_at =  now()
        		where part_id = '. $part->getPartId();

        $updatePartPop = $this->prepare($updatePop);
        $updatePartPop->execute();

        return $part;
    }

    /*
     * Update existing Parts Color
     *
     * @param  PartsInterface            $part
     * @param  ChangesetDetailsInterface $details
     * @param  array                     $rowData
     * @return null|PartsInterface
     */
    public function editColor(
        PartsInterface            $part,
        ChangesetDetailsInterface $details,
        $rowData = array())
    {
        $part->setModifiedAt(new DateTime('now'))
             ->setModifiedBy('system')
             ->setColor(trim($rowData[24]));

        $this->objectManager->flush();
        
        $updateColor = 'UPDATE parts set color = "'. trim($rowData[24]) .
        '", modified_by =  "system", modified_at =  now()
        		where part_id = '. $part->getPartId();
        
        $updatePartColor = $this->prepare($updateColor);
        $updatePartColor->execute();

        return $part;
    }

    /*
     * Update existing Parts Dimensions
     *
     * @param  PartsInterface            $part
     * @param  ChangesetDetailsInterface $details
     * @param  array                     $rowData
     * @return null|PartsInterface
     */
    public function editDimensions(
        PartsInterface            $part,
        ChangesetDetailsInterface $details,
        $rowData = array())
    {
        $part->setModifiedAt(new DateTime('now'))
             ->setModifiedBy('system')
             ->setDima(trim($rowData[38]))
             ->setDimb(trim($rowData[39]))
             ->setDimc(trim($rowData[40]))
             ->setDimd(trim($rowData[41]))
             ->setDime(trim($rowData[42]))
             ->setDimf(trim($rowData[43]))
             ->setDimg(trim($rowData[44]))
             ->setWeight(trim($rowData[19]))
             ->setHeight(trim($rowData[20]))
             ->setWidth(trim($rowData[21]))
             ->setLength(trim($rowData[22]));

        $this->objectManager->flush();
        
        $updateDimensions = 'UPDATE parts set dima = "'. trim($rowData[38]) .
        					'", dimb = "'. trim($rowData[39]) .
        					'", dimc = "'. trim($rowData[40]) .
        					'", dimd = "'. trim($rowData[41]) .
        					'", dime = "'. trim($rowData[42]) .
        					'", dimf = "'. trim($rowData[43]) .
        					'", dimg = "'. trim($rowData[44]) .
        					'", weight = "'. trim($rowData[19]) .
        					'", height = "'. trim($rowData[20]) .
        					'", width = "'. trim($rowData[21]) .
        					'", length = "'. trim($rowData[22]) .
        					'", modified_by =  "system", modified_at =  now()
        					where part_id = '. $part->getPartId();
        
        //$this->logger->info($updateDimensions);
        
        $updatePartDimensions = $this->prepare($updateDimensions);
        $updatePartDimensions->execute();

        return $part;
    }

    /*
     * Update existing Parts item class
     *
     * @param  PartsInterface            $part
     * @param  ChangesetDetailsInterface $details
     * @param  ProductLinesInterface     $productLine
     * @param  array                     $rowData
     * @return null|PartsInterface
     */
    public function editClass(
        PartsInterface $part,
        ChangesetDetailsInterface $details,
        ProductLinesInterface $productLine,
        $rowData = array())
    {
    	// not found, create it, cache it
    	if(strpos(trim($rowData[5]), "/"))
    	{
    		$cleaned_product_category_name = str_replace("/", "-", trim($rowData[5]));
    	}
    	else
    	{
    		$cleaned_product_category_name = trim($rowData[5]);
    	}
    	
    	// find out if product_category exists by short_code, create it if not, cache
    	$foundProductCategory = $this->masterService->findProductCategory($rowData[5]);
    	
    	if (null != $foundProductCategory) {
    		// cache it
    	} else {
    		$foundProductCategory = $this->masterService->insertProductCategory(
                date('Y-m-d H:i:s'), 0, 1,
                trim($rowData[4]),
                trim($rowData[5]),
                $cleaned_product_category_name
    		);
    	}
    	
    	// create it, cache it
    	if(strpos(trim($rowData[3]), "/"))
    	{
    		$cleaned_product_line_name = str_replace("/", "-", trim($rowData[3]));
    	}
    	else
    	{
    		$cleaned_product_line_name = trim($rowData[3]);
    	}
    	
    	
    	/*
    	
    	$productLine->setModifiedAt(new DateTime('now'))
    				->setModifiedBy('system')
    				->setName($cleaned_product_line_name)
    				->setDisplayname($cleaned_product_line_name)
    				->setShortCode($cleaned_product_line_name)
    				->setBpcsCode(trim($rowData[2])
    				->setProductCategory((object) $foundProductCategory));
    				

    	$this->objectManager->flush();
    	*/
    	
    	$updateClass = 'UPDATE product_lines set modified_by =  "system", modified_at =  now()
    					, name = "'. $cleaned_product_line_name .
    					'", short_code = "'. $cleaned_product_line_name .
    					'", bpcs_code = "'. trim($rowData[2]) .
    					'", product_category_id = "'. $foundProductCategory['product_category_id'] .
        			    '" where product_line_id = '. $productLine->getProductLineId();
    	
    	
    	$updatePartClass = $this->prepare($updateClass);
    	$updatePartClass->execute();
    	
    	
    	/*
    	
        $part->setModifiedAt(new DateTime('now'))
            ->setModifiedBy('system')
            ->setProductLine($productLine);
        
        $this->objectManager->flush();

       
        $updateClass = 'UPDATE parts set product_line_id = "'. $productLine->getProductLineId() .
        			   '", modified_by =  "system", modified_at =  now()
        			   where part_id = '. $part->getPartId();
        
        $updatePartClass = $this->prepare($updateClass);
        $updatePartClass->execute();
*/
        return $productLine;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                 $id
     * @return PartsInterface|null
     */
    public function find($id)
    {
        return $this->partsRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return PartsInterface[]
     */
    public function findAll()
    {
        return $this->partsRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array            $criteria
     * @param  array|null       $orderBy
     * @param  int|null         $limit
     * @param  int|null         $offset
     * @return PartsInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->partsRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array               $criteria
     * @return PartsInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->partsRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->partsRepository->getClassName();
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
    public function getLogger()
    {
        return $this->logger;
    }
    
    public function findYear($category=null, $productLine=null)
    {
	
        /*
        echo "select distinct veh_year.name from veh_collection
        LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
        LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
        LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
        LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
        LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
        where product_categories.display_name= '$category'
        ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
			order by name desc";exit;
    	*/
    	
    	
    	$foundMakeCollection = $this->prepare("select distinct veh_year.name from veh_collection
			LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
			LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
			LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
			LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
			LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id 
			where product_lines.disabled = '0'
    		and product_lines.deleted = '0'
            and product_categories.disabled = '0'
            and product_categories.deleted = '0'
    	    ".(($category== '')? '' : "and product_categories.display_name= '$category'" )."
    		".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
			order by name desc");
    	
    	$foundMakeCollection->execute();
    	
    	return $foundMakeCollection->fetchAll();
    }
    
    public function findByYear($year, $category=null, $productLine=null)
    {
        /*
        echo "select distinct veh_make.name from veh_collection
			LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
			LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
			LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
			LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
			LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
			LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
			where product_lines.disabled = '0'
    		and product_lines.deleted = '0'
            and product_categories.disabled = '0'
            and product_categories.deleted = '0'
    		".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
			and veh_year.name = '". $year ."'
			order by name";exit;
		*/	
        
    	$foundMakeCollection = $this->prepare("select distinct veh_make.name from veh_collection
			LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
			LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
			LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
			LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
			LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
			LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id 
			where product_lines.disabled = '0'
    		and product_lines.deleted = '0'
            and product_categories.disabled = '0'
            and product_categories.deleted = '0'
    		".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
			and veh_year.name = '". $year ."'
			order by name");
    	
    	$foundMakeCollection->execute();
    	
    	return $foundMakeCollection->fetchAll();
    }
    
    public function findByYearMake($brand, $year, $make, $category, $productLine=null)
    {
    	
    	$foundModelCollection = $this->prepare("select distinct veh_model.name from veh_collection
			LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
			LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
			LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
			LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
			LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
			LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
			LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
			where product_lines.brand_id in ('". $brand ."')
    		and product_lines.disabled = '0'
    		and product_lines.deleted = '0'
            and product_categories.disabled = '0'
            and product_categories.deleted = '0'
    		".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
			and veh_year.name = '". $year ."'
			and veh_make.name = '". $make ."'
			order by name");
    	 
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findMake()
    {
        
        $foundMakeCollection = $this->prepare("select distinct * from 
            veh_make where name is not null order by name ");
        
        $foundMakeCollection->execute();
        
        return $foundMakeCollection->fetchAll();
    }
    
    public function findModel($make)
    {
        
        $foundMakeCollection = $this->prepare("select distinct veh_model.* from veh_model, veh_make 
            where veh_model.veh_make_id = veh_make.veh_make_id 
            and veh_make.name='". $make."' order by name;");
        
        $foundMakeCollection->execute();
        
        return $foundMakeCollection->fetchAll();
    }
    
    public function findModelByYearMake($model, $make)
    {
        
        $foundModelCollection = $this->prepare("select *
			from veh_model 
            where veh_make_id = '". $make[0]->getVehMakeId()."'
			and name = '". $model."'");
        
        $foundModelCollection->execute();
        
        return $foundModelCollection->fetchAll();
    }
    
    public function findModelSubmodelByYearMake($year, $make, $category, $productLine=null)
    {
    	/*
        echo "select distinct veh_model.name, veh_submodel.name as submodel  from veh_collection
			LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
			LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
			LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
			LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
			LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
			LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
			LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
			LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
			where product_lines.disabled = '0'
    		and product_lines.deleted = '0'
            and product_categories.disabled = '0'
            and product_categories.deleted = '0'
    		".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
			and veh_year.name = '". $year ."'
			and veh_make.name = '". $make ."'
			order by name";exit;
    	*/
    	
    	$foundModelCollection = $this->prepare("select distinct veh_model.name, veh_submodel.name as submodel  from veh_collection
			LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
			LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
			LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
			LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
			LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
			LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
			LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
			LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
			where product_lines.disabled = '0'
    		and product_lines.deleted = '0'
            and product_categories.disabled = '0'
            and product_categories.deleted = '0'
    		".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
			and veh_year.name = '". $year ."'
			and veh_make.name = '". $make ."'
			order by name");
    	 
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findInstallationsByYearMakeModel($year, $make, $model)
    {
        
        /*
        echo "select distinct parts.part_number, parts.isheet, product_lines.display_name as PLname, product_categories.display_name as PCname from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id in ('". $brand ."')
    			".(($submodel == '')? '' : "and veh_submodel.name = '$submodel'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
				and veh_model.name = '". $model ."'
				order by part_number";exit;
    	*/
        
    	
    	$foundModelCollection = $this->prepare("select distinct parts.part_number, parts.isheet, product_lines.display_name as PLname, product_categories.display_name as PCname from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id				
				where product_lines.disabled = '0'
        		and product_lines.deleted = '0'
                and product_categories.disabled = '0'
                and product_categories.deleted = '0'
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
				and veh_model.name = '". $model ."'
				order by part_number");
    	 
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findInstallationsByPart($part)
    {
    	/*
        echo "select distinct parts.part_number, parts.isheet, product_lines.display_name as PLname, product_categories.display_name as PCname from parts
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where parts.part_number = '". $part ."'
				order by part_number";exit;
    	*/
    	
    	$foundModelCollection = $this->prepare("select distinct parts.part_number, parts.isheet, product_lines.display_name as PLname, product_categories.display_name as PCname from parts				
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id				
				where parts.part_number = '". $part ."'
				order by part_number");
    	 
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findByYearMakeModel($brand, $year, $make, $model, $category)
    {
    	/*
    	echo "select distinct body_type as name from veh_collection
			LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
			LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
			LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
			LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
			LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
			LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
			LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
			where product_lines.brand_id = '". $brand ."'
    		".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
			and veh_year.name = '". $year ."'
			and veh_make.name = '". $make ."'
			and veh_model.name = '". $model ."'
			order by body_type";exit;
    	*/
    	
    	$foundModelCollection = $this->prepare("select distinct body_type as name from veh_collection
			LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
			LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
			LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
			LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
			LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
			LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
			LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
			where product_lines.brand_id = '". $brand ."'
    		".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
			and veh_year.name = '". $year ."'
			and veh_make.name = '". $make ."'
			and veh_model.name = '". $model ."'
			order by body_type");
    	 
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findByYearMakeModelBody($brand, $year, $make, $model, $bodyType, $category)
    {
    	if($bodyType == 'NO BODY TYPE')
    	{
    		/*
	    	$foundModelCollection = $this->prepare("select distinct parts.color as name from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
			LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id = '". $brand ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
				and veh_model.name = '". $model ."'
				order by name");
	    	*/
    	} else {
    		
    		$foundModelCollection = $this->prepare("select distinct parts.color as name from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id = '". $brand ."'
    			".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
				and veh_model.name = '". $model ."'
				and body_type = '". $bodyType ."'
				order by name");
    		
    	}
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findVehBedLength($year, $make, $model, $subModel=null, $category=null, $productLine=null )
    {
    	/*
        echo "select distinct parts.bed_length from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where veh_year.name = '". $year ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
				and veh_model.name = '". $model ."'";exit;
			*/
    	
	    	$foundModelCollection = $this->prepare("select distinct parts.bed_length from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where veh_year.name = '". $year ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."				
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
				and veh_model.name = '". $model ."'");
	    	
    	
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findVehBodyType($year, $make, $model, $subModel=null, $bedLength=null, $category=null, $productLine=null)
    {
    	/*
        echo "select distinct veh_collection.body_type from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id in ('". $brand ."')
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
				and veh_model.name = '". $model ."'";exit;
    	*/
    	
	    	$foundModelCollection = $this->prepare("select distinct veh_collection.body_type from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where veh_year.name = '". $year ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
				and veh_model.name = '". $model ."'");
	    	
    	
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findSoldAs($year, $make, $model, $subModel=null, $bedLength=null, $bodyType=null, $category=null, $productLine=null)
    {
    	/*
    	echo "select distinct parts.sold_as from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id in ('". $brand ."')
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
    		    ".(($bodyType == '')? '' : "and veh_collection.body_type = '$bodyType'" )."
				and veh_model.name = '". $model ."'";exit;
    		*/
    	
	    	$foundModelCollection = $this->prepare("select distinct parts.sold_as from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where veh_year.name = '". $year ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
    		    ".(($bodyType == '')? '' : "and veh_collection.body_type = '$bodyType'" )."
				and veh_model.name = '". $model ."'");
	    	
    	
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findFinish($year, $make, $model, $subModel=null, $bedLength=null, $bodyType=null, $soldAs=null, $category=null, $productLine=null)
    {
        /*
         echo "select distinct parts.finish from veh_collection
         LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
         LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
         LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
         LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
         LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
         LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
         LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
         LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
         where product_lines.brand_id in ('". $brand ."')
         ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
         ".(($productLine == '')? '' : "and product_lines.name= '$productLine'" )."
         and veh_year.name = '". $year ."'
         and veh_make.name = '". $make ."'
         ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
         ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
         ".(($bodyType == '')? '' : "and veh_collection.body_type = '$bodyType'" )."
         ".(($soldAs == '' || $soldAs == 'NULL')? '' : "and parts.sold_as = '$soldAs'" )."
         and veh_model.name = '". $model ."'";exit;
         */
         
        $foundModelCollection = $this->prepare("select distinct parts.finish from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where veh_year.name = '". $year ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
    		    ".(($bodyType == '')? '' : "and veh_collection.body_type = '$bodyType'" )."
    		    ".(($soldAs == '' || $soldAs == 'NULL')? '' : "and parts.sold_as = '$soldAs'" )."
				and veh_model.name = '". $model ."'");
        
        
        $foundModelCollection->execute();
        
        return $foundModelCollection->fetchAll();
    }
    
    public function findColor($year, $make, $model, $subModel=null, $bedLength=null, $bodyType=null, $soldAs=null, $finish=null, $category=null, $productLine=null)
    {
    	/*
    	echo "select distinct parts.color from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id in ('". $brand ."')
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
    		    ".(($bodyType == '')? '' : "and veh_collection.body_type = '$bodyType'" )."
    		    ".(($soldAs == '' || $soldAs == 'NULL')? '' : "and parts.sold_as = '$soldAs'" )."
    		    ".(($finish== '' || $finish== 'NULL')? '' : "and parts.finish = '$finish'" )."
				and veh_model.name = '". $model ."'";
    	*/
//    	exit;
    		
        
	    	$foundModelCollection = $this->prepare("select distinct parts.color from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where veh_year.name = '". $year ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
    		    ".(($bodyType == '')? '' : "and veh_collection.body_type = '$bodyType'" )."
    		    ".(($soldAs == '' || $soldAs == 'NULL')? '' : "and parts.sold_as = '$soldAs'" )."
    		    ".(($finish== '' || $finish== 'NULL')? '' : "and parts.finish = '$finish'" )."
				and veh_model.name = '". $model ."'");
	    	
    	
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    


    public function findPartId($year, $make, $model, $subModel=null, $bedLength=null, $bodyType=null, $soldAs=null, $finish=null, $color=null, $category=null, $productLine=null)
    {
    	
    /*
        echo "select distinct parts.*, part_veh_collection.subdetail, product_lines.installation_video, brands.name as brand_name from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN brands on brands.brand_id = product_lines.brand_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where parts.disabled = '0'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
                and parts.deleted = '0'
                and product_lines.disabled = '0'
                and product_lines.deleted = '0'
    		    ".(($subModel == '')? "and veh_collection.veh_submodel_id is null" : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
    		    ".(($bodyType == '')? '' : "and veh_collection.body_type = '$bodyType'" )."
    		    ".(($soldAs == '' || $soldAs == 'NULL')? '' : "and parts.sold_as = '$soldAs'" )."
    		    ".(($finish == '' || $finish== 'NULL')? '' : "and parts.finish = '$finish'" )."
    		    ".(($color == '' || $color == 'NULL')? '' : "and parts.color = '$color'" )."
				and veh_model.name = '". $model ."'";exit;
    	*/
    	
    	$foundModelCollection = $this->prepare("select distinct parts.*, part_veh_collection.subdetail, product_lines.installation_video, brands.name as brand_name from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN brands on brands.brand_id = product_lines.brand_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where parts.disabled = '0'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
    		    ".(($productLine == '')? '' : "and product_lines.display_name= '$productLine'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
                and parts.deleted = '0'
                and product_lines.disabled = '0'
                and product_lines.deleted = '0'
    		    ".(($subModel == '')? "and veh_collection.veh_submodel_id is null" : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
    		    ".(($bodyType == '')? '' : "and veh_collection.body_type = '$bodyType'" )."
    		    ".(($soldAs == '' || $soldAs == 'NULL')? '' : "and parts.sold_as = '$soldAs'" )."
    		    ".(($finish == '' || $finish== 'NULL')? '' : "and parts.finish = '$finish'" )."
    		    ".(($color == '' || $color == 'NULL')? '' : "and parts.color = '$color'" )."
				and veh_model.name = '". $model ."'");
    
    	 
    	$foundModelCollection->execute();
    
    	return $foundModelCollection->fetchAll();
    }
    
    public function findWebsitePartId($partId)
    {
    	
   /*
    	echo "select distinct veh_year.name as 'year', veh_make.name as 'make', veh_model.name as 'model', veh_submodel.name as 'submodel', part_veh_collection.subdetail as 'subdetail', veh_collection.body_type as 'bodyType', parts.bed_length as 'bedLength' 
				from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				where parts.part_id = '". $partId ."'
                order by  make, model, year;";exit;
    	*/
    	
    	$foundModelCollection = $this->prepare("select distinct veh_year.name as 'year', veh_make.name as 'make', veh_model.name as 'model', veh_submodel.name as 'submodel', part_veh_collection.subdetail as 'subdetail', veh_collection.body_type as 'bodyType', parts.bed_length as 'bedLength' 
				from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				where parts.part_id = '". $partId ."'
                order by  make, model, year;");
    
    	 
    	$foundModelCollection->execute();
    
    	return $foundModelCollection->fetchAll();
    }
    
    public function findVehBedType($brand, $year, $make, $model, $subModel=null, $category=null, $bedLength=null)
    {
    /*
    	echo "select distinct parts.bed_length from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id = '". $brand ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
				and veh_model.name = '". $model ."'";
		*/				
    	$foundModelCollection = $this->prepare("select distinct parts.bed_type from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id = '". $brand ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
    		    ".(($subModel == '')? '' : "and veh_submodel.name = '$subModel'" )."
    		    ".(($bedLength == '')? '' : "and parts.bed_length = '$bedLength'" )."
				and veh_model.name = '". $model ."'");
    
    	 
    	$foundModelCollection->execute();
    
    	return $foundModelCollection->fetchAll();
    }
    
    public function findSubModelByYearMakeModel($brand, $year, $make, $model, $category)
    {
    		
	    	$foundModelCollection = $this->prepare("select distinct veh_submodel.name as name from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id = '". $brand ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
				and veh_model.name = '". $model ."' 
	    		order by name");
	    	
    	
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findcolorByYearMakeModelSubmodel($brand, $year, $make, $model, $category, $submodel)
    {
    	if($submodel == 'All Sub Models')
    	{
	    	$foundModelCollection = $this->prepare("select distinct parts.color as name from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id = '". $brand ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
				and veh_model.name = '". $model ."'
				order by name");
    	} else {
    		$foundModelCollection = $this->prepare("select distinct parts.color as name from veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id
				LEFT JOIN veh_submodel on veh_submodel.veh_submodel_id = veh_collection.veh_submodel_id
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id
				where product_lines.brand_id = '". $brand ."'
    		    ".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
				and veh_model.name = '". $model ."'
				and veh_submodel.name = '". $model ."'
				order by name");
    	}
	    	
    	
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    public function findAllByYearMakeModelBody($brand, $year, $make, $model, $bodyType, $category)
    {
    	if($bodyType == 'NO BODY TYPE')
    	{
    	
    		
	    	$foundModelCollection = $this->prepare("select 
					distinct parts.part_id as part_id, parts.color as color, parts.part_number as part_number, product_lines.saleable as saleable, product_lines.display_name as productLine_display_name, product_categories.display_name as productCategories_display_name
				from 
					veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id 
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id 
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id 
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id 
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id 
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id 
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id 
	    		where product_lines.brand_id = '". $brand ."'
    			".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
				and veh_model.name = '". $model ."'
				order by color");
	    	
    	} else {
    		
    		
    		
    		$foundModelCollection = $this->prepare("select 
					distinct parts.part_id as part_id, parts.color as color, parts.part_number as part_number, product_lines.saleable as saleable, product_lines.display_name as productLine_display_name, product_categories.display_name as productCategories_display_name
				from 
					veh_collection
				LEFT JOIN veh_year on veh_year.veh_year_id = veh_collection.veh_year_id 
				LEFT JOIN veh_make on veh_make.veh_make_id = veh_collection.veh_make_id 
				LEFT JOIN veh_model on veh_model.veh_model_id = veh_collection.veh_model_id 
				LEFT JOIN part_veh_collection on part_veh_collection.veh_collection_id = veh_collection.veh_collection_id 
				LEFT JOIN parts on part_veh_collection.part_id = parts.part_id 
				LEFT JOIN product_lines on parts.product_line_id = product_lines.product_line_id 
				LEFT JOIN product_categories on product_categories.product_category_id = product_lines.product_category_id 			
				where product_lines.brand_id = '". $brand ."'
    			".(($category == '')? '' : "and product_categories.display_name= '$category'" )."
				and veh_year.name = '". $year ."'
				and veh_make.name = '". $make ."'
				and veh_model.name = '". $model ."'
				and body_type = '". $bodyType ."'
				order by color");
    		
    	}
    	$foundModelCollection->execute();
    	 
    	return $foundModelCollection->fetchAll();
    }
    
    
    public function findCountryId($name)
    {
            
        $foundCountryId= $this->prepare("select * from country where name = '" . $name . "'");
            
        
        $foundCountryId->execute();
        
        return $foundCountryId->fetchAll();
    }
    
    
    public function findStateId($country, $state)
    {
        
        echo "select * from state where code_char3 = '" . $country. "' and subdivision_name = '" . $state. "'";exit;
        $foundStateId= $this->prepare("select * from state where code_char3 = '" . $country. "' and subdivision_name = '" . $state. "'");
        
        
        $foundStateId->execute();
        
        return $foundStateId->fetchAll();
    }
    
    
    public function findState($state)
    {
        
        $foundStateId= $this->prepare("select * from state where state_id = '" . $state. "'");
        
        
        $foundStateId->execute();
        
        return $foundStateId->fetchAll();
    }
    
}
