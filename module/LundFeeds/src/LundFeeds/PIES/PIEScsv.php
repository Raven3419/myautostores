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
use Exception;

class PIEScsv implements PiesInterface
{
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
     * @var string
     */
    private $_piesVersion = 'csv';

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
    public function getBody($fp)
    {
        $headerArray = array(
            'Item #',
            'Brand',
            'Item Class',
            'Class Description',
            'Product Family',
            'Product Family Description',
            date('Y') . ' Jobber',
            date('Y') . ' MSRP',
            'Color',
            'I-Sheet',
            'Country of Origin',
            'Marketing Copy',
            'Features - Benefits 1',
            'Features - Benefits 2',
            'Features - Benefits 3',
            'Features - Benefits 4',
            'Features - Benefits 5',
            'Features - Benefits 6',
            'Features - Benefits 7',
            'Features - Benefits 8',
            'Features - Benefits 9',
            'Features - Benefits 10',
            'Features - Benefits 11',
            'Features - Benefits 12',
            'Features - Benefits 13',
            'Features - Benefits 14',
            'Features - Benefits 15',
            'Features - Benefits 16',
            'Features - Benefits 17',
            'Features - Benefits 18',
            'Features - Benefits 19',
            'Features - Benefits 20',
            'P01 - Off Vehicle',
            'P03 - Lifestyle',
            'P04 - Primary Photo',
            'P05 - Closeup',
            'P06 - Mounted',
            'P07 - Unmounted'
        );

        fputcsv($fp, $headerArray);

        $records = $this->partService->getAcesParts($this->brand, $this->generate, $this->changeset_id, $this->lundonly);

        // iterate through parts
        foreach ($records as $record) {
        	if(!$record->getDisabled())
        	{
        		
	            $overview = strip_tags($record->getProductLine()->getOverview());
	            $overview = str_replace("\n", '', $overview);
	            $overview = str_replace("\r", '', $overview);
	            $overview = str_replace("&trade;", "™", $overview);
	            $overview = str_replace("&reg;", "®", $overview);
	            $overview = str_replace("&#39;", "'", $overview);
	            $partArray = array(
	                $record->getPartNumber(),
	                $record->getProductLine()->getBrand()->getName(),
	                $record->getProductLine()->getBpcsCode(),
	                $record->getProductLine()->getName(),
	                $record->getProductLine()->getProductCategory()->getBpcsCode(),
	                $record->getProductLine()->getProductCategory()->getName(),
	                $record->getJobberPrice(),
	                $record->getMsrpPrice(),
	                $record->getColor(),
	                $record->getIsheet(),
	                $record->getCountryOfOrigin(),
	                $overview
	                //strip_tags($record->getProductLine()->getOverview())
	                //$record->getProductline()->getFeatures()
	            );
	
	            $productLineFeatureService = $this->piesService->getProductLineFeatureService();
	            $features = $productLineFeatureService->getProductLineFeaturesByProductLine($record->getProductLine());
	
	            if (null != $features) {
	                $iterator=0;
	                foreach ($features as $feature) {
	                    $featurecopy = $feature->getFeatureCopy();
	                    $featurecopy = str_replace("&trade;", "™", $featurecopy);
	                    $featurecopy = str_replace("&reg;", "®", $featurecopy);
	                    $featurecopy = str_replace("&#39;", "'", $featurecopy);
	                    $partArray[] = $featurecopy;
	                    $featurecopy = '';
	                    $iterator++;
	                }
	                while ($iterator < 20) {
	                    $partArray[] = '';
	                    $iterator++;
	                }
	            } else {
					$iterator=0;
					while ($iterator < 20) {
			                    $partArray[] = '';
					    $iterator++;
					}
	            }
	
	            $partAssetArray = array(
	                'P01' => '',
	                'P03' => '',
	                'P04' => '',
	                'P05' => '',
	                'P06' => '',
	                'P07' => ''
	            );
	            foreach ($record->getPartAsset() as $partAsset) {
	                $asset = $partAsset->getAsset();
	
	                $partAssetArray[$partAsset->getPicType()] = $asset->getFileName();
	            }
	
	            ksort($partAssetArray);
	
	            foreach ($partAssetArray as $key => $value) {
	                $partArray[] = $value;
	            }
	
	            fputcsv($fp, $partArray);
            
        	}
        }
    }

    /**
     * @param  string $location
     * @return void
     */
    public function saveCSV($location = null)
    {
        $fp = fopen($location, 'w');

        $this->getBody($fp);

        fclose($fp);

        return true;
    }

    /**
     * @return string
     */
    private function _getPiesVersion()
    {
        return $this->_piesVersion;
    }
}
