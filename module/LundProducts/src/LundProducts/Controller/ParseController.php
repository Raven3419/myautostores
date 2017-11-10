<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;
use SPLFileInfo,
    SPLFileObject;
use RecursiveIteratorIterator,
    RecursiveDirectoryIterator;
use LundProducts\Service\ParseMasterService,
    LundProducts\Service\ParseSupplementService;
use LundProducts\Service\ParsePromoService;
use LundProducts\Service\PromoService;
use RocketAdmin\Service\AuditService;
use RocketDam\Service\AssetService;
use RocketDam\Entity\AssetInterface;
use LundProducts\Service\PartAssetService;
use LundProducts\Service\PartService;
use LundProducts\Service\ProductLineService;
use LundProducts\Service\FileLogService;
use RocketAdmin\Service\TaskService;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ProductLineAssetService;
use RocketUser\Service\UserService;
use LundProducts\Service\ProductReviewService;
use DateTime;

/**
 * Parse master/supplement controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ParseController extends AbstractActionController
{
    /**
     * @var ParseMasterService
     */
    protected $masterService = null;

    /**
     * @var ParseSupplementService
     */
    protected $supplementService = null;
    
    /**
     * @var ParsePromoService
     */
    protected $parsePromoService= null;
    
    /**
     * @var PromoService
     */
    protected $promoService = null;

    /**
     * @var AuditService
     */
    protected $auditService;

    /**
     * @var AssetService
     */
    protected $assetService;

    /**
     * @var PartAssetService
     */
    protected $partAssetService;

    /**
     * @var PartService
     */
    protected $partService;

    /**
     * @var ProductLineService
     */
    protected $productLineService;

    /**
     * @var FileLogService
     */
    protected $fileLogService;

    /**
     * @var TaskService
     */
    protected $taskService;

    /**
     * @var ChangesetsService
     */
    protected $changesetsService;

    /**
     * @var ProductLineAssetService
     */
    protected $productLineAssetService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var ProductReviewService
     */
    protected $productReviewService;

    protected $_extensions = ['csv'];

    /**
     * @param ParseMasterService     $masterService
     * @param ParseSupplementService $supplementService
     * @param ParsePromoService      $parsePromoService
     * @param PromoService           $promoService
     * @param AuditService           $auditService;
     * @param AssetService           $assetService
     * @param PartAssetService       $partAssetService
     * @param PartService            $partService
     * @oaram ProductLineService     $productLineService
     * @param FileLogService          $fileLogService
     * @param TaskService             $taskService
     * @param ChangesetsService       $changesetsService
     * @param ProductLineAssetService $productLineAssetService
     * @param UserService             $userService
     * @param ProductReviewService    $productReviewService
     */
    public function __construct(
        ParseMasterService         $masterService,
        ParseSupplementService     $supplementService,
        ParsePromoService          $parsePromoService,
        PromoService               $promoService,
        AuditService               $auditService,
        AssetService               $assetService,
        PartAssetService           $partAssetService,
        PartService                $partService,
        ProductLineService         $productLineService,
        FileLogService             $fileLogService,
        TaskService                $taskService,
        ChangesetsService          $changesetsService,
        ProductLineAssetService    $productLineAssetService,
        UserService                $userService,
        ProductReviewService       $productReviewService
    )
    {
        $this->masterService     = $masterService;
        $this->supplementService = $supplementService;
        $this->parsePromoService = $parsePromoService;
        $this->promoService      = $promoService;
        $this->auditService      = $auditService;
        $this->assetService      = $assetService;
        $this->partAssetService  = $partAssetService;
        $this->partService       = $partService;
        $this->productLineService = $productLineService;
        $this->fileLogService    = $fileLogService;
        $this->taskService       = $taskService;
        $this->changesetsService = $changesetsService;
        $this->productLineAssetService = $productLineAssetService;
        $this->userService          = $userService;
        $this->productReviewService = $productReviewService;
    }

    /**
     * Parse the part staging directory and associate assets to parts
     */
    public function parseassetsAction()
    {
        $dirname = $this->getRequest()->getParam('dirname');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryiterator($dirname)
        );

        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'tif', 'mov', 'mp4', 'm4v'];
        $image_exts = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'tif'];
        $video_exts = ['mov', 'mp4', 'm4v'];

        $partIdArr = array();

        foreach ($files as $file) {
            if (!in_array(strtolower($file->getExtension()), $allowed_exts)) {
                continue;
            }

            $videoType = null;
            $picType   = null;
            $assetType = null;

            $path = $file->getPath();
            $fileName = $file->getFilename();
            $fullPath = $file->getPathname();
            $size = $file->getSize();
            $mtime = $file->getMTime();
            $ext = strtolower($file->getExtension());

            if (in_array(strtolower($file->getExtension()), $image_exts)) {
                $assetType = 'picture';
            } elseif (in_array(strtolower($file->getExtension()), $video_exts)) {
                $assetType = 'video';
            }

            $finfo = finfo_open(FILEINFO_MIME);
            $mimeArr = explode(';', finfo_file($finfo, $fullPath));
            $mime = $mimeArr[0];
            finfo_close($finfo);

            $partTmpArr = explode('.', $fileName);
            $partArr = explode('_', $partTmpArr[0]);
//var_dump($fileName);
//exit;
//print_r($partArr);exit;           
            
            if ($assetType == 'picture') {
                if (!is_array($partArr) || count($partArr) < 3) {
                    continue;
                }

                $partNumber = $partArr[0];
                $picType    = strtoupper($partArr[1]);

                if ($picType != 'P01' && $picType != 'P03' && $picType != 'P04' && $picType != 'P05' && $picType != 'P06' && $picType != 'P07') {
                    continue;
                }

                $resolution = strtoupper($partArr[2]);
                
                if(isset($partArr[3]))
                {
                	$sequence = $partArr[3];
                }
                else
                {
                	$sequence = 1;
                }
                
                
                /*
                if (preg_match('/_/', $resolution)) {
                    $resArr = explode('_', $resolution);
                    $resolution = $resArr[0];
                    $sequence = $resArr[1];
                } else {
                    $sequence = 1;
                }
                */
                

                $dimensions = getimagesize($fullPath);
            } elseif ($assetType == 'video') {

            }

            $part = $this->partService->getPartByPartNumber($partNumber);

            if (null != $part) {
                if (!in_array($part->getPartId(), $partIdArr)) {
                    $partIdArr[] = $part->getPartId();
                }

                $stat = array(
                    'size' => $size,
                    'mime' => $mime,
                    'ext'  => $ext,
                );

                if ($assetType == 'picture') {
                    $stat['filetype'] = 'partimage';
                    $stat['width'] = $dimensions[0];
                    $stat['height'] = $dimensions[1];
                } elseif ($assetType == 'video') {
                    $stat['filetype'] = 'partvideo';
                }

                $hashPath = 'library/products/parts/'.$fileName;
                $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
                $hash = rtrim($hash, '.');
                $hash = 'l1_'.$hash;

                $asset = $this->assetService->getAssetPrototype();;
                $asset = $this->assetService->saveFile('library/products/parts', $fileName, $stat, $hash);

                if ($asset instanceof AssetInterface) {
                    $ingest_asset_command = 'mv "' . $fullPath . '" "' . realpath(__DIR__ . '/../../../../../public/assets/library/products/parts') . '/' . $fileName . '"';
                    shell_exec($ingest_asset_command);
                } else {
                    // Error creating asset
                    continue;
                }

                $amazonName = null;

                if (!$this->partAssetService->duplicateCheck($part, $asset)) {
                    $partAsset = $this->partAssetService->create($part, $asset, $amazonName, $picType, $sequence, $assetType, $videoType);
                }
            }

            $this->partAssetService->flushObject();
        }

        $this->cleanUpAmazon($partIdArr);
    }

    /**
     * Clean up part asset table based on amazon requirements
     *
     * @param array $partIds
     */
    public function cleanUpAmazon($partIds)
    {
        foreach ($partIds as $id) {
            $part       = $this->partService->getPart($id);
            $partAssets = $this->partAssetService->getPartAssetsByPart($part);

            $upc = $part->getUpcCode();

            $amazonName = null;
            $descr      = null;

            $counter = 1;

            foreach ($partAssets as $partAsset) {
                switch ($partAsset->getPicType()) {
                    case 'P04':
                        $descr = 'MAIN';
                        break;
                    case 'P05':
                        $descr = 'PT0' . $counter;
                        $counter++;
                        break;
                    case 'P06':
                        $descr = 'PT0' . $counter;
                        $counter++;
                        break;
                    case 'P07':
                        $descr = 'PT0' . $counter;
                        $counter++;
                        break;
                    case 'P03':
                        $descr = 'PT0' . $counter;
                        $counter++;
                        break;
                    case 'P01':
                        $descr = 'PT0' . $counter;
                        $counter++;
                        break;
                }

                $amazonName = $upc . '.' . $descr . '.' . $partAsset->getAsset()->getExtension();
                $this->partAssetService->editPartAsset($partAsset, $amazonName);
            }

            $this->partAssetService->flushObject();
        }
    }

    /**
     * Fix MS Word Characters
     */
    public function fixMsWord($string)
    {
        $string = mb_convert_encoding($string, 'UTF-8', mb_detect_encoding($string, 'UTF-8, ISO-8859-1, ISO-8859-15', true));

        return mb_convert_encoding($string, 'HTML-ENTITIES', 'UTF-8');
        /*$map = array(
        chr(0x8A) => chr(0xA9),
        chr(0x8C) => chr(0xA6),
        chr(0x8D) => chr(0xAB),
        chr(0x8E) => chr(0xAE),
        chr(0x8F) => chr(0xAC),
        chr(0x9C) => chr(0xB6),
        chr(0x9D) => chr(0xBB),
        chr(0xA1) => chr(0xB7),
        chr(0xA5) => chr(0xA1),
        chr(0xBC) => chr(0xA5),
        chr(0x9F) => chr(0xBC),
        chr(0xB9) => chr(0xB1),
        chr(0x9A) => chr(0xB9),
        chr(0xBE) => chr(0xB5),
        chr(0x9E) => chr(0xBE),
        chr(0x80) => '&euro;',
        chr(0x82) => '&sbquo;',
        chr(0x84) => '&bdquo;',
        chr(0x85) => '&hellip;',
        chr(0x86) => '&dagger;',
        chr(0x87) => '&Dagger;',
        chr(0x89) => '&permil;',
        chr(0x8B) => '&lsaquo;',
        chr(0x91) => '&lsquo;',
        chr(0x92) => '&rsquo;',
        chr(0x93) => '&ldquo;',
        chr(0x94) => '&rdquo;',
        chr(0x95) => '&bull;',
        chr(0x96) => '&ndash;',
        chr(0x97) => '&mdash;',
        chr(0x99) => '&trade;',
        chr(0x9B) => '&rsquo;',
        chr(0xA6) => '&brvbar;',
        chr(0xA9) => '&copy;',
        chr(0xAB) => '&laquo;',
        chr(0xAE) => '&reg;',
        chr(0xB1) => '&plusmn;',
        chr(0xB5) => '&micro;',
        chr(0xB6) => '&para;',
        chr(0xB7) => '&middot;',
        chr(0xBB) => '&raquo;',
    );
        $new_string = html_entity_decode(mb_convert_encoding(strtr($string, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8');

        return $new_string;*/
    }

    /**
     * Parse reviewmigration document
     *
     * @return null
     */
    public function parsereviewmigrationAction()
    {
        $filename   = $this->getRequest()->getParam('filename');

        $file = new SPLFileObject($filename);

        if (($file->isFile()) && ($file->isReadable())) {
            $file->setFlags(SplFileObject::READ_CSV);
            $file->setCsvControl(',', '"', '\\');
            $iterator = 0;

            $filepath = explode('/', $filename);

            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Migration File Ingestion',
                'summary'   => 'Starting product reviews migration file ingestions on file \'' . $filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);

            foreach ($file as $rowData) {
                $iterator++;

                if (($iterator == 1) || (count($rowData) <=1)) {
                    continue;
                }
/**
 * first_name       0
 * last_name        1
 * email            2
 * address          3
 * address_2        4
 * city             5
 * state            6
 * country          7
 * zip              8
 * name             9
 * dci_name         10
 * review           11
 * rating           12
 * date             13
 */

                $first_name  = trim($rowData[0]);
                $last_name   = trim($rowData[1]);
                $email       = trim($rowData[2]);
                $address     = trim($rowData[3]);
                $address_2   = trim($rowData[4]);
                $city        = trim($rowData[5]);
                $state       = trim($rowData[6]);
                $country     = trim($rowData[7]);
                $zip         = trim($rowData[8]);
                $name        = trim($rowData[9]);
                $dci_name    = trim($rowData[10]);
                $review      = trim($rowData[11]);
                $rating      = trim($rowData[12]);
                $date        = trim($rowData[13]);

                $user = null;
                $existing = null;
                echo "ITERATOR: ".$iterator."\n";
                if (strlen($email) > 1) {
                    if ($email == 'NULL') { $email = 'webmaster@gorocketred.com'; }
                    $existing = $this->userService->getUserByEmail($email);
                    if (null == $existing) {
                        $userForm = $this->userService->getCreateUserForm();
                        $systemUser = $this->userService->getUser(6);

                        $newPassword = 'thesmartdata';

                        $data = new \Zend\Stdlib\Parameters();
                        $values = array(
                            'username' => strtolower($email),
                            'password' => $newPassword,
                            'passwordVerification' => $newPassword,
                            'disabled' => '0',
                            'role' => '5',
                            'firstName' => ($first_name != NULL ? $first_name : 'system'),
                            'lastName' => ($last_name != NULL ? $last_name : 'system'),
                            'emailAddress' => $email,
                            'companyName' => null,
                            'streetAddress' => ($address != NULL ? $address : '4325 Hamilton Mill Road'),
                            'extStreetAddress' => $address_2,
                            'locality' => ($city != NULL ? $city : 'Buford'),
                            'region' => '18660',
                            'postCode' => ($zip != NULL ? $zip : '30518'),
                            'country' => '240'
                        );

                        $data->set('user-fieldset', $values);

                        $user = $this->userService->create($systemUser, $data);
                    } else {
                        $user = $existing;
                    }

                    if (null != $user) {
                        $productLine = $this->productLineService->getProductLineByName($name);

                        if (null != $productLine) {
                            $productReview = $this->productReviewService->getProductReviewsPrototype();

                            $productReview->setCreatedAt(new \DateTime($date));
                            $productReview->setCreatedBy($user->getUsername());
                            $productReview->setUser($user);
                            $productReview->setReview($review);
                            $productReview->setRating($rating);
                            $productReview->setProductLines($productLine);

                            $result = $this->productReviewService->createProductReviewParse($productReview, $user);
                            $this->productReviewService->flushObject();
                        }
                    }
                }
            }
        }
    }

    /**
     * Parse copymigration document
     *
     * @return null
     */
    public function parsecopymigrationAction()
    {
        $filename   = $this->getRequest()->getParam('filename');
        $brand_name = $this->getRequest()->getParam('brand', null);

        $file = new SPLFileObject($filename);

        if (($file->isFile()) && ($file->isReadable())) {
            $file->setFlags(SplFileObject::READ_CSV);
            $file->setCsvControl(',', '"', '"');
            $iterator = 0;

            $partArray = array();
            $lineArray = array();

            $filepath = explode('/', $filename);

            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Migration File Ingestion',
                'summary'   => 'Starting part copy migration file ingestions on file \'' . $filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);

            foreach ($file as $rowData) {
                $iterator++;

                if (($iterator == 1) || (count($rowData) <=1)) {
                    continue;
                }
/**
 * Item #                           0    "12003"
 * Brand                            1    "AVS"
 * Item Class                       2    "RE"
 * Class Description                3    "VENTSHADE - 2PC STAINLESS"
 * Product Family                   4    24
 * Product Family Description       5    "WINDOW"
 * Marketing Copy                   6    "The original ..."
 * Feature 1                        7    "Custom fit ..."
 * Feature 2                        8    "Custom fit ..."
 * Feature 3                        9    "Custom fit ..."
 * Feature 4                        10   "Custom fit ..."
 * Feature 5                        11   "Custom fit ..."
 * Feature 6                        12   "Custom fit ..."
 * Feature 7                        13   "Custom fit ..."
 * Feature 8                        14   "Custom fit ..."
 * Feature 9                        15   "Custom fit ..."
 * Feature 10                       16   "Custom fit ..."
 * Feature 11                       17   "Custom fit ..."
 * Feature 12                       18   "Custom fit ..."
 * Feature 13                       19   "Custom fit ..."
 * Feature 14                       20   "Custom fit ..."
 * Feature 15                       21   "Custom fit ..."
 * Feature 16                       22   "Custom fit ..."
 * Feature 17                       23   "Custom fit ..."
 * Feature 18                       24   "Custom fit ..."
 * Feature 19                       25   "Custom fit ..."
 * Feature 20                       26   "Custom fit ..."
 */
                $part_number                   = trim($rowData[0]);
                $brand                         = trim($rowData[1]);
                $product_lines_short_code      = trim($rowData[3]);
                $product_categories_short_code = trim($rowData[5]);
                $marketing_copy                = trim($rowData[6]);
                $feature_1                     = trim($rowData[7]);
                $feature_2                     = trim($rowData[8]);
                $feature_3                     = trim($rowData[9]);
                $feature_4                     = trim($rowData[10]);
                $feature_5                     = trim($rowData[11]);
                $feature_6                     = trim($rowData[12]);
                $feature_7                     = trim($rowData[13]);
                $feature_8                     = trim($rowData[14]);
                $feature_9                     = trim($rowData[15]);
                $feature_10                    = trim($rowData[16]);
                $feature_11                    = trim($rowData[17]);
                $feature_12                    = trim($rowData[18]);
                $feature_13                    = trim($rowData[19]);
                $feature_14                    = trim($rowData[20]);
                $feature_15                    = trim($rowData[21]);
                $feature_16                    = trim($rowData[22]);
                $feature_17                    = trim($rowData[23]);
                $feature_18                    = trim($rowData[24]);
                $feature_19                    = trim($rowData[25]);
                $feature_20                    = trim($rowData[26]);

                if (trim($part_number) == '') {
                    continue;
                }

                $featuresArray = array(
                    $this->fixMsWord($feature_1),
                    $this->fixMsWord($feature_2),
                    $this->fixMsWord($feature_3),
                    $this->fixMsWord($feature_4),
                    $this->fixMsWord($feature_5),
                    $this->fixMsWord($feature_6),
                    $this->fixMsWord($feature_7),
                    $this->fixMsWord($feature_8),
                    $this->fixMsWord($feature_9),
                    $this->fixMsWord($feature_10),
                    $this->fixMsWord($feature_11),
                    $this->fixMsWord($feature_12),
                    $this->fixMsWord($feature_13),
                    $this->fixMsWord($feature_14),
                    $this->fixMsWord($feature_15),
                    $this->fixMsWord($feature_16),
                    $this->fixMsWord($feature_17),
                    $this->fixMsWord($feature_18),
                    $this->fixMsWord($feature_19),
                    $this->fixMsWord($feature_20)
                );

                $part = $this->partService->getPartByPartNumber($part_number);

                if (null != $part) {
                    $productLine = $part->getProductLine();

                    if (!in_array($productLine->getProductLineId(), $lineArray)) {
                        $productLine->setOverview($this->fixMsWord($marketing_copy));
                        //$productLine->setFeatures($this->fixMsWord($features));
                        //$productLine->setOverview($marketing_copy);
                        //$productLine->setFeatures($features);

                        $result = $this->productLineService->editProductLineCopy($productLine, $featuresArray);

                        $lineArray[] = $productLine->getProductLineId();
                    }
                } else {
                    //var_dump('NOT FOUND PART[' . $iterator . ']: ' . $part_number);
                }
            }

            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Migration File Ingestion',
                'summary'   => 'Finished part copy migration file ingestions on file \'' . $filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);
        }
    }

    /**
     * Parse plassetmigration document
     *
     * @return null
     */
    public function parseplassetmigrationAction()
    {
        $filename   = $this->getRequest()->getParam('filename');
        $brand_name = $this->getRequest()->getParam('brand', null);

        $file = new SPLFileObject($filename);

        if (($file->isFile()) && ($file->isReadable())) {
            $file->setFlags(SplFileObject::READ_CSV);
            $file->setCsvControl(',', '"', '\\');
            $iterator = 0;

            $productLineArray = array();

            $filepath = explode('/', $filename);

            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Migration File Ingestion',
                'summary'   => 'Starting product line asset migration file ingestions on file \'' . $filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);

            foreach ($file as $rowData) {
                $iterator++;

                if (($iterator == 1) || (count($rowData) <=1)) {
                    continue;
                }
/**
 * Item #                           0   "12003"
 * Brand                            1   "AVS"
 * Item Class                       2   "RE"
 * Class Description                3   "VENTSHADE - 2PC STAINLESS"
 * Product Family                   4   24
 * Product Family Description       5   "WINDOW"
 * P01 - Off Vehicle                6   "RE-1.jpg"
 * P03 - Lifestyle                  7   "RE-1.jpg"
 * P04 - Primary Photo              8   "RE-1.jpg"
 * P05 - Closeup                    9   "RE-1.jpg"
 * P06 - Mounted                    10  "RE-1.jpg"
 * P07 - Unmounted                  11  "RE-1.jpg"
 */

                $part_number                   = trim($rowData[0]);
                $brand                         = trim($rowData[1]);
                $product_lines_short_code      = trim($rowData[3]);
                $product_categories_short_code = trim($rowData[5]);
                $p01                           = trim($rowData[6]);
                $p03                           = trim($rowData[7]);
                $p04                           = trim($rowData[8]);
                $p05                           = trim($rowData[9]);
                $p06                           = trim($rowData[10]);
                $p07                           = trim($rowData[11]);

                if (trim($part_number) == '') {
                    continue;
                }

                $part = $this->partService->getPartByPartNumber($part_number);
                $hasImage = null;

                if (null != $part) {
                    if (!in_array($part->getProductLine()->getProductLineId(), $productLineArray)) {
                        $imageArray = array($p04, $p03, $p05, $p06, $p07, $p01);

                        $iterator = 1;
                        foreach ($imageArray as $image) {
                            if (strlen($image) > 1) {
                                $asset = $this->assetService->getAssetByPath('library/products/parts/' . $image);
                                if (null != $asset) {
                                    $fullPath = realpath(__DIR__ . '/../../../../../public/assets/library/products/parts') . '/' . $asset->getFileName();
                                    $pretty = preg_replace('/ /', '', strip_tags(strtolower($part->getProductLine()->getName())));
                                    $fileName = $pretty . '-' . $iterator . '.' . $asset->getExtension();
                                    $hashPath = 'library/products/product_lines/'.$fileName;
                                    $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
                                    $hash = rtrim($hash, '.');
                                    $hash = 'l1_'.$hash;
                                    $newAsset = $this->assetService->saveFile('library/products/product_lines', $fileName, [
                                        'mime'     => $asset->getMime(),
                                        'filetype' => 'file',
                                        'ext'      => $asset->getExtension(),
                                        'size'     => $asset->getSize(),
                                        'height'   => $asset->getHeight(),
                                        'width'    => $asset->getWidth()], $hash);

                                    $productLineAsset = $this->productLineAssetService->create($part->getProductLine(), $newAsset, $iterator, 'picture', null);

                                    $ingest_asset_command = 'cp "' . $fullPath . '" "' . realpath(__DIR__ . '/../../../../../public/assets/library/products/product_lines') . '/' . $fileName . '"';
                                    shell_exec($ingest_asset_command);

                                    $hasImage = true;
                                    $iterator++;
                                }
                            }
                        }

                        if ($hasImage) {
                            $productLineArray[] = $part->getProductLine()->getProductLineId();
                        }
                    }
                } else {
                    //var_dump('NOT FOUND PART[' . $iterator . ']: ' . $part_number);
                }

                $this->productLineAssetService->flushObject();
            }

            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Migration File Ingestion',
                'summary'   => 'Finished product line asset migration file ingestions on file \'' . $filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);
        }
    }

    /**
     * Parse assetmigration document
     *
     * @return null
     */
    public function parseassetmigrationAction()
    {
        $filename   = $this->getRequest()->getParam('filename');
        $brand_name = $this->getRequest()->getParam('brand', null);

        $file = new SPLFileObject($filename);

        if (($file->isFile()) && ($file->isReadable())) {
            $file->setFlags(SplFileObject::READ_CSV);
            $file->setCsvControl(',', '"', '\\');
            $iterator = 0;

            $partArray = array();

            $filepath = explode('/', $filename);

            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Migration File Ingestion',
                'summary'   => 'Starting part asset migration file ingestions on file \'' . $filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);

            foreach ($file as $rowData) {
                $iterator++;

                if (($iterator == 1) || (count($rowData) <=1)) {
                    continue;
                }
/**
 * Item #                           0   "12003"
 * Brand                            1   "AVS"
 * Item Class                       2   "RE"
 * Class Description                3   "VENTSHADE - 2PC STAINLESS"
 * Product Family                   4   24
 * Product Family Description       5   "WINDOW"
 * P01 - Off Vehicle                6   "RE-1.jpg"
 * P03 - Lifestyle                  7   "RE-1.jpg"
 * P04 - Primary Photo              8   "RE-1.jpg"
 * P05 - Closeup                    9   "RE-1.jpg"
 * P06 - Mounted                    10  "RE-1.jpg"
 * P07 - Unmounted                  11  "RE-1.jpg"
 */

                $part_number                   = trim($rowData[0]);
                $brand                         = trim($rowData[1]);
                $product_lines_short_code      = trim($rowData[3]);
                $product_categories_short_code = trim($rowData[5]);
                $p01                           = trim($rowData[6]);
                $p03                           = trim($rowData[7]);
                $p04                           = trim($rowData[8]);
                $p05                           = trim($rowData[9]);
                $p06                           = trim($rowData[10]);
                $p07                           = trim($rowData[11]);

                if (trim($part_number) == '') {
                    continue;
                }

                $part = $this->partService->getPartByPartNumber($part_number);
                $hasImage = null;

                if (null != $part) {
                    $p01Asset = $this->assetService->getAssetByPath('library/products/parts/' . $p01);
                    if (null != $p01Asset && !$this->partAssetService->duplicateCheck($part, $p01Asset)) {
                        $partAsset = $this->partAssetService->create($part, $p01Asset, null, 'P01', '1', 'picture', null);
                        $hasImage = true;
                    } else {
                        if (strlen($p01) > 1) {
                            //var_dump('NOT FOUND P01[' . $iterator . ']: ' . $part_number . ' - ' . $p01);
                        }
                    }

                    $p03Asset = $this->assetService->getAssetByPath('library/products/parts/' . $p03);
                    if (null != $p03Asset && !$this->partAssetService->duplicateCheck($part, $p03Asset)) {
                        $partAsset = $this->partAssetService->create($part, $p03Asset, null, 'P03', '1', 'picture', null);
                        $hasImage = true;
                    } else {
                        if (strlen($p03) > 1) {
                            //var_dump('NOT FOUND P03[' . $iterator . ']: ' . $part_number . ' - ' . $p03);
                        }
                    }

                    $p04Asset = $this->assetService->getAssetByPath('library/products/parts/' . $p04);
                    if (null != $p04Asset && !$this->partAssetService->duplicateCheck($part, $p04Asset)) {
                        $partAsset = $this->partAssetService->create($part, $p04Asset, null, 'P04', '1', 'picture', null);
                        $hasImage = true;
                    } else {
                        if (strlen($p04) > 1) {
                            //var_dump('NOT FOUND P04[' . $iterator . ']: ' . $part_number . ' - ' . $p04);
                        }
                    }

                    $p05Asset = $this->assetService->getAssetByPath('library/products/parts/' . $p05);
                    if (null != $p05Asset && !$this->partAssetService->duplicateCheck($part, $p05Asset)) {
                        $partAsset = $this->partAssetService->create($part, $p05Asset, null, 'P05', '1', 'picture', null);
                        $hasImage = true;
                    } else {
                        if (strlen($p05) > 1) {
                            //var_dump('NOT FOUND P05[' . $iterator . ']: ' . $part_number . ' - ' . $p05);
                        }
                    }

                    $p06Asset = $this->assetService->getAssetByPath('library/products/parts/' . $p06);
                    if (null != $p06Asset && !$this->partAssetService->duplicateCheck($part, $p06Asset)) {
                        $partAsset = $this->partAssetService->create($part, $p06Asset, null, 'P06', '1', 'picture', null);
                        $hasImage = true;
                    } else {
                        if (strlen($p06) > 1) {
                            //var_dump('NOT FOUND P06[' . $iterator . ']: ' . $part_number . ' - ' . $p06);
                        }
                    }

                    $p07Asset = $this->assetService->getAssetByPath('library/products/parts/' . $p07);
                    if (null != $p07Asset && !$this->partAssetService->duplicateCheck($part, $p07Asset)) {
                        $partAsset = $this->partAssetService->create($part, $p07Asset, null, 'P07', '1', 'picture', null);
                        $hasImage = true;
                    } else {
                        if (strlen($p07) > 1) {
                            //var_dump('NOT FOUND P07[' . $iterator . ']: ' . $part_number . ' - ' . $p07);
                        }
                    }

                    if ($hasImage) {
                        $partArray[] = $part->getPartId();
                    }
                } else {
                    //var_dump('NOT FOUND PART[' . $iterator . ']: ' . $part_number);
                }

                $this->partAssetService->flushObject();
            }

            $this->cleanUpAmazon($partArray);

            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Migration File Ingestion',
                'summary'   => 'Finished part asset migration file ingestions on file \'' . $filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);
        }
    }
    
    /**
     * Parse the promo file, create changeset taxonomy.
     *
     * @return string
     */
    public function parsepromoAction()
    {
        
        $filename = $this->getRequest()->getParam('filename');
        $file     = new SPLFileObject($filename);
        
        if (($file->isFile()) && ($file->isReadable())) {
            switch (strtolower($file->getExtension())) {
                case 'csv':
                    $file->setFlags(SplFileObject::READ_CSV);
                    $file->setCsvControl(',', '"', '\\');
                    $iterator = 0;
                    $summary  = [];
                    
                    $filepath = explode('/', $filename);
                    
                    // generate audit log entry
                    $this->auditService->create([
                        'createdBy' => 'system',
                        'object'    => 'LundProducts',
                        'action'    => 'Promo File Ingestion',
                        'summary'   => 'Starting promp file ingestion on file \'' . $filepath[count($filepath) - 1] . '\'',
                        'result'    => 'success',
                    ]);
                    
                    foreach ($file as $rowData) {
                        
                        $iterator++;
                        
                        // TODO: figure out why CSV file contains an array with no data in it.
                        if (($iterator == 1) || (count($rowData) <= 1)) {
                            continue;
                        }
                        
                        /*
                         customerNumber             0   "20",
                         partNumber                 1   "92741",
                         itemClass                  2   "VENTVISOR 2PC",
                         startDate                  3   "2017-06-25",
                         endDate                    4   "2017-06-25",
                         promoDesc                  5   "OB",
                         promoCode                  6   "summer2017",
                         promoNumber                7   "1",
                         promoLine                  8   "",
                         price                      9   "10.00",
                         percent                    10  "20",
                         itemPromoPrice             11  "Y",
                         itemPromoOff               12  "Y",
                         customerPromo              13  "Y",
                         itemClassPromo             14  "Y",
                         itemPromo                  15  "Y",
                         description                16  "$10 off part number 796003",
                         */
                        
                        $customerNumber                 = trim($rowData[0]);
                        $partNumber                     = trim($rowData[1]);
                        $itemClass                      = trim($rowData[2]);
                        $startDate                      = trim($rowData[3]);
                        $endDate                        = trim($rowData[4]);
                        $promoDesc                      = trim($rowData[5]);
                        $promoCode                      = trim($rowData[6]);
                        $promoNumber                    = trim($rowData[7]);
                        $promoLine                      = trim($rowData[8]);
                        $price                          = (!empty(trim($rowData[9])) ? trim($rowData[9]) : '0.00');
                        $percent                        = trim($rowData[10]);
                        $promoPrice                     = strtoupper(trim($rowData[11]));
                        $promoOff                       = strtoupper(trim($rowData[12]));
                        $customerPromo                  = ((trim($rowData[13]) == 'Y' ) ? trim($rowData[13]) : 'N');
                        $itemClassPromo                 = strtoupper(trim($rowData[14]));
                        $itemPromo                      = strtoupper(trim($rowData[15]));
                        $description                    = strtoupper(trim($rowData[16]));
                        
                        $activePromo = $this->promoService->getActivePromo($promoNumber, $promoLine);
                        
                        
                        if(empty($activePromo)) {
                            
                            // create changeset, update summary later
                            $promo    = $this->parsePromoService->createPromo(date('Y-m-d H:i:s'), null, null, null, 0, 0, $promoNumber, $promoLine);
                            
                            $promo_id = $promo['promo_id'];
                            
                            
                        } else {
                            $promo_id = $activePromo[0]->getPromoId();
                        }
                        
                        if(!empty($partNumber)) {
                            $foundPart = $this->supplementService->findPart($partNumber);
                            
                            $partId = $foundPart['part_id'];
                        } else {
                            $partId = null;
                        }
                        
                        
                        if(!empty($itemClass)) {
                            $foundProductLine = $this->supplementService->findProductLine($itemClass);
                        
                            $productLineId = $foundProductLine['product_line_id'];
                        } else {
                            $productLineId = null;
                        }
                        $promoId = $this->parsePromoService->editPromo($promo_id, $customerNumber, $partId, $productLineId, $startDate, $endDate, $promoDesc, $promoCode,
                                                                    $price, $percent, $promoPrice, $promoOff, $customerPromo, $itemClassPromo, $itemPromo, $description);
                        
                     
                }
            }
        }
    }

    /**
     * Parse the supplement file, create changeset taxonomy.
     *
     * @return string
     */
    public function parsesupplementAction()
    {
        $filename = $this->getRequest()->getParam('filename');
        $file     = new SPLFileObject($filename);

        if (($file->isFile()) && ($file->isReadable())) {
            switch (strtolower($file->getExtension())) {
                case 'csv':
                    $file->setFlags(SplFileObject::READ_CSV);
                    $file->setCsvControl(',', '"', '\\');
                    $iterator = 0;
                    $summary  = [];

                    $filepath = explode('/', $filename);

                    // generate audit log entry
                    $this->auditService->create([
                        'createdBy' => 'system',
                        'object'    => 'LundProducts',
                        'action'    => 'Supplement File Ingestion',
                        'summary'   => 'Starting supplement file ingestion on file \'' . $filepath[count($filepath) - 1] . '\'',
                        'result'    => 'success',
                    ]);

                    // create changeset, update summary later
                    $changeset    = $this->supplementService->createChangeset(date('Y-m-d H:i:s'), null, null, null, 0, 0, date('Y-m-d H:i:s'), null, $filename);
                    $changeset_id = $changeset['changeset_id'];

                    $changesetObject = $this->changesetsService->getChangeset($changeset_id);

                    //print_r($file);exit;
                    foreach ($file as $rowData) {
                    	
                        $iterator++;

                        // TODO: figure out why CSV file contains an array with no data in it.
                        if (($iterator == 1) || (count($rowData) <= 1)) {
                            continue;
                        }
                        
/*
item                      0   "192503"
brand                     1   "AVS",
class                     2   "P1",
ClassDesc                 3   "IN-CHANNEL VENTVISOR 2PC",
PF                        4   24,
PF_Desc                   5   "WINDOW",
FromYear                  6   1999.0,
ToYear                    7   2013.0,
Make                      8   "FORD",
Model                     9   "F-250",
SubModel                 10   "",
SubDetail                11   "",
BodyTyp                  12   "",
BedTyp                   13   "",
Jobber                   14   51.800,
MSRP                     15   69.920,
MAP                      16   0.00,
POPcode                  17   "B",
UPC                      18   "725478069853",
Weight                   19   2.10,
Height                   20   1.88,
Width                    21   12.25,
Length                   22   47.25,
ShippingHrs              23   48,
Color                    24   "SMOKE",
NoDrill                  25   "",
ExtraDesc                26   "",
In App guide             27   "Y",
InJobber                 28   "Y",
I-Sheet                  29   "99VV21",
DateChgdSinceLastDwnLoad 30   0,
CountryOfOrgn            31   "USA",
RetailFlg                32   "Y",
OversizeCode             33   "0",
StatusCode               34   0,
OriginalBrand            35   "AVS",
FlareHeight              36   0.00,
FlareTireCoverage        37   0.00,
DIM_A                    38   0.000,
DIM_B                    39   0.000,
DIM_C                    40   0.000,
DIM_D                    41   0.000,
DIM_E                    42   0.000,
DIM_F                    43   0.000,
DIM_G                    44   0.000,
VehicleType              45   "T",
ModelType                46   "",
MakeID                   47   "54",
ModelID                  48   "667",
SubModelID               49   "",
NoDoorsID                50   "",
PartTypeID               51   "",
BodyTypeID               52   "",
BedTypeID                53   "",
MaintType                54   "CHANGE",
AppChgd                  55   "Y",
StatusChgd               56   "",
CountryChgd              57   "",
POPchgd                  58   "",
DimsChgd                 59   "",
ColorChgd                60   "",
ClassChgd                61   "",
ImageChgd                62   "",
SeqNo                    63    1,
year_changed             64   "",
lookup_id                65   ""
 */

                        //echo trim($rowData[0])." - ";
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
                        $veh_class_name                = trim($rowData[45]);
                        $body_type                     = trim($rowData[12]);
                        $bed_type                      = trim($rowData[13]);
                        $jobber_price                  = trim($rowData[14]);
                        $msrp_price                    = trim($rowData[15]);
                        $sale_price                    = trim($rowData[16]);
                        $pop_code                      = trim($rowData[17]);
                        $upc_code                      = trim($rowData[18]);
                        $weight                        = trim($rowData[19]);
                        $height                        = trim($rowData[20]);
                        $width                         = trim($rowData[21]);
                        $length                        = trim($rowData[22]);
                        $color                         = trim($rowData[24]);
                        $isheet                        = trim($rowData[29]);
                        $country_of_origin             = trim($rowData[31]);
                        $status_code                   = trim($rowData[34]);
                        $orig_brand                    = trim($rowData[35]);
                        $dima                          = trim($rowData[38]);
                        $dimb                          = trim($rowData[39]);
                        $dimc                          = trim($rowData[40]);
                        $dimd                          = trim($rowData[41]);
                        $dime                          = trim($rowData[42]);
                        $dimf                          = trim($rowData[43]);
                        $dimg                          = trim($rowData[44]);
                        $makeID                        = trim($rowData[47]);
                        $modelID                       = trim($rowData[48]);
                        $subModelID                    = trim($rowData[49]);
                        $noDoorsID                     = trim($rowData[50]);
                        $partTypeID                    = trim($rowData[51]);
                        $bodyTypeID                    = trim($rowData[52]);
                        $bedTypeID                     = trim($rowData[53]);
                        $change_type                   = trim($rowData[54]); // CHANGE, DELETE, etc
                        $app_changed              	   = strtoupper(trim($rowData[55])) == 'Y'; // TODO  Which data fields in csv are to be used to be replaced/removed
                        $status_changed                = strtoupper(trim($rowData[56])) == 'Y'; // TODO: Status: 0, 50, 55 - what do these mean?
                        $country_changed               = strtoupper(trim($rowData[57])) == 'Y'; // TODO: where does this field get updated when changeset approved?
                        $pop_changed                   = strtoupper(trim($rowData[58])) == 'Y'; // parts table
                        $dims_changed                  = strtoupper(trim($rowData[59])) == 'Y'; // parts table
                        $color_changed                 = strtoupper(trim($rowData[60])) == 'Y'; // parts table
                        $class_changed                 = strtoupper(trim($rowData[61])) == 'Y';
                        $image_changed                 = strtoupper(trim($rowData[62])) == 'Y';
                        $seq_no                        = trim($rowData[63]);
                        $year_changed				   = strtoupper(trim($rowData[64])) == 'Y';
                        $lookup_id                     = trim($rowData[65]);
                        $bed_length                    = trim($rowData[66]);
                        $bed_length_id                 = trim($rowData[67]);
                        $finish                        = trim($rowData[68]);
                        $style                         = trim($rowData[69]);
                        $material                      = trim($rowData[70]);
                        $meterial_thickness            = trim($rowData[71]);
                        $sold_as                       = trim($rowData[72]);
                        $tube_shape                    = trim($rowData[73]);
                        $tube_size                     = trim($rowData[74]);
                        $warranty                      = trim($rowData[75]);
                        $liquid_storage                = trim($rowData[76]);
                        $box_style                     = trim($rowData[77]);
                        $box_opening                   = trim($rowData[78]);
                        $based_veh_id                  = trim($rowData[79]);
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
                        $real_flare_height             = trim($rowData[92]);
                        $rear_flare_tire_coverage      = trim($rowData[93]);
                        $stake_holes                   = trim($rowData[94]);
                        $color_grp                     = trim($rowData[95]);
                        
                        //print_r($rowData);
                        //echo $rowData[54]."   -   ";

                        // universal parts:
                        // - Make = UNIVERSAL
                        // - missing Make, Model, Submodel and SubDetail
                        $universal = ((strtoupper(trim($veh_make_name)) == 'UNIVERSAL') ? true : false);

                        $change_file_row = '';

                        foreach ($rowData as $index => $rowColumnData) {
                            $change_file_row .= '"' . $rowColumnData . '",';
                        }

                        $changeset_detail_record = ['part_id'                => null,
                                                    'brand_id'               => null,
                                                    'product_category_id'    => null,
                                                    'product_line_id'        => null,
                                                    'changeset_id'           => $changeset_id,
                                                    'part_number'            => null,
                                                    'brand_label'            => null,
                                                    'product_category_label' => null,
                                                    'product_line_label'     => null,
                                                    'change'                 => trim(strtolower($change_type)),
                                                    'app_changed'            => null,
                                                    'status_changed'         => null,
                                                    'country_changed'        => null,
                                                    'pop_changed'            => null,
                                                    'color_changed'          => null,
                                                    'dims_changed'           => null,
                                                    'class_changed'          => null,
                                                    'image_changed'          => null,
                                                    'change_file_row'        => $change_file_row,
                                                   ];

                        // build summary
                        if ($app_changed == true) {
                            $summary[$change_type][] = 'app_changed';
                            $changeset_detail_record['app_changed'] = $app_changed;
                            //echo "(".$part_number.") - ";
                        }

                        if ($status_changed == true) {
                            $summary[$change_type][] = 'status_changed';
                            $changeset_detail_record['status_changed'] = $status_changed;
                        }

                        if ($country_changed == true) {
                            $summary[$change_type][] = 'country_changed';
                            $changeset_detail_record['country_changed'] = $country_changed;
                        }

                        if ($pop_changed == true) {
                            $summary[$change_type][] = 'pop_changed';
                            $changeset_detail_record['pop_changed'] = $pop_changed;
                        }

                        if ($dims_changed == true) {
                            $summary[$change_type][] = 'dims_changed';
                            $changeset_detail_record['dims_changed'] = $dims_changed;
                        }

                        if ($color_changed == true) {
                            $summary[$change_type][] = 'color_changed';
                            $changeset_detail_record['color_changed'] = $color_changed;
                        }

                        if ($class_changed == true) {
                            $summary[$change_type][] = 'class_changed';
                            $changeset_detail_record['class_changed'] = $class_changed;
                        }

                        if ($image_changed == true) {
                            $summary[$change_type][] = 'image_changed';
                            $changeset_detail_record['image_changed'] = $image_changed;
                        }
                        
                        if ($year_changed == true) {
                        	$summary[$change_type][] = 'year_changed';
                        	$changeset_detail_record['year_changed'] = $year_changed;
                        }

                        
                        $foundBrand = $this->masterService->findBrand($orig_brand);

                        // TODO: is there going to ever be a brand in the supplement file that doesn't already exist?
                        if (null != $foundBrand) {
                            $changeset_detail_record['brand_id'] = $foundBrand['brand_id'];
                        } else {
                            $changeset_detail_record['brand_label'] = $orig_brand;
                            
                            $foundBrand = $this->masterService->insertBrand(date('Y-m-d H:i:s'), 0, 0, $orig_brand, $orig_brand, $orig_brand);
                            
                            $changeset_detail_record['brand_id'] = $foundBrand['brand_id'];
                        }

                        $foundProductLine = $this->supplementService->findProductLine($product_lines_short_code);

                        if (null != $foundProductLine) {
                            $changeset_detail_record['product_line_id'] = $foundProductLine['product_line_id'];
                        } else {
                            $changeset_detail_record['product_line_label'] = $product_lines_short_code;
                        }

                        $foundProductCategory = $this->supplementService->findProductCategory($product_categories_short_code);

                        if (null != $foundProductCategory) {
                            $changeset_detail_record['product_category_id'] = $foundProductCategory['product_category_id'];
                        } else {
                            $changeset_detail_record['product_category_label'] = $product_categories_short_code;
                        }

                        $foundPart = $this->supplementService->findPart($part_number);

                        if (null != $foundPart) {
                            $changeset_detail_record['part_id'] = $foundPart['part_id'];
                        } else {
                            $changeset_detail_record['part_number'] = $part_number;
                        }

                        //print_r($changeset_detail_record);
                        $detail_record = $this->supplementService->createChangesetDetail($changeset_detail_record);

                        
                        if (($universal != true) && ($from_year > 0 && $to_year > 0)) {
                            $from_year = round((FLOAT)$from_year, 0, PHP_ROUND_HALF_DOWN);
                            $to_year   = round((FLOAT)$to_year, 0, PHP_ROUND_HALF_DOWN);

                            // insert changeset_details_vehicles record
                            for ($k = $from_year; $k <= $to_year; $k++) {
                                $this_year = $k;

                                $vehicle_record = [
                                    'veh_collection_id'   => null,
                                    'veh_make_id'         => null,
                                    'veh_model_id'        => null,
                                    'veh_submodel_id'     => null,
                                    'veh_year_id'         => null,
                                    'veh_class_id'        => null,
                                    'changeset_detail_id' => $detail_record['changeset_detail_id'],
                                    'veh_make_label'      => null,
                                    'veh_model_label'     => null,
                                    'veh_submodel_label'  => null,
                                    'veh_year_label'      => null,
                                    'veh_class_label'     => null,
                                    'body_type'           => null,
                                ];

                                // vehicle year
                                $foundVehYear = $this->masterService->findVehYear((STRING)$this_year);

                                if (null == $foundVehYear) {
                                    $vehicle_record['veh_year_label'] = (STRING)$this_year;
                                } else {
                                    $vehicle_record['veh_year_id'] = $foundVehYear['veh_year_id'];
                                }

                                // vehicle make
                                $foundVehMake = $this->masterService->findVehMake($veh_make_name);

                                if (null == $foundVehMake) {
                                    $vehicle_record['veh_make_label'] = $veh_make_name;
                                } else {
                                    $vehicle_record['veh_make_id'] = $foundVehMake['veh_make_id'];
                                }

                                $foundVehClass = $this->masterService->findVehClass($veh_class_name);

                                if (null == $foundVehClass) {
                                    $vehicle_record['veh_class_label'] = $veh_class_name;
                                } else {
                                    $vehicle_record['veh_class_id'] = $foundVehClass['veh_class_id'];
                                }

                                // vehicle model
                                $foundVehModel = $this->masterService->findVehModel($veh_model_name, $foundVehMake['veh_make_id']);

                                if (null == $foundVehModel) {
                                    $vehicle_record['veh_model_label'] = $veh_model_name;
                                } else {
                                    $vehicle_record['veh_model_id'] = $foundVehModel['veh_model_id'];
                                }

                                // veh_submodel
                                if (trim($veh_submodel_name) != '') {
                                    $foundVehSubmodel = $this->masterService->findVehSubmodel($veh_submodel_name, $foundVehModel['veh_model_id']);

                                    if (null == $foundVehSubmodel) {
                                        $vehicle_record['veh_submodel_label'] = $veh_submodel_name;
                                    } else {
                                        $vehicle_record['veh_submodel_id'] = $foundVehSubmodel['veh_submodel_id'];
                                    }
                                }

                                if (trim($body_type) != '') {
                                    $vehicle_record['body_type'] = $body_type;
                                }

                                // if veh_make_id, veh_model_id, veh_submodel_id, and veh_year_id exists, lookup veh_collection record
                                // update $vehicle_record['veh_collection_id'] with found record id.
                                if ((null != $vehicle_record['veh_make_id']) && (null != $vehicle_record['veh_model_id']) &&
                                    (null != $vehicle_record['veh_year_id'])) {
                                    // lookup veh_collection record
                                    $foundVehCollection = $this->supplementService->findVehCollection(
                                        $vehicle_record['veh_make_id'],
                                        $vehicle_record['veh_model_id'],
                                        $vehicle_record['veh_submodel_id'],
                                        $vehicle_record['veh_year_id'],
                                        $vehicle_record['body_type']
                                    );

                                    if (null != $foundVehCollection) {
                                        $vehicle_record['veh_collection_id'] = $foundVehCollection['veh_collection_id'];
                                    }
                                }

                                // insert changeset_details_vehicles record
                                $this->supplementService->createChangesetDetailsVehicle($vehicle_record);
                            }
                        }
                    }

                    // build summary
                    $changeset_summary = [];

                    if (is_array($summary)) {
                        foreach ($summary as $changeType => $whatChanged) {
                            $changeset_summary[$changeType] = '';

                            $app_changed_count     = 0;
                            $status_changed_count  = 0;
                            $country_changed_count = 0;
                            $pop_changed_count     = 0;
                            $dims_changed_count    = 0;
                            $color_changed_count   = 0;
                            $class_changed_count   = 0;
                            $image_changed_count   = 0;
                            $year_changed_count    = 0;

                            // find out how many things changed based on keys above
                            foreach ($whatChanged as $key) {
                                if ($key == 'app_changed') {
                                    $app_changed_count++;
                                }

                                if ($key == 'status_changed') {
                                    $status_changed_count++;
                                }

                                if ($key == 'country_changed') {
                                    $country_changed_count++;
                                }

                                if ($key == 'pop_changed') {
                                    $pop_changed_count++;
                                }

                                if ($key == 'dims_changed') {
                                    $dims_changed_count++;
                                }

                                if ($key == 'color_changed') {
                                    $color_changed_count++;
                                }

                                if ($key == 'class_changed') {
                                    $class_changed_count++;
                                }

                                if ($key == 'image_changed') {
                                    $image_changed_count++;
                                }
                                
                                if ($key == 'year_changed') {
                                	$year_changed_count++;
                                }
                            }

                            // now build summary based off of above calculations
                            $changeset_summary[$changeType]  = 'Changeset Type: <b>' . $changeType . '</b><br />';
                            $changeset_summary[$changeType] .= 'Application Data Changed: ' . $app_changed_count . '<br />';
                            $changeset_summary[$changeType] .= 'Status Changed: ' . $status_changed_count . '<br />';
                            $changeset_summary[$changeType] .= 'Country Changed: ' . $country_changed_count . '<br />';
                            $changeset_summary[$changeType] .= 'POP Changed: ' . $pop_changed_count . '<br />';
                            $changeset_summary[$changeType] .= 'Dimensions Changed: ' . $dims_changed_count . '<br />';
                            $changeset_summary[$changeType] .= 'Color Changed: ' . $color_changed_count . '<br />';
                            $changeset_summary[$changeType] .= 'Class Changed: ' . $class_changed_count . '<br />';
                            $changeset_summary[$changeType] .= 'Image Changed: ' . $image_changed_count . '<br />';
                            $changeset_summary[$changeType] .= 'Year Changed: ' . $year_changed_count;
                            $changeset_summary[$changeType] .= '<br /><br />';
                        }
                    }

                    $change_text = '';

                    if (empty($summary)) {
                        $change_text = 'There was no data provided to modify in this supplement file.';
                    } else {
                        // update summary!
                        foreach ($changeset_summary as $sum) {
                            $change_text .= $sum;
                        }

                        $this->supplementService->updateChangesetSummary($changeset_id, $change_text);
                    }

                    $filepath = explode('/', $filename);

                    // copy supplement file to public/assets/library/products/change_files/
                    $curDate = date('YmdHis');
                    shell_exec('mv ' . $filename . ' ' . realpath(__DIR__ . '/../../../../../public/assets/library/products/change_files') . '/' . $curDate.$filepath[count($filepath) - 1]);

                    // generate asset entry
                    $hashPath = 'library/products/change_files/'.$curDate.$filepath[count($filepath) - 1];
                    $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
                    $hash = rtrim($hash, '.');
                    $hash = 'l1_'.$hash;

                    $asset = $this->assetService->saveFile('library/products/change_files', $curDate.$filepath[count($filepath) - 1], ['mime'     => 'text/csv',
                        'ext' => 'csv',
                                                                                                                              'size'     => filesize($filename),
                                                                                                                              'filetype' => 'changefile',
                                                                                                                              'width'    => null,
                                                                                                                              'height'   => null], $hash);

                    // update changeset asset_id
                    $this->supplementService->updateChangesetAsset($changeset_id, $asset->getAssetId());
                break;
            }

            $filepath = explode('/', $filename);

            // generate audit log entry
            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Supplement File Ingestion',
                'summary'   => 'Successfully ingested supplement file \'' . $curDate.$filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);

            // generate task to approve new changeset
            $dueDate = new \DateTime('now');
            $dueDate->add(new \DateInterval('P10D'));

            $this->taskService->createCustomTask([
                'classification' => 'Approval',
                'priority' => 'high',
                'title' => 'A new Changeset is awaiting approval',
                'message' => 'There is a new Changeset added to the system and needs approval.',
                'start_date' => new \DateTime('now'),
                'due_date' => $dueDate,
            ]);

            $fileLog = $this->fileLogService->create(['type' => 'supplement',
                'brand' => null,
                'changesets' => $changesetObject,
                'asset' => $asset]);

            // create message for all administrator users
            $this->supplementService->createMessageForRole('administrator', 'Changeset Found', 'The changeset \'' . $curDate.$filepath[count($filepath) - 1] . '\' was found and needs approval.');

            $baseArray = explode('/', $filename);
            $basePathArray = array_slice($baseArray, 0, -1);
            $basePathCleaned = implode('/', $basePathArray);
            $basePath = $basePathCleaned . '/supplement.trg';
            shell_exec('rm ' . $basePath);

            $mfFilePath = $filepath;
            $mfFilePathTemp = array_pop($mfFilePath);
            $mfFilePathTemp = array_pop($mfFilePath);
            $mfPath = implode('/', $mfFilePath);
            $mfPath = $mfPath.'/master';

            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($mfPath)
            );

            foreach ($files as $file) {
                if (!in_array(strtolower($file->getExtension()), $this->_extensions)) {
                    continue;
                }
                $mf = $file->getRealPath();

                $filepath = explode('/', $mf);
                $mfFilesize = filesize($mf);

                shell_exec('mv ' . $mf . ' ' . realpath(__DIR__ . '/../../../../../public/assets/library/products/master_files') . '/' . $curDate.$filepath[count($filepath) - 1]);

                $hashPath = 'library/products/master_files/'.$curDate.$filepath[count($filepath) - 1];
                $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
                $hash = rtrim($hash, '.');
                $hash = 'l1_'.$hash;

                $asset = $this->assetService->saveFile('library/products/master_files', $curDate.$filepath[count($filepath) - 1], ['mime' => 'text/csv',
                    'ext' => 'csv',
                    'size' => $mfFilesize,
                    'filetype' => 'masterfile',
                    'width' => null,
                    'height' => null], $hash);

                $fileLog = $this->fileLogService->create(['type' => 'master',
                    'brand' => null,
                    'changesets' => $changesetObject,
                    'asset' => $asset]);
            }
        }
    }

    /**
     * Parse the master file, create product taxonomy.
     *
     * @return string
     */
    public function parsemasterAction()
    {
        $filename       = $this->getRequest()->getParam('filename');
        $from_iteration = (INT)$this->getRequest()->getParam('from_iteration');
        $to_iteration   = (INT)$this->getRequest()->getParam('to_iteration');

        $file = new SPLFileObject($filename);

        if (($file->isFile()) && ($file->isReadable())) {
            switch (strtolower($file->getExtension())) {
                // parse csv file
                case 'csv':
                    $file->setFlags(SplFileObject::READ_CSV);
                    $file->setCsvControl(',', '"', '\\');
                    $dataArray = array();

                    foreach ($file as $row) {
                        $dataArray[] = $row;
                    }

                    $filepath = explode('/', $filename);

                   // generate audit log entry
                    $this->auditService->create([
                        'createdBy' => 'system',
                        'object'    => 'LundProducts',
                        'action'    => 'Master File Ingestion',
                        'summary'   => 'Started master file ingestion on file \'' . $filepath[count($filepath) - 1] . '\'',
                        'result'    => 'success',
                    ]);

                    $highestRow   = (count($dataArray) - 1);
                    $iterator     = 1;
                    $iterator_cap = $highestRow;

                    if (($from_iteration > 0) && ($to_iteration > 0)) {
                        $iterator     = $from_iteration;
                        $iterator_cap = $to_iteration;
                    }

                    for ($i = $iterator; $i <= $iterator_cap; $i++) {
                        $this->masterService->getLogger()->info('===============[ON ITERATION ' . $i . ']===============');

                        if ($i == $iterator) {
                            continue;
                        }

                        $rowData = $dataArray[$i - 1];

/*

0: item,
1: brand,
2: class
3: class desc
4: PF
5: PF Desc
6: From Year
7: To Year
8: Make
9: Model
10: SubModel
11: SubDetail
12: BodyTyp
13: BedTyp
14: Jobber
15: MSRP
16: MAP
17: POP code
18: UPC
19: Weight
20: Height
21: Width
22: Length
23: Shipping Hrs
24: Color
25: No drill
26: extra desc
27: In App guide
28: In Jobber
29: I-Sheet
30: Date Chgd since last DwnLoad
31: country of orgn
32: Retail Flg
33: Oversize code
34: Status Code
35: Original brand
36: Flare Height
37: Flare Tire Coverage
38: DIM A
39: DIM B
40: DIM C
41: DIM D
42: DIM E
43: DIM F
44: DIM G
45: Vehicle Type
46: Model Type
47: MakeID
48: ModelID
49: SubModelID
50: NoOfDoorsID
51: PartTypeId
52: BodyTypID
53: BedTypeID
54: SeqNo
 */

                        if (count($rowData) == 1) {
                            continue;
                        }

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
                        $veh_class_name                = trim($rowData[45]);
                        $jobber_price                  = trim($rowData[14]);
                        $msrp_price                    = trim($rowData[15]);
                        $sale_price                    = trim($rowData[16]);
                        $pop_code                      = trim($rowData[17]);
                        $upc_code                      = trim($rowData[18]);
                        $weight                        = trim($rowData[19]);
                        $height                        = trim($rowData[20]);
                        $width                         = trim($rowData[21]);
                        $length                        = trim($rowData[22]);
                        $color                         = trim($rowData[24]);
                        $isheet                        = trim($rowData[29]);
                        $country_of_origin             = trim($rowData[31]);
                        $status_code                   = trim($rowData[34]);
                        $orig_brand                    = trim($rowData[35]);
                        $dima                          = trim($rowData[38]);
                        $dimb                          = trim($rowData[39]);
                        $dimc                          = trim($rowData[40]);
                        $dimd                          = trim($rowData[41]);
                        $dime                          = trim($rowData[42]);
                        $dimf                          = trim($rowData[43]);
                        $dimg                          = trim($rowData[44]);
                        $lookup_make_id                = trim($rowData[47]);
                        $lookup_model_id               = trim($rowData[48]);
                        $lookup_submodel_id            = trim($rowData[49]);
                        $lookup_body_num_doors_id      = trim($rowData[50]);
                        $lookup_part_type_id           = trim($rowData[51]);
                        $lookup_body_type_id           = trim($rowData[52]);
                        $lookup_bed_type_id            = trim($rowData[53]);
                        $seq_no                        = trim($rowData[54]);

                        if ((trim($brand) == '') || (trim($part_number) == '')) {
                            continue;
                        }

                        // universal parts:
                        // - Make = UNIVERSAL
                        // - missing Make, Model, Submodel and SubDetail
                        $universal = ((strtoupper(trim($veh_make_name)) == 'UNIVERSAL') ? true :
                                     (((trim($veh_make_name) == '') && (trim($veh_model_name) == '') && (trim($veh_submodel_name) == '') && (trim($veh_submodel_subdetail) == '')) ? true : false));

                        $brand_id            = null;
                        $orig_brand_id       = null;
                        $product_category_id = null;
                        $product_line_id     = null;
                        $part_id             = null;

                        // first, insert/find brand, if orig_brand exists, create it, assign association in brands, cache
                        //  -- same with orig_brand, find/create/assign orig_brand to brands.parent_orig_id to brands
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
                            $cleaned_product_category_name = preg_replace("/\//", "-", $product_categories_short_code);
                            $foundProductCategory = $this->masterService->insertProductCategory(
                                date('Y-m-d H:i:s'), 0, 1,
                                $product_categories_bpcs_code,
                                $product_categories_short_code,
                                $cleaned_product_category_name);

                            $product_category_id  = $foundProductCategory['product_category_id'];
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
                            $cleaned_product_line_name = preg_replace("/\//", "-", $product_lines_short_code);
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
                        $foundPart = $this->masterService->findPart($part_number, $product_line_id);

                        if (null != $foundPart) {
                            $part_id = $foundPart['part_id'];
			    if (null == $foundPart['part_type_id']) {
			        $updatePartType = $this->masterService->updatePartType($part_id, $lookup_part_type_id);
			    }
                        } else {
                            // create it, cache part_id
                            $foundPart = $this->masterService->insertPart(date('Y-m-d H:i:s'), 0, 0, $part_number, $jobber_price, $msrp_price, $sale_price,
                                                                          $color, $isheet, $pop_code, $upc_code, $weight, $height, $width, $length, $product_line_id, $country_of_origin, $status_code,
                                                                          $dima, $dimb, $dimc, $dimd, $dime, $dimf, $dimg, $universal, $lookup_part_type_id);
                            $part_id = $foundPart['part_id'];
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

                            for ($k = $from_year; $k <= $to_year; $k++) {
                                $this_year = $k;

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
                                    ((trim($lookup_body_type) != '' ) ? $lookup_body_type : null));

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
                                        $lookup_body_num_doors_id,
                                        $lookup_bed_type_id,
                                        $lookup_bed_type
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
                                       null,
                                       $veh_submodel_subdetail);
                                }
                            }
                        }
                    }
                break;
            }

            $filepath = explode('/', $filename);

            // copy master file to public/assets/library/products/master_files/
            $curDate = date('YmdHis');
            shell_exec('mv ' . $filename . ' ' . realpath(__DIR__ . '/../../../../../public/assets/library/products/master_files') . '/' . $curDate.$filepath[count($filepath) - 1]);

            // generate asset entry
            $hashPath = 'library/products/master_files/'.$curDate.$filepath[count($filepath) - 1];
            $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
            $hash = rtrim($hash, '.');
            $hash = 'l1_'.$hash;

            $asset = $this->assetService->saveFile('library/products/master_files', $curDate.$filepath[count($filepath) - 1], ['mime'     => 'text/csv',
                'ext' => 'csv',
                                                                                                             'size'     => filesize($filename),
                                                                                                             'filetype' => 'masterfile',
                                                                                                             'height'   => null,
                                                                                                             'width'    => null], $hash);

            // generate audit log entry
            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'Master File Ingestion',
                'summary'   => 'Finished master file ingestion on file \'' . $curDate.$filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);

            $fileLog = $this->fileLogService->create(['type' => 'master',
                'brand' => null,
                'changesets' => null,
                'asset' => $asset]);

            // create message for all administrator users
            $this->supplementService->createMessageForRole('administrator', 'Master File Found', 'A master file was found named \'' . $curDate.$filepath[count($filepath) - 1] . '\' and was ingested.');

            $baseArray = explode('/', $filename);
            $basePathArray = array_slice($baseArray, 0, -1);
            $basePathCleaned = implode('/', $basePathArray);
            $basePath = $basePathCleaned . '/master.trg';
            shell_exec('rm ' . $basePath);
        }
    }
    
    /**
     * Parse the supplement file, create changeset taxonomy.
     *
     * @return string
     */
    public function parsesdcpiesAction()
    {
        $filename = $this->getRequest()->getParam('filename');
        $file     = new SPLFileObject($filename);
        
        if (($file->isFile()) && ($file->isReadable())) {
            switch (strtolower($file->getExtension())) {
                case 'xml':
                    $xml=simplexml_load_file($filename) or die("Error: Cannot create object");
                    
                    foreach ($xml->Items->Item as $item)
                    {
                        //echo $item->Item->PartNumber;
                        //print_r($item);exit;
                        $partNumber             = $item->PartNumber;
                        $upc                    = $item->ItemLevelGTIN;
                        $brand                  = $item->BrandLabel;
                        $partTypeId             = $item->PartTerminologyID;
                        
                        //print_r($item->Item->Descriptions);
                        foreach ($item->Descriptions->Description as $desc)
                        {
                            //print_r($desc);
                            //echo $desc->Description->attributes()->DescriptionCode;
                            if($desc->attributes()->DescriptionCode == 'DES')
                            {
                                
                                $productLine = $desc->Description;
                            
                            } else if($desc->attributes()->DescriptionCode == 'EXT')
                            {
                                
                                $productCategory = $desc->Description;
                                
                            } else if($desc->attributes()->DescriptionCode == 'MKT')
                            {
                                
                                $productLineDescription = $desc->Description;
                                
                            } else if($desc->attributes()->DescriptionCode == 'ASC')
                            {
                                
                                $productCategoryDescription = $desc->Description;
                                
                            }
                        }
                        
                        foreach ($item->Prices->Pricing as $pricing)
                        {
                            //print_r($desc);
                            //echo $desc->Description->attributes()->DescriptionCode;
                            if($pricing->attributes()->PriceType== 'JBR')
                            {
                                
                                $jobberPrice = $pricing->Price;
                                
                            } else if($pricing->attributes()->PriceType== 'RET')
                            {
                                
                                $msrpPrice = $pricing->Price;
                                
                            }
                        }
                        
                        foreach ($item->ProductAttributes->ProductAttribute as $productAttribute)
                        {
                            if($productAttribute->attributes()->AttributeID== 'Color') {
                                $color = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Finish') {
                                $finish = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Material') {
                                $material = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Sold As') {
                                $soldAs = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Bed Length') {
                                $bedLength = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Front Flare Height') {
                                $frontFlareHeight = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Rear Flare Height') {
                                $rearFlareHeight = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Front Flare Tire Coverage') {
                                $frontFlareTireCoverage = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Rear Flare Tire Coverage') {
                                $rearFlareTireCoverage = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Warranty') {
                                $warranty = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Style') {
                                $style = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Tube Shape') {
                                $tubeShape = $productAttribute;
                            } else if($productAttribute->attributes()->AttributeID== 'Tube Size') {
                                $tubeSize = $productAttribute;
                            } else {
                                
                            }
                        }
                        $countryOfOrigin = $item->ExtendedInformation->ExtendedProductInformation[0];
                        $height = $item->Packages->Package->Dimensions->Height;
                        $width = $item->Packages->Package->Dimensions->Width;
                        $length = $item->Packages->Package->Dimensions->Length;
                        $weight = $item->Packages->Package->Weights->Weight;
                        
                        foreach ($item->DigitalAssets->DigitalFileInformation as $digital)
                        {
                            //print_r($desc);
                            //echo $desc->Description->attributes()->DescriptionCode;
                            if($digital->AssetType == 'ISG')
                            {
                                
                                $isheet = $digital->FileName;
                                
                            }
                        }

                        
                        $foundBrand = $this->masterService->findBrand($brand);
                        
                        if (null != $foundBrand) {
                            // found, cache it
                            $brand_id = $foundBrand['brand_id'];
                        } else {
                            // not found, we create it, cache brand_id
                            $foundBrand = $this->masterService->insertBrand(date('Y-m-d H:i:s'), 0, 0, $brand, $brand, $brand);
                            $brand_id   = $foundBrand['brand_id'];
                        }
                        
                        // find out if product_category exists by short_code, create it if not, cache
                        $foundProductCategory = $this->masterService->findProductCategory($productCategory);
                        
                        if (null != $foundProductCategory) {
                            // cache it
                            $product_category_id = $foundProductCategory['product_category_id'];
                        } else {
                            // not found, create it, cache it
                            $cleaned_product_category_name = preg_replace("/\//", "-", $productCategory);
                            $foundProductCategory = $this->masterService->insertProductCategory(
                                date('Y-m-d H:i:s'), 0, 1,
                                '',
                                $productCategory,
                                $cleaned_product_category_name);
                            
                            $product_category_id  = $foundProductCategory['product_category_id'];
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
                        $foundProductLine = $this->masterService->findProductLine($productLine, $brand_id);
                        
                        if (null != $foundProductLine) {
                            $product_line_id = $foundProductLine['product_line_id'];
                        } else {
                            // create it, cache it
                            $cleaned_product_line_name = preg_replace("/\//", "-", $productLine);
                            $foundProductLine = $this->masterService->insertProductLine(
                                date('Y-m-d H:i:s'), 0, 1,
                                null,
                                $productLine,
                                $cleaned_product_line_name,
                                $product_category_id,
                                $brand_id,
                                null,
                                $productLineDescription);
                            $product_line_id = $foundProductLine['product_line_id'];
                        }
                        
                        // find if part exists by $part_number and $product_line_id
                        // -- find out if product exists by product_line_id from above
                        // -- if not, create it
                        // TODO: ** parent_part_id
                        $foundPart = $this->masterService->findPart($partNumber);
                        
                        $modified_at = null;
                        $deleted = null;
                        $disabled = null;
                        $salePrice = '0.00';
                        $popCode = null;
                        $statusCode = null;
                        $dima = null;
                        $dimb = null;
                        $dimc = null;
                        $dimd = null;
                        $dime = null;
                        $dimf = null;
                        $dimg = null;
                        $universal = null;
                        $lookup_number = null;
                        $bed_length_id = null;
                        $vehicle_type = null;
                        $no_drill = null;
                        $material_thickness = null;
                        $liquid_storage_capacity = null;
                        $box_style = null;
                        $box_opening_type = null;
                        $cut_required = null;
                        $stake_holes = null;
                        $color_group = null;
                        $map_price = null;
                        $saleable = null;
                        
                        
                        if (null != $foundPart) {
                            $part_id = $foundPart['part_id'];
                                $updatePartType = $this->masterService->updatePart($part_id, $modified_at, $deleted, $disabled, $partNumber, $jobberPrice, $msrpPrice,
                                    $salePrice, $color, $isheet, $popCode, $upc, $weight, $height, $width, $length, $product_line_id, $countryOfOrigin, $statusCode,
                                    $dima, $dimb, $dimc, $dimd, $dime, $dimf, $dimg, $universal, $partTypeId, $lookup_number, $bedLength, $bed_length_id, $frontFlareHeight,
                                    $frontFlareTireCoverage, $vehicle_type, $no_drill, $finish, $style, $material, $material_thickness, $soldAs, $tubeShape, $tubeSize, $warranty, 
                                    $liquid_storage_capacity, $box_style, $box_opening_type, $cut_required, $rearFlareHeight, $rearFlareTireCoverage, $stake_holes, $color_group, 
                                    $map_price, $saleable);
                                
                        } else {
                            // create it, cache part_id
                            $foundPart = $this->masterService->insertPart(date('Y-m-d H:i:s'), 0,  0, $partNumber, $jobberPrice, $msrpPrice, $salePrice, $color, 
                                $isheet, $popCode, $upc, $weight, $height, $width, $length, $product_line_id, $countryOfOrigin, $statusCode, $dima, $dimb, $dimc, 
                                $dimd, $dime, $dimf, $dimg, $universal, $partTypeId, $lookup_number, $bedLength, $bed_length_id, $frontFlareHeight, $frontFlareTireCoverage, 
                                $vehicle_type, $no_drill, $finish, $style, $material, $material_thickness, $soldAs, $tubeShape, $tubeSize, $warranty, $liquid_storage_capacity,
                                $box_style, $box_opening_type, $cut_required, $rearFlareHeight, $rearFlareTireCoverage, $stake_holes, $color_group, $map_price, $saleable);
                            $part_id = $foundPart['part_id'];
                        }
                        
                    }
                    break;
                    
            }
            
            $curDate = date('YmdHis');
            $filepath = explode('/', $filename);
            
            // generate audit log entry
            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'SDCPies File Ingestion',
                'summary'   => 'Successfully ingested sdc Pies file \'' . $curDate.$filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);
            
            
            $baseArray = explode('/', $filename);
            $basePathArray = array_slice($baseArray, 0, -1);
            $basePathCleaned = implode('/', $basePathArray);
            $basePath = $basePathCleaned . '/sdcPies.trg';
            $newPath = '/var/www/sites/SmartData/data/pies/6.5/';
            
            
            shell_exec('rm ' . $basePath);
            shell_exec('mv ' . $filename. ' ' .$newPath );
        }
    }
    
    
    /**
     * Parse the supplement file, create changeset taxonomy.
     *
     * @return string
     */
    public function parsesdcacesAction()
    {
        $filename = $this->getRequest()->getParam('filename');
        $file     = new SPLFileObject($filename);
        
        if (($file->isFile()) && ($file->isReadable())) {
            switch (strtolower($file->getExtension())) {
                case 'xml':
                    $xml=simplexml_load_file($filename) or die("Error: Cannot create object");
                    
                    foreach ($xml->App as $item)
                    {
                        
                        $baseVehicleId          = $item->BaseVehicle->attributes()->id;
                        $partNumber             = $item->Part;
                        
                        $return = $this->masterService->searchAAIA($baseVehicleId);
                        
                        //print_r($return);exit;
                        $year           = $return['yearID'];
                        $make           = $return['MakeName'];
                        $model          = $return['ModelName'];
                        $vehicleType    = $return['VehicleTypeName'];
                        
                        $foundVehYear = $this->masterService->findVehYear((STRING)$year);
                        
                        if (null == $foundVehYear) {
                            $foundVehYear = $this->masterService->insertVehYear((STRING)$year);
                        }
                        
                        // vehicle make
                        $foundVehMake = $this->masterService->findVehMake($make);
                        
                        if (null == $foundVehMake) {
                            $foundVehMake = $this->masterService->insertVehMake($make, $make);
                        }
                        
                        $foundVehClass = $this->masterService->findVehClass($vehicleType);
                        
                        if (null == $foundVehClass) {
                            $foundVehClass = $this->masterService->insertVehClass($vehicleType);
                        }
                        
                        // vehicle model
                        $foundVehModel = $this->masterService->findVehModel($model, $foundVehMake['veh_make_id']);
                        
                        if (null == $foundVehModel) {
                            $foundVehModel = $this->masterService->insertVehModel(
                                $model,
                                $model,
                                $foundVehMake['veh_make_id'], $foundVehClass['veh_class_id']);
                        }
                        
                        $foundVehCollection = $this->masterService->findVehCollection(
                            $foundVehYear['veh_year_id'],
                            $foundVehMake['veh_make_id'],
                            $foundVehModel['veh_model_id'],
                            null,
                            null,
                            null);
                        
                        if (null == $foundVehCollection) {
                            // doesn't exist, create it
                            $foundVehCollection = $this->masterService->insertVehCollection(
                                $foundVehYear['veh_year_id'],
                                $foundVehMake['veh_make_id'],
                                $foundVehModel['veh_model_id'],
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null
                                );
                        }
                        
                        $foundPart = $this->masterService->findPart($partNumber);
                        
                        // check part_veh_collection assignment
                        $foundPartVehCollection = $this->masterService->findPartVehCollection(
                            $foundPart['part_id'],
                            $foundVehCollection['veh_collection_id']);
                        
                        if (null == $foundPartVehCollection) {
                            // create the association
                            $insertPartVehCollection = $this->masterService->insertPartVehCollection(
                                $foundPart['part_id'],
                                $foundVehCollection['veh_collection_id'],
                                1,
                                null,
                                null);
                        }
                        
                        
                    }
                    
                    break;
                    
            }
            
            $curDate = date('YmdHis');
            $filepath = explode('/', $filename);
            
            // generate audit log entry
            $this->auditService->create([
                'createdBy' => 'system',
                'object'    => 'LundProducts',
                'action'    => 'SDCAces File Ingestion',
                'summary'   => 'Successfully ingested sdc Aces file \'' . $curDate.$filepath[count($filepath) - 1] . '\'',
                'result'    => 'success',
            ]);
            
            
            $baseArray = explode('/', $filename);
            $basePathArray = array_slice($baseArray, 0, -1);
            $basePathCleaned = implode('/', $basePathArray);
            $basePath = $basePathCleaned . '/sdcAces.trg';
            $newPath = '/var/www/sites/SmartData/data/aces/3.1/';
            
            
            shell_exec('rm ' . $basePath);
            shell_exec('mv ' . $filename. ' ' .$newPath );
        }
    }
}
