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
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\Parts;
use LundProducts\Entity\PartsInterface;
use LundProducts\Entity\BrandsInterface;
use LundProducts\Repository\PartsRepositoryInterface;
use LundProducts\Entity\ProductLinesInterface;
use RocketUser\Entity\User;
use DateTime;

/*
 * Service managing the CRUD of brands.
 */
class PartService implements EventManagerAwareInterface
{
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

    /**
     * @var PartsForm
     */
    protected $partsForm;

    /**
     * @var PartsInterface
     */
    protected $partsPrototype;

    /**
     * @param ObjectManager            $objectManager
     * @param PartsRepositoryInterface $repository
     * @param FormInterface            $partsForm
     */
    public function __construct(
        ObjectManager             $objectManager,
        PartsRepositoryInterface  $repository,
        FormInterface             $partsForm
    )
    {
        $this->objectManager = $objectManager;
        $this->repository    = $repository;
        $this->partsForm     = $partsForm;
    }

    /**
     * Return count of active parts
     *
     * @return integer
     */
    public function getCount()
    {
        $dql = 'SELECT COUNT(p) FROM LundProducts\Entity\Parts p WHERE p.deleted = :deleted';
        $q = $this->objectManager->createQuery($dql);
        $q->setParameters(array('deleted' => 0));

        return $q->getSingleScalarResult();
    }
    
    /**
     * Return view PartForm
     *
     * @param  string   $partId
     * @return PartForm
     */
    public function getViewPartForm($partId)
    {
        $part = $this->repository->find($partId);

        $this->partsForm->bind($part);

        return $this->partsForm;
    }

    /**
     * Return create PartForm
     *
     * @return PartForm
     */
    public function getCreatePartForm()
    {
        $this->partsForm->bind(clone $this->getPartsPrototype());

        return $this->partsForm;
    }

    /**
     * Return edit PartForm
     *
     * @param  string   $partId
     * @return PartForm
     */
    public function getEditPartForm($partId)
    {
        $part = $this->repository->find($partId);

        $this->partsForm->bind($part);

        return $this->partsForm;
    }

    /**
     * @return PartsInterface
     */
    public function getPartsPrototype()
    {
        if ($this->partsPrototype === null) {
            $this->setPartsPrototype(new Parts());
        }

        return $this->partsPrototype;
    }

    /**
     * @param  PartsInterface $partsPrototype
     * @return PartService
     */
    public function setPartsPrototype(PartsInterface $partsPrototype)
    {
        $this->partsPrototype = $partsPrototype;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActiveParts($limit = null, $offset = null, $orderBy = array(), $sSearch = null)
    {
        return $this->repository->findActive($limit, $offset, $orderBy, $sSearch);
    }

    /*
     * @return mixed
     */
    public function getPartsByProductLine(ProductLinesInterface $productLine)
    {
        return $this->repository->findBy(
            array(
                'deleted' => false,
                'disabled' => false,
                'productLine' => $productLine->getProductLineId(),
            ),
            array(
                'partNumber' => 'ASC',
            )
        );
    }

    /**
     * @return mixed
     */
    public function getUniversalPartsByProductLine(ProductLinesInterface $productLine)
    {
        return $this->repository->findBy(
            array(
                'deleted' => false,
                'disabled' => false,
                'universal' => true,
                'productLine' => $productLine->getProductLineId(),
            ),
            array(
                'partNumber' => 'ASC',
            )
        );
    }

    /**
     * @return mixed
     */
    public function getUniversalParts($modelType = null)
    {
    	switch($modelType)
    	{
    		case 'C':
    			$universalPart[] = 'M';
    			$universalPart[] = 'C';
    			break;
    		
    		case 'H':
    			$universalPart[] = 'M';
    			$universalPart[] = 'H';
    			break;
    			
    		case 'S':
    			$universalPart[] = 'M';
    			$universalPart[] = 'L';
    			$universalPart[] = 'S';
    			break;
    			
    		case 'T':
    			$universalPart[] = 'M';
    			$universalPart[] = 'L';
    			$universalPart[] = 'T';
    			break;  
    			
    		case 'U':
    			$universalPart[] = 'M';
    			$universalPart[] = 'U';
    			break;
    			
    		case 'V':
    			$universalPart[] = 'M';
    			$universalPart[] = 'V';
    			break;   			
    	}
    	
	  	$query = $this->repository->findBy(
	   		array(
	         	'deleted' => false,
	         	'disabled' => false,
	           	'universal' => true,
	           	'vehicleType' => $universalPart,
	      	),
	      	array(
	          	'partNumber' => 'ASC',
	      	)
	  	);
	       
        return $query;
    }

    /**
     * @param BrandsInterface $brand
     * @param string          $generate
     * @param int             $changeset_id
     * @param string          $lundonly
     */
    public function getWebsiteParts(
        $brand        = null,
        $generate     = null,
        $changeset_id = null,
        $lundonly     = null
    )
    {
        return $this->repository->findWebsiteParts($brand, $changeset_id, $lundonly, $generate);
    }

    /**
     * @param BrandsInterface $brand
     * @param string          $generate
     * @param int             $changeset_id
     * @param string          $lundonly
     */
    public function getAcesParts(
        $brand        = null,
        $generate     = null,
        $changeset_id = null,
        $lundonly     = null
    )
    {
        return $this->repository->findAcesParts($brand, $changeset_id, $lundonly, $generate);
    }

    /**
     * @param BrandsInterface $brand
     * @param string          $generate
     * @param int             $changeset_id
     */
    public function getPartsForImages(
        $brand        = null,
        $generate     = null,
        $changeset_id = null,
        $lundonly     = null
    )
    {
        return $this->repository->findAcesParts($brand, $changeset_id, $lundonly);
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getPart($recordId)
    {
        return $this->repository->find($recordId);
    }

    /**
     * @param string $lookupNumber
     *
     * @return mixed
     */
    public function getPartByLookupNumber($lookupNumber)
    {
    	$part = $this->repository->findOneBy(
    			array(
    					'deleted' => false,
    					'disabled' => false,
    					'lookupNumber' => $lookupNumber,
    			));
    	 
    	return $part;
        //return $this->repository->findOneBy(array('lookupNumber' => $lookupNumber));
    }

    /**
     * @param string $partNumber
     *
     * @return mixed
     */
    public function getPartByPartNumber($partNumber)
    {
    	$part = $this->repository->findOneBy(
    			array(
    					'deleted' => false,
    					'disabled' => false,
    					'partNumber' => $partNumber,
    			));
    	
    	return $part;
        //return $this->repository->findOneBy(array('partNumber' => $partNumber));
    }

    /**
     * @param \Admin\Entity\Parts $recordEntity
     * @param \Admin\Entity\User  $usersEntity
     *
     * @return \Admin\Entity\Parts $recordEntity
     */
    public function createPart(Parts $recordEntity, User $usersEntity)
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
     * @param \Admin\Entity\Parts $recordEntity
     * @param \Admin\Entity\User  $usersEntity
     *
     * @return \Admin\Entity\Parts $recordEntity
     */
    public function editPart(Parts $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername());
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \Admin\Entity\Parts $recordEntity
     * @param \Admin\Entity\User  $usersEntity
     *
     * @return \Admin\Entity\Parts $recordEntity
     */
    public function deletePart(Parts $recordEntity, User $usersEntity)
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
     * @param Parts $recordEntity
     * @param User  $usersEntity
     *
     * @return Parts $recordEntity
     */
    public function disablePart(Parts $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername())
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
        $cacheDriver->delete('parts_find_active');
    }

    public function getPartsTotalCount($sSearch = null)
    {
        return $this->repository->getTotalRows($sSearch);
    }

    public function getPartListings(AbstractActionController $controller, $limit = null, $offset = null, $sEcho = null, $sortingCols = null, $sSearch = null)
    {
        $columns = array('r.partNumber', 'r.upcCode', 'r.productLine', 'r.color', 'r.msrpPrice', 'r.isheet');
        $orderBy = array();

        if ($sortingCols > 0) {
            for ($i = 0; $i < $sortingCols; $i++) {
                if ($controller->params()->fromQuery('bSortable_' . $controller->params()->fromQuery('iSortCol_' . $i)) == 'true') {
                    // column name
                    $orderBy[] = $columns[(INT)$controller->params()->fromQuery('iSortCol_' . $i)];
                    // order direction
                    $orderBy[] = (($controller->params()->fromQuery('sSortDir_' . $i) === 'asc') ? 'ASC' : 'DESC');
                }
            }
        }

        $records           = $this->getActiveParts($limit, $offset, $orderBy, $sSearch);
        $recordsCount      = count($records);
        $totalRecordsCount = $this->getPartsTotalCount($sSearch);
        $aaData            = array();

        if ($recordsCount > 0) {
            foreach ($records as $record) {
                $aaData[] = array($record->getPartNumber(),
                                  $record->getUpcCode(),
                                  ['id' => $record->getProductLine()->getProductLineId(),
                                   'name' => $record->getProductLine()->getName()],
                                  $record->getColor(),
                                  $record->getMsrpPrice(),
                                  ['id' => $record->getPartId(),
                                   'isheet' => $record->getIsheet()],
                                  $record->getPartId()
                );
            }
        }

        return array('sEcho'                => $sEcho,
                     'aaData'               => $aaData,
                     'iTotalRecords'        => $totalRecordsCount,
                     'iTotalDisplayRecords' => $totalRecordsCount);
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

    /**
     * Return a list of years by category
     */
    public function getVehYear($category=null, $productLine=null)
    {
    	return $this->repository->findYear($category, $productLine);
    }

    /**
     * Return a list of makes by year
     */
    public function getVehMake($year, $category, $productLine=null)
    {
    	return $this->repository->findByYear($year, $category, $productLine);
    }

    /**
     * Return a list of models by year and make
     */
    public function getVehModel($brand, $year, $make, $category)
    {
        return $this->repository->findByYearMake($brand, $year, $make, $category);
    }
    
    /**
     * Return a list of models  by year and make
     */
    public function getVehModelbyYear($model, $make)
    {
        return $this->repository->findModelByYearMake($model, $make);
    }

    /**
     * Return a list of models and submodels by year and make
     */
    public function getVehModelSubmodel($year, $make, $category, $productLine=null)
    {
        return $this->repository->findModelSubmodelByYearMake($year, $make, $category, $productLine);
    }

    /**
     * Return a list of subModels by year and make and model
     */
    public function getVehSubModel($brand, $year, $make, $model, $category)
    {
        return $this->repository->findSubModelByYearMakeModel($brand, $year, $make, $model, $category);
    }

    
    /**
     * Return a list of SoldAs by year and make and model and submodel
     */
    public function getSoldAs($year, $make, $model, $submodel=null, $bedLength=null, $bodyType=null, $category=null, $productLine=null)
    {						
        return $this->repository->findSoldAs($year, $make, $model, $submodel, $bedLength, $bodyType, $category, $productLine);
    }
    
    /**
     * Return a list of colors by year and make and model and submodel
     */
    public function getColor($year, $make, $model, $submodel=null, $bedLength=null, $bodyType=null, $soldAs=null, $finish=null, $category=null, $productLine=null)
    {						
        return $this->repository->findColor($year, $make, $model, $submodel, $bedLength, $bodyType, $soldAs, $finish, $category, $productLine);
    }
    
    /**
     * Return a list of finish by year and make and model and submodel
     */
    public function getFinish($year, $make, $model, $submodel=null, $bedLength=null, $bodyType=null, $soldAs=null, $category=null, $productLine=null)
    {
        return $this->repository->findFinish($year, $make, $model, $submodel, $bedLength, $bodyType, $soldAs, $category, $productLine);
    }
    
    /**
     * Return a list of Part by year and make and model and submodel
     */
    public function getPartId($year, $make, $model, $submodel=null, $bedLength=null, $bodyType=null, $soldAs=null, $finish=null, $color=null, $category=null, $productLine=null)
    {						
        return $this->repository->findPartId($year, $make, $model, $submodel, $bedLength, $bodyType, $soldAs, $finish, $color, $category, $productLine);
    }
    
    /**
     * Return a list of year, make, models by part_id
     */
    public function getWebsitePartID($partId)
    {						
    	return $this->repository->findWebsitePartID($partId);
    }
    
    /**
     * Return a list of body parts by year and make and model
     */
    public function getVehBodyType($brand, $year, $make, $model, $category)
    {
        return $this->repository->findByYearMakeModel($brand, $year, $make, $model, $category);
    }

    /**
     * Return a list of body parts by year and make and model
     */
    public function getVehColor($brand, $year, $make, $model, $bodyType, $category)
    {
        return $this->repository->findByYearMakeModelBody($brand, $year, $make, $model, $bodyType, $category);
    }

    /**
     * Return a list of Bed Length by year and make and model and submodel
     */
    public function getVehBedLength($year, $make, $model, $subModel=null, $category=null, $productLine=null)
    {
        return $this->repository->findVehBedLength($year, $make, $model, $subModel, $category, $productLine);
    }

    /**
     * Return a list of Body Type by year and make and model and submodel
     */
    public function getBodyType($year, $make, $model, $subModel=null, $bedLength=null, $category=null, $productLine=null)
    {
        return $this->repository->findVehBodyType($year, $make, $model, $subModel, $bedLength, $category, $productLine);
    }
    
    /**
     * Return a list of body parts by year and make and model
     */
    public function getAllVeh($brand, $year, $make, $model, $bodyType, $category)
    {
    	return $this->repository->findAllByYearMakeModelBody($brand, $year, $make, $model, $bodyType, $category);
    }
    
    /**
     * Return a list of isheets by year and make and model
     */
    public function getInstallations($year, $make, $model)
    {
    	return $this->repository->findInstallationsByYearMakeModel($year, $make, $model);
    }
    
    /**
     * Return a list of isheets by part number
     */
    public function getInstallationsParts($part)
    {
    	return $this->repository->findInstallationsByPart($part);
    }
    
    /**
     * Return a Country ID
     */
    public function getCountryId($name)
    {
        return $this->repository->findCountryId($name);
    }
    
    /**
     * Return a State ID
     */
    public function getStateId($country, $state)
    {
        return $this->repository->findStateId($country, $state);
    }
    
    /**
     * Return a State ID
     */
    public function getState($state)
    {
        return $this->repository->findState($state);
    }
}
