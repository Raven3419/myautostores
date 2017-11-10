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
use Zend\View\Model\JsonModel;
use LundProducts\Controller\Options;
use LundProducts\Form\ProductCategoryForm;
use LundProducts\Service\ProductCategoryService;
use LundProducts\Service\BrandProductCategoryService;

/**
 * Product Categories controller for admin module
 *
 * @category   Zend
 * @package    Admin
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/commander for the canonical source repository
 */
class ProductCategoriesController extends AbstractActionController
{
    /**
     * @var ProductCategoryService
     */
    protected $productCategoryService;

    /**
     * @var BrandProductCategoryService
     */
    protected $brandProductCategoryService;

    /**
     * @var HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param ProductCategoryService $productCategoryService
     * @param BrandProductCategoryService $brandProductCategoryService
     * @param HelperPluginManager    $viewHelperManager
     */
    public function __construct(
        ProductCategoryService  $productCategoryService,
        BrandProductCategoryService  $brandProductCategoryService,
        ViewHelperManager       $viewHelperManager)
    {
        $this->productCategoryService = $productCategoryService;
        $this->brandProductCategoryService  = $brandProductCategoryService;
        $this->viewHelperManager      = $viewHelperManager;
    }

    /**
     * Display a table of product categories
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->productCategoryService->getActiveProductCategories(),
        ));
    }

    /**
     * View a single product category record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $recordId = (int) $this->params()->fromRoute('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-categories');
        }

        $record = $this->productCategoryService->getProductCategory($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-categories');
        }

        $brandProductCategories = $this->brandProductCategoryService->getBrandProductCategoryByProductCategory($record);

        $form = $this->productCategoryService->getViewProductCategoryForm($recordId);

        return new ViewModel(array(
            'record'   => $record,
            'form'     => $form,
            'recordId' => $recordId,
            'brandProductCategories' => $brandProductCategories,
        ));
    }

    /**
     * Create a new product category record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $record = new \LundProducts\Entity\ProductCategories();

        $form = $this->productCategoryService->getCreateProductCategoryForm();

        if ($this->request->isPost()) {
            $post = array_merge_recursive(
                $this->request->getPost()->toArray(),
                $this->request->getFiles()->toArray()
            );

            $form->setData($post);
            if ($form->isValid()) {
                $this->productCategoryService->createProductCategory($record, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('You have successfully created a new product category.');

                return $this->redirect()->toRoute('rocket-admin/products/product-categories');
            } else {
                $this->flashMessenger()->setNamespace('error')
                     ->addMessage('There was an error while trying to create a new product category.');
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
            ->appendScript("$(function () {CKEDITOR.replace('product-category-fieldset[longDescr]');});", 'text/javascript');

        return new ViewModel(array(
            'record' => $record,
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing product category record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $recordId = (int) $this->params()->fromRoute('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-categories');
        }

        $record = $this->productCategoryService->getProductCategory($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-categories');
        }

        $form = $this->productCategoryService->getEditProductCategoryForm($recordId);

        if ($this->request->isPost()) {
            $post = array_merge_recursive(
                $this->request->getPost()->toArray(),
                $this->request->getFiles()->toArray()
            );

            $form->setData($post);

            if ($form->isValid()) {
                $this->productCategoryService->editProductCategory($record, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully modified a product category.');

                return $this->redirect()->toRoute('rocket-admin/products/product-categories');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error while trying to edit a product category.');
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
            ->appendScript("$(function () {CKEDITOR.replace('product-category-fieldset[longDescr]');});", 'text/javascript');

        return new ViewModel(array(
            'record'   => $record,
            'form'     => $form,
            'recordId' => $recordId,
        ));
    }

    /**
     * Delete an existing product category record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-categories');
        }

        $record = $this->productCategoryService->getProductCategory($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-categories');
        }

        $this->productCategoryService->deleteProductCategory($record, $this->identity());

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted a product category.');

        return $this->redirect()->toRoute('rocket-admin/products/product-categories');
    }
}
