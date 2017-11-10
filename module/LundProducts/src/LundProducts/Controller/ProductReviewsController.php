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
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use LundProducts\Controller\Options;
use LundProducts\Form\ParocuctReviewForm;
use LundProducts\Service\ProductReviewService;

/**
 * Product Reviews controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductReviewsController extends AbstractActionController
{
    /**
     * @var ProductReviewService
     */
    protected $productReviewService;

    /**
     * @param ProductReviewService $productReviewService
     */
    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    /**
     * Display a table of product reviews
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $records = $this->productReviewService->getProductReviewListings($this, (INT)$this->params()->fromQuery('iDisplayLength'),
                (INT)$this->params()->fromQuery('iDisplayStart'),
                (INT)$this->params()->fromQuery('sEcho'),
                (INT)$this->params()->fromQuery('iSortingCols'),
                (STRING)$this->params()->fromQuery('sSearch'));

            return new JsonModel($records);
        }

        return new ViewModel();
    }

    /**
     * Approve a product review for display on the website
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function approveAction()
    {
        $recordId = (int) $this->params('id', null);

        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record');

            return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
        }

        $record = $this->productReviewService->getProductReview($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record');

            return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
        } else {
            $this->productReviewService->approveProductReview($record, $this->identity());

            $this->flashMessenger()->setNamespace('success')
                 ->addMessage('You have successfully approved a Product Review.');

            return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
        }
    }

    /**
     * Create a new product review record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $record = new \LundProducts\Entity\ProductReviews();

        $form = $this->productReviewService->getCreateProductReviewForm();

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $productReview = $form->getData();
                $this->productReviewService->createProductReview($productReview, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('You have successfully created a new Product Review.');

                return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
            } else {
                $this->flashMessenger()->setNamespace('error')
                     ->addMessage('There was an error while attempting to create a new Product Review.');
            }
        }

        return new ViewModel(array(
            'record' => $record,
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing product review record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
        }

        $record = $this->productReviewService->getProductReview($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
        }

        $form = $this->productReviewService->getEditProductReviewForm($record);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->productReviewService->editProductReview($record, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('You have successfully edited a Product Review.');

                return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
            } else {
                $this->flashMessenger()->setNamespace('error')
                     ->addMessage('There was an error while attempting to edit an existing Product Review.');
            }
        }

        return new ViewModel(array(
            'record'   => $record,
            'form'     => $form,
            'recordId' => $recordId,
        ));
    }

    /**
     * Delete an existing product review record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
        }

        $record = $this->productReviewService->getProductReview($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
        }

        $this->productReviewService->deleteProductReview($record, $this->identity());

        $this->flashMessenger()->setNamespace('success')
             ->addMessage('You have successfully deleted a Product Review.');

        return $this->redirect()->toRoute('rocket-admin/products/product-reviews');
    }
}
