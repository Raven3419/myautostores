<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * This source file is part of Commander.
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    Application
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace Application\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use RocketCms\Service\SiteService;
use RocketCms\Entity\SiteInterface;
use RocketCms\Service\LayoutService;
use RocketCms\Service\TemplateService;
use RocketCms\Service\PageService;
use RocketCms\Service\MenuService;
use RocketCms\Service\MenuElementService;
use RocketUser\Service\UserService;
use RocketUser\Service\LoginService;
use LundCustomer\Service\CustomerService;
use LundProducts\Service\FileLogService;
use RocketDam\Service\AssetService;
use LundSite\Service\LundSiteService;
use LundProducts\Service\LundProductService;
use LundProducts\Service\ParseMasterService;
use LundCustomer\Service\RetailerService;
use RocketEcom\Service\RocketEcomService;
//use RocketBase\Service\CountryService;
use Zend\View\Model\JsonModel;
use Zend\View\HelperPluginManager as ViewHelperManager;
use Zend\Session\Container;
use Zend\Mail;
use Zend\Stdlib\Parameters;
use LundProducts\Entity\BrandsInterface;
use RocketEcom\Service\FedexService;
use RocketEcom\Service\AvaTaxService;
use SimpleXMLElement;
use DOMDocument;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use RocketEcom\Service\TransactionBuilder;
use RocketEcom\Service\AvaTaxClient;
use Symfony\Component\Debug\Tests\Fixtures\ToStringThrower;

/**
 * Sites controller for admin module
 *
 * @category   Zend
 * @package    Application
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class IndexController extends AbstractActionController
{
    /**
     * 
     */
    protected $dbAdapter;
    
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \RocketCms\Service\LayoutService
     */
    protected $layoutService;

    /**
     * @var \RocketCms\Service\TemplateService
     */
    protected $templateService;

    /**
     * @var \RocketCms\Service\PageService
     */
    protected $pageService;

    /**
     * @var \RocketCms\Service\MenuService
     */
    protected $menuService;

    /**
     * @var \RocketCms\Service\MenuElementService
     */
    protected $menuElementService;

    /**
     * @var UserService
     */
    protected $userService;
    
    /**
     * @var BrandSites
     */
    protected $brandSites;
    
    /**
     * @var BrandName
     */
    protected $brandName;
    
    /**
     * @var name
     */
    protected $name;
    
    /**
     * @var brandType
     */
    protected $brandType;
    
    /**
     * @var standAlone
     */
    protected $standAlone;

    /**
     * @var LoginService
     */
    protected $loginService;

    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * @var FileLogService
     */
    protected $fileLogService;

    /**
     * @var AssetService
     */
    protected $assetService;

    /**
     * @var LundSiteService
     */
    protected $lundSiteService;

    /**
     * @var LundProductService
     */
    protected $lundProductService;

    /**
     * @var masterService
     */
    protected $masterService;

    /**
     * @var RetailerService
     */
    protected $retailerService;

    /**
     * @var RocketEcomService
     */
    protected $rocketEcomService;
    
    /**
     * @var CountryService
     */
    //protected $countryService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @var \Zend\Session\Container
     */
    protected $sessionSV;
    protected $sessionEC;

    protected $brandsService = null;
    protected $productCategoryService = null;
    protected $brandProductCategoryService = null;
    protected $productLineService = null;
    protected $productLineAssetService = null;
    protected $productLineFeatureService = null;
    protected $partService = null;
    protected $partAssetService = null;
    protected $vehCollectionService = null;
    protected $productReviewService = null;
    protected $cartService = null;
    protected $cartItemService = null;
    protected $orderService = null;
    protected $orderItemService = null;
    protected $orderAddressService = null;
    protected $shippingMethodService = null;

    /**
     * @param SiteService         $siteService
     * @param LayoutService       $layoutService
     * @param TemplateService     $templateService
     * @param PageService         $pageService
     * @param MenuService         $menuService
     * @param MenuElementService  $menuElementService
     * @param UserService         $userService
     * @param LoginService        $loginService
     * @param CustomerService     $customerService
     * @param FileLogService      $fileLogService
     * @param AssetService        $assetService
     * @param LundSiteService     $lundSiteService
     * @param LundProductService  $lundProductService
     * @param RetailerService     $retailerService
     * @param RocketEcomService   $rocketEcomService
     * @param CountryService      $countryService
     * @param ParseMasterService  $masterService
     * @param HelperPluginManager $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        LayoutService $layoutService,
        TemplateService $templateService,
        PageService $pageService,
        MenuService $menuService,
        MenuElementService $menuElementService,
        UserService $userService,
        LoginService $loginService,
        CustomerService $customerService,
        FileLogService $fileLogService,
        AssetService $assetService,
        LundSiteService $lundSiteService,
        LundProductService $lundProductService,
        RetailerService $retailerService,
        RocketEcomService $rocketEcomService,
        //CountryService $countryService,
        ParseMasterService $masterService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService        = $siteService;
        $this->layoutService      = $layoutService;
        $this->templateService    = $templateService;
        $this->pageService        = $pageService;
        $this->menuService        = $menuService;
        $this->menuElementService = $menuElementService;
        $this->userService  = $userService;
        $this->loginService = $loginService;
        $this->customerService = $customerService;
        $this->fileLogService = $fileLogService;
        $this->assetService = $assetService;
        $this->lundSiteService = $lundSiteService;
        $this->lundProductService = $lundProductService;
        $this->retailerService = $retailerService;
        $this->rocketEcomService = $rocketEcomService;
        //$this->countryService = $countryService;
        $this->masterService = $masterService;
        $this->viewHelperManager = $viewHelperManager;
        $this->sessionSV = new Container('saved_vehicle');
        $this->sessionEC = new Container('saved_cart');
        $this->sessionSC = new Container('saved_customer');
    }

    /**
     * Construct CMS Page
     *
     * @return \Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
    	$slugone   = $this->params()->fromRoute('slugone', null);
    	
	  	$slugtwo   = $this->params()->fromRoute('slugtwo', null);
	    $slugthree = $this->params()->fromRoute('slugthree', null);
	    $slugfour  = $this->params()->fromRoute('slugfour', null);
	    $slugfive  = $this->params()->fromRoute('slugfive', null);
	    
	    if($slugone == 'avs') {
	        
	        $siteBrands = array('1');
	        $this->brandSites = $siteBrands;
	        $brand = $this->lundProductService->getBrandsService()->getBrand('1');
	        $this->brandName = $brand->getName();
	        $this->brandContent = $brand->getHtml();
	        $this->name = $slugone;
	       
	        $slugone = $slugtwo;
	        $slugtwo = $slugthree;
	        $slugthree = $slugfour;
	        $slugfour = $slugfive;
	        $this->brandType = 'brand';
	        
	    } else if($slugone == 'lund') {
	        
	        $siteBrands = array('2');
	        $this->brandSites = $siteBrands;
	        $brand = $this->lundProductService->getBrandsService()->getBrand('2');
	        $this->brandName = $brand->getName();
	        $this->brandContent = $brand->getHtml();
	        $this->name = $slugone;
	        
	        $slugone = $slugtwo;
	        $slugtwo = $slugthree;
	        $slugthree = $slugfour;
	        $slugfour = $slugfive;
	        $this->brandType = 'brand';
	        
	    }else { 
        
    	    $siteBrands = array('1', '2');
    	    $this->brandSites = $siteBrands;
    	    $this->brandName = null;
    	    $this->brandType = null;
	    
	    }
	    
        

        if (null != $slugtwo ) {
            if ($slugone != 'products' && $slugone != 'news' && $slugone != 'cart' && $slugone != 'vehicle') {
                $slug = $slugone . '/' . $slugtwo;
            } else {
                $slug = $slugone;
            }
        } elseif(null != $slugthree) {
        	$slug = $slugone . '/' . $slugtwo . '/' . $slugthree;
        } else {
            $slug = $slugone;
        }
        
        //echo $slug;exit;
        //print_r($result);exit;
        $envVariable = $_SERVER['APP_SITE'];
        
        $site     = $this->siteService->getSiteByEnvVariable($envVariable);
        if (null == $site) {
        	return $this->redirect()->toRoute('rocket-admin');
        }
        
        
        /*
         * ALL OF THE AJAX FUNCTIONS
         */
        if ($slugone == 'ajax-vehicleSelector') {
            $result = $this->vehicleSelector();
        } else if ($slugone == 'clear-vehicle') {
            $result = $this->clearVehicle();
        }

        /*
         * END OF AJAX FUNCTION
         */

        $layout   = $this->layoutService->getLayoutBySite($site->getSiteId());
        $page     = $this->pageService->getPageBySlug($slug, $site->getSiteId());

		if (null != $page) {
	
	        $template = $this->templateService->getTemplate($page->getTemplate()->getTemplateId());
		} else {
		return new ViewModel();
		}
				
		/*  Setting the sessionID for later */
		if(isset($_SESSION['customerID'])) {
			$customerID = $_SESSION['customerID'];
		} else {
			$customerID = rand();
			$_SESSION['customerID'] = $customerID;
		}

        $this->layout($layout->getDirectory(). '/layout');

        if ($page->getLoadInclude()) {
            $vm = new ViewModel(array(
                'templateContent' => false,
                'loadInclude'     => $page->getLoadInclude(),
            	'title'			  => $page->getTitle(),
            ));
        } elseif ($page->getContent()) {
            $vm = new ViewModel(array(
                'templateContent' => $page->getContent(),
                'loadInclude'     => false,
            	'title'			  => $page->getTitle(),
            ));
        } else {
            $vm = new ViewModel();
        }
        

        $vm->setTemplate($template->getFilename());

        $menu = $this->menuService;

        
        $canonical = $slugone;
        
        if (null != $this->brandType)
        {
            $canonical = $this->name."/".$slugone;
        }
        
        if (null != $slugtwo) 
        {
            $canonical .= "/".$slugtwo;
        }
        
        if (null != $slugthree)
        {
            $canonical .= "/".$slugthree;
        }
        
        if (null != $slugfour)
        {
            $canonical .= "/".$slugfour;
        }

        if($canonical == 'index')
        {
            $canonical = null;
        }     
        
        /**
         * Getting the Cart
         */
        
        $cartItems = null;
        if(null !== $this->sessionEC->getManager()->getId()) {
            
            $cart = $this->rocketEcomService->getCartService()->getCartBySessionId($this->sessionEC->getManager()->getId());
            
            if(null != $cart) {
                $cartItems = $this->rocketEcomService->getCartItemService()->getCartItemsByCart($cart);  
                         
                foreach($cartItems as $cartItem) { 
                    
                $image = $this->rocketEcomService->getCartItemService()->getCartItemImage($cartItem->getCartItemId());
                
                $cartItem->setProductLinesAsset($image['product_lines_asset']);
                
                }
            } 
          
        }
        
        /**
         * Getting Product Category Information
         */
        if(isset($_SESSION['vehicle'])) {
            
            $partService        = $this->lundProductService->getPartService();
        	$vehCollectionService = $this->lundProductService->getVehCollectionService();
        	
        	$cars = explode(" - ", $_SESSION['vehicle']['model']);
        	
        	$years = $vehCollectionService->getVehYearsByName($_SESSION['vehicle']['year']);
        	$make = $vehCollectionService->getMake($_SESSION['vehicle']['make']);
      
        	$model = $partService->getVehModelbyYear($cars['0'], $make);
        	//$model = $partService->getVehModelSubmodel($this->brandSites, $years, $make);
        	
        	//print_r($model);
        	if(isset($cars['1'])) {
        	    $subModel= $this->lundProductService->getProductLineService()->getSubModel($cars['1'], $model);
        	    $productCategories = $this->lundProductService->getBrandProductCategoryService()->getVehicleProductCategory($years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites, $subModel[0]['veh_submodel_id'] );
        		
        	
        	} else {
        		
        	    $productCategories = $this->lundProductService->getBrandProductCategoryService()->getVehicleProductCategory($years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites);
        		
        	   // echo count($productCategories);exit;
        	
        	}
        	
        	
        } else {
     
        	$productCategories = $this->lundProductService->getBrandProductCategoryService()->getAllVehicleProductCategory($this->brandSites);
        }
        
        //echo count($this->menuService->getMenuByShortCode());exit;

        //echo $page->getMetaDescription();exit;
        
        $this->layout()->setVariables(array(
            'menuService'        	=> $this->menuService,
            'menuElementService' 	=> $this->menuElementService,
            'site'               	=> $site,
            'page'               	=> $page,
            'metaTitle'          	=> substr($page->getMetaTitle(), 0 , 40),
            'metaKeywords'       	=> $page->getMetaKeywords(),
            'metaDescription'    	=> substr($page->getMetaDescription(), 0, 149),
            'canonical'          	=> $canonical,
            'slug'            		=> $slug,
            'slugtwo'            	=> $slugtwo,
            'slugthree'          	=> $slugthree,
            'slugfour'           	=> $slugfour,
            'brandSites'           	=> $this->brandSites,
        	'brandName'				=> $this->brandName,
            'brandProductCategory' 	=> $this->lundProductService->getBrandProductCategoryService(),
        	'productCategories'		=> $productCategories,
            'cart'               	=> ($this->sessionEC->cartId ? $this->sessionEC->cartId : null),
        	'sessionID'			 	=> $customerID,
            'cartItems'             => $cartItems,
            'cartCount'             => $this->sessionEC->cartCount,
            'discountAmount'        => ($this->sessionEC->discounts ? $this->sessionEC->discounts: null),
            'customerId'            => ($this->sessionSC->customerId ? $this->sessionSC->customerId : null),
            
        ));
        
        if ($page->getSlug() == 'index') {
            $vm = $this->index($site, $vm);
        }
        elseif ($page->getSlug() == 'login') {
            $vm = $this->login($site, $vm);
        }
        elseif ($page->getSlug() == 'logout') {
            $vm = $this->logout($site, $vm);
        }
        elseif ($page->getSlug() == 'products') {
            $vm = $this->products($site, $vm, urldecode($slugtwo), urldecode($slugthree), urldecode($slugfour));
        } 
        elseif ($page->getSlug() == 'contact-us') {
            $vm = $this->contact($site, $vm);
        }
        elseif ($page->getSlug() == 'installation-guide') {
            $vm = $this->installationGuide($site, $vm);
        }
        elseif ($page->getSlug() == 'registration') {
            $vm = $this->registration($site, $vm);
        }
        elseif ($page->getSlug() == 'cart') {
            $vm = $this->cart($site, $vm, $slugtwo, $slugthree, $slugfour);
        }
        elseif ($page->getSlug() == 'ecom-login') {
            $vm = $this->eLogin($site, $vm);
        }
        elseif ($page->getSlug() == 'billing') {
            $vm = $this->billing($site, $vm);
        }
        elseif ($page->getSlug() == 'payment') {
            $vm = $this->payment($site, $vm);
        }
        elseif ($page->getSlug() == 'receipt') {
            $vm = $this->receipt($site, $vm);
        }
        elseif ($page->getSlug() == 'address') {
            $vm = $this->address($site, $vm);
        }
        elseif ($page->getSlug() == 'newsletter') {
            $vm = $this->newsletter($site, $vm);
        }
        elseif ($page->getSlug() == 'contact-information') {
            $vm = $this->contactInformation($site, $vm);
        }
        elseif ($page->getSlug() == 'my-account') {
            $vm = $this->myAccount($site, $vm);
        }
        elseif ($page->getSlug() == 'vehicle') {
            $vm = $this->vehicle($site, $vm, $slugtwo, $slugthree);
        }
        elseif ($page->getSlug() == 'news') {
            if (null != $slugtwo) {
                $vm = $this->newsDetail($site, $vm, $slugtwo);
            } else {
                $vm = $this->news($site, $vm);
            }
        }
        elseif($page->getSlug()== 'affiliates') {
            $vm = $this->affiliates($site, $vm);
        }

        

        return $vm;
    }

    protected function index(SiteInterface $site, ViewModel $vm)
    {
        $years = $this->lundProductService->getPartService()->getVehYear();
        /*
        $number ="";
        for($x=0; $x<40; $x++) {
            $number .= rand(0, 200).", ";
        }
        */
        
        $number = '46, 25, 86, 4, 52, 201, 193, 129, 150, 12, 53, 210, 6, 7, 9, 215, 218, 219, 206, 26, ';
        
        $upsale       = $this->lundProductService->getProductLineService()->getProductLines(substr($number, 0, -2));
        
        $upsales = array();
        $upsalesArray = array();
        for($x=0; $x<count($upsale); $x++) {
            if(!in_array($upsale[$x]['PL_Display'], $upsalesArray)) {
                array_push($upsalesArray, $upsale[$x]['PL_Display']);
                array_push($upsales, $upsale[$x]);
            }
        }
        
        $vm->setVariable('years', $years);
        $vm->setVariable('upsale', $upsales);

        return $vm;
    }
    
    protected function logout(SiteInterface $site, ViewModel $vm)
    {
        $this->loginService->logout();
        
        unset($_SESSION['customerID']);
        unset($_SESSION['saved_customer']);
        
        
        $this->redirect()->toUrl('/');
        return $vm;
    }
    
    protected function login(SiteInterface $site, ViewModel $vm)
    {
        
        
        if(isset($this->sessionSC->customerId)) {
            return $this->redirect()->toUrl('/');
        } else {
            
            $ecomCustomerService = $this->rocketEcomService->getEcomCustomerService();
            
            $form = $ecomCustomerService->getCreateEcomCustomerForm();
            
            if ($this->request->isPost())
            {
                $data = $this->request->getPost();
                
                $fieldset = $data['ecom-customer-fieldset'];
                
                $fieldset['disabled'] = '0';
                $fieldset['newsletters'] = '0';
                $fieldset['guest'] = '0';
                
                $data['ecom-customer-fieldset'] = $fieldset;
                
                
                $authResult = $ecomCustomerService->authenticate($data);
                
                
                if($authResult)
                {
                    $this->sessionSC->customerId = $authResult->getEcomCustomerId();
                    $this->sessionSC->firstName= $authResult->getFirstName();
                    $this->sessionSC->lastName = $authResult->getLastName();
                    
                    return $this->redirect()->toUrl('/my-account');
                  
                    
                } else {
                    
                    $vm->setVariable('errorMessage', 'Invalid login or password.');
                    
                }
            }
            
            
            $vm->setVariable('form', $form);
            
            return $vm;
        }
        
    }
    
    protected function registration(SiteInterface $site, ViewModel $vm)
    {
        
        
        if(isset($this->sessionSC->customerId)) {
            //return $this->redirect()->toUrl('/my-account');
        } else {
            
            $ecomCustomerService = $this->rocketEcomService->getEcomCustomerService();
            
            $form = $ecomCustomerService->getCreateEcomCustomerForm();
            
            if ($this->request->isPost()) {
                
                $systemUser = $this->userService->getUser(1);
                $data = $this->request->getPost();
                
                $data2 = $data['ecom-customer-fieldset'];
                
                $data2['disabled'] = '0';
                $data2['guest'] = '0';
                $data2['sameAsBilling'] = '1';
                
                if(!isset($data2['newsletters'])) {
                    $data2['newsletters'] = '0';
                }
                
                //print_r($data2);exit;
                $data['ecom-customer-fieldset'] = $data2;
                
                
                $emailErr = "";
                $error = '0';
                
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $data['ecom-customer-fieldset']['firstName'])) {
                    $emailErr .= "Only letters and white space allowed for First Name. <br />";
                    $error = '1';
                }
                
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $data['ecom-customer-fieldset']['lastName'])) {
                    $emailErr .= "Only letters and white space allowed for Last Name. <br />";
                    $error = '1';
                }
                
                // checking for valid emails
                if (!filter_var($data['ecom-customer-fieldset']['email'], FILTER_VALIDATE_EMAIL)) {
                    $emailErr .= "Invalid email format. <br />";
                    $error = '1';
                }
                
                // checking for valid password
                if ($data['ecom-customer-fieldset']['password'] != $data['ecom-customer-fieldset']['passwordVerification']) {
                    $emailErr .= "Passwords does not match. <br />";
                    $error = '1';
                }
                
                // checking for valid emails
                if (strlen($data['ecom-customer-fieldset']['password']) < '6' ) {
                    $emailErr .= "Passwords must be longer then 5 characters. <br />";
                    $error = '1';
                }
                
                if(!$error) {
                    
                    $ecomSubmission = $ecomCustomerService->create($systemUser, $data);
                    
                    if ($ecomSubmission instanceof \RocketEcom\Entity\EcomCustomerInterface) {
                        
                        $vm->setVariable('result', 'success');
                        
                         $from = 'admin@myautostores.com';
                         $to = array( $ecomSubmission->getEmail() );
                         $subject = 'My Auto Stores Registration Form Submission';
                         
                         $message = '<p><b>' . $ecomSubmission->getFirstName() . '</b> has registrater for an account with My Auto Store.</p>';
                         
                         $this->sendEmail($from, $to, $subject, $message);
                         
                      
                    } else {
                        $vm->setVariable('result', 'error');
                        $form->setData($this->request->getPost());
                    }
                    
                } else {
                    $vm->setVariable('error', $error);
                    $vm->setVariable('emailErr', $emailErr);
                    $form->setData($this->request->getPost());
                }
            }
            
            $vm->setVariable('form', $form);
            $vm->setVariable('site', $site);
            
            return $vm;
        }
        
    }
    
    protected function installationGuide(SiteInterface $site, ViewModel $vm)
    {
        
        $years = $this->lundProductService->getPartService()->getVehYear();
        
        //print_r($years);exit;
        $vm->setVariable('years', $years);
        
        return $vm;
        
    }
    
    protected function news(SiteInterface $site, ViewModel $vm)
    {
        
        $news = $this->lundSiteService->getNewsReleaseService()->getActiveNewsReleasesBySite($site);
        
        $vm->setVariable('type', 'list');
        $vm->setVariable('news', $news);
        
        return $vm;
        
    }
    
    protected function newsDetail(SiteInterface $site, ViewModel $vm, $url = null )
    {
        
        $news = $this->lundSiteService->getNewsReleaseService()->getNewsReleaseByUrl($site, $url);
        
        
        $this->layout()->setVariables(array(
            'metaTitle' => 'My Auto Store - News - '.$news->getTitle(),
            'metaKeywords' => 'My Auto Store - News - '.$news->getTitle(),
            'metaDescription' => 'My Auto Store - News - '.$news->getTitle(),
        ));
       
        
        $vm->setVariable('type', 'detail');
        $vm->setVariable('news', $news);
        
        return $vm;
        
    }
    
    protected function products(SiteInterface $site, ViewModel $vm, $category = null, $line = null )
    {
        $categories     = $this->params()->fromPost('categories', array());
        $color          = $this->params()->fromPost('color', array());
        $price          = $this->params()->fromPost('price', array());
        $finish         = $this->params()->fromPost('finish', array());
        $style          = $this->params()->fromPost('style', array());
        $price          = $this->params()->fromPost('price', array());
        $brandName      = $this->params()->fromPost('brandName', array());
        
        $this->brandsService               = $this->lundProductService->getBrandsService();
        $this->productCategoryService      = $this->lundProductService->getProductCategoryService();
        $this->productLineService          = $this->lundProductService->getProductLineService();
        $this->brandProductCategoryService = $this->lundProductService->getBrandProductCategoryService();
        
        
        
        if (null != $category && null == $line || $this->brandType == 'brand') {
            echo "4";exit;
            $vm = $this->loadProductLinePage($vm, $category, $brandName, $color, $price, $finish, $style, $price, $categories);
        } 
        if (null != $category && null != $line) {
            echo "5";exit;
            $vm = $this->loadPartsPage($vm, $category, $line, $brandName);
        } 
        
        return $vm;
    }

    protected function loadProductLinePage(ViewModel $vm, $category = null, $brandName = null, $color=null, $price=null, $finish=null, $style=null, $price=null, $categories=null)
    {
        $show  = $this->params()->fromPost('show', 10);
        $sort  = $this->params()->fromPost('sort', 1);
        
        if($category == 'vehicle'){
            
            $this->storeVehicle();
            
            if(isset($_SESSION['vehicle'])) {
                
                $brandProductCategory = null;
                
                $partService        = $this->lundProductService->getPartService();
                $vehCollectionService = $this->lundProductService->getVehCollectionService();
                
                $cars = explode(" - ", $_SESSION['vehicle']['model']);
                
                $years = $vehCollectionService->getVehYearsByName($_SESSION['vehicle']['year']);
                $make = $vehCollectionService->getMake($_SESSION['vehicle']['make']);
                
                $model = $partService->getVehModelbyYear($cars['0'], $make);
                $model[0]['name'];
                
                if(isset($cars['1'])) {
                    
                    $subModel= $this->lundProductService->getProductLineService()->getSubModel($cars['1'], $model);
                    
                    $baseProductLines = $this->lundProductService->getProductLineService()->getCategoryBrandProductCategory('', $years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites, '', $subModel[0]['veh_submodel_id']);
                    
                    $productLines = $this->lundProductService->getProductLineService()->getCategoryBrandProductCategory('', $years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites, '', $subModel[0]['veh_submodel_id'], $color, $finish, $style, $price);
                    
                    
                } else {
                    
                    //echo "hi";exit;
                    $baseProductLines = $this->lundProductService->getProductLineService()->getCategoryBrandProductCategory('', $years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites);
                    
                    $productLines = $this->lundProductService->getProductLineService()->getCategoryBrandProductCategory('', $years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites, $sort, $color, $finish, $style, $price);
                    
                    
                }
            }
        
        } else if($this->brandType == 'brand'){
            
            $category = $this->brandName;
            if(isset($_SESSION['vehicle'])) {
                
                $partService        = $this->lundProductService->getPartService();
                $vehCollectionService = $this->lundProductService->getVehCollectionService();
                
                $cars = explode(" - ", $_SESSION['vehicle']['model']);
                
                $years = $vehCollectionService->getVehYearsByName($_SESSION['vehicle']['year']);
                $make = $vehCollectionService->getMake($_SESSION['vehicle']['make']);
                
                $model = $partService->getVehModelbyYear($cars['0'], $make);
            
                
                $baseProductLines = $this->lundProductService->getProductLineService()->getCategoryBrandProductCategoryByBrand($years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites);
                
                $productLines = $this->lundProductService->getProductLineService()->getCategoryBrandProductCategoryByBrand($years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites, $sort, $color, $finish, $style, $price, $categories);
                
            } else {
                
                $baseProductLines = $this->lundProductService->getProductLineService()->getBrandProductCategoryByBrand($this->brandSites);
                
                $productLines = $this->lundProductService->getProductLineService()->getBrandProductCategoryByBrand($this->brandSites, $sort, $color, $finish, $style, $price, $categories);
                
            }
            
            $vm->setVariable('brandContent', $this->brandContent);
            $vm->setVariable('productLinesBrands', '1');
            $vm->setVariable('name', $this->name);
            
            
        } else {
            
            $productCategory = $this->productCategoryService->getProductCategoryByName($category);
            $brandProductCategory = $this->brandProductCategoryService->getCategoryByBrandAndCategory($productCategory);
            
            if(isset($_SESSION['vehicle'])) {
                
                $partService        = $this->lundProductService->getPartService();
                $vehCollectionService = $this->lundProductService->getVehCollectionService();
                
                $cars = explode(" - ", $_SESSION['vehicle']['model']);
                
                $years = $vehCollectionService->getVehYearsByName($_SESSION['vehicle']['year']);
                $make = $vehCollectionService->getMake($_SESSION['vehicle']['make']);
                
                $model = $partService->getVehModelbyYear($cars['0'], $make);
                $model[0]['name'];
                
                $baseProductLines = $this->lundProductService->getProductLineService()->getCategoryBrandProductCategory($category, $years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites);
                
                $productLines = $this->lundProductService->getProductLineService()->getCategoryBrandProductCategory($category, $years->getVehYearId(), $make[0]->getVehMakeId(), $model[0]['veh_model_id'], $this->brandSites, $sort, $color, $finish, $style, $price);
                
            } else {
                
                $baseProductLines = $this->lundProductService->getProductLineService()->getBrandProductCategory($category, $this->brandSites);
                
                $productLines = $this->lundProductService->getProductLineService()->getBrandProductCategory($category, $this->brandSites, $sort, $color, $finish, $style, $price);
                
                //echo count($baseProductLines);exit;
            }
            
        }
        
        
        $allBrands = $this->lundProductService->getBrandsService()->getCurrentBrands();
       
            $categoriesProductLineArray= array();
            $colorProductLineArray= array();
            $finishProductLineArray= array();
            $styleProductLineArray= array();
            $priceProductLineArray= array();
            $brandNameProductLineArray= array();
            
            $categories = array_keys($categories);
            $color = array_keys($color);
            $finish = array_keys($finish);
            $style = array_keys($style);
            $price = array_keys($price);
            $brandName = array_keys($brandName);
            
            //print_r($finish);exit;
            $categoriesArray = array();
            $colorArray = array();
            $finishArray = array();
            $styleArray = array();
            $priceArray = array();
            $brandNameArray = array();
            
            foreach($baseProductLines as $baseProductLine)
            {
                if($baseProductLine['brand'] != '')
                {
                    if(!in_array($baseProductLine['brand'], $brandNameProductLineArray))
                    {
                        array_push($brandNameProductLineArray, $baseProductLine['brand']);
                    }
                }
                if($baseProductLine['display_name'] != '')
                {
                    if(!in_array($baseProductLine['display_name'], $categoriesProductLineArray))
                    {
                        array_push($categoriesProductLineArray, $baseProductLine['display_name']);
                    }
                }
                if($baseProductLine['color_group'] != '')
                {
                    if(!in_array($baseProductLine['color_group'], $colorProductLineArray))
                    {
                        array_push($colorProductLineArray, $baseProductLine['color_group']);
                    }
                }
                if($baseProductLine['finish'] != '')
                {
                    if(!in_array($baseProductLine['finish'], $finishProductLineArray))
                    {
                        array_push($finishProductLineArray, $baseProductLine['finish']);
                    }
                }
                if($baseProductLine['style'] != '')
                {
                    if(!in_array($baseProductLine['style'], $styleProductLineArray))
                    {
                        array_push($styleProductLineArray, $baseProductLine['style']);
                    }
                }
                if($baseProductLine['sale_price'] != '')
                {
                    if(!in_array($baseProductLine['sale_price'], $priceProductLineArray))
                    {
                        array_push($priceProductLineArray, $baseProductLine['sale_price']);
                    }
                }
                /*
                if($baseProductLine['brandName'] != '')
                {
                    if(!in_array($baseProductLine['brandName'], $brandNameProductLineArray))
                    {
                        array_push($brandNameProductLineArray, $baseProductLine['brandName']);
                    }
                }
                */
            }
            
            $productLineMetaNames = array('Side Window Deflectors'  => array('Car Window Shades',
                                                                             'Rain Guards',
                                                                             'Window Guards',
                                                                             'Wind Deflectors',
                                                                             'Auto Ventshade',
                                                                             'Car Window Shades',
                                                                             'Rain Guards',
                                                                             'Window Guards',
                                                                             'Wind Deflectors',
                                                                             'Auto Ventshade'
                                                                            ),
                                          'Tonneau Cover'          => array('Truck Accessories',
                                                                             'Tonneau Cover',
                                                                             'Truck Bed Covers',
                                                                             'Tonneau Covers',
                                                                             'Bed Cover',
                                                                             'Truck Accessories',
                                                                             'Tonneau Cover',
                                                                             'Truck Bed Covers',
                                                                             'Tonneau Covers',
                                                                             'Bed Cover'
                                                                            ),
                                          'Fender Flare'            => array('Bushwacker',
                                                                             'Fender Flare',
                                                                             'Fender Flares',
                                                                             'Fender Mustang',
                                                                             'Bushwacker Fender Flare',
                                                                             'Bushwacker',
                                                                             'Fender Flare',
                                                                             'Fender Flares',
                                                                             'Fender Mustang',
                                                                             'Bushwacker Fender Flare'
                                                                            ),
                                          'Running Boards'          => array('Running Boards',
                                                                             'Truck Steps',
                                                                             'Sidestep',
                                                                             'Truckingboards',
                                                                             'Running Boards For Trucks',
                                                                             'Running Boards',
                                                                             'Truck Steps',
                                                                             'Sidestep',
                                                                             'Truckingboards',
                                                                             'Running Boards For Trucks'
                                                                            ),
                                          'Light Covers'            => array('Light Covers',
                                                                             'Tail Light Cover',
                                                                             'Tail Light Covers',
                                                                             'Headlight Cover',
                                                                             'Headlight Covers',
                                                                             'Light Covers',
                                                                             'Tail Light Cover',
                                                                             'Tail Light Covers',
                                                                             'Headlight Cover',
                                                                             'Headlight Covers'
                                                                            ),
                                          'Hood Scoops'             => array('Carscoops',
                                                                             'Hood Scoops',
                                                                             'Body Kit',
                                                                             'Wide Body Kits',
                                                                             'Car Body Kit',
                                                                             'Carscoops',
                                                                             'Hood Scoops',
                                                                             'Body Kit',
                                                                             'Wide Body Kits',
                                                                             'Car Body Kit',
                                                                            ),
                                          'Hood Shields'            => array('Bug Car',
                                                                             'Wind Deflectors',
                                                                             'Bug Deflector',
                                                                             'Bug Shield',
                                                                             'AVS Bug Shield',
                                                                             'Bug Car',
                                                                             'Wind Deflectors',
                                                                             'Bug Deflector',
                                                                             'Bug Shield',
                                                                             'AVS Bug Shield'
                                                                            ),
                                          'Aeroskin'                => array('Auto Ventshade',
                                                                             'AVS Vent Visors',
                                                                             'Ventshade',
                                                                             'AVS Window Visors',
                                                                             'AVS Rain Guards',
                                                                             'Auto Ventshade',
                                                                             'AVS Vent Visors',
                                                                             'Ventshade',
                                                                             'AVS Window Visors',
                                                                             'AVS Rain Guards'
                                                                            ),
                                          'Rocker Guards'           => array('Jeep Accessories',
                                                                             'Jeep Parts',
                                                                             'Rhino Liner',
                                                                             'Bumper',
                                                                             'Jeep Wrangler Accessories',
                                                                             'Jeep Accessories',
                                                                             'Jeep Parts',
                                                                             'Rhino Liner',
                                                                             'Bumper',
                                                                             'Jeep Wrangler Accessories'
                                                                            ),
                                          'Bull Bars'               => array('Bull Bars',
                                                                             'Bullguard',
                                                                             'Push Far',
                                                                             'Bull Bar F150',
                                                                             'Bull Bars for Trucks',
                                                                             'Bull Bars',
                                                                             'Bullguard',
                                                                             'Push Far',
                                                                             'Bull Bar F150',
                                                                             'Bull Bars for Trucks'
                                                                            ),
                                          'Nerf Bars'               => array('Sidebar',
                                                                             'Nerf Bars',
                                                                             'Truck Steps',
                                                                             'Sidestep',
                                                                             'Rock Bar',
                                                                             'Sidebar',
                                                                             'Nerf Bars',
                                                                             'Truck Steps',
                                                                             'Sidestep',
                                                                             'Rock Bar'
                                                                            ),
                                          'Floor Covering'          => array('Weathertech',
                                                                             'Weathertech Floor Liner',
                                                                             'Weathertech Floor Mats',
                                                                             'Floor Mats',
                                                                             'Car Floor Mats',
                                                                             'Weathertech',
                                                                             'Weathertech Floor Liner',
                                                                             'Weathertech Floor Mats',
                                                                             'Floor Mats',
                                                                             'Car Floor Mats'
                                                                            ),
                                          'Air Deflectors'          => array('Rain Guards',
                                                                             'Air Vent Deflector',
                                                                             'Air Vent Deflectors',
                                                                             'Rain Guards',
                                                                             'Air Vent Deflector',
                                                                             'Air Vent Deflectors',
                                                                             'Rain Guards',
                                                                             'Air Vent Deflector',
                                                                             'Air Vent Deflectors',
                                                                             'Rain Guards'
                                                                            ),
                                          'Chrome Accessories'      => array('Car Accessories',
                                                                             'Auto Accessories',
                                                                             'Chrome Shop',
                                                                             'Pickup Truck Accessories',
                                                                             'Car Accessories',
                                                                             'Auto Accessories',
                                                                             'Chrome Shop',
                                                                             'Pickup Truck Accessories',
                                                                             'Car Accessories',
                                                                             'Auto Accessories'
                                                                            )
                                         );
            
            $vm->setVariable('categoriesProductLineArray', $categoriesProductLineArray);
            $vm->setVariable('colorProductLineArray', $colorProductLineArray);
            $vm->setVariable('finishProductLineArray', $finishProductLineArray);
            $vm->setVariable('styleProductLineArray', $styleProductLineArray);
            $vm->setVariable('priceProductLineArray', $priceProductLineArray);
            $vm->setVariable('brandNameProductLineArray', $brandNameProductLineArray);
            
            $vm->setVariable('show', $show);
            $vm->setVariable('sort', $sort);
            
            $vm->setVariable('categories', $categories);
            $vm->setVariable('color', $color);
            $vm->setVariable('finish', $finish);
            $vm->setVariable('style', $style);
            $vm->setVariable('price', $price);
            $vm->setVariable('brandName', $brandName);
            
            $vm->setVariable('categoriesArray', $categoriesArray);
            $vm->setVariable('colorArray', $colorArray);
            $vm->setVariable('finishArray', $finishArray);
            $vm->setVariable('styleArray', $styleArray);
            $vm->setVariable('priceArray', $priceArray);
            $vm->setVariable('brandNameArray', $brandNameArray);
            
            $vm->setVariable('allBrands', $allBrands);
            $vm->setVariable('brandProductCategory', $brandProductCategory);
            
            $vm->setVariable('productLines', $productLines);
            $vm->setVariable('baseProductLines', $baseProductLines);
            $vm->setVariable('category', $category);
            $vm->setVariable('productLineMetaNames', $productLineMetaNames);
            
        
        
        if (null != $brandProductCategory) {
            $this->layout()->setVariables(array(
                'metaTitle'       => ($brandProductCategory->getMetaTitle() == '' ? $productCategory->getName() : $brandProductCategory->getMetaTitle()),
                'metaKeywords'    => ($brandProductCategory->getMetaKeywords() == '' ? $productCategory->getName() : $brandProductCategory->getMetaKeywords()),
                'metaDescription' => ($brandProductCategory->getMetaDescr() == '' ? $productCategory->getName() : $brandProductCategory->getMetaDescr()),
            ));
        } else {
            $this->layout()->setVariables(array(
                'metaTitle' => 'My Auto Store | AVS | LUND | Accessories',
                'metaKeywords' => 'My Auto Store | AVS | LUND | Accessories',
                'metaDescription' => 'My Auto Store | AVS | LUND | Accessories for any part you will ever need for your car',
            ));
        }
        
        return $vm;
    }
    
    protected function loadPartsPage(ViewModel $vm, $category = null, $line = null, $brandName = null)
    {
        
        $productLines = $this->lundProductService->getProductLineService()->getProductLinesByName($line);
        $parts        = $this->lundProductService->getPartService()->getPartsByProductLine($productLines[0]);
        $years        = $this->lundProductService->getPartService()->getVehYear($category, $productLines['0']->getDisplayName());
        $features     = $this->lundProductService->getProductLineService()->getAllBrandProductLineFeature($productLines['0']->getProductLineId());
        
        $price = '10000';
        $number ="";
        
        for($n=0; $n<count($parts); $n++) {
            if($parts[$n]->getSalePrice() !== '0.00')
            {
                if($parts[$n]->getSalePrice() < $price)
                {
                    $price = $parts[$n]->getSalePrice();
                }
            }
        }
        
        /*
         $number ="";
         for($x=0; $x<40; $x++) {
         $number .= rand(0, 200).", ";
         }
         */
        
        $number = '46, 25, 86, 4, 52, 201, 193, 129, 150, 12, 53, 210, 6, 7, 9, 215, 218, 219, 206, 26, ';
        
        $upsale       = $this->lundProductService->getProductLineService()->getProductLines(substr($number, 0, -2));
        
        $upsales = array();
        $upsalesArray = array();
        for($x=0; $x<count($upsale); $x++) {
            if(!in_array($upsale[$x]['PL_Display'], $upsalesArray)) {
                array_push($upsalesArray, $upsale[$x]['PL_Display']);
                array_push($upsales, $upsale[$x]);
            }
        }
        
        $vm->setVariable('category', $category);
        $vm->setVariable('productLines', $productLines);
        $vm->setVariable('price', $price);
        $vm->setVariable('parts', $parts);
        $vm->setVariable('years', $years);
        $vm->setVariable('upsale', $upsales);
        $vm->setVariable('features', $features);
        $vm->setVariable('loadInclude', 'parts.phtml');
        
        $this->layout()->setVariables(array(
            'metaTitle'       => substr($productLines['0']->getMetaTitle(), 0, 40),
            'metaKeywords'    => $productLines['0']->getMetaKeywords(),
            'metaDescription' => substr($productLines['0']->getMetaDescr(), 0, 149),
        ));
        
        return $vm;
    }
    
    protected function vehicleSelector()
    {
        $result = '';
        $partService        = $this->lundProductService->getPartService();
        $vehCollectionService = $this->lundProductService->getVehCollectionService();
        
        $module = $this->params()->fromPost('module', null);
        $year   = $this->params()->fromPost('vehYear', null);
        $make   = $this->params()->fromPost('vehMake', null);
        $model  = $this->params()->fromPost('vehModel', null);
        $partNumber  = $this->params()->fromPost('partNumber', null);
        
        $productCategory  = $this->params()->fromPost('productCategory', null);
        $productLine  = $this->params()->fromPost('productLine', null);
        
        
        $bedLength  = $this->params()->fromPost('bedLength', null);
        $bodyType  = $this->params()->fromPost('bodyType', null);
        $soldAs  = $this->params()->fromPost('soldAs', null);
        $finish  = $this->params()->fromPost('finish', null);
        $color  = $this->params()->fromPost('color', null);
        $partId  = $this->params()->fromPost('partId', null);
        
        
        if ($module == 'getMake') {
            $records = $partService->getVehMake($year, $productCategory, $productLine);
            
            for($m=0; $m<count($records); $m++)
            {
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                }
            }
            
        } elseif ($module == 'getModelSubmodel') {
            $records = $partService->getVehModelSubmodel($year, $make, $productCategory, $productLine);
            
            
            for($m=0; $m<count($records); $m++)
            {
                
                if(!empty($records[$m]['submodel']))
                {
                    //echo $records[$m]['submodel'];exit;
                    $records[$m]['name'] = $records[$m]['name']." - ".$records[$m]['submodel'];
                }
                
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                    unset($records[$m]['submodel']);
                }
            }
            
        } elseif ($module == 'getBedLength') {
            
            $records = $partService->getVehBedLength($year, $make, $model, '', $productCategory, $productLine);

            for($m=0; $m<count($records); $m++)
            {
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                }
            }
            
        } elseif ($module == 'getBodyType') {
            
            $records = $partService->getBodyType($year, $make, $model, '', $bedLength, $productCategory, $productLine);
            
            for($m=0; $m<count($records); $m++)
            {
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                }
            }
            
        } elseif ($module == 'getSoldAs') {
            
            $records = $partService->getSoldAs($year, $make, $model, '', $bedLength, $bodyType, $productCategory, $productLine);
            
            for($m=0; $m<count($records); $m++)
            {
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                }
            }
            
        } elseif ($module == 'getFinish') {
            
            $records = $partService->getFinish($year, $make, $model, '', $bedLength, $bodyType, $soldAs, $productCategory, $productLine);
            
            for($m=0; $m<count($records); $m++)
            {
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                }
            }
            
        } elseif ($module == 'getColor') {
            
            $records = $partService->getColor($year, $make, $model, '', $bedLength, $bodyType, $soldAs, $finish, $productCategory, $productLine);
            
            for($m=0; $m<count($records); $m++)
            {
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                }
            }
            
        } elseif ($module == 'getPartId') {
            
            $records = $partService->getPartId($year, $make, $model, '', $bedLength, $bodyType, $soldAs, $finish, $color, $productCategory, $productLine);
            
            for($m=0; $m<count($records); $m++)
            {
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                }
            }
            
        } elseif ($module == 'getIsheet') {
            
            $records = $partService->getInstallations($year, $make, $model);
            
            for($m=0; $m<count($records); $m++)
            {
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                }
            }
            
        } elseif ($module == 'getIsheetPart') {
            
            $records = $partService->getInstallationsParts($partNumber);
            
            for($m=0; $m<count($records); $m++)
            {
                for($n=0; $n<count($records[$m]); $n++)
                {
                    unset($records[$m][$n]);
                }
            }
           
            } else {
            
            $records = null;
            
        }
        
        //echo count($records);exit;
        //print_r($records);exit;
        $json = json_encode($records);
        echo $json;
        exit();
        
    }
    
    protected function contact(SiteInterface $site, ViewModel $vm)
    {
        $contactSubmissionService = $this->lundSiteService->getContactSubmissionService();
        
        $form = $contactSubmissionService->getCreateContactSubmissionForm();
        
        if ($this->request->isPost()) {
            $systemUser = $this->userService->getUser(1);
            
            $contactSubmission = $contactSubmissionService->create($systemUser, $this->request->getPost());
            
            if ($contactSubmission instanceof \LundSite\Entity\ContactSubmissionInterface) {
                
                $vm->setVariable('result', 'success');
                
                $from = 'admin@myautostores.com';
                $to = array('raven3419@gmail.com');
                $subject = 'My Auto Stores Contact Form Submission';
                
                $message = '<p><b>' . $contactSubmission->getFirstName() . '</b> has submitted a contact request.</p><p><b>Information:</b><br><br>First Name: ' . $contactSubmission->getFirstName() . '<br>Last Name: ' . $contactSubmission->getLastName() . '<br>Email Address: ' . $contactSubmission->getEmailAddress() . '<br>Phone Number: ' . $contactSubmission->getPhoneNumber() . '<br>Comments: ' . $contactSubmission->getComments() . '</p>';
                
                $this->sendEmail($from, $to, $subject, $message);
                
            } else {
                $vm->setVariable('result', 'error');
                $form->setData($this->request->getPost());
            }
        }
        
        $vm->setVariable('form', $form);
        $vm->setVariable('site', $site);
        
        return $vm;
    }
    
    protected function storeVehicle()
    {
        $year = $this->params()->fromPost('year');
        $make = $this->params()->fromPost('make');
        $model = $this->params()->fromPost('model');
        
        if((null != $year) && (null != $make) && (null != $model) ) {
            
            $_SESSION['vehicle']['year'] = $year;
            $_SESSION['vehicle']['make'] = $make;
            $_SESSION['vehicle']['model'] = $model;
        
        }
        return true;
    }
    
    protected function clearVehicle()
    {
        
        unset($_SESSION['vehicle']);
        
        $recordArray['status'] = 'complete';
        
        echo json_encode($recordArray);
        exit();
    }
    
    protected function eLogin(SiteInterface $site, ViewModel $vm)
    {
        if(isset($this->sessionSC->customerId)) {
         
            return $this->redirect()->toUrl('/billing');
            
        } else {
        
            $ecomCustomerService = $this->rocketEcomService->getEcomCustomerService();
            
            $form = $ecomCustomerService->getCreateEcomCustomerForm();
            
            if ($this->request->isPost())
            {
                $data = $this->request->getPost();
                
                if($data['loginForm'] == '1' ) 
                {
                    $fieldset = $data['ecom-customer-fieldset'];
                    
                    $fieldset['disabled'] = '0';
                    $fieldset['newsletters'] = '0';
                    $fieldset['guest'] = '0';
                    
                    $data['ecom-customer-fieldset'] = $fieldset;
                    
                    
                    $authResult = $ecomCustomerService->authenticate($data);
                    
                    
                    if($authResult)
                    {
                        $this->sessionSC->customerId = $authResult->getEcomCustomerId();
                        $this->sessionSC->firstName= $authResult->getFirstName();
                        $this->sessionSC->lastName = $authResult->getLastName();
                        
                        return $this->redirect()->toUrl('/billing');
                        
                        
                    } else {
                        
                        $vm->setVariable('errorMessage', 'Invalid login or password.');
                        
                    }
                    
                } elseif( $data['loginForm'] == '2' ) {
                    
                    $systemUser = $this->userService->getUser(1);
                    $data = $this->request->getPost();
                    
                    $data2 = $data['ecom-customer-fieldset'];
                    
                    $data2['disabled'] = '0';
                    $data2['guest'] = '0';
                    $data2['sameAsBilling'] = '1';
                    
                    if(!isset($data2['newsletters'])) {
                        $data2['newsletters'] = '0';
                    }
                    
                    //print_r($data2);exit;
                    $data['ecom-customer-fieldset'] = $data2;
                    
                    
                    $emailErr = "";
                    $error = '0';
                    
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z ]*$/", $data['ecom-customer-fieldset']['firstName'])) {
                        $emailErr .= "Only letters and white space allowed for First Name. <br />";
                        $error = '1';
                    }
                    
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z ]*$/", $data['ecom-customer-fieldset']['lastName'])) {
                        $emailErr .= "Only letters and white space allowed for Last Name. <br />";
                        $error = '1';
                    }
                    
                    // checking for valid emails
                    if (!filter_var($data['ecom-customer-fieldset']['email'], FILTER_VALIDATE_EMAIL)) {
                        $emailErr .= "Invalid email format. <br />";
                        $error = '1';
                    }
                    
                    // checking for valid password
                    if ($data['ecom-customer-fieldset']['password'] != $data['ecom-customer-fieldset']['passwordVerification']) {
                        $emailErr .= "Passwords does not match. <br />";
                        $error = '1';
                    }
                    
                    // checking for valid emails
                    if (strlen($data['ecom-customer-fieldset']['password']) < '6' ) {
                        $emailErr .= "Passwords must be longer then 5 characters. <br />";
                        $error = '1';
                    }
                    
                    // checking for valid emails
                    if ($ecomCustomerService->getEcomCustomerByEmail($data['ecom-customer-fieldset']['email']) != null) {
                        $emailErr .= "User Account has already been created please log in. <br />";
                        $error = '1';
                    }
                    
                    if(!$error) {
                        
                        $ecomSubmission = $ecomCustomerService->create($systemUser, $data);
                        
                        if ($ecomSubmission instanceof \RocketEcom\Entity\EcomCustomerInterface) {
                            
                            $vm->setVariable('result', 'success');
                            
                            $this->sessionSC->customerId = $ecomSubmission->getEcomCustomerId();
                            $this->sessionSC->firstName= $ecomSubmission->getFirstName();
                            $this->sessionSC->lastName = $ecomSubmission->getLastName();
                            
                            return $this->redirect()->toUrl('/billing');
                            
                        } else {
                            $vm->setVariable('result', 'error');
                            $form->setData($this->request->getPost());
                        }
                        
                    } else {
                        $vm->setVariable('error', $error);
                        $vm->setVariable('errorMessage', $emailErr);
                        $form->setData($this->request->getPost());
                    }
                    
                }
            }
            
            $vm->setVariable('form', $form);
            
            return $vm;
        }
    }
    
    protected function receipt(SiteInterface $site, ViewModel $vm)
    {
        
        $this->cartService           = $this->rocketEcomService->getCartService();
        $this->orderService          = $this->rocketEcomService->getOrderService();
        $this->orderItemService      = $this->rocketEcomService->getOrderItemService();
        
        $cart = $this->cartService->getCartBySessionId($this->sessionEC->getManager()->getId());
        
        $shipping = $this->cartService->getShipping($cart);
        $taxes = $this->sessionEC->taxes;
        
        $cart->setShippingCost($shipping['shipping_cost']);
        
        $order = $this->orderService->getOrder($this->sessionEC->orderId);
        
        $vm->setVariable('taxes', $taxes);
        $vm->setVariable('order', $order);
        $vm->setVariable('cart', $cart);
            
        $this->cartService->disableCart($cart);
        $this->sessionEC->getManager()->getStorage()->clear('saved_cart');
        unset($_SESSION['saved_cart']);
        
        
        return $vm;
    }
    
    protected function payment(SiteInterface $site, ViewModel $vm)
    {
        
        if(!isset($this->sessionSC->customerId)) {
            
            return $this->redirect()->toUrl('/');
            
        } else {
            $this->cartService           = $this->rocketEcomService->getCartService();
            $cart = $this->cartService->getCartBySessionId($this->sessionEC->getManager()->getId());
            $this->cartItemService       = $this->rocketEcomService->getCartItemService();
            $this->orderService          = $this->rocketEcomService->getOrderService();
            $this->orderItemService      = $this->rocketEcomService->getOrderItemService();
                 
            $systemUser = $this->userService->getUser(1);
            $shipping = $this->cartService->getShipping($cart);
            $taxes = $this->sessionEC->taxes;
            
            $cart->setShippingCost($shipping['shipping_cost']);
            
            if ($this->request->isPost()) {
                
                if (null == $this->sessionEC->orderId) {
                    
                    $cartItems = $this->cartItemService->getCartItemsByCart($cart);
                    $grandtotal = 0;
                    foreach($cartItems as $item) {
                        
                        $subtotal = $item->getQuantity() * $item->getPrice();
                        $price = $item->getPrice();
                      
                        $grandtotal = $grandtotal + $subtotal;
                    }
                    
                    $amount = ($shipping['shipping_cost'] + $grandtotal + $taxes['tax']);
                    
                    $data = array(
                        'user_id'       => $systemUser->getUserId(),
                        'subtotal'      => $grandtotal,
                        'total'         => $amount,
                        'shipping'      => $cart->getShippingCost(),
                        'taxes'         => $taxes['tax'],
                        'discount'      => 0,
                        'cart'          => $cart,
                    );
                    
                    $order = $this->orderService->createOrder($systemUser, $data);
                    
                    foreach ($cartItems as $item) {
                        $data = array(
                            'product_id'    => $item->getProductId(),
                            'quantity'      => $item->getQuantity(),
                            'description'   => $item->getDescription(),
                            'price'         => $item->getPrice(),
                            'weight'        => $item->getWeight(),
                            'length'        => $item->getLength(),
                            'height'        => $item->getHeight(),
                            'width'         => $item->getWidth(),
                            'upc_code'      => $item->getUpcCode(),
                            'cart_item_id'  => $item,
                        );
                        
                        $orderItem = $this->orderItemService->createOrderItem($systemUser, $order, $data);
                    }
                    
                    $this->sessionEC->orderId = $order->getOrderId();
                    
                } else {
                    $order = $this->orderService->getOrder($this->sessionEC->orderId);
                }
                
                $ecomCustomer = $this->rocketEcomService->getEcomCustomerService()->getEcomCustomer($this->sessionSC->customerId);
                
                //$ccNumber = '4111111111111111';
                $ccNumber   = $this->params()->fromPost('ccNumber');
                $ccExpMonth = $this->params()->fromPost('ccExpMonth');
                $ccExpYear  = $this->params()->fromPost('ccExpYear');
                $ccCVV      = $this->params()->fromPost('ccCVV');
                
                $trxnProperties = array(
                    "User_Name"                 => "",
                    "Secure_AuthResult"         => "",
                    "Ecommerce_Flag"            => "",
                    "XID"                       => "",
                    "ExactID"                   => "L29960-23",                          //Payment Gateway
                    "CAVV"                      => "",
                    "Password"                  => "y7k0K7OkmWNAE2lrWV4B1M",	         //Gateway Password
                    "CAVV_Algorithm"            => "",
                    "Transaction_Type"          => "00",                                 //Transaction Code I.E. Purchase="00" Pre-Authorization="01" etc.
                    "Reference_No"              => $order->getOrderId(),
                    "Customer_Ref"              => "",
                    "Reference_3"               => "",
                    "Client_IP"                 => $_SERVER['REMOTE_ADDR'],				 //This value is only used for fraud investigation.
                    "Client_Email"              => $ecomCustomer->getEmail(),			 //This value is only used for fraud investigation.
                    "Language"                  => "en",			                     //English="en" French="fr"
                    "Card_Number"               => $ccNumber,		                     //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
                    "Expiry_Date"               => $ccExpMonth.$ccExpYear,               //This value should be in the format MM/YY.
                    "CardHoldersName"           => $ecomCustomer->getFirstName()." ".$ecomCustomer->getLastName(),
                    "Track1"                    => "",
                    "Track2"                    => "",
                    "Authorization_Num"         => "",  //** not sure
                    "Transaction_Tag"           => "",
                    "DollarAmount"              => $order->getTotal(),
                    "VerificationStr1"          => $ecomCustomer->getBillingStreetAddress()."|".$ecomCustomer->getBillingPostCode()."|".$ecomCustomer->getBillingCity()."|".$ecomCustomer->getBillingState()->getSubdivisionName()."|".$ecomCustomer->getBillingState()->getCodeChar2(),
                    "VerificationStr2"          => $ccCVV,
                    "CVD_Presence_Ind"          => "",
                    "Secure_AuthRequired"       => "",
                    "Currency"                  => "USD",
                    "PartialRedemption"         => "",
                    
                    // Level 2 fields
                    "ZipCode"                   => "",
                    "Tax1Amount"                => "",
                    "Tax1Number"                => "",
                    "Tax2Amount"                => "",
                    "Tax2Number"                => "",
                    
                );
                
                //print_r($trxnProperties);exit;
               
             
                $path_to_wsdl = "https://api.globalgatewaye4.firstdata.com/transaction/v11/wsdl";
          
                $client = new SoapClientHMAC( $path_to_wsdl );
                
                $trxnResult = $client->SendAndCommit($trxnProperties);
                
                if($trxnResult->Transaction_Error == '1')
                {
                    $vm->setVariable('error', '1');
                    $vm->setVariable('errorMessage', 'Please review your address and re-enter your credit card information.');
                }
                
                if($trxnResult->Transaction_Approved == '1')
                {
                    $transactionId = $trxnResult->Transaction_Tag;
                    $cardType = $trxnResult->CardType;
                    $scrubCC = $trxnResult->TransarmorToken;
                
                    $order = $this->orderService->scrubOrder($order, $scrubCC, $transactionId, $ccExpMonth, $ccExpYear, $ccCVV, $cardType, $ecomCustomer);
                
                    $from = 'webmaster@myautostores.com';
                    $subject = 'Confirmation Order Email';
                    $to = array($order->getEcomCustomer()->getEmail(),
                                'webmaster@myautostores.com');
                    $message = '<!DOCTYPE html><html lang="en">
                                	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
                                	<head>
                                	</head>
                                	<body>
                                		<table border = "0" width="100%">
                                			<tr>
                                				<td colspan="1">
                                					<a href="https://www.myautostores.com">
                                						<img src="https://www.myautostores.com/assets/application/myautostores/images/logo/logo2.png" alt="myautostores" title="myautostores">
                                					</a>
                                				</td><td colspan="2">
                                					<center>
                                						<font size="40">Thank You For Your Order!</font>
                                						<br />
                                						Order # '.$order->getOrderId().'
                                					</center>
                                				</td>
                                			</tr>
                                			<tr>
                                				<td colspan="3">
                                					<p>Thank you for shopping with us!  Your order has been received and you will receive a confirmation once your order ships.</p>
                                					<p>Give us a call if you have any questions, please visit us at <a href="https://www.myautostores.com">MyAutoStores.com</a> or call us at 770-406-0442</p>
                                					<p>Kind regards,</p>
                                					<p>My Auto Stores Team</p>
                                					<p>P.S.  Be on the lookout for an email with the shipping information as soon as it ships!  Also, be sure to update to your account for newsletters to receive special promos and deals!!</p>
                                				</td>
                                			</tr>
                                			<table border="0" width="130%">
                                				<tr>
                                					<td colspan="3" style="background-color: #f76d2b;text-align: center;">
                                						ORDER # '.$order->getOrderId().'
                                					</td>
                                				</tr>
                                				<tr>
                                					<td colspan="3"  height="120px">
                                						Shipping Method: UPS Ground <br />
                                						Shipping Address: <br />'.
                                						$order->getEcomCustomer()->getShippingStreetAddress().' <br />'.
                                						$order->getEcomCustomer()->getShippingCity().', '.$order->getEcomCustomer()->getShippingState()->getSubdivisionName().' '. $order->getEcomCustomer()->getShippingPostCode() .'<br/>
                                					</td>
                                				</tr>
                                				<tr height="30px">
                                					<td>
                                						<b>Description</b>
                                					</td>
                                					<td>
                                						<b>Price</b>
                                					</td>
                                					<td>
                                						<b>Total Cost</b>
                                					</td>
                                				</tr>';
                                				
                                				foreach ($cartItems as $item){ 

                                   $message .= '<tr height="30px">
                                					<td>'.
                                					   $item->getDescription()
                                					.'</td>
                                					<td>'.
                                					   $item->getPrice()
                                					.'</td>
                                					<td>'.
                                					   $item->getPrice() * $item->getQuantity()
                                					.'</td>
                                				</tr>';
                                				}
                                	$message .= '<tr height="30px">
                                					<td colspan="2" style="text-align: right;">
                                						Subtotal :
                                					</td>
                                					<td>'.
                                					   $order->getSubtotal()
                                					.'</td>
                                				</tr>
                                				<tr height="30px">
                                					<td colspan="2" style="text-align: right;">
                                						Shipping :
                                					</td>
                                					<td>'.
                                					   $order->getShippingCost()
                                					.'</td>
                                				</tr>
                                				<tr height="30px">
                                					<td colspan="2" style="text-align: right;">
                                						Tax :
                                					</td>
                                					<td>'.
                                					   $order->getTaxCost()
                                					.'</td>
                                				</tr>
                                				<tr height="30px">
                                					<td colspan="2" style="text-align: right;">
                                						Total :
                                					</td>
                                					<td>'.
                                					   $order->getTotal()
                                					.'</td>
                                				</tr>
                                			</table>
                                			<tr>
                                				<td colspan="3">
                                					<p>You are receiving this email because you registered on <a href="https://www.myautostores.com">MyAutoStores.com</a> with this email address.  By placing your order, you agree to MyAutoStore.com’s Privacy Notice 
                                						and Terms & Conditions and your order will be processed by The My Auto Stores, 3482 Keith Bridge Rd Suite 336, Cumming GA 30041. 
                                						If you need more information, please contact 770-406-0442. Unless otherwise noted, items sold by <a href="https://www.myautostores.com">MyAutostores</a> are subject to sales tax 
                                						in select states in accordance with the applicable laws of that state</p>
                                					<p>*This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.</p>
                                				</td>
                                			</tr>
                                		</table>
                                	</body>
                                </html>';
                    
                    
                    $this->sendEmail($from, $to, $subject, $message);
                    
                    return $this->redirect()->toUrl('/receipt');
                }
                
                
                
                
                
            }
            
            $vm->setVariable('cart', $cart);
            $vm->setVariable('taxes', $taxes);
            
            return $vm;
            
        }
    }
    
    protected function myAccount(SiteInterface $site, ViewModel $vm)
    {
        
        if(!isset($this->sessionSC->customerId)) {
            
            return $this->redirect()->toUrl('/login');
            
        } else {
            
            
            $ecomCustomerId = (int) $this->sessionSC->customerId;
            
            $ecomCustomer = $this->rocketEcomService->getEcomCustomerService()->getEcomCustomer($this->sessionSC->customerId);
            
            $vm->setVariable('ecomCustomer', $ecomCustomer);
            return $vm;
            
        }
    }
    
    protected function address(SiteInterface $site, ViewModel $vm)
    {
        
        if(!isset($this->sessionSC->customerId)) {
            
            return $this->redirect()->toUrl('/login');
            
        } else {
            
            $ecomCustomerId = (int) $this->sessionSC->customerId;
            
            $this->ecomCustomerService  = $this->rocketEcomService->getEcomCustomerService();
            $this->partService          = $this->lundProductService->getPartService();
            $this->cartService          = $this->rocketEcomService->getCartService();
            $this->cartItemService      = $this->rocketEcomService->getCartItemService();
            
            $form = $this->ecomCustomerService->getEditEcomCustomerForm($ecomCustomerId);
            
            $ecomCustomer = $this->ecomCustomerService->getEcomCustomer($this->sessionSC->customerId);
            
            if ($this->request->isPost()) {
                
                
                $systemUser = $this->userService->getUser(1);
                $data = $this->request->getPost();
                
                $data2 = $data['ecom-customer-fieldset'];
                
                $data2['disabled'] = '0';
                $data2['guest'] = '0';
                
                $data['ecom-customer-fieldset'] = $data2;
                
                $emailErr = "";
                $error = '0';
                
                $data2['email'] = $ecomCustomer->getEmail();
                $data2['newsletters'] = $ecomCustomer->getNewsletters();
                
                
                if($data2['sameAsBilling'] != '2') {
                    
                    $billingState = $this->partService->getState($data['ecom-customer-fieldset']['billingState']);
                    
                    $data2['shippingStreetAddress'] = $data2['billingStreetAddress'];
                    $data2['shippingCity'] = $data2['billingCity'];
                    $data2['shippingState'] = $data2['billingState'];
                    $data2['shippingPostCode'] = $data2['billingPostCode'];
                    $data2['shippingCountry']= '';
                    
                
                } 
                
                //print_r($data2);exit;
                $data['ecom-customer-fieldset'] = $data2;
                
                
                $emailErr = "";
                $error = '0';
                
                
                
                
                
                
                if(!$error) {
                    
                    $ecomCustomer= $this->ecomCustomerService->edit($systemUser, $data, $ecomCustomer);
                    
                    if ($ecomCustomer instanceof \RocketEcom\Entity\EcomCustomerInterface) {
                        
                        $this->flashMessenger()->setNamespace('success')
                        ->addMessage('You have successfully edited the customer.');
                        
                        return $this->redirect()->toUrl('/my-account');
                        
                        
                    } else {
                        
                        $this->flashMessenger()->setNamespace('error')
                        ->addMessage('There was an error editing the customer.');
                        
                        $form->setData($this->request->getPost());
                        
                    }
                    
                } else {
                    $vm->setVariable('error', $error);
                    $vm->setVariable('errorMessage', $emailErr);
                    $form->setData($this->request->getPost());
                }
                
            }
            
            
            $vm->setVariable('ecomCustomer', $ecomCustomer);
            $vm->setVariable('form', $form);
            
            return $vm;
            
        }
    }
    
    protected function newsletter(SiteInterface $site, ViewModel $vm)
    {
        if(!isset($this->sessionSC->customerId)) {
            
            return $this->redirect()->toUrl('/login');
            
        } else {
            
            $ecomCustomerId = (int) $this->sessionSC->customerId;
            
            $this->ecomCustomerService          = $this->rocketEcomService->getEcomCustomerService();
            
            $form = $this->ecomCustomerService->getEditEcomCustomerForm($ecomCustomerId);
            
            $ecomCustomer = $this->ecomCustomerService->getEcomCustomer($this->sessionSC->customerId);
            
            if ($this->request->isPost()) {
                
                $systemUser = $this->userService->getUser(1);
                $data = $this->request->getPost();
                
                $data2 = $data['ecom-customer-fieldset'];
                
                $data2['disabled'] = '0';
                $data2['guest'] = '0';
                $data2['password'] = '';
                $data2['email'] = $ecomCustomer->getEmail();
                
                if(!isset($data2['newsletters'])) {
                    $data2['newsletters'] = '0';
                }
                
                $data['ecom-customer-fieldset'] = $data2;
                
                
                
                $customerEdit = $this->ecomCustomerService->edit($systemUser, $data, $ecomCustomer);
                
                if ($customerEdit instanceof \RocketEcom\Entity\EcomCustomerInterface) {
                    
                    $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the customer.');
                    
                    return $this->redirect()->toUrl('/my-account');
                    
                    
                } else {
                    
                    $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the customer.');
                    
                    $form->setData($this->request->getPost());
                    
                }
                
            }
            
            
            $vm->setVariable('ecomCustomer', $ecomCustomer);
            $vm->setVariable('form', $form);
            
            return $vm;
            
        }
    }
    
    
    protected function contactInformation(SiteInterface $site, ViewModel $vm)
    {
        
        if(!isset($this->sessionSC->customerId)) {
            
            return $this->redirect()->toUrl('/login');
            
        } else {
            
            $ecomCustomerId = (int) $this->sessionSC->customerId;
            
            $this->ecomCustomerService        = $this->rocketEcomService->getEcomCustomerService();
            $this->partService          = $this->lundProductService->getPartService();
            $this->cartService          = $this->rocketEcomService->getCartService();
            $this->cartItemService      = $this->rocketEcomService->getCartItemService();
            
            $form = $this->ecomCustomerService->getEditEcomCustomerForm($ecomCustomerId);
            
            $ecomCustomer = $this->ecomCustomerService->getEcomCustomer($this->sessionSC->customerId);
            
            if ($this->request->isPost()) {
                
                
                $systemUser = $this->userService->getUser(1);
                $data = $this->request->getPost();
                
                $data2 = $data['ecom-customer-fieldset'];
                
                $data2['disabled'] = '0';
                $data2['guest'] = '0';
                
                $data['ecom-customer-fieldset'] = $data2;
                
                $emailErr = "";
                $error = '0';
                
                //print_r($data);exit;
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $data['ecom-customer-fieldset']['firstName'])) {
                    $emailErr .= "Only letters and white space allowed for First Name. <br />";
                    $error = '1';
                }
                
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $data['ecom-customer-fieldset']['lastName'])) {
                    $emailErr .= "Only letters and white space allowed for Last Name. <br />";
                    $error = '1';
                }
                
                // checking for valid emails
                if (!filter_var($data['ecom-customer-fieldset']['email'], FILTER_VALIDATE_EMAIL)) {
                    $emailErr .= "Invalid email format. <br />";
                    $error = '1';
                }
                
                if(isset($data['ecom-customer-fieldset']['password'] )) {
                    // checking for valid emails
                    if ($data['ecom-customer-fieldset']['password'] != $data['ecom-customer-fieldset']['confirmation']) {
                        $emailErr .= "Passwords does not match. <br />";
                        $error = '1';
                    }
                    
                    // checking for valid password
                    if (strlen($data['ecom-customer-fieldset']['password']) < '5') {
                        $emailErr .= "Passwords must be at least 6 characters. <br />";
                        $error = '1';
                    }
                    
                    
                    $result = $this->ecomCustomerService->checkPassword($data, $ecomCustomer->getEcomCustomerId());
                    
                    if(!$result) {
                        $emailErr .= "Current password is incorrect. <br />";
                        $error = '1';
                    } 
                }
                
                if(!$error) {
                    
                    $ecomCustomer= $this->ecomCustomerService->edit($systemUser, $data, $ecomCustomer);
                    
                    if ($ecomCustomer instanceof \RocketEcom\Entity\EcomCustomerInterface) {
                        
                        $this->flashMessenger()->setNamespace('success')
                        ->addMessage('You have successfully edited the customer.');
                        
                        return $this->redirect()->toUrl('/my-account');
                       
                        
                    } else {
                        
                        $this->flashMessenger()->setNamespace('error')
                        ->addMessage('There was an error editing the customer.');
                        
                        $form->setData($this->request->getPost());
                        
                    }
                    
                } else {
                    $vm->setVariable('error', $error);
                    $vm->setVariable('errorMessage', $emailErr);
                    $form->setData($this->request->getPost());
                }
                
            }
            
            
            $vm->setVariable('ecomCustomer', $ecomCustomer);
            $vm->setVariable('form', $form);
            
            return $vm;
            
        }
    }
    
    protected function billing(SiteInterface $site, ViewModel $vm)
    {
        
        if(!isset($this->sessionSC->customerId)) {
            
            return $this->redirect()->toUrl('/');
            
        } else {
            
            $ecomCustomerId = (int) $this->sessionSC->customerId;
            
            $ecomCustomerService = $this->rocketEcomService->getEcomCustomerService();
            $this->partService          = $this->lundProductService->getPartService();
            $this->cartService           = $this->rocketEcomService->getCartService();
            $this->cartItemService       = $this->rocketEcomService->getCartItemService();
            
            $form = $ecomCustomerService->getEditEcomCustomerForm($ecomCustomerId);
            
            $ecomCustomer = $ecomCustomerService->getEcomCustomer($this->sessionSC->customerId);
            
            if ($this->request->isPost()) {
                
                
                $systemUser = $this->userService->getUser(1);
                $data = $this->request->getPost();
                
                $data2 = $data['ecom-customer-fieldset'];
                
                $data2['disabled'] = '0';
                $data2['guest'] = '0';
                $data2['email'] = $ecomCustomer->getEmail();
                
                if(!isset($data2['newsletters'])) {
                    $data2['newsletters'] = '0';
                }
                
                //print_r($data2);exit;
                $data['ecom-customer-fieldset'] = $data2;
                
                
                $emailErr = "";
                $error = '0';
                
                $address = array();
                
                
                if($data['ecom-customer-fieldset']['sameAsBilling'] == '2') {
                    
                    $shippingState = $this->partService->getState($data['ecom-customer-fieldset']['shippingState']);
                    
                    $address = array_merge($address, array('address' => $data['ecom-customer-fieldset']['shippingStreetAddress']));
                    $address = array_merge($address, array('city' => $data['ecom-customer-fieldset']['shippingCity']));
                    $address = array_merge($address, array('state' => $shippingState[0]['subdivision_name']));
                    $address = array_merge($address, array('zip' => $data['ecom-customer-fieldset']['shippingPostCode']));
                    $address = array_merge($address, array('country' => $shippingState[0]['code_char2']));
                } else {
                    
                    $billingState = $this->partService->getState($data['ecom-customer-fieldset']['billingState']);
                    
                    $address = array_merge($address, array('address' => $data['ecom-customer-fieldset']['billingStreetAddress']));
                    $address = array_merge($address, array('city' => $data['ecom-customer-fieldset']['billingCity']));
                    $address = array_merge($address, array('state' => $billingState[0]['subdivision_name']));
                    $address = array_merge($address, array('zip' => $data['ecom-customer-fieldset']['billingPostCode']));
                    $address = array_merge($address, array('country' => $billingState[0]['code_char2']));
                }
                
                $cart = $this->cartService->getCartBySessionId($this->sessionEC->getManager()->getId());
                $cartItems = $this->cartItemService->getCartItemsByCart($cart);
                
                $totalWeight = 0;
                $total = 0;
                foreach($cartItems as $items) {
                    $totalWeight = $totalWeight + ( $items->getWeight() * $items->getQuantity() );
                    $total = $total + ( $items->getPrice() * $items->getQuantity() );
                }
                
                $upsService = $this->rocketEcomService->getUpsService();
                
                $recordArray = $upsService->getUpsRates($address, $totalWeight);
                
                if($recordArray->Response->ResponseStatusDescription == 'Success')
                {
                    $amount = floatval($recordArray->RatedShipment->NegotiatedRates->NetSummaryCharges->GrandTotal->MonetaryValue);
                } else {
                    $amount = '0';
                }
                $amountArray = array('shipping_cost' => $amount);
                
                $tax = array('tax' => '0.00');
                
                if($address['state'] == 'Georgia')
                {;
                $tax = array('tax' => number_format((float)($amount + $total) * .07, 2, '.', ''));
                }
                
                $this->sessionEC->taxes = $tax;
                               
                $cart = $this->cartService->edit($systemUser, $cart, $amountArray);
                
                if(!$error) {
                    $ecomSubmission = $ecomCustomerService->edit($systemUser, $data, $ecomCustomer);
                    //$ecomSubmission = $ecomCustomerService->create($systemUser, $data);
                    
                    if ($ecomSubmission instanceof \RocketEcom\Entity\EcomCustomerInterface) {
                        
                        return $this->redirect()->toUrl('/payment');
                        
                        
                    } else {
                        $vm->setVariable('result', 'error');
                        $form->setData($this->request->getPost());
                    }
                    
                } else {
                    $ecomCustomerService = $this->rocketEcomService->getEcomCustomerService();
                    $ecomCustomer = $ecomCustomerService->getEcomCustomer($this->sessionSC->customerId);
                    
                    $vm->setVariable('billing', $data);
                    $vm->setVariable('error', $error);
                    $vm->setVariable('emailErr', $emailErr);
                }
            }
            
            
            $vm->setVariable('ecomCustomer', $ecomCustomer);
            $vm->setVariable('form', $form);
            
            return $vm;
            
        }
    }
    
    protected function cart(SiteInterface $site, ViewModel $vm, $action = null, $id = null, $number = null)
    {
        
        $this->cartService           = $this->rocketEcomService->getCartService();
        $this->cartItemService       = $this->rocketEcomService->getCartItemService();
        $this->partService           = $this->lundProductService->getPartService();
        $this->parsePromoService = $this->lundProductService->getParsePromoService();
        
        $systemUser = $this->userService->getUser(1);
        
        $cart = $this->cartService->getCartBySessionId($this->sessionEC->getManager()->getId());
        
        if (null == $cart) {
            $data = array(
                'user_id'    => $systemUser->getUserId(),
                'session_id' => $this->sessionEC->getManager()->getId());
            $cart = $this->cartService->create($systemUser, $data);
            $this->sessionEC->cartId = $cart->getCartId();
        }
        
        
        switch ($action) {
                case 'add':
                    
                    $data = $_REQUEST;
                    
                    if(isset($data['vehYear'])) {
                        $_SESSION['vehicle']['year'] = $data['vehYear'];
                        $_SESSION['vehicle']['make'] = $data['vehMake'];
                        $_SESSION['vehicle']['model'] = $data['vehModel'];
                    }
                    
                    $part = $this->partService->getPart($id);
                    
                    $cartItem = $this->cartItemService->getCartItemByProductId($cart, $id);
                    
                    $recordArray = $this->parsePromoService->getPromoByPartId($this->websiteId, $part->getPartId());
                    
                    $productLinesAsset = $this->lundProductService->getProductLineService()->getProductLineAssets($part->getProductLine()->getproductLineId() );
                                   
                    if (null == $cartItem) {
                        $data = array(
                            'product_id' => $part->getPartId(),
                            'quantity' => '1',
                            'description' => $part->getProductLine()->getBrand()->getName().' '. $part->getProductLine()->getDisplayName() . ' (Part# ' . $part->getPartNumber() . ')',
                            'price' => ((empty($recordArray)) ? $part->getSalePrice() : $recordArray[0]['price']),
                            'weight' => $part->getWeight(),
                            'height' => $part->getHeight(),
                            'width' => $part->getWidth(),
                            'length' => $part->getLength(),
                            'upc_code' => $part->getUpcCode(),
                            'parts' => $part,
                            'productLinesAsset' => $productLinesAsset[0]['fileName'],
                        );
                                                
                        $cartItem = $this->cartItemService->create($systemUser, $cart, $data, $part);
                        
                        $this->cartItemService->setCartItemImage($cartItem->getCartItemId(), $productLinesAsset[0]['fileName']);
                    } else {
                        $cartItem = $this->cartItemService->incrementQuantity($systemUser, $cartItem, $cartItem->getQuantity());
                    }
                    break;
                case 'remove':
                    $cartItem = $this->cartItemService->getCartItem($cart, $id);
                    if (null != $cartItem) {
                        $this->cartItemService->delete($systemUser, $cartItem);
                        $vm->setVariable('message', $cartItem->getDescription() . ' has been removed from your cart.');
                        
                        return $this->redirect()->toUrl('/cart');
                        
                    }
                    
                    break;
                case 'change':
                    $cartItem = $this->cartItemService->getCartItem($cart, $id);
                    if (null != $cartItem) {
                        $this->cartItemService->changeQuantity($systemUser, $cartItem, $number);
                        
                        return $this->redirect()->toUrl('/cart');
                        
                    }
                    break;
            
        }
        
        
        return $vm;
    }
    
    protected function affiliates(SiteInterface $site, ViewModel $vm)
    {
        $retailersOnline = $this->retailerService->getActiveOnlineRetailers();
        
        $vm->setVariable('retailersOnline', $retailersOnline);
        return $vm;
    }
    
    protected function vehicle(SiteInterface $site, ViewModel $vm, $slugtwo=null, $slugthree=null)
    {
        if(null != $slugthree) {
            
            $show           = $this->params()->fromPost('show', 10);
            $sort           = $this->params()->fromPost('sort', 1);
            $categories     = $this->params()->fromPost('categories', array());
            $color          = $this->params()->fromPost('color', array());
            $price          = $this->params()->fromPost('price', array());
            $finish         = $this->params()->fromPost('finish', array());
            $style          = $this->params()->fromPost('style', array());
            $price          = $this->params()->fromPost('price', array());
            $brandName      = $this->params()->fromPost('brandName', array());
            
            $baseProductLines = $this->lundProductService->getProductLineService()->getProductLineByMakeModel($slugtwo, $slugthree);
            
            $productLines = $this->lundProductService->getProductLineService()->getProductLineByMakeModel($slugtwo, $slugthree, $categories, $sort, $color, $finish, $style, $price, $brandName);
            
            $categoriesProductLineArray= array();
            $colorProductLineArray= array();
            $finishProductLineArray= array();
            $styleProductLineArray= array();
            $priceProductLineArray= array();
            $brandNameProductLineArray= array();
            
            $categories = array_keys($categories);
            $color = array_keys($color);
            $finish = array_keys($finish);
            $style = array_keys($style);
            $price = array_keys($price);
            $brandName = array_keys($brandName);
            
            //print_r($finish);exit;
            $categoriesArray = array();
            $colorArray = array();
            $finishArray = array();
            $styleArray = array();
            $priceArray = array();
            $brandNameArray = array();
            
            foreach($baseProductLines as $baseProductLine)
            {
                if($baseProductLine['brand'] != '')
                {
                    if(!in_array($baseProductLine['brand'], $brandNameProductLineArray))
                    {
                        array_push($brandNameProductLineArray, $baseProductLine['brand']);
                    }
                }
                if($baseProductLine['display_name'] != '')
                {
                    if(!in_array($baseProductLine['display_name'], $categoriesProductLineArray))
                    {
                        array_push($categoriesProductLineArray, $baseProductLine['display_name']);
                    }
                }
                if($baseProductLine['color_group'] != '')
                {
                    if(!in_array($baseProductLine['color_group'], $colorProductLineArray))
                    {
                        array_push($colorProductLineArray, $baseProductLine['color_group']);
                    }
                }
                if($baseProductLine['finish'] != '')
                {
                    if(!in_array($baseProductLine['finish'], $finishProductLineArray))
                    {
                        array_push($finishProductLineArray, $baseProductLine['finish']);
                    }
                }
                if($baseProductLine['style'] != '')
                {
                    if(!in_array($baseProductLine['style'], $styleProductLineArray))
                    {
                        array_push($styleProductLineArray, $baseProductLine['style']);
                    }
                }
                if($baseProductLine['sale_price'] != '')
                {
                    if(!in_array($baseProductLine['sale_price'], $priceProductLineArray))
                    {
                        array_push($priceProductLineArray, $baseProductLine['sale_price']);
                    }
                }
            }
            
            $vm->setVariable('categoriesProductLineArray', $categoriesProductLineArray);
            $vm->setVariable('colorProductLineArray', $colorProductLineArray);
            $vm->setVariable('finishProductLineArray', $finishProductLineArray);
            $vm->setVariable('styleProductLineArray', $styleProductLineArray);
            $vm->setVariable('priceProductLineArray', $priceProductLineArray);
            $vm->setVariable('brandNameProductLineArray', $brandNameProductLineArray);
            
            $vm->setVariable('categories', $categories);
            $vm->setVariable('color', $color);
            $vm->setVariable('finish', $finish);
            $vm->setVariable('style', $style);
            $vm->setVariable('price', $price);
            $vm->setVariable('brandName', $brandName);
            
            $vm->setVariable('categoriesArray', $categoriesArray);
            $vm->setVariable('colorArray', $colorArray);
            $vm->setVariable('finishArray', $finishArray);
            $vm->setVariable('styleArray', $styleArray);
            $vm->setVariable('priceArray', $priceArray);
            $vm->setVariable('brandNameArray', $brandNameArray);
            
            
            $vm->setVariable('productLines', $productLines);
            $vm->setVariable('baseProductLines', $baseProductLines);
            $vm->setVariable('show', $show);
            $vm->setVariable('sort', $sort);
            $vm->setVariable('make', $slugtwo);
            $vm->setVariable('model', $slugthree);
            $vm->setVariable('status', 'lookup');
            $vm->setVariable('loadInclude', 'vehicle-line.phtml');
            
        }
        elseif(null != $slugtwo) {
            $model = $this->lundProductService->getPartService()->getModel($slugtwo);
            
            $vm->setVariable('make', $slugtwo);
            $vm->setVariable('model', $model);
            $vm->setVariable('status', 'model');
            
        }
        else {
            
            $make = $this->lundProductService->getPartService()->getMake();
            
            $vm->setVariable('make', $make);
            $vm->setVariable('status', 'make');
            
        }
        
        return $vm;
    }
    
    protected function sendEmail($from = null, $to = array(), $subject = null, $message = null)
    {
        $mail = new Mail\Message();
        $html = new \Zend\Mime\Part($message);
        $html->type = 'text/html';
        $body = new \Zend\Mime\Message();
        $body->setParts(array($html));
        $mail->setBody($body);
        $mail->setFrom($from);
        foreach ($to as $recipient) {
            $mail->addTo($recipient);
        }
        $mail->setSubject($subject);
        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);

        return true;
    }
    
}

class SoapClientHMAC extends \SoapClient {
    public function __doRequest($request, $location, $action, $version, $one_way = NULL) {
        global $context;
        $hmackey = "Zi88ZCDQYoaMp0AMwnYM9eLt~Rx89PwO"; // <-- Insert your HMAC key here
        $keyid = "566035"; // <-- Insert the Key ID here
        $hashtime = date("c");
        $hashstr = "POST\ntext/xml; charset=utf-8\n" . sha1($request) . "\n" . $hashtime . "\n" . parse_url($location,PHP_URL_PATH);
        $authstr = base64_encode(hash_hmac("sha1",$hashstr,$hmackey,TRUE));
        if (version_compare(PHP_VERSION, '5.3.11') == -1) {
            ini_set("user_agent", "PHP-SOAP/" . PHP_VERSION . "\r\nAuthorization: GGE4_API " . $keyid . ":" . $authstr . "\r\nx-gge4-date: " . $hashtime . "\r\nx-gge4-content-sha1: " . sha1($request));
        } else {
            stream_context_set_option($context,array("http" => array("header" => "authorization: GGE4_API " . $keyid . ":" . $authstr . "\r\nx-gge4-date: " . $hashtime . "\r\nx-gge4-content-sha1: " . sha1($request))));
        }
        return parent::__doRequest($request, $location, $action, $version, $one_way);
    }
    
    public function SoapClientHMAC($wsdl, $options = NULL) {
        global $context;
        $context = stream_context_create();
        $options['stream_context'] = $context;
        return parent::SoapClient($wsdl, $options);
    }
}
