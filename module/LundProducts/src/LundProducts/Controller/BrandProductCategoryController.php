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
use LundProducts\Form\BrandProductCategoryForm;
use LundProducts\Service\BrandsService;
use LundProducts\Service\BrandProductCategoryService;
use LundProducts\Entity\BrandsInterface;
use LundProducts\Entity\BrandProductCategoryInterface;
use LundProducts\Service\ProductCategoryService;

/**
 * BrandProductCategory controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class BrandProductCategoryController extends AbstractActionController
{
    /**
     * @var BrandsService
     */
    protected $brandService;

    /**
     * @var BrandProductCategoryService
     */
    protected $brandProductCategoryService;

    /**
     * @var ProductCategoryService;
     */
    protected $productCategoryService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param BrandsService      $brandService
     * @param BrandProductCategoryService $brandProductCategoryService
     * @param ProductCategoryService            $productCategoryService
     * @param HelperPluginManager     $viewHelperManager
     */
    public function __construct(
        BrandsService       $brandService,
        BrandProductCategoryService  $brandProductCategoryService,
        ProductCategoryService      $productCategoryService,
        ViewHelperManager $viewHelperManager)
    {
        $this->brandService       = $brandService;
        $this->brandProductCategoryService  = $brandProductCategoryService;
        $this->productCategoryService = $productCategoryService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of brand product categories
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        $brandId = (int) $this->params()->fromRoute('id', null);

        if (null === $brandId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a brand in order to access the brand product category component.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $brand = $this->brandService->getBrand($brandId);

        if (!($brand instanceof BrandsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a brand in order to access the product category component.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        return new ViewModel(array(
            'records' => $this->brandProductCategoryService->getBrandProductCategoriesByBrand($brand),
            'brandId'  => $brandId,
            'brand'    => $brand,
        ));
    }

    /**
     * View a single brand product category record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $brandId = (int) $this->params()->fromRoute('id', null);

        if (null === $brandId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a brand in order to access the brand product category component.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $brandProductCategoryId = (int) $this->params()->fromRoute('brandproductcategoryid', null);

        if (null === $brandProductCategoryId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands/view/product-category', array('id' => $brandId));
        }

        $brandProductCategory = $this->brandProductCategoryService->getBrandProductCategory($brandProductCategoryId);

        if (!($brandProductCategory instanceof BrandProductCategoryInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands/view/product-category', array('id' => $brandId));
        }

        $form = $this->brandProductCategoryService->getEditBrandProductCategoryForm($brandProductCategoryId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $brandProductCategoryId,
            'brandId'   => $brandId,
            'brandProductCategory' => $brandProductCategory,
        ));
    }

    /**
     * Create a new brand product category record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $brandId = (int) $this->params()->fromRoute('id', null);

        if (null === $brandId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a brand in order to access the brand product category component.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $brand = $this->brandService->getBrand($brandId);

        if (!($brand instanceof BrandsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a brand in order to access the brand product category component.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $form = $this->brandProductCategoryService->getCreateBrandProductCategoryForm();

        if ($this->request->isPost()) {
            $brandProductCategory = $this->brandProductCategoryService->createRecord($this->identity(), $brand, $this->request->getPost());

            if ($brandProductCategory instanceof BrandProductCategoryInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a brand product category.');

                return $this->redirect()->toRoute('rocket-admin/products/brands/view/product-category', array('id' => $brandId));
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new brand product category.');

                $form->setData($this->request->getPost());
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
             ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('InlineScript')
             ->appendScript("$(function () {CKEDITOR.replace('brand-product-category-fieldset[longDescr]');});", 'text/javascript');

        return new ViewModel(array(
            'form'   => $form,
            'brandId' => $brandId,
        ));
    }

    /**
     * Edit an existing brand product category record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $brandId = (int) $this->params()->fromRoute('id', null);

        if (null === $brandId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a brand in order to access the brand product category component.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $brand = $this->brandService->getBrand($brandId);

        if (!($brand instanceof BrandsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a brand in order to access the brand product category component.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $brandProductCategoryId = (int) $this->params()->fromRoute('brandproductcategoryid', null);

        if (null === $brandProductCategoryId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands/view/product-category', array('id' => $brandId));
        }

        $brandProductCategory = $this->brandProductCategoryService->getBrandProductCategory($brandProductCategoryId);

        if (!($brandProductCategory instanceof BrandProductCategoryInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands/view/product-category', array('id' => $brandId));
        }

        $form = $this->brandProductCategoryService->getEditBrandProductCategoryForm($brandProductCategoryId);

        if ($this->request->isPost()) {
            $brandProductCategory = $this->brandProductCategoryService->editRecord($this->identity(), $this->request->getPost(), $brandProductCategory);

            if ($brandProductCategory instanceof BrandProductCategoryInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the brand product category.');

                return $this->redirect()->toRoute('rocket-admin/products/brands/view/product-category', array('id' => $brandId));
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the brand product category.');

                $form->setData($this->request->getPost());
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
             ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('InlineScript')
             ->appendScript("$(function () {CKEDITOR.replace('brand-product-category-fieldset[longDescr]');});", 'text/javascript');

        return new ViewModel(array(
            'form'     => $form,
            'brandProductCategoryId' => $brandProductCategoryId,
            'brandId'   => $brandId,
        ));
    }

    /**
     * Delete an existing brand product category record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $brandId = (int) $this->params()->fromRoute('id', null);

        if (null === $brandId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a brand in order to access the brand product category component.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $brand = $this->brandService->getBrand($brandId);

        if (!($brand instanceof BrandsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a brand in order to access the brand product category component.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $brandProductCategoryId = (int) $this->params()->fromRoute('brandproductcategoryid', null);

        if (null === $brandProductCategoryId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands/view/product-category', array('id' => $brandId));
        }

        $brandProductCategory = $this->brandProductCategoryService->getBrandProductCategory($brandProductCategoryId);

        if (!($brandProductCategory instanceof BrandProductCategoryInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands/view/product-category', array('id' => $brandId));
        }

        $this->brandProductCategoryService->delete($this->identity(), $brandProductCategory);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the brand product category.');

        return $this->redirect()->toRoute('rocket-admin/products/brands/view/product-category', array('id' => $brandId));
    }
}
