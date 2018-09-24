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
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\HelperPluginManager as ViewHelperManager;
use Zend\View\Model\ViewModel;
use LundProducts\Form\BrandForm;
use LundProducts\Service\BrandsService;
use LundProducts\Service\BrandProductCategoryService;
use RocketAdmin\Service\MessageService;

/**
 * Brands controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 */
class BrandsController extends AbstractActionController
{
    /**
     * @var BrandsService
     */
    protected $brandsService;

    /**
     * @var BrandProductCategoryService
     */
    protected $brandProductCategoryService;

    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * @var HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param BrandsService  $brandsService
     * @param BrandProductCategoryService $brandProductCategoryService
     * @param MessageService $messageService
     * @param HelperPluginManager $viewHelperManager
     */
    public function __construct(
        BrandsService  $brandsService,
        BrandProductCategoryService $brandProductCategoryService,
        MessageService $messageService,
        ViewHelperManager $viewHelperManager
    )
    {
        $this->brandsService  = $brandsService;
        $this->brandProductCategoryService = $brandProductCategoryService;
        $this->messageService = $messageService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of brands
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->brandsService->getCurrentBrands(),
        ));
    }

    /**
     * View a single brand record
     *
     * @return ViewModel|array
     */
    public function viewAction()
    {
        $recordId = (int) $this->params('id', null);

        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $record = $this->brandsService->getBrand($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $form = $this->brandsService->getEditBrandForm($recordId);

        $brandProductCategories = $this->brandProductCategoryService->getBrandProductCategoriesByBrand($record);

        return new ViewModel(array(
            'record'   => $record,
            'form'     => $form,
            'recordId' => $recordId,
            'productCategories' => $brandProductCategories,
        ));
    }

    /**
     * Create a new brand record
     *
     * @return ViewModel|array
     */
    public function createAction()
    {
        $record = new \LundProducts\Entity\Brands();

        $form = $this->brandsService->getCreateBrandForm();

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->brandsService->createBrand($record, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                                       ->addMessage('You have successfullly created a new Brand.');

                return $this->redirect()->toRoute('rocket-admin/products/brands');
            } else {
                $this->flashMessenger()->setNamespace('error')
                                       ->addMessage('There was an error trying to create a new Brand.');
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
             ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('InlineScript')
             ->appendScript("$(function () {CKEDITOR.replace('brand-fieldset[html]');});", 'text/javascript');

        return new ViewModel(array(
            'record' => $record,
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing brand record
     *
     * @return ViewModel|array
     */
    public function editAction()
    {
        $recordId = (int) $this->params('id', null);

        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $record = $this->brandsService->getBrand($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $form = $this->brandsService->getEditBrandForm($recordId);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->brandsService->editBrand($record, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('You have successfully edited a Brand.');

                return $this->redirect()->toRoute('rocket-admin/products/brands');
            } else {
                $form->getData();
                $this->flashMessenger()->setNamespace('error')
                     ->addMessage('There was an error trying to edit an existing Brand.');
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
             ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('InlineScript')
             ->appendScript("$(function () {CKEDITOR.replace('brand-fieldset[html]');});", 'text/javascript');

        return new ViewModel(array(
            'record'   => $record,
            'form'     => $form,
            'recordId' => $recordId,
        ));
    }

    /**
     * Delete an existing brand record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $recordId = (int) $this->params('id', null);

        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $record = $this->brandsService->getBrand($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/brands');
        }

        $this->brandsService->deleteBrand($record, $this->identity());

        $this->flashMessenger()->setNamespace('success')
             ->addMessage('You have successfully deleted a Brand.');

        return $this->redirect()->toRoute('rocket-admin/products/brands');
    }
}
