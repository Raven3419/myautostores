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
use LundProducts\Form\ProductLineFeatureForm;
use LundProducts\Service\ProductLineService;
use LundProducts\Service\ProductLineFeatureService;
use LundProducts\Entity\ProductLinesInterface;
use LundProducts\Entity\ProductLineFeatureInterface;

/**
 * ProductLineFeature controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductLineFeatureController extends AbstractActionController
{
    /**
     * @var ProductLineService
     */
    protected $productLineService;

    /**
     * @var ProductLineFeatureService
     */
    protected $productLineFeatureService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param ProductLineService      $productLineService
     * @param ProductLineFeatureService $productLineFeatureService
     * @param HelperPluginManager     $viewHelperManager
     */
    public function __construct(
        ProductLineService       $productLineService,
        ProductLineFeatureService  $productLineFeatureService,
        ViewHelperManager $viewHelperManager)
    {
        $this->productLineService       = $productLineService;
        $this->productLineFeatureService  = $productLineFeatureService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of product line features
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $max = $this->productLineFeatureService->getMaxPosition($productLine);

        return new ViewModel(array(
            'records' => $this->productLineFeatureService->getProductLineFeaturesByProductLine($productLine),
            'productLineId'  => $productLineId,
            'productLine'    => $productLine,
            'max'            => $max,
        ));
    }

    /**
     * View a single product line feature record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLineFeatureId = (int) $this->params()->fromRoute('productlinefeatureid', null);

        if (null === $productLineFeatureId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $productLineFeature = $this->productLineFeatureService->getProductLineFeature($productLineFeatureId);

        if (!($productLineFeature instanceof ProductLineFeatureInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $form = $this->productLineFeatureService->getEditProductLineFeatureForm($productLineFeatureId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $productLineFeatureId,
            'productLineId'   => $productLineId,
            'productLineFeature' => $productLineFeature,
        ));
    }

    /**
     * Create a new product line feature record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $form = $this->productLineFeatureService->getCreateProductLineFeatureForm();

        if ($this->request->isPost()) {
            $productLineFeature = $this->productLineFeatureService->createRecord($this->identity(), $productLine, $this->request->getPost());

            if ($productLineFeature instanceof ProductLineFeatureInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a product line feature.');

                return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new product line feature.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
            'productLineId' => $productLineId,
        ));
    }

    /**
     * Edit an existing product line feature record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLineFeatureId = (int) $this->params()->fromRoute('productlinefeatureid', null);

        if (null === $productLineFeatureId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $productLineFeature = $this->productLineFeatureService->getProductLineFeature($productLineFeatureId);

        if (!($productLineFeature instanceof ProductLineFeatureInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $form = $this->productLineFeatureService->getEditProductLineFeatureForm($productLineFeatureId);

        if ($this->request->isPost()) {
            $productLineFeature = $this->productLineFeatureService->editRecord($this->identity(), $this->request->getPost(), $productLineFeature, $productLine);

            if ($productLineFeature instanceof ProductLineFeatureInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the product line feature.');

                return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the product line feature.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'productLineFeatureId' => $productLineFeatureId,
            'productLineId'   => $productLineId,
        ));
    }

    /**
     * Rank Up an existing feature record
     *
     * @return void
     */
    public function rankUpAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLineFeatureId = (int) $this->params()->fromRoute('productlinefeatureid', null);

        if (null === $productLineFeatureId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $productLineFeature = $this->productLineFeatureService->getProductLineFeature($productLineFeatureId);

        if (!($productLineFeature instanceof ProductLineFeatureInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $productLineFeature = $this->productLineFeatureService->rankUpFeature($this->identity(), $productLineFeature);

        if ($productLineFeature) {
            $this->flashMessenger()->setNamespace('success')
                ->addMessage('You have successfully ranked up the product line feature.');
        }

        return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
    }

    /**
     * Rank Down an existing product line feature record
     *
     * @return void
     */
    public function rankDownAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        
        $productLineFeatureId = (int) $this->params()->fromRoute('productlinefeatureid', null);

        if (null === $productLineFeatureId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $productLineFeature = $this->productLineFeatureService->getProductLineFeature($productLineFeatureId);

        if (!($productLineFeature instanceof ProductLineFeatureInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $productLineFeature = $this->productLineFeatureService->rankDownFeature($this->identity(), $productLineFeature);

        if ($productLineFeature) {
            $this->flashMessenger()->setNamespace('success')
                ->addMessage('You have successfully ranked down the product line feature.');
        }

        return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
    }

    /**
     * Delete an existing product line feature record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $productLineId = (int) $this->params()->fromRoute('id', null);

        if (null === $productLineId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLine = $this->productLineService->getProductLine($productLineId);

        if (!($productLine instanceof ProductLinesInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a product line in order to access the product line feature component.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines');
        }

        $productLineFeatureId = (int) $this->params()->fromRoute('productlinefeatureid', null);

        if (null === $productLineFeatureId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $productLineFeature = $this->productLineFeatureService->getProductLineFeature($productLineFeatureId);

        if (!($productLineFeature instanceof ProductLineFeatureInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
        }

        $this->productLineFeatureService->delete($this->identity(), $productLineFeature);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the product line feature.');

        return $this->redirect()->toRoute('rocket-admin/products/product-lines/view/feature', array('id' => $productLineId));
    }
}
