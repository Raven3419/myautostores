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
use RocketCms\Service\SiteService;
use LundSite\Service\ProductRegistrationService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\ProductRegistrationInterface;

/**
 * ProductRegistrations controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductRegistrationController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\ProductRegistrationService
     */
    protected $productRegistrationService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService                $siteService
     * @param ProductRegistrationService $productRegistrationService
     * @param HelperPluginManager        $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        ProductRegistrationService $productRegistrationService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->productRegistrationService       = $productRegistrationService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of productRegistrations
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->productRegistrationService->getActiveProductRegistrations(),
        ));
    }

    /**
     * View a single productRegistration record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $productRegistrationId = (int) $this->params()->fromRoute('id', null);

        if (null === $productRegistrationId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-registration');
        }

        $productRegistration = $this->productRegistrationService->getProductRegistration($productRegistrationId);

        if (!($productRegistration instanceof ProductRegistrationInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-registration');
        }

        $form = $this->productRegistrationService->getEditProductRegistrationForm($productRegistrationId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $productRegistrationId,
        ));
    }

    /**
     * Create a new productRegistration record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->productRegistrationService->getCreateProductRegistrationForm();

        if ($this->request->isPost()) {
            $productRegistration = $this->productRegistrationService->create($this->identity(), $this->request->getPost());

            if ($productRegistration instanceof ProductRegistrationInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a product registration.');

                return $this->redirect()->toRoute('rocket-admin/lund/product-registration');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new product registration.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing productRegistration record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $productRegistrationId = (int) $this->params()->fromRoute('id', null);

        if (null === $productRegistrationId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-registration');
        }

        $productRegistration = $this->productRegistrationService->getProductRegistration($productRegistrationId);

        if (!($productRegistration instanceof ProductRegistrationInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-registration');
        }

        $form = $this->productRegistrationService->getEditProductRegistrationForm($productRegistrationId);

        if ($this->request->isPost()) {
            $productRegistration = $this->productRegistrationService->edit($this->identity(), $this->request->getPost(), $productRegistration);

            if ($productRegistration instanceof ProductRegistrationInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the product registration.');

                return $this->redirect()->toRoute('rocket-admin/lund/product-registration');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the product registration.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'productRegistrationId' => $productRegistrationId,
        ));
    }

    /**
     * Delete an existing productRegistration record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $productRegistrationId = (int) $this->params()->fromRoute('id', null);

        if (null === $productRegistrationId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-registration');
        }

        $productRegistration = $this->productRegistrationService->getProductRegistration($productRegistrationId);

        if (!($productRegistration instanceof ProductRegistrationInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-registration');
        }

        $this->productRegistrationService->delete($this->identity(), $productRegistration);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the product registration.');

        return $this->redirect()->toRoute('rocket-admin/lund/product-registration');
    }
}
