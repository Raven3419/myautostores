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
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\Changesets;
use LundProducts\Entity\ChangesetsInterface;
use LundProducts\Repository\ChangesetsRepositoryInterface;
use LundProducts\Repository\PartVehCollectionRepositoryInterface;
use LundProducts\Repository\PartsRepositoryInterface;
use LundProducts\Service\ParseMasterService;
use LundProducts\Repository\VehCollectionRepositoryInterface;
use LundProducts\Service\ParseSupplementService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\BrandsService;
use RocketAdmin\Service\AuditService;
use Doctrine\ORM\EntityManager;
use RocketUser\Entity\UserInterface;
use DateTime;
use LundProducts\Service\ProductLineService;
use LundProducts\Repository\BrandsRepository;

/*
 * Service managing the CRUD of changesets.
 */
class ChangesetsService implements EventManagerAwareInterface
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
     * @var ChangesetsRepositoryInterface ObjectRepository
     */
    protected $repository;

    /**
     * @var PartsRepositoryInterface ObjectRepository
     */
    protected $partsRepository;

    /**
     * @var ParseMasterService
     */
    protected $masterService;

    /**
     * @var ParseSupplementService
     */
    protected $supplementService;

    /**
     * @var ChangesetDetailsService
     */
    protected $changesetDetailsService;

    /**
     * @var ChangesetDetailsVehiclesService
     */
    protected $changesetDetailsVehiclesService;

    /**
     * @var PartVehCollectionRepositoryInterface
     */
    protected $partVehCollectionRepository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var VehCollectionRepositoryInterface
     */
    protected $vehCollectionRepository;

    /**
     * @var AuditService
     */
    protected $auditService;

    /**
     * @var ProductLineService
     */
    protected $productLineService;

    /**
     * @var BrandService
     */
    protected $brandsService;

    /**
     * @param ObjectManager                        $objectManager
     * @param ChangesetsRepositoryInterface        $repository
     * @param PartsRepositoryInterface             $partsRepository
     * @param ParseMasterService                   $masterService
     * @param ParseSupplementService               $supplementService
     * @param ChangesetDetailsService              $changesetDetailsService
     * @param ChangesetDetailsVehiclesService      $changesetDetailsVehiclesService
     * @param PartVehCollectionRepositoryInterface $partVehCollectionRepository
     * @param VehCollectionRepositoryInterface     $vehCollectionRepository
     * @param AuditService                         $auditService
     * @param BrandsRepository                     $brandsRepository
     * @param ProductLineService                   $productLineService
     */
    public function __construct(ObjectManager                        $objectManager,
                                ChangesetsRepositoryInterface        $repository,
                                PartsRepositoryInterface             $partsRepository,
                                ParseMasterService                   $masterService,
                                ParseSupplementService               $supplementService,
                                ChangesetDetailsService              $changesetDetailsService,
                                ChangesetDetailsVehiclesService      $changesetDetailsVehiclesService,
                                PartVehCollectionRepositoryInterface $partVehCollectionRepository,
                                EntityManager                        $entityManager,
                                VehCollectionRepositoryInterface     $vehCollectionRepository,
                                AuditService                         $auditService,
                                BrandsRepository                  	 $brandsRepository,
                                ProductLineService                   $productLineService)
    {
        $this->objectManager                   = $objectManager;
        $this->repository                      = $repository;
        $this->partsRepository                 = $partsRepository;
        $this->masterService                   = $masterService;
        $this->supplementService               = $supplementService;
        $this->changesetDetailsService         = $changesetDetailsService;
        $this->changesetDetailsVehiclesService = $changesetDetailsVehiclesService;
        $this->partVehCollectionRepository     = $partVehCollectionRepository;
        $this->entityManager                   = $entityManager;
        $this->vehCollectionRepository         = $vehCollectionRepository;
        $this->auditService                    = $auditService;
        $this->brandsRepository                = $brandsRepository;
        $this->productLineService              = $productLineService;
    }

    /**
     * @return mixed
     */
    public function getActiveChangesets()
    {
        return $this->repository->findBy(
            array('deleted'  => false,
                  'disabled' => false,
                  //'approved' => false,
                  //'deployed' => false,
                 ),
            array('uploadedAt' => 'ASC')
        );
    }
    


    /**
     * @return mixed
     */
    public function getActiveBrands()
    {
    	return $this->brandsRepository->findBy(
    			array('deleted'  => false,
    					'disabled' => false,
    			)
    	);
    }

    /**
     * @param integer $recordId
     *
     * @return ChangesetsInterface
     */
    public function getChangeset($recordId)
    {
        return $this->repository->find($recordId);
    }

    /**
     * Return changesets based on created time
     *
     * @param  string              $frequency
     * @return ChangesetsInterface
     */
    public function getChangesetByFrequency($frequency)
    {
        $endDate = new DateTime('now');
        $startDate = new DateTime('now');
        switch ($frequency) {
            case 'day':
                $startDate = $startDate->sub(new \DateInterval('P1D'));
                break;
            case 'week':
                $startDate = $startDate->sub(new \DateInterval('P1W'));
                break;
            case 'month':
                $startDate = $startDate->sub(new \DateInterval('P1M'));
                break;
        }

        return $this->repository->findByFrequency($startDate, $endDate);
    }

    /**
     * Deploy a changeset.
     *
     * @param ChangesetsInterface $changeset
     *
     * @return void
     */
    public function deployChangeset(ChangesetsInterface $changeset)
    {
    	//print_r($this->brandsService->getActiveBrands());exit;
        set_time_limit(0);
        ini_set('max_execution_time', 0);
        // get changeset_id
        // loop through its changesetdetails
        // shell_exec php public/index.php generate aces 3.0.1 $brand
        // done
        if (null != $changeset) {
            $used_brands       = [];
            $all_brands       = [];
            $changeset_details = $changeset->getChangesetDetails();
            
            if ($changeset_details) {
                foreach ($changeset_details as $detail) {
                	
                	foreach ($this->getActiveBrands() as $brands)
                	{
                		$all_brands[] = $brands->getName();
                	}
                	
                    if (in_array($detail->getBrand()->getName(), $used_brands)) 
                    {
                        continue;
                    } 
                    else 
                    {
                        $used_brands[] = $detail->getBrand()->getName();
                    }

                    if (null != $detail->getPart()) 
                    {
                        if (in_array($detail->getPart()->getProductLine()->getOrigBrand()->getName(), $used_brands)) 
                        {
                            continue;
                        } 
                        else 
                        {
                        	$used_brands[] = $detail->getPart()->getProductLine()->getOrigBrand()->getName();
                        }
                    } 
                    else 
                    {
                        $part = $this->partsRepository->findOneBy(
                            array(
                                'partNumber' => $detail->getPartNumber(),
                            )
                        );

                        if (null != $part) 
                        {
                         	if (in_array($part->getProductLine()->getOrigBrand()->getName(), $used_brands)) 
                            {
                                continue;
                            } 
                            else 
                            {
                                $used_brands[] = $part->getProductLine()->getOrigBrand()->getName();
                            }
                        }
                    }
                }

                
                foreach ($changeset_details as $detail) {
                    if (null == $detail->getPart()) {
                        $part = $this->partsRepository->findOneBy(
                            array(
                                'partNumber' => $detail->getPartNumber(),
                            )
                        );

                        if (null != $part) {
                            $detail->setPartId($part->getPartId());
                            $this->objectManager->persist($detail);
                            $this->objectManager->flush($detail);
                        }
                    }
                }
            }

            $used_brands = array_unique($used_brands);
            $all_brands = array_unique($all_brands);
           
            foreach ($all_brands as $allBrand) {
            	if ($allBrand == 'BELMOR') { continue; }
            	// create proper shell environment, AKA PHP's environment when PHP is executed in the browser, set env vars in the same way apache does
            	// export APP_ENV="development" && export APP_SITE="lunddigitalplatform" && php public/index.php generate aces 3.0.1 BRAND incr|full changeset_id
            	// generate incremental ACES file
            
            	// generate full ACES file
            	$full_aces_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate aces 3.0.1 "' . strtoupper($allBrand) . '" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
//            	var_dump($full_aces_shell_command);
            	shell_exec($full_aces_shell_command);
            
            	$full_year_aces_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate aces 3.0.1 "' . strtoupper($allBrand) . '" year_full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            	//var_dump($full_year_aces_shell_command);
            	shell_exec($full_year_aces_shell_command);
            
            	if (strtoupper($allBrand) == 'LUND') {
            		$full_aces_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate aces 3.0.1 "LUNDONLY" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            		//var_dump($full_aces_shell_command);
            		shell_exec($full_aces_shell_command);
            
            		$full_year_aces_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate aces 3.0.1 "LUNDONLY" year_full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            		//var_dump($full_year_aces_shell_command);
            		shell_exec($full_year_aces_shell_command);
            	}
            
            	// generate full PIES file
            	$full_pies_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate pies 6.5 "' . strtoupper($allBrand) . '" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            	//var_dump($full_pies_shell_command);
            	shell_exec($full_pies_shell_command);
            
            	if (strtoupper($allBrand) == 'LUND') {
            		$full_pies_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate pies 6.5 "LUNDONLY" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            		//var_dump($full_pies_shell_command);
            		shell_exec($full_pies_shell_command);
            	}
            
            	// generate full PIES CSV file
            	$full_pies_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate pies csv "' . strtoupper($allBrand) . '" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            	//var_dump($full_pies_shell_command);
            	shell_exec($full_pies_shell_command);
            
            	if (strtoupper($allBrand) == 'LUND') {
            		$full_pies_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate pies csv "LUNDONLY" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            		//var_dump($full_pies_shell_command);
            		shell_exec($full_pies_shell_command);
            	}
            	
            	// generate full MAGENTO file
            	$full_magento_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate magentoBrands csv "' . strtoupper($allBrand) . '" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            	//var_dump($full_magento_shell_command);exit;
            	shell_exec($full_magento_shell_command);
            	
            	if (strtoupper($allBrand) == 'LUND') {
            		// generate full MAGENTO file
            		$full_magento_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate magentoBrands csv "LUNDONLY" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            		//var_dump($full_magento_shell_command);exit;
            		shell_exec($full_magento_shell_command);
            	}
            	
            	// package images for customers
            	$package_customer_images_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate customer "' . strtoupper($allBrand) . '" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            	//var_dump($package_customer_images_shell_command);
            	shell_exec($package_customer_images_shell_command);
            	
            	
            	if (strtoupper($allBrand) == 'LUND') {
            		$package_customer_images_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate customer "LUNDONLY" full ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
            		//var_dump($package_customer_images_shell_command);
            		shell_exec($package_customer_images_shell_command);
            	}
            
            }
            	

            foreach ($used_brands as $brand) {
            	
                if ($brand == 'BELMOR') { continue; }
                    // create proper shell environment, AKA PHP's environment when PHP is executed in the browser, set env vars in the same way apache does
                    // export APP_ENV="development" && export APP_SITE="lunddigitalplatform" && php public/index.php generate aces 3.0.1 BRAND incr|full changeset_id
                    // generate incremental ACES file
                  
                    $incr_aces_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate aces 3.0.1 "' . strtoupper($brand) . '" incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                    //var_dump($incr_aces_shell_command);
                        shell_exec($incr_aces_shell_command);

                        
                    $incr_year_aces_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate aces 3.0.1 "' . strtoupper($brand) . '" year_incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                        //var_dump($incr_year_aces_shell_command);
                        shell_exec($incr_year_aces_shell_command);


                    if (strtoupper($brand) == 'LUND') {
                        $incr_aces_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate aces 3.0.1 "LUNDONLY" incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                        //var_dump($incr_aces_shell_command);
                            shell_exec($incr_aces_shell_command);
                            
                    	$incr_year_aces_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate aces 3.0.1 "LUNDONLY" year_incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                            //var_dump($incr_year_aces_shell_command);
                            shell_exec($incr_year_aces_shell_command);
                    }

                    // generate incremental PIES file
                    $incr_pies_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate pies 6.5 "' . strtoupper($brand) . '" incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                    //var_dump($incr_pies_shell_command);
                        shell_exec($incr_pies_shell_command);

                    if (strtoupper($brand) == 'LUND') {
                        $incr_pies_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate pies 6.5 "LUNDONLY" incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                        //var_dump($incr_pies_shell_command);
                            shell_exec($incr_pies_shell_command);
                    }

                    // generate incremental PIES CSV file
                    $incr_pies_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate pies csv "' . strtoupper($brand) . '" incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                    //var_dump($incr_pies_shell_command);
                        shell_exec($incr_pies_shell_command);

                    if (strtoupper($brand) == 'LUND') {
                        $incr_pies_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate pies csv "LUNDONLY" incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                        //var_dump($incr_pies_shell_command);
                            shell_exec($incr_pies_shell_command);
                    }
                    


                    // generate incremental MAGENTO file
                    $incr_magento_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate magentoBrands csv "' . strtoupper($allBrand) . '" incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                    //var_dump($incr_magento_shell_command);exit;
                    shell_exec($incr_magento_shell_command);
                     
                    if (strtoupper($allBrand) == 'LUND') {
                    	// generate incremental MAGENTO file
                    	$incr_magento_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate magentoBrands csv "LUNDONLY" incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                    	//var_dump($incr_magento_shell_command);exit;
                    	shell_exec($incr_magento_shell_command);
                    }

                    // generate edgenet xml file
                    if (strtoupper($brand) == 'AVS' || strtoupper($brand) == 'LUND') {
                        $incr_edgenet_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate edgenet 1.0 "' . strtoupper($brand) . '" ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                        //var_dump($incr_edgenet_shell_command);
                        shell_exec($incr_edgenet_shell_command);
                    }

                    // package images for amazon
                    $package_amazon_images_shell_command = 'export APP_ENV="' . getenv('APP_ENV') . '" && export APP_SITE="' . getenv('APP_SITE') . '" && php public/index.php generate amazon "' . strtoupper($brand) . '" incr ' . $changeset->getChangesetId() . ' > /dev/null 2>&1 &';
                    //var_dump($package_amazon_images_shell_command);
                        shell_exec($package_amazon_images_shell_command);

                                                
            }
             
            //exit;
//exit();
            // now mark as deployed..
            $changeset->setDeployed(true);

            $this->objectManager->persist($changeset);
            $this->objectManager->flush($changeset);
            $this->flushCache();

            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Changeset Deploy',
                //'summary'   => 'Deployed changeset uploaded on ' . $this->dateFormat($changeset->getUploadedAt(), IntlDateFormatter::LONG, IntlDateFormatter::LONG, 'en_us'),
                'summary'   => 'Deployed changeset uploaded on ' . $changeset->getUploadedAt()->format('Y-m-d H:i:s'),
                'result'    => 'success',
            ]);
            //exit();
        }
    }

    /**
     * @param Changesets $changeset
     *
     * @return boolean true|false
     */
    public function approveChangeset(UserInterface $identity, array $changeset_details)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        if (!is_array($changeset_details)) {
            return false;
        }

        if (count($changeset_details) == 0) {
            return false;
        }

        $changeset_id = null;
        $batchSize    = 20;
        $iterator     = 0;

        
        foreach ($changeset_details as $detail) {
        	
            $rowData = str_getcsv($detail->getChangeFileRow());
            
            if(null == $detail->getParts())
            {
            	$part = $this->partsRepository->findOneBy(
            			array(
            					'partNumber' => $detail->getPartNumber(),
            			)
            	);
            	
            	$detail->setParts($part);
            } 
            
            switch ($detail->getChange()) {
                case 'add':
                    $this->integrateChangesetDetail($detail->getChangesetDetailId());
                break;
                case 'change':
                    if ($detail->getAppChanged()) {
                    	//echo "app-".$detail->getParts()->getPartNumber()." - ";
                        $result = $this->integrateChangesetDetail($detail->getChangesetDetailId());
                        //echo "pass - ";
                    }
                    if ($detail->getStatusChanged()) {
                    	//echo "status-";
                    	//echo $detail->getParts()->getPartNumber();
                    	//print_r($rowData);

                    	$this->integrateChangesetDetail($detail->getChangesetDetailId());
                    	
                    	if(null == $detail->getParts())
                    	{
                    		$part = $this->partsRepository->findOneBy(
                    				array(
                    						'partNumber' => $rowData[0],
                    				)
                    		);
                    	
                    		$detail->setParts($part);
                    	}
                    	
                        $result = $this->partsRepository->editStatus($detail->getParts(), $detail, $rowData);
                    	//echo $detail->getParts()->getPartNumber()." - pass - ";
                    }
                    if ($detail->getCountryChanged()) {
                    	//echo "country-".$detail->getParts()->getPartNumber()." - ";

                    	$this->integrateChangesetDetail($detail->getChangesetDetailId());
                    	
                    	if(null == $detail->getParts())
                    	{
                    		$part = $this->partsRepository->findOneBy(
                    				array(
                    						'partNumber' => $rowData[0],
                    				)
                    		);
                    	
                    		$detail->setParts($part);
                    	}
                    	
                        $result = $this->partsRepository->editCountry($detail->getParts(), $detail, $rowData);
                        //echo "pass - ";
                    }
                    if ($detail->getPopChanged()) {

                    	$this->integrateChangesetDetail($detail->getChangesetDetailId(), false);

						if(null == $detail->getParts())
						{
							$part = $this->partsRepository->findOneBy(
									array(
											'partNumber' => $rowData[0],
									)
							);
							 
							$detail->setParts($part);
						}
                    	//echo "pop - ".$detail->getParts()->getPartNumber()." - ";
                    	//echo " - GOOD - ";
                        $result = $this->partsRepository->editPop($detail->getParts(), $detail, $rowData);
                    	//echo "pass - ";
                    }
                    if ($detail->getColorChanged()) {
                    	//echo "color-";

                    	$this->integrateChangesetDetail($detail->getChangesetDetailId());
                    	
                    	if(null == $detail->getParts())
                    	{
                    		$part = $this->partsRepository->findOneBy(
                    				array(
                    						'partNumber' => $rowData[0],
                    				)
                    		);
                    	
                    		$detail->setParts($part);
                    	}
                    	
                        $result = $this->partsRepository->editColor($detail->getParts(), $detail, $rowData);
                        //echo $detail->getParts()->getPartNumber()." pass - ";
                    }
                    if ($detail->getDimsChanged()) {
                    	//echo "dim-".$detail->getParts()->getPartNumber()." - ";

                    	$this->integrateChangesetDetail($detail->getChangesetDetailId());
                    	
                    	if(null == $detail->getParts())
                    	{
                    		$part = $this->partsRepository->findOneBy(
                    				array(
                    						'partNumber' => $rowData[0],
                    				)
                    		);
                    	
                    		$detail->setParts($part);
                    	}
                    	
                        $result = $this->partsRepository->editDimensions($detail->getParts(), $detail, $rowData);
                    	//echo "pass - ";
                    }
                    if ($detail->getClassChanged()) {

                    	$this->integrateChangesetDetail($detail->getChangesetDetailId());
                    	
                    	if(null == $detail->getParts())
                    	{
                    		$part = $this->partsRepository->findOneBy(
                    				array(
                    						'partNumber' => $rowData[0],
                    				)
                    		);
                    	
                    		$detail->setParts($part);
                    	}
                    	
                        $foundBrand = $this->masterService->findBrand(trim($rowData[1]));
                        if (null != $foundBrand) {
                            $brand_id = $foundBrand['brand_id'];

                            $foundProductLine = $this->masterService->findProductLine(trim($rowData[3]), $brand_id);
                            if (null != $foundProductLine) {
                                $product_line_id = $foundProductLine['product_line_id'];

                                $productLine = $this->productLineService->getProductLine($product_line_id);
                                $result = $this->partsRepository->editClass($detail->getParts(), $detail, $productLine, $rowData);
                            }
                        }
                    }
                    if ($detail->getImageChanged()) { /* Nothing to do yet */ }
                    if ($detail->getYearChanged()) {
                    	$result = $this->integrateChangesetDetail($detail->getChangesetDetailId(), true);
                    }
                break;
                case 'delete':
                	//echo "DELETE - ";
                    $changeset_vehicles     = $this->changesetDetailsVehiclesService->getChangesetDetailsVehiclesByChangesetDetailsId($detail->getChangesetDetailId());
                    $veh_collection_records = [];

                    foreach ($changeset_vehicles as $vehicle) {
                        // if veh_collection_id exists, add it to the list of part_veh_collection records to remove
                        if ($vehicle->getVehCollection()) {
                            $veh_collection_records[] = $vehicle->getVehCollection()->getVehCollectionId();
                        } else {
                            // try to find vehicle based on make/model/submodel/year
                            $veh_collection_lookup = ['vehMake'     => null,
                                                      'vehModel'    => null,
                                                      'vehSubmodel' => null,
                                                      'vehYear'     => null];

                            if ($vehicle->getVehMake()) {
                                $veh_collection_lookup['vehMake'] = $vehicle->getVehMake()->getVehMakeId();
                            } else {
                                // find veh_make_id by changeset_details_vehicles.veh_make_label
                                $veh_make = $this->masterService->findVehMake($vehicle->getVehMakeLabel());

                                if (null != $veh_make) {
                                    $veh_collection_lookup['vehMake'] = $veh_make['veh_make_id'];
                                }
                            }

                            if ($vehicle->getVehModel()) {
                                $veh_collection_lookup['vehModel'] = $vehicle->getVehModel()->getVehModelId();
                            } else {
                                $veh_model = $this->masterService->findVehModel($vehicle->getVehModelLabel(), $veh_collection_lookup['vehMake']);

                                if (null != $veh_model) {
                                    $veh_collection_lookup['vehModel'] = $veh_model['veh_model_id'];
                                }
                            }

                            if ($vehicle->getVehSubmodel()) {
                                $veh_collection_lookup['vehSubmodel'] = $vehicle->getVehSubmodel()->getVehSubmodelId();
                            } else {
                                // could be null, submodel not always included
                                $veh_submodel = $this->masterService->findVehSubmodel($vehicle->getVehSubmodelLabel(), $veh_collection_lookup['vehModel']);

                                if (null != $veh_submodel) {
                                    $veh_collection_lookup['vehSubmodel'] = $veh_submodel['veh_submodel_id'];
                                }
                            }

                            if ($vehicle->getVehYear()) {
                                $veh_collection_lookup['vehYear'] = $vehicle->getVehYear()->getVehYearId();
                            } else {
                                // could be null, submodel not always included
                                $veh_year = $this->masterService->findVehYear($vehicle->getVehYearLabel());

                                if (null != $veh_year) {
                                    $veh_collection_lookup['vehYear'] = $veh_year['veh_year_id'];
                                }
                            }

                            // pass all into a find into veh_collection
                            // add those records into the list of veh_collection ID's to remove
                            $veh_collection_find = $this->vehCollectionRepository->findBy($veh_collection_lookup);

                            if ($veh_collection_find) {
                                foreach ($veh_collection_find as $veh_coll) {
                                    $veh_collection_records[] = $veh_coll->getVehCollectionId();
                                }
                            }
                        }
                    }

                    // get part_id by part_number given
                    $part_id = null;

                    if ($detail->getParts()) {
                        $part_id = $detail->getParts()->getPartId();
                    } else {
                        $part_number = $this->partsRepository->findOneBy(['partNumber' => $detail->getPartNumber()]);

                        if ($part_number) {
                            $part_id = $part_number->getPartId();
                        }
                    }

                    //echo $part_id." - ";
                    // if this part exists in the system by part_number
                    if ($part_id) {
                        // loop through $veh_collection_records
                        // find all part_veh_collection records by: $part_id and veh_collection_id's
                        foreach ($veh_collection_records as $index => $veh_collection_record) {
                            //echo 'looking for part_veh_collection record of part_id: ' . $part_id . ', and veh_collection_id: ' . $veh_collection_record . '<br />';

                            $part_veh_collection_records = $this->partVehCollectionRepository->findBy(['part'          => $part_id,
                                                                                                       'vehCollection' => $veh_collection_record]);

                            if (count($part_veh_collection_records) > 0) {
                                foreach ($part_veh_collection_records as $pvc_record) {
                                    $this->entityManager->remove($pvc_record);
                                    $this->entityManager->flush();
                                }
                            } else {
                                // no part_veh_collection records exist by part_id/veh_collection_id
                                // error?
                            }
                        }
                    } else {
                        // this part does not exist
                        // error?
                    }
                break;
                case 'disabled':
                	//echo "DELETED - ";
                	
                	if (null == $detail->getChangesetDetailId()) {
                		// throw new Exception();
                	}
                	
                	$changeset_detail = $this->changesetDetailsService->getChangesetDetails($detail->getChangesetDetailId());
                	
                	if (trim($changeset_detail->getChangeFileRow()) == '') {
                		// throw new Exception();
                	}
                	
                	$rowData = str_getcsv($changeset_detail->getChangeFileRow());
                	
                	$part_number                   = trim($rowData[0]);
                	$brand                         = trim($rowData[1]);
                	$product_lines_bpcs_code       = trim($rowData[2]);
                	$product_lines_short_code      = trim($rowData[3]);
                	$product_categories_bpcs_code  = trim($rowData[4]);
                	$product_categories_short_code = trim($rowData[5]);
                	$from_year                     = trim($rowData[6]);
                	$to_year                       = trim($rowData[7]);
                	$veh_make_name                 = trim($rowData[8]);
                	$veh_model_name                = trim($rowData[9]);
                	$veh_submodel_name             = trim($rowData[10]);
                	$veh_submodel_subdetail        = trim($rowData[11]);
                	$lookup_body_type              = trim($rowData[12]);
                	$lookup_bed_type               = trim($rowData[13]);
                	$jobber_price                  = trim($rowData[14]);
                	$msrp_price                    = trim($rowData[15]);
                	$sale_price                    = trim($rowData[16]);
                	$pop_code                      = trim($rowData[17]);
                	$upc_code                      = trim($rowData[18]);
                	$weight                        = trim($rowData[19]);
                	$height                        = trim($rowData[20]);
                	$width                         = trim($rowData[21]);
                	$length                        = trim($rowData[22]);
                	//$shippingHrs				   = trim($rowData[23]);
                	$color                         = trim($rowData[24]);
                	//$noDrill				   	   = trim($rowData[25]);
                	//$extraDesc				  	   = trim($rowData[26]);
                	//$inAppGuide				  	   = trim($rowData[27]);
                	//$inJobber				  	   = trim($rowData[28]);
                	$isheet                        = trim($rowData[29]);
                	//$dateChgdSinceLastDownload	   = trim($rowData[30]);
                	$country_of_origin             = trim($rowData[31]);
                	//$retailFlg				  	   = trim($rowData[32]);
                	//$overSizeCode				   = trim($rowData[33]);
                	$status_code                   = trim($rowData[34]);
                	$orig_brand                    = trim($rowData[35]);
                	//$flareHeight				   = trim($rowData[36]);
                	//$flareTireCoverage			   = trim($rowData[37]);
                	$dima                          = trim($rowData[38]);
                	$dimb                          = trim($rowData[39]);
                	$dimc                          = trim($rowData[40]);
                	$dimd                          = trim($rowData[41]);
                	$dime                          = trim($rowData[42]);
                	$dimf                          = trim($rowData[43]);
                	$dimg                          = trim($rowData[44]);
                	$veh_class_name                = trim($rowData[45]);
                	//$veh_ModelType				   = trim($rowData[46]);
                	$lookup_make_id                = trim($rowData[47]);
                	$lookup_model_id               = trim($rowData[48]);
                	$lookup_submodel_id            = trim($rowData[49]);
                	$lookup_num_doors_id           = trim($rowData[50]);
                	$lookup_part_type_id           = trim($rowData[51]);
                	$lookup_body_type_id           = trim($rowData[52]);
                	$lookup_bed_type_id            = trim($rowData[53]);
                	$seq_no                        = trim($rowData[63]);
                	 
                	$foundPart = $this->masterService->findPart($part_number);
                	if (null != $foundPart) {
                	
                		$this->masterService->disablePart($foundPart['part_id'], date('Y-m-d H:i:s'), 1, 1);
                		 
                		$part_id = $foundPart['part_id'];
                	} 
                	
                break;
            }

            $changeset_id = $detail->getChangesets()->getChangesetid();
	    	$iterator++;
            //++$iterator;

            // batch process, bypass execution time issue
            if (($iterator % $batchSize) == 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }

        //exit;
        // now mark as approved..
        $approve_changeset = $this->getChangeset($changeset_id);
        $approve_changeset->setApproved(true);

        // store filename for later use in message generation
        $filename = explode('/', $approve_changeset->getUploadLocation());
        $filename = $filename[count($filename) - 1];

        // store changeset date for later use in message generation
        $changeset_date = $approve_changeset->getUploadedAt()->format('Y-m-d H:i:s');

        $this->objectManager->persist($approve_changeset);
        $this->objectManager->flush($approve_changeset);
        $this->flushCache();

        // create an audit_log entry
        $this->auditService->create([
            'createdBy' => 'system',
            'object'    => 'LundProducts',
            'action'    => 'Changeset Approval',
            'summary'   => 'Successfully approved changeset \'' . $filename . '\'.',
            'result'    => 'success',
        ]);

        // send message to all administrator users
        $this->supplementService->createMessageForRole('administrator', 'Changeset Approved', 'The changeset \'' . $filename . '\', uploaded on \'' . $changeset_date . '\', has been approved.');
    }

    /**
     * @param int $changeset_detail_id
     *
     * @return void
     */
    public function integrateChangesetDetail($changeset_detail_id = null, $yearChange = null)
    {
        if (null == $changeset_detail_id) {
            // throw new Exception();
        }

        $changeset_detail = $this->changesetDetailsService->getChangesetDetails($changeset_detail_id);

        if (trim($changeset_detail->getChangeFileRow()) == '') {
            // throw new Exception();
        }

        $rowData = str_getcsv($changeset_detail->getChangeFileRow());   
   
    
        $part_number                   = trim($rowData[0]);
        $brand                         = trim($rowData[1]);
        $product_lines_bpcs_code       = trim($rowData[2]);
        $product_lines_short_code      = trim($rowData[3]);
        $product_categories_bpcs_code  = trim($rowData[4]);
        $product_categories_short_code = trim($rowData[5]);
        $from_year                     = trim($rowData[6]);
        $to_year                       = trim($rowData[7]);
        $veh_make_name                 = trim($rowData[8]);
        $veh_model_name                = trim($rowData[9]);
        $veh_submodel_name             = trim($rowData[10]);
        $veh_submodel_subdetail        = trim($rowData[11]);
        $lookup_body_type              = trim($rowData[12]);
        $lookup_bed_type               = trim($rowData[13]);
        $jobber_price                  = trim($rowData[14]);
        $msrp_price                    = trim($rowData[15]);
        $map_price                     = trim($rowData[16]);
        $pop_code                      = trim($rowData[17]);
        $upc_code                      = trim($rowData[18]);
        $weight                        = trim($rowData[19]);
        $height                        = trim($rowData[20]);
        $width                         = trim($rowData[21]);
        $length                        = trim($rowData[22]);
        
        $color                         = trim($rowData[24]);
        $noDrill                       = trim($rowData[25]);
        
        $isheet                        = trim($rowData[29]);
        
        $country_of_origin             = trim($rowData[31]);
        
        $status_code                   = trim($rowData[34]);
        $orig_brand                    = trim($rowData[35]);
        $flare_height                  = trim($rowData[36]);  
        $flare_tire_coverage           = trim($rowData[37]);
        $dima                          = trim($rowData[38]);
        $dimb                          = trim($rowData[39]);
        $dimc                          = trim($rowData[40]);
        $dimd                          = trim($rowData[41]);
        $dime                          = trim($rowData[42]);
        $dimf                          = trim($rowData[43]);
        $dimg                          = trim($rowData[44]);
        $veh_class_name                = trim($rowData[45]);
        $model_type                    = trim($rowData[46]);
        $lookup_make_id                = trim($rowData[47]);
        $lookup_model_id               = trim($rowData[48]);
        $lookup_submodel_id            = trim($rowData[49]);
        $lookup_num_doors_id           = trim($rowData[50]);
        $lookup_part_type_id           = trim($rowData[51]);
        $lookup_body_type_id           = trim($rowData[52]);
        $lookup_bed_type_id            = trim($rowData[53]);        
        $seq_no                        = trim($rowData[63]);
        $lookup_number                 = trim($rowData[65]);
        $bed_length                    = trim($rowData[66]);
        $bed_length_id                 = ((trim($rowData[67]) == '') ? '0' : trim($rowData[67]));
        $finish                        = trim($rowData[68]);
        $style                 		   = trim($rowData[69]);
        $material                      = trim($rowData[70]);
        $material_thickness            = trim($rowData[71]);
        $sold_as                       = trim($rowData[72]);
        $tube_shape                    = trim($rowData[73]);
        $tube_size                     = trim($rowData[74]);
        $warranty            		   = trim($rowData[75]);
        $liquid_storage_capacity       = trim($rowData[76]);
        $box_style                     = trim($rowData[77]);
        $box_opening_type              = trim($rowData[78]);
        $base_veh_id              	   = ((trim($rowData[79]) == '') ? '0' : trim($rowData[79]));
        $fit_code_1                    = trim($rowData[80]);
        $fit_code_1_desc               = trim($rowData[81]);
        $fit_code_2                    = trim($rowData[82]);
        $fit_code_2_desc               = trim($rowData[83]);
        $fit_code_3                    = trim($rowData[84]);
        $fit_code_3_desc               = trim($rowData[85]);
        $fit_code_4                    = trim($rowData[86]);
        $fit_code_4_desc               = trim($rowData[87]);
        $fit_code_5                    = trim($rowData[88]);
        $fit_code_5_desc               = trim($rowData[89]);
        $jeep_clearance                = trim($rowData[90]);
        $cut_required                  = trim($rowData[91]);
        $rear_flare_height             = ((trim($rowData[92]) == '') ? '0.00' : trim($rowData[92]));
        $rear_flare_tire_coverage      = ((trim($rowData[93]) == '') ? '0.00' : trim($rowData[93]));
        $stake_holes                   = trim($rowData[94]);
        $color_group                   = trim($rowData[95]);
        $sale_price                    = trim($rowData[96]);
        $saleable                      = trim($rowData[97]);
        
        
        //print_r($rowData);exit;
        // universal parts:
        // - Make = UNIVERSAL
        // - missing Make, Model, Submodel and SubDetail
        $universal = ((strtoupper(trim($veh_make_name)) == 'UNIVERSAL') ? true : false);

        $brand_id            = null;
        $orig_brand_id       = null;
        $product_category_id = null;
        $product_line_id     = null;
        $part_id             = null;

        // first, insert/find brand, if orig_brand exists, create it, assign association in brands, cache
        //  -- same with orig_brand, find/create/assign orig_brand to brands.parent_orig_id to brands

        // it appears ALL line items in the master file have
        // an orig_brand field, always have one
        $foundBrand = $this->masterService->findBrand($brand);

        if (null != $foundBrand) {
            // found, cache it
            $brand_id = $foundBrand['brand_id'];
        } else {
            // not found, we create it, cache brand_id
            $foundBrand = $this->masterService->insertBrand(date('Y-m-d H:i:s'), 0, 0, $brand, $brand, $brand);
            $brand_id   = $foundBrand['brand_id'];
        }

        // find brand, assign $orig_brand_id in create query if needs it
        $foundOrigBrand = $this->masterService->findBrand($orig_brand);

        if (null != $foundOrigBrand) {
            // original brand exists, store in $orig_brand_id;
            $orig_brand_id = $foundOrigBrand['brand_id'];
        } else {
            // create brand, assign it to $orig_brand_id
            $foundOrigBrand = $this->masterService->insertBrand(date('Y-m-d H:i:s'), 0, 0, $orig_brand, $orig_brand, $orig_brand, $brand_id);
            $orig_brand_id  = $foundOrigBrand['brand_id'];
        }

        // find out if product_category exists by short_code, create it if not, cache
        $foundProductCategory = $this->masterService->findProductCategory($product_categories_short_code);

        if (null != $foundProductCategory) {
            // cache it
            $product_category_id = $foundProductCategory['product_category_id'];
        } else {
            // not found, create it, cache it
        	if(strpos($product_categories_short_code, "/"))
        	{
            	$cleaned_product_category_name = str_replace("/", "-", $product_categories_short_code);
        	}
        	else
        	{
        		$cleaned_product_category_name = $product_categories_short_code;
        	}
            
            $foundProductCategory = $this->masterService->insertProductCategory(
                date('Y-m-d H:i:s'), 0, 1,
                $product_categories_bpcs_code,
                $product_categories_short_code,
                $cleaned_product_category_name);

            $product_category_id = $foundProductCategory['product_category_id'];
        }

        //  -- find if brand_id & category_id exist in brand_product_category, if not, create brand_product_category relationship
        // find brand_product_category relationship by $product_category_id and $brand_id
        // if not exist, create it
        $pcBrandFound = $this->masterService->findBrandProductCategory($product_category_id, $brand_id);

        if (null == $pcBrandFound) {
            // create it!
            $pcBrandFound = $this->masterService->insertBrandProductCategory($product_category_id, $brand_id);
        }

        // find out if product_line exists by product_lines.short_code && product_lines.product_category_id
        // -- if not exist, create it with brand_id and product_category_id
        $foundProductLine = $this->masterService->findProductLine($product_lines_short_code, $brand_id);

        if (null != $foundProductLine) {
            $product_line_id = $foundProductLine['product_line_id'];
        } else {
            // create it, cache it
	        if(strpos($product_lines_short_code, "/"))
			{
				$cleaned_product_line_name = str_replace("/", "-", $product_lines_short_code);
			}
            else
            {
            	$cleaned_product_line_name = $product_lines_short_code;
            }
            
            $foundProductLine = $this->masterService->insertProductLine(
                date('Y-m-d H:i:s'), 0, 1,
                $product_lines_bpcs_code,
                $product_lines_short_code,
                $cleaned_product_line_name,
                $product_category_id,
                $brand_id,
                $orig_brand_id);

            $product_line_id = $foundProductLine['product_line_id'];
        }

        // find if part exists by $part_number and $product_line_id
        // -- find out if product exists by product_line_id from above
        // -- if not, create it
        // TODO: ** parent_part_id
        $foundPart = $this->masterService->findPart($part_number);
        if (null != $foundPart) {
        	
        	$this->masterService->updatePart($foundPart['part_id'], date('Y-m-d H:i:s'), 0, 0, $part_number, $jobber_price, $msrp_price, $sale_price,
        									 $color, $isheet, $pop_code, $upc_code, $weight, $height, $width, $length, $product_line_id, $country_of_origin,
        									 $status_code, $dima, $dimb, $dimc, $dimd, $dime, $dimf, $dimg, $universal, $lookup_part_type_id, $lookup_number,
        									 $bed_length, $bed_length_id, $flare_height, $flare_tire_coverage, $veh_class_name, $noDrill,
        									 $finish, $style, $material, $material_thickness, $sold_as, $tube_shape, $tube_size, $warranty,
                                    	     $liquid_storage_capacity, $box_style, $box_opening_type, $cut_required, $rear_flare_height,
        	                                 $rear_flare_tire_coverage, $stake_holes, $color_group, $map_price, $saleable);
        	
        	
            $part_id = $foundPart['part_id'];
            
        } else {
      	
           // echo $real_flare_height." - ".$rear_flare_tire_coverage;
            
            // create it, cache part_id
            $foundPart = $this->masterService->insertPart(date('Y-m-d H:i:s'), 0, 0, $part_number, $jobber_price, $msrp_price, $sale_price,
                                                          $color, $isheet, $pop_code, $upc_code, $weight, $height, $width, $length, $product_line_id, $country_of_origin,
                                                          $status_code, $dima, $dimb, $dimc, $dimd, $dime, $dimf, $dimg, $universal, $lookup_part_type_id, $lookup_number,
            											  $bed_length, $bed_length_id, $flare_height, $flare_tire_coverage, $veh_class_name, $noDrill,
        									 			  $finish, $style, $material, $material_thickness, $sold_as, $tube_shape, $tube_size, $warranty,
                                                          $liquid_storage_capacity, $box_style, $box_opening_type, $cut_required, $rear_flare_height,
                                                          $rear_flare_tire_coverage, $stake_holes, $color_group, $map_price, $saleable);
            $part_id = $foundPart['part_id'];
            
            //print_r($foundPart);exit;
        }

        // loop through FROM YEAR - TO YEAR and generate:
        // find out if vehicle exists by look ups into these tables:
        // -- veh_collection.veh_make_id
        // -- veh_collection.veh_model_id
        // -- veh_collection.veh_submodel_id
        // -- veh_collection.veh_year_id
        // if make/model/submodel/year do  not exist in any form, create/cache
        // after finished, create veh_collection entry, save primary key
        // create new part_veh_collection row with part_id and veh_collection_id from above
        if (($from_year == '9999') || ($to_year == '9999')) {
            // invalid data...
        } elseif (($from_year == '0') || ($to_year == '0')) {
            // universal data?
        } else {
            // regular dates, account for .5's, round down
            $from_year = round((FLOAT)$from_year, 0, PHP_ROUND_HALF_DOWN);
            $to_year   = round((FLOAT)$to_year, 0, PHP_ROUND_HALF_DOWN);
            
            $arrayYear = array();

            for ($k = $from_year; $k <= $to_year; $k++) {
                $this_year = $k;
                array_push($arrayYear, $this_year);

                // vehicle year
                $foundVehYear = $this->masterService->findVehYear((STRING)$this_year);

                if (null == $foundVehYear) {
                    $foundVehYear = $this->masterService->insertVehYear((STRING)$this_year);
                }

                // vehicle make
                $foundVehMake = $this->masterService->findVehMake($veh_make_name);

                if (null == $foundVehMake) {
                    $foundVehMake = $this->masterService->insertVehMake($veh_make_name, $veh_make_name);
                }

                $foundVehClass = $this->masterService->findVehClass($veh_class_name);

                if (null == $foundVehClass) {
                    $foundVehClass = $this->masterService->insertVehClass($veh_class_name);
                }

                // vehicle model
                $foundVehModel = $this->masterService->findVehModel($veh_model_name, $foundVehMake['veh_make_id']);

                if (null == $foundVehModel) {
                    $foundVehModel = $this->masterService->insertVehModel(
                        $veh_model_name,
                        $veh_model_name,
                        $foundVehMake['veh_make_id'], $foundVehClass['veh_class_id']);
                }

                if (trim($veh_submodel_name) != '') {
                    // vehicle submodel
                    $foundVehSubmodel = $this->masterService->findVehSubmodel($veh_submodel_name, $foundVehModel['veh_model_id']);

                    if (null == $foundVehSubmodel) {
                        $foundVehSubmodel = $this->masterService->insertVehSubmodel(
                            $veh_submodel_name,
                            $veh_submodel_name,
                            $foundVehModel['veh_model_id']);
                    }
                }

                
                
                $foundVehCollection = $this->masterService->findVehCollection(
                    $foundVehYear['veh_year_id'],
                    $foundVehMake['veh_make_id'],
                    $foundVehModel['veh_model_id'],
                    ((trim($veh_submodel_name) != '') ? $veh_submodel_name : null),
                    ((trim($veh_submodel_name) != '') ? $foundVehSubmodel['veh_submodel_id'] : null),
                    $lookup_body_type);

                
                
                if (null == $foundVehCollection) {
                    
                    // doesn't exist, create it
                    $foundVehCollection = $this->masterService->insertVehCollection(
                        $foundVehYear['veh_year_id'],
                        $foundVehMake['veh_make_id'],
                        $foundVehModel['veh_model_id'],
                        ((trim($veh_submodel_name) != '') ? $veh_submodel_name : null ),
                        ((trim($veh_submodel_name) != '') ? $foundVehSubmodel['veh_submodel_id'] : null),
                        $lookup_make_id,
                        $lookup_model_id,
                        $lookup_submodel_id,
                        $lookup_body_type_id,
                        $lookup_body_type,
                        $lookup_num_doors_id,
                        $lookup_bed_type_id,
                        $lookup_bed_type,
                    	$model_type,
                    	$base_veh_id,
                        $fit_code_1,
                        $fit_code_1_desc,
                        $fit_code_2,
                        $fit_code_2_desc,
                        $fit_code_3,
                        $fit_code_3_desc,
                        $fit_code_4,
                        $fit_code_4_desc,
                        $fit_code_5,
                        $fit_code_5_desc,
                        $jeep_clearance
                    );
                    
                }
                else
                {
                    
                	$this->masterService->updateVehCollection(
	                    $foundVehYear['veh_year_id'],
	                    $foundVehMake['veh_make_id'],
	                    $foundVehModel['veh_model_id'],
	                    ((trim($veh_submodel_name) != '') ? $veh_submodel_name : null),
	                    ((trim($veh_submodel_name) != '') ? $foundVehSubmodel['veh_submodel_id'] : null),
	                    ((trim($lookup_body_type) != '') ? $lookup_body_type : null),
                		$model_type,
                	    $base_veh_id,
                	    $fit_code_1,
                	    $fit_code_1_desc,
                	    $fit_code_2,
                	    $fit_code_2_desc,
                	    $fit_code_3,
                	    $fit_code_3_desc,
                	    $fit_code_4,
                	    $fit_code_4_desc,
                	    $fit_code_5,
                	    $fit_code_5_desc,
                	    $jeep_clearance
                	);
                }

                // check part_veh_collection assignment
                $foundPartVehCollection = $this->masterService->findPartVehCollection(
                    $foundPart['part_id'],
                    $foundVehCollection['veh_collection_id']);

                if (null == $foundPartVehCollection) {
                	
                    // create the association
                    $insertPartVehCollection = $this->masterService->insertPartVehCollection(
                        $foundPart['part_id'],
                        $foundVehCollection['veh_collection_id'],
                        $seq_no,
                        $changeset_detail_id,
                        $veh_submodel_subdetail);
                }
				else
	         	{
					$this->masterService->updatePartVehCollection($foundPartVehCollection, $seq_no, $veh_submodel_subdetail);
	         	}
            }
            
            if($yearChange)
            {
	            $findAllPartVehCollection = $this->masterService->findAllPartVehCollection($foundPart['part_id'], $seq_no);
	            
	            $yearFound = array();
	            $idFound = array();
	            $newYear = array();
	            
	            for($n=0; $n<count($findAllPartVehCollection); $n++)
	            {
	            	array_push($idFound, $findAllPartVehCollection[$n][0]);
	            	array_push($yearFound, $findAllPartVehCollection[$n][1]);
	            }
	            
	            $resultDiff = array_diff($yearFound, $arrayYear);
	            
	            foreach($resultDiff as $key => $value)
	            {
	            	array_push($newYear, $value);
	            }

	            for($l=0; $l<count($findAllPartVehCollection); $l++)
	            {
	            	for($m=0; $m<count($newYear); $m++)
	            	{
	            		if($findAllPartVehCollection[$l][1] == $newYear[$m])
	            		{
	            			$this->masterService->deletePartVehCollection($findAllPartVehCollection[$l][0]);
	            		}
	            		
	            	}
	            }
            }
        }
    }
    
    /**
     * Get vehicle collection post approval
     *
     * @param integer $yearId
     * @param integer $makeId
     * @param integer $modelId
     * @param integer $submodelId
     *
     * @return mixed
     */
    public function getVehicleCollection($yearId = null, $makeId = null, $modelId = null, $submodelId = null)
    {
        $veh_collection_lookup = array(
            'vehYear'     => $yearId,
            'vehMake'     => $makeId,
            'vehModel'    => $modelId,
            'vehSubmodel' => $submodelId
        );

        return $this->vehCollectionRepository->findBy($veh_collection_lookup);
    }

    /** Get part vehicle collection
     *
     * @param integer $partId
     * @param integer $vehicleCollectionId
     *
     * @return mixed
     */
    public function getPartVehicleCollection($partId = null, $vehicleCollectionId = null)
    {
        return $this->partVehCollectionRepository->findBy([
            'part' => $partId,
            'vehCollection' => $vehicleCollectionId]);
    }

    /**
     * @param \LundProducts\Entity\Changesets $recordEntity
     * @param \RocketUser\Entity\User         $usersEntity
     *
     * @return \LundProducts\Entity\Changesets $recordEntity
     */
    public function createChangeset(Changesets $recordEntity, User $usersEntity)
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
     * @param \LundProducts\Entity\Changesets $recordEntity
     * @param \RocketUser\Entity\User         $usersEntity
     *
     * @return \LundProducts\Entity\Changesets $recordEntity
     */
    public function editChangeset(Changesets $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
                     ->setModifiedBy($usersEntity->getUsername());
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\Changesets $recordEntity
     * @param \RocketUser\Entity\User         $usersEntity
     *
     * @return \LundProducts\Entity\Changesets $recordEntity
     */
    public function deleteChangeset(Changesets $recordEntity, User $usersEntity)
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
     * @return \LundProducts\Entity\Changesets $recordEntity
     */
    public function denyChangeset(UserInterface $identity, Changesets $recordEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
                     ->setModifiedBy($identity->getUsername())
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
        $cacheDriver->delete('changesets_find_active');
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
