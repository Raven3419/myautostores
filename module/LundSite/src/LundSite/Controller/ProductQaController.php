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
use LundSite\Service\ProductQaService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\ProductQaInterface;

/**
 * ProductQa controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductQaController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\ProductQaService
     */
    protected $productQaService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService         $siteService
     * @param ProductQaService  		  $productQaService
     * @param HelperPluginManager $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        ProductQaService $productQaService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->productQaService  = $productQaService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of productQa
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->productQaService->getActiveProductQa(),
        ));
    }

    /**
     * View a single productQa record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $productQaId = (int) $this->params()->fromRoute('id', null);

        if (null === $productQaId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-qa');
        }

        $productQa = $this->productQaService->getProductQa($productQaId);

        if (!($productQa instanceof ProductQaInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-qa');
        }

        $form = $this->productQaService->getEditProductQaForm($productQaId);
        
        

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $productQaId,
        ));
    }

    /**
     * Create a new productQa record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->productQaService->getCreateProductQaForm();

        if ($this->request->isPost()) {
            $productQa = $this->productQaService->create($this->identity(), $this->request->getPost());

            if ($productQa instanceof ProductQaInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a productQa.');

                return $this->redirect()->toRoute('rocket-admin/lund/product-qa');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new productQa.');

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
            ->appendScript("$(function () {CKEDITOR.replace('productQa-fieldset[answer]');});", 'text/javascript');

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing productQa record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $productQaId = (int) $this->params()->fromRoute('id', null);

        if (null === $productQaId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-qa');
        }

        $productQa = $this->productQaService->getProductQa($productQaId);

        if (!($productQa instanceof ProductQaInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-qa');
        }

        $form = $this->productQaService->getEditProductQaForm($productQaId);

        if ($this->request->isPost()) {

            $productQa = $this->productQaService->edit($this->identity(), $this->request->getPost(), $productQa);

            if ($productQa instanceof ProductQaInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the productQa.');

                return $this->redirect()->toRoute('rocket-admin/lund/product-qa');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the productQa.');

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
            ->appendScript("$(function () {CKEDITOR.replace('productQa-fieldset[answer]');});", 'text/javascript');

        return new ViewModel(array(
            'form'     => $form,
            'productQaId' => $productQaId,
        ));
    }

    /**
     * Delete an existing productQa record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $productQaId = (int) $this->params()->fromRoute('id', null);

        if (null === $productQaId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-qa');
        }

        $productQa = $this->productQaService->getProductQa($productQaId);

        if (!($productQa instanceof ProductQaInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/product-qa');
        }

        $this->productQaService->delete($this->identity(), $productQa);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the productQa.');

        return $this->redirect()->toRoute('rocket-admin/lund/product-qa');
    }
}
