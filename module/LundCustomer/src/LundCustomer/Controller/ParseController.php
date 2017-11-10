<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundCustomer\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\Parameters;
use Zend\Console\Request as ConsoleRequest;
use SPLFileInfo;
use SPLFileObject;
use Zend\Mail;
use LundCustomer\Service\ParseCustomerService;
use LundCustomer\Service\CustomerService;
use RocketUser\Service\UserService;
use RocketAdmin\Service\AuditService;
use RocketDam\Service\AssetService;
use RocketBase\Repository\CountryRepository;
use RocketBase\Repository\StateRepository;
use LundCustomer\Service\RetailerService;

/**
 * Parse master/customer controller for LundCustomer module
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ParseController extends AbstractActionController
{
    /**
     * @var ParseCustomerService
     */
    protected $parseCustomerService = null;

    /**
     * @var CustomerService
     */
    protected $customerService = null;

    /**
     * @var UserService
     */
    protected $userService = null;

    /**
     * @var AuditService
     */
    protected $auditService = null;

    /**
     * @var AssetService
     */
    protected $assetService = null;

    /**
     * @var RetailerService
     */
    protected $retailerService = null;

    /**
     * @var CountryRepository
     */
    protected $countryRepository = null;

    /**
     * @var StateRepository
     */
    protected $stateRepository = null;

    /**
     * @param ParseCustomerService 	$parseCustomerService
     * @param CustomerService      	$customerService
     * @param UserService          	$userService
     * @param AuditService         	$auditService
     * @param AssetService         	$assetService
     * @param RetailerService      	$retailerService
     * @param CountryRepository    	$countryRepository
     * @param StateRepository    	$stateRepository
     */
    public function __construct(
        ParseCustomerService $parseCustomerService,
        CustomerService $customerService,
        UserService $userService,
        AuditService $auditService,
        AssetService $assetService,
        RetailerService $retailerService,
    	CountryRepository $countryRepository,
    	StateRepository $stateRepository
    )
    {
        $this->parseCustomerService = $parseCustomerService;
        $this->customerService      = $customerService;
        $this->userService          = $userService;
        $this->auditService         = $auditService;
        $this->assetService         = $assetService;
        $this->retailerService      = $retailerService;
        $this->countryRepository   	= $countryRepository;
        $this->stateRepository   	= $stateRepository;
    }

    /**
     * Parse the customer file
     *
     * @return string
     */
    public function parsecustomerAction()
    {
        $filename = $this->getRequest()->getParam('filename');
        $file     = new SPLFileObject($filename);

        if (($file->isFile()) && ($file->isReadable())) {
            switch (strtolower($file->getExtension())) {
                case 'csv':
                    $file->setFlags(SplFileObject::READ_CSV);
                    $file->setCsvControl(',', '"', '\\');
                    $iterator = 0;

                    $filepath = explode('/', $filename);

                    // generate audit log entry
                    $this->auditService->create([
                        'createdBy' => 'system',
                        'object'    => 'LundCustomer',
                        'action'    => 'Customer File Ingestion',
                        'summary'   => 'Starting customer file ingestion on file \'' . $filepath[count($filepath) - 1] . '\'',
                        'result'    => 'success',
                    ]);

                    foreach ($file as $rowData) {
                        $customer = null;
                        $iterator++;

                        if (($iterator == 1) || (count($rowData) <= 1)) {
                            continue;
                        }
/*
 * Header column                   BPCS
 *                                 Fld Nam FldTyp lngth #of dec/numeric
 *                                                                         P=numeric
 * Cust                    0        ZMCUS      P      6   0
 * Custname                1        ZNME       A     30
 * Filepickup              2        ZFPCKP     A      1
 * Pushfile                3        ZPUSH      A      1
 * Ftpsite                 4        ZFTPS      A     60
 * Ftpuser                 5
 * Ftppass                 6
 * Emailaddrs              7        ZEMAL      A     60
 * Contactname             8        ZCONT      A     50
 * Updatetype              9        ZUTYP      A      1
 * Frequency               10        ZFREQ      A      1
 * Filetype1               11        ZFTY1      A     10
 * Filetype2               12        ZFTY2      A     10
 * Lund                    13        ZBR01      A      1
 * Dfmal                   14        ZBR02      A      1
 * Avs                     15        ZBR03      A      1
 * Nifty                   16        ZBR04      A      1
 * Tradesman               17        ZBR05      A      1
 * Lmp                     18        ZBR06      A      1
 * Amp                     19        ZBR07      A      1
 * Ht_am                   20        ZBR08      A      1
 * Belmor                  21        ZBR09      A      1
 * LundAll                 22                   A      1
 * Rampage                 23        ZBR11      A      1  
 * Bushwacker              24        ZBR12      A      1  
 * Stampede                25        ZBR13      A      1  
 * Brand14                 26        ZBR14      A      1
 * Brand15                 27        ZBR15      A      1
 * Imagetyp                28        ZIMAG      A      5
 * Renameimages            29        ZRENM      A      1
 * Acceptvideo             30        ZVDEO      A      1
 * Videotype               31        ZVTYP      A     10
 * CustomerOrDealer  	   32        
 * Password                33        
 */
                        
                        //print_r($rowData);

                        $custId       = trim($rowData[0]);
                        $name         = trim($rowData[1]);
                        $filePickup   = strtoupper(trim($rowData[2])) == 'Y';
                        $filePush     = strtoupper(trim($rowData[3])) == 'Y';
                        $ftpSite      = trim($rowData[4]);
                        $ftpUser      = trim($rowData[5]);
                        $ftpPass      = trim($rowData[6]);
                        $email        = trim($rowData[7]);
                        $contactName  = trim($rowData[8]);
                        $updateType   = (strtoupper(trim($rowData[9])) == 'N' ? 'net' : 'full');
                        $frequency    = (strtoupper(trim($rowData[10])) == 'W' ? 'week' : 'month');
                        $acesVersion  = trim($rowData[11]);
                        $piesVersion  = trim($rowData[12]);
                        $lund         = strtoupper(trim($rowData[13])) == 'Y';
                        $dfmal        = strtoupper(trim($rowData[14])) == 'Y';
                        $avs          = strtoupper(trim($rowData[15])) == 'Y';
                        $nifty        = strtoupper(trim($rowData[16])) == 'Y';
                        $tradesman    = strtoupper(trim($rowData[17])) == 'Y';
                        $lmp          = strtoupper(trim($rowData[18])) == 'Y';
                        $amp          = strtoupper(trim($rowData[19])) == 'Y';
                        $htam         = strtoupper(trim($rowData[20])) == 'Y';
                        $belmor       = strtoupper(trim($rowData[21])) == 'Y';
                        $lundAll      = strtoupper(trim($rowData[22])) == 'Y';
                        $rampage      = strtoupper(trim($rowData[23])) == 'Y';
                        $bushwacker   = strtoupper(trim($rowData[24])) == 'Y'; 
                        $stampede     = strtoupper(trim($rowData[25])) == 'Y';
                        $tonnopro     = strtoupper(trim($rowData[26])) == 'Y'; // reserved for later
                        //$brand15      = strtoupper(trim($rowData[27])) == 'Y'; // reserved for later
                        $imageType    = trim($rowData[28]);
                        $renameImages = strtoupper(trim($rowData[29])) == 'Y';
                        $acceptVideo  = strtoupper(trim($rowData[30])) == 'Y';
                        $videoType    = trim($rowData[31]);
                        $customerOrDealer    = trim($rowData[32]);
                        $password    	= trim($rowData[33]);
                        $authorized		= trim($rowData[34]);
                        $address1		= trim($rowData[35]);
                        $address2		= trim($rowData[36]);
                        $city			= trim($rowData[37]);
                        $state			= trim($rowData[38]);
                        $zip			= trim($rowData[39]);
                        $country		= trim($rowData[40]);

                        
                        $customer = $this->customerService->findCustomerByCustId($custId);
                        
                        if($authorized == '1') {
                        	$disabled = '0';
                        } else {
                        	$disabled = '1';
                        }

                        if ($contactName == '') { $contactName = 'Support Contact'; }
                        if ($email == '') { $email = 'webit@thesmartdata.com'; }

                        
                        // TODO: is there going to ever be a brand in the customer file that doesn't already exist?
                        if (null != $customer) {
                        	
                        	//echo "YES";exit;
                        	
                            $customer = $this->parseCustomerService->editCustomer($customer, $custId, $name, $filePickup, $filePush,
                                                                                  $ftpSite, $ftpUser, $ftpPass, $email, $contactName,
                                                                                  $updateType, $frequency,
                                                                                  $acesVersion, $piesVersion, $lund, $dfmal, $avs,
                                                                                  $nifty, $tradesman, $lmp, $amp, $htam, $belmor, $lundAll, $rampage, $bushwacker, $stampede, $tonnopro,
                                                                                  $imageType, $renameImages, $acceptVideo, $videoType, $customerOrDealer, $disabled);
                        
                            
                     		       
                            $countryId = $this->countryRepository->findOneBy(array('codeChar2' => $country));
                            
                            
                            $stateId = $this->stateRepository->findOneBy(array('codeChar2' => $country, 'subdivisionName' => $state));
                            if(empty($stateID)) {
                                echo $country."-".$state;
                            	$stateId = $this->stateRepository->findOneBy(array('codeChar2' => $country, 'subdivisionCode' => $country."-".$state));
                            }
                            
                            $retailerData = new Parameters();
                            $retailerValues = array();
                            //$retailerValues['retailerId'] = '';
                            $retailerValues['retailerType'] = 'physical';
                            $retailerValues['companyName'] = $name;
                            $retailerValues['streetAddress'] = $address1;
                            $retailerValues['extStreetAddress'] = $address2;
                            $retailerValues['locality'] = $city;
                            $retailerValues['region'] = $stateId;
                            $retailerValues['postCode'] = $zip;
                            $retailerValues['country'] = $countryId;
                            $retailerValues['phoneNumber'] = substr($custId, 0, 3)."-".substr($custId, 3, 3)."-".substr($custId, 6);
                            $retailerValues['discount'] = '0';
                            $retailerValues['disabled'] = '0';
                            $retailerValues['customerId'] = $customer;
                            $retailerValues['customerOrDealer'] = $customerOrDealer;
                            $retailerData->set('retailer-fieldset', $retailerValues);
                            
                            
                            
                            if(strlen($retailerValues['phoneNumber']) == '12')
                            {
                            	if(null == $this->retailerService->getRetailerByPhone($retailerValues['phoneNumber']))
                            	{
                            		   	//echo "yes";exit;
                            		$retailer = $this->retailerService->insertRetailer($retailerValues);
                            	}       
                            }
                            
                           
                        } else {

                        	//echo "NO";exit;
                        	
                            $userForm = $this->userService->getCreateUserForm();

                            $systemUser = $this->userService->getUser(6);

                            /*
                             * Dont create a user in the system for a Retailer
                             */
                            if($customerOrDealer != 'R')
                            {
                            	//echo "NO R";exit;
	                            if($customerOrDealer == 'D')
	                            {
	                            	
	                            	$newPassword = 	$password;
	                            	
	                            } else {
	                            	
		                            $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';
		                            $newPassword = '';
		                            for ($i=0; $i<7;$i++) {
		                                $newPassword .= substr($chars, rand(0, 54), 1);
		                            }
		                            $newPassword = str_shuffle($newPassword);
	
	                            }
	                            $data = new Parameters();
	                            $values = array();
	                            $values['username'] = strtolower($email);
	                            $values['password'] = $newPassword;
	                            $values['passwordVerification'] = $newPassword;
	                            $values['disabled'] = '0';
	                            $values['role'] = '2';
	                            $values['firstName'] = $contactName;
	                            $values['lastName'] = $name;
	                            $values['emailAddress'] = strtolower($email);
	                            $values['companyName'] = $name;
	                            $values['streetAddress'] = '4325 Hamilton Mill Road';
	                            $values['extStreetAddress'] = '';
	                            $values['locality'] = 'Buford';
	                            $values['region'] = '18660';
	                            $values['postCode'] = '30518';
	                            $values['country']  = '240';
	                            $values['phoneNumber'] = '';
	                            $values['cellularNumber'] = '';
	                            $data->set('user-fieldset', $values);
	                            
	                            
	                            if(!$this->userService->getUserByEmail($values['username']))
	                            {
	
	                            	$user = $this->userService->create($systemUser, $data);
								
	                            }
	                            else {
	                            	$user = $this->userService->getUserByEmail($values['username']);
	                            }
	                      	
                            } else {
                            	//echo "IS R";exit;
                            	$user = $systemUser;
                            }
                            
                           
                            $customer = $this->parseCustomerService->insertCustomer($custId, $name, $filePickup, $filePush, $ftpSite,
                                                                                    $ftpUser, $ftpPass, $user,
                                                                                    $email, $contactName, $updateType, $frequency,
                                                                                    $acesVersion, $piesVersion, $lund, $dfmal, $avs,
                                                                                    $nifty, $tradesman, $lmp, $amp, $htam, $belmor, $lundAll, $rampage, $bushwacker, $stampede, $tonnopro,
                                                                                    $imageType, $renameImages, $acceptVideo, $videoType, $customerOrDealer);

                            $customerId = $customer->getCustomerId();
                            
                            //echo $customerId;exit;
                            
                            /*
                             * Add the customer to the retailer file
                             */
                            
                            $countryId = $this->countryRepository->findOneBy(array('codeChar2' => $country));
                            
                            
                            $stateId = $this->stateRepository->findOneBy(array('codeChar2' => $country, 'subdivisionName' => $state));
                            if(empty($stateID)) {
                            	$stateId = $this->stateRepository->findOneBy(array('codeChar2' => $country, 'subdivisionCode' => $country."-".$state));
                            }
                            
                            $retailerData = new Parameters();
                            $retailerValues = array();
                            //$retailerValues['retailerId'] = '';
                            $retailerValues['retailerType'] = 'physical';
                            $retailerValues['companyName'] = $name;
                            $retailerValues['streetAddress'] = $address1;
                            $retailerValues['extStreetAddress'] = $address2;
                            $retailerValues['locality'] = $city;
                            $retailerValues['region'] = $stateId;
                            $retailerValues['postCode'] = $zip;
                            $retailerValues['country'] = $countryId;
                            $retailerValues['phoneNumber'] = substr($custId, 0, 3)."-".substr($custId, 3, 3)."-".substr($custId, 6);
                            $retailerValues['discount'] = '0';
                            $retailerValues['disabled'] = '0';
                            $retailerValues['customerId'] = $customer;
                            $retailerValues['customerOrDealer'] = $customerOrDealer;
                            $retailerData->set('retailer-fieldset', $retailerValues);
                            
                        
                            //echo strlen($retailerValues['phoneNumber'])." - ";
                            if(strlen($retailerValues['phoneNumber']) == '12')
                            {
	                            if(!$this->retailerService->getRetailerByName($name))
	                            {
	                         //   	echo "yes";exit;
	                            	$retailer = $this->retailerService->insertRetailer($retailerValues);
	                            }
	                            
	                            //echo $retailer->getCompanyName(); exit;
	                            
	                            
                            }
                            
                            
                            //echo $retailerId;exit;
                            
                            /*
                             * Send out emails letting Customer and Dealers know they have been created an account
                             */
                            if($customerOrDealer == 'C')
                            {
                            	$customerName = str_replace(" ","_", $customer->getName());
                           
                            
	                            $customerPath = "/var/www/sites/SmartData/public/assets/library/customers/accounts/" . $customerName;
	                           
	                            if (!is_dir($customerPath)) {
	                                mkdir($customerPath);
	                                touch($customerPath . '/.gitignore');
	                            }
	                            
	                            /* Send email */
	                            $mail = new Mail\Message();
	                            $mail->setBody("An account has been created for you on www.myautostores.com\r\n\r\n
	                                Username: " . strtolower($email) . "\r\n
	                                Password: " . $newPassword . "\r\n
	                            	");
	                            $mail->setFrom('webit@thesmartdata.com');
	                            /* TODO: Replace email with customer file supplied email address */
	                            $mail->addTo($email);
	                            $mail->addCc('webit@thesmartdata.com');
	                            $mail->setSubject('Account created for myautostores.com');
	                            $transport = new Mail\Transport\Sendmail();
	                            $transport->send($mail);
	                            
	                            
                            }
                            elseif($customerOrDealer == 'D')
                            {
                            	//echo "YES";exit;
                            	/* Send email */
	                            $mail = new Mail\Message();
	                            $headers = $mail->getHeaders();
	                            $headers->removeHeader('Content-Type');
								$headers->addHeaderLine('Content-Type', 'text/html; charset=UTF-8');
								
	                           // print_r($headers);exit;
	                            $mail->setBody("");
	                            $mail->setFrom('webit@thesmartdata.com');
	                            /* TODO: Replace email with customer file supplied email address */
	                            $mail->addTo($email);
	                            $mail->setSubject('Account created for myautostores.com');
	                            //$transport = new Mail\Transport\Sendmail();
	                            //$transport->send($mail);
                            } else {
                            	
                            }
                            
                        }
                        
                    }

                    $filepath = explode('/', $filename);

                    $asset = $this->assetService->saveFile('library/customers', date('YmdHis').$filepath[count($filepath) - 1],
                        ['mime'     => 'text/csv',
                         'size'     => filesize($filename),
                         'filetype' => 'customerfile',
                         'ext'      => 'csv',
                         'width'    => null,
                         'height'   => null]);

                    shell_exec('mv ' . $filename . ' public/assets/library/customers/' . date('YmdHis').$filepath[count($filepath) - 1]);

                    $this->auditService->create(array(
                        'createdBy' => 'system',
                        'object'    => 'LundCustomer',
                        'action'    => 'Customer File Ingestion',
                        'summary'   => 'Successfully ingested customer file \'' . $filepath[count($filepath) - 1] . '\'',
                        'result'    => 'success',
                    ));

                    $baseArray = explode('/', $filename);
                    $basePathArray = array_slice($baseArray, 0, -1);
                    $basePathCleaned = implode('/', $basePathArray);
                    $basePath = $basePathCleaned . '/customer.trg';
                    shell_exec('rm ' . $basePath);
                break;
            }
        }
    }
}
