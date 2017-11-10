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

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\HelperPluginManager as ViewHelperManager;
use Zend\View\Model\ViewModel;
use LundProducts\Form\ProductLineForm;
use LundProducts\Service\ProductLineService;
use LundProducts\Service\ProductLineAssetService;
use LundProducts\Service\PartService;
use RocketAdmin\Service\MessageService;

/**
 * Product Lines controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/commander for the canonical source repository
 */
class ProductLinesController extends AbstractActionController
{
    /**
     * @var ProductLineService
     */
    protected $productLineService;

    /**
     * @var ProductLineAssetService
     */
    protected $productLineAssetService;

    /**
     * @var PartService
     */
    protected $partService;

    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * @var HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param ProductLineService      $productLineService
     * @param ProductLineAssetService $productLineAssetService
     * @param PartService             $partService
     * @param ProductLineForm         $productLineForm
     * @param OptMessageService       $messageService
     * @param HelperPluginManager     $viewHelperManager
     */
    public function __construct(
        ProductLineService $productLineService,
        ProductLineAssetService $productLineAssetService,
        PartService $partService,
        MessageService     $messageService,
        ViewHelperManager  $viewHelperManager)
    {
        $this->productLineService = $productLineService;
        $this->productLineAssetService = $productLineAssetService;
        $this->partService = $partService;
        $this->messageService     = $messageService;
        $this->viewHelperManager  = $viewHelperManager;
    }

    /**
     * Display a table of product lines
     *
     * @return ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->productLineService->getActiveProductLines(),
        ));
    }

    /**
     * View a single product line record
     *
     * @return ViewModel|array
     */
    public function viewAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $record = $this->productLineService->getProductLine($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $form = $this->productLineService->getViewProductLineForm($recordId);

        $productLineAssets = $this->productLineAssetService->getProductLineAssetsByProductLine($record);

        return new ViewModel(array(
            'record'   => $record,
            'form'     => $form,
            'recordId' => $recordId,
            'assets'   => $productLineAssets,
        ));
    }

    /**
     * View parts associated to a given product line
     *
     * @return ViewModel|array
     */
    public function partsAction()
    {
        $productLineId = (int) $this->params('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (null === $productLine) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $parts = $this->partService->getPartsByProductLine($productLine);

        return new ViewModel(array(
            'productLine' => $productLine,
            'parts'       => $parts,
        ));
    }

    /**
     * Create a new product line record
     *
     * @return ViewModel|array
     */
    public function createAction()
    {
        $record = new \LundProducts\Entity\ProductLines();

        $form = $this->productLineService->getCreateProductLineForm();
        $form->bind($record);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->productLineService->createProductLine($record, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('You have successfully created a new product line.');

                return $this->redirect()->toRoute('rocket-admin/products/product-lines');
            } else {
                $this->flashMessenger()->setNamespace('error')
                     ->addMessage('There was an error while attempting to create a new product line.');
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
             ->offsetSetFile(200, $base . '/assets/rocket-admin/js/plugins/elfinder/jquery.elfinder.js')
             ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('HeadLink')
            ->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css')
            ->appendStylesheet($base . '/assets/rocket-admin/css/adm.elfinder.css')
            ->appendStylesheet($base . '/assets/rocket-admin/css/adm.elfinder.theme.css');
        $this->viewHelperManager->get('InlineScript')
             ->appendScript("$(function () {CKEDITOR.replace('product-line-fieldset[overview]');CKEDITOR.replace('product-line-fieldset[websiteOverview]');CKEDITOR.replace('product-line-fieldset[teaser]');CKEDITOR.replace('product-line-fieldset[features]');});", 'text/javascript');

        return new ViewModel(array(
            'record' => $record,
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing product line record
     *
     * @return ViewModel|array
     */
    public function editAction()
    {
        $recordId = (int) $this->params('id', null);

        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $record = $this->productLineService->getProductLine($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $form = $this->productLineService->getEditProductLineForm($recordId);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->productLineService->editProductLine($record, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('You have successfully edited an existing product line.');

                return $this->redirect()->toRoute('rocket-admin/products/product-lines');
            } else {
                $this->flashMessenger()->setNamespace('error')
                     ->addMessage('There was an error while attempting to edit a product line.');
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
            ->offsetSetFile(200, $base . '/assets/rocket-admin/js/plugins/elfinder/jquery.elfinder.js')
            ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('HeadLink')
            ->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css')
            ->appendStylesheet($base . '/assets/rocket-admin/css/adm.elfinder.css')
            ->appendStylesheet($base . '/assets/rocket-admin/css/adm.elfinder.theme.css');
        $this->viewHelperManager->get('InlineScript')
            ->appendScript("$(function () {CKEDITOR.replace('product-line-fieldset[overview]');CKEDITOR.replace('product-line-fieldset[websiteOverview]');CKEDITOR.replace('product-line-fieldset[teaser]');CKEDITOR.replace('product-line-fieldset[features]');});", 'text/javascript');

        return new ViewModel(array(
            'record'   => $record,
            'form'     => $form,
            'recordId' => $recordId,
        ));
    }

    /**
     * Delete an existing product line record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $record = $this->productLineService->getProductLine($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $this->productLineService->deleteProductLine($record, $this->identity());

        $this->flashMessenger()->setNamespace('success')
             ->addMessage('You have successfully deleted a product line.');

        return $this->redirect()->toRoute('rocket-admin/products/product-lines');
    }
}
