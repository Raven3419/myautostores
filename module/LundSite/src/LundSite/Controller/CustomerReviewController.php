<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * This source file is part of Commander.
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundSite\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\HelperPluginManager as ViewHelperManager;
use Zend\View\Model\ViewModel;
use LundProducts\Service\ProductLineService;
use RocketCms\Service\SiteService;
use LundSite\Service\CustomerReviewService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\CustomerReviewInterface;

/**
 * CustomerReview controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class CustomerReviewController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\CustomerReviewService
     */
    protected $customerReviewService;

    /**
     * @var \LundProducts\Service\ProductLineService
     */
    protected $productLineService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService         		$siteService
     * @param CustomerReviewService  	$customerReviewService
     * @param ProductLineService  		$productLineService
     * @param HelperPluginManager 		$viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        CustomerReviewService $customerReviewService,
        ProductLineService $productLineService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->customerReviewService  = $customerReviewService;
        $this->productLineService  = $productLineService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of customerReview
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->customerReviewService->getActiveCustomerReview(),
        ));
    }

    /**
     * View a single customerReview record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $customerReviewId = (int) $this->params()->fromRoute('id', null);

        if (null === $customerReviewId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/customer-review');
        }

        $customerReview = $this->customerReviewService->getCustomerReview($customerReviewId);

        if (!($customerReview instanceof CustomerReviewInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/customer-review');
        }

        $form = $this->customerReviewService->getEditCustomerReviewForm($customerReviewId);
        
        

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $customerReviewId,
        ));
    }

    /**
     * Create a new customerReview record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->customerReviewService->getCreateCustomerReviewForm();

        if ($this->request->isPost()) {
            $customerReview = $this->customerReviewService->create($this->identity(), $this->request->getPost());

            if ($customerReview instanceof CustomerReviewInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a customerReview.');

                return $this->redirect()->toRoute('rocket-admin/lund/customer-review');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new customerReview.');

                $form->setData($this->request->getPost());
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
            ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('HeadLink')
            ->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css');
        $this->viewHelperManager->get('InlineScript')
            ->appendScript("$(function () {CKEDITOR.replace('customerReview-fieldset[answer]');});", 'text/javascript');

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing customerReview record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $customerReviewId = (int) $this->params()->fromRoute('id', null);

        if (null === $customerReviewId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/customer-review');
        }

        $customerReview = $this->customerReviewService->getCustomerReview($customerReviewId);

        if (!($customerReview instanceof CustomerReviewInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/customer-review');
        }

        $form = $this->customerReviewService->getEditCustomerReviewForm($customerReviewId);

        if ($this->request->isPost()) {

        	$total = 0;
            $customerReview = $this->customerReviewService->edit($this->identity(), $this->request->getPost(), $customerReview);

            $productLineTotals = $this->customerReviewService->getCustomerReviewByProduct($customerReview->getProductLine());
            
            foreach($productLineTotals as $productLineTotal) {
            	 $total = $total + $productLineTotal->getTotal();
            }
            
            $record = $this->productLineService->getProductLine($customerReview->getProductLine()->getProductLineId());
            
            $record->setTotalRating($total/count($productLineTotals));
            $record->setTotalCount(count($productLineTotals));
            
            $this->productLineService->editProductLine($record, $this->identity());
            
            //$this->productLineService->createProductLine($recordEntity, $usersEntity)
            //echo $total/count($productLineTotals);exit;
            
            if ($customerReview instanceof CustomerReviewInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the customerReview.');

                return $this->redirect()->toRoute('rocket-admin/lund/customer-review');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the CustomerReview.');

                $form->setData($this->request->getPost());
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
            ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('HeadLink')
            ->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css');
        $this->viewHelperManager->get('InlineScript')
            ->appendScript("$(function () {CKEDITOR.replace('customerReview-fieldset[answer]');});", 'text/javascript');

        return new ViewModel(array(
            'form'     => $form,
            'customerReviewId' => $customerReviewId,
        ));
    }

    /**
     * Delete an existing customerReview record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $customerReviewId = (int) $this->params()->fromRoute('id', null);

        if (null === $customerReviewId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/customer-review');
        }

        $customerReview = $this->customerReviewService->getCustomerReview($customerReviewId);

        if (!($customerReview instanceof CustomerReviewInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/customer-review');
        }

        $this->customerReviewService->delete($this->identity(), $customerReview);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the customerReview.');

        return $this->redirect()->toRoute('rocket-admin/lund/customer-review');
    }
}
