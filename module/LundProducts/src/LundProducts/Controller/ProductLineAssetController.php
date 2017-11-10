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
use LundProducts\Form\ProductLineAssetForm;
use LundProducts\Service\ProductLineService;
use LundProducts\Service\ProductLineAssetService;
use LundProducts\Entity\ProductLinesInterface;
use LundProducts\Entity\ProductLineAssetInterface;
use RocketDam\Service\AssetService;

/**
 * ProductLineAsset controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductLineAssetController extends AbstractActionController
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
     * @var AssetService;
     */
    protected $assetService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param ProductLineService      $productLineService
     * @param ProductLineAssetService $productLineAssetService
     * @param AssetService            $assetService
     * @param HelperPluginManager     $viewHelperManager
     */
    public function __construct(
        ProductLineService       $productLineService,
        ProductLineAssetService  $productLineAssetService,
        AssetService      $assetService,
        ViewHelperManager $viewHelperManager)
    {
        $this->productLineService       = $productLineService;
        $this->productLineAssetService  = $productLineAssetService;
        $this->assetService = $assetService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of product line assets
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        return new ViewModel(array(
            'records' => $this->productLineAssetService->getProductLineAssetsByProductLine($productLine),
            'productLineId'  => $productLineId,
            'productLine'    => $productLine,
        ));
    }

    /**
     * View a single product line asset record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLineAssetId = (int) $this->params()->fromRoute('productlineassetid', null);

        if (null === $productLineAssetId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/asset', array('id' => $productLineId));
        }

        $productLineAsset = $this->productLineAssetService->getProductLineAsset($productLineAssetId);

        if (!($productLineAsset instanceof ProductLineAssetInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/asset', array('id' => $productLineId));
        }

        $form = $this->productLineAssetService->getEditProductLineAssetForm($productLineAssetId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $productLineAssetId,
            'productLineId'   => $productLineId,
            'productLineAsset' => $productLineAsset,
        ));
    }

    /**
     * Create a new product line asset record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $form = $this->productLineAssetService->getCreateProductLineAssetForm();

        if ($this->request->isPost()) {
            $productLineAsset = $this->productLineAssetService->createRecord($this->identity(), $productLine, $this->request->getPost());

            if ($productLineAsset instanceof ProductLineAssetInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a product line asset.');

                return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/asset', array('id' => $productLineId));
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new product line asset.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
            'productLineId' => $productLineId,
        ));
    }

    /**
     * Edit an existing product line asset record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLineAssetId = (int) $this->params()->fromRoute('productlineassetid', null);

        if (null === $productLineAssetId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/asset', array('id' => $productLineId));
        }

        $productLineAsset = $this->productLineAssetService->getProductLineAsset($productLineAssetId);

        if (!($productLineAsset instanceof ProductLineAssetInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/asset', array('id' => $productLineId));
        }

        $form = $this->productLineAssetService->getEditProductLineAssetForm($productLineAssetId);

        if ($this->request->isPost()) {
            $productLineAsset = $this->productLineAssetService->editRecord($this->identity(), $this->request->getPost(), $productLineAsset);

            if ($productLineAsset instanceof ProductLineAssetInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the product line asset.');

                return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/asset', array('id' => $productLineId));
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the product line asset.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'productLineAssetId' => $productLineAssetId,
            'productLineId'   => $productLineId,
        ));
    }

    /**
     * Delete an existing product line asset record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLineAssetId = (int) $this->params()->fromRoute('productlineassetid', null);

        if (null === $productLineAssetId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/asset', array('id' => $productLineId));
        }

        $productLineAsset = $this->productLineAssetService->getProductLineAsset($productLineAssetId);

        if (!($productLineAsset instanceof ProductLineAssetInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/asset', array('id' => $productLineId));
        }

        $this->productLineAssetService->delete($this->identity(), $productLineAsset);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the product line asset.');

        return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/asset', array('id' => $productLineId));
    }
}
