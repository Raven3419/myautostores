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
use LundProducts\Form\PartAssetForm;
use LundProducts\Service\PartService;
use LundProducts\Service\PartAssetService;
use LundProducts\Entity\PartsInterface;
use LundProducts\Entity\PartAssetInterface;
use RocketDam\Service\AssetService;

/**
 * PartAsset controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class PartAssetController extends AbstractActionController
{
    /**
     * @var PartService
     */
    protected $partService;

    /**
     * @var PartAssetService
     */
    protected $partAssetService;

    /**
     * @var AssetService;
     */
    protected $assetService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param PartService         $partService
     * @param PartAssetService    $partAssetService
     * @param AssetService        $assetService
     * @param HelperPluginManager $viewHelperManager
     */
    public function __construct(
        PartService       $partService,
        PartAssetService  $partAssetService,
        AssetService      $assetService,
        ViewHelperManager $viewHelperManager)
    {
        $this->partService       = $partService;
        $this->partAssetService  = $partAssetService;
        $this->assetService = $assetService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of part assets
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        $partId = (int) $this->params()->fromRoute('id', null);

        if (null === $partId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a part in order to access the part asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $part = $this->partService->getPart($partId);

        if (!($part instanceof PartsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a part in order to access the part asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        return new ViewModel(array(
            'records' => $this->partAssetService->getPartAssetsByPart($part),
            'partId'  => $partId,
            'part'    => $part,
        ));
    }

    /**
     * View a single part asset record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $partId = (int) $this->params()->fromRoute('id', null);

        if (null === $partId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a part in order to access the part asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $partAssetId = (int) $this->params()->fromRoute('partassetid', null);

        if (null === $partAssetId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts/view/asset', array('id' => $partId));
        }

        $partAsset = $this->partAssetService->getPartAsset($partAssetId);

        if (!($partAsset instanceof PartAssetInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts/view/asset', array('id' => $partId));
        }

        $form = $this->partAssetService->getEditPartAssetForm($partAssetId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $partAssetId,
            'partId'   => $partId,
            'partAsset' => $partAsset,
        ));
    }

    /**
     * Create a new part asset record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $partId = (int) $this->params()->fromRoute('id', null);

        if (null === $partId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a part in order to access the part asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $part = $this->partService->getPart($partId);

        if (!($part instanceof PartsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a part in order to access the part asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $form = $this->partAssetService->getCreatePartAssetForm();

        if ($this->request->isPost()) {
            $partAsset = $this->partAssetService->createRecord($this->identity(), $part, $this->request->getPost());

            if ($partAsset instanceof PartAssetInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a part asset.');

                return $this->redirect()->toRoute('rocket-admin/products/parts/view/asset', array('id' => $partId));
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new part asset.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
            'partId' => $partId,
        ));
    }

    /**
     * Edit an existing part asset record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $partId = (int) $this->params()->fromRoute('id', null);

        if (null === $partId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a part in order to access the part asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $part = $this->partService->getPart($partId);

        if (!($part instanceof PartsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a part in order to access the part asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $partAssetId = (int) $this->params()->fromRoute('partassetid', null);

        if (null === $partAssetId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts/view/asset', array('id' => $partId));
        }

        $partAsset = $this->partAssetService->getPartAsset($partAssetId);

        if (!($partAsset instanceof PartAssetInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts/view/asset', array('id' => $partId));
        }

        $form = $this->partAssetService->getEditPartAssetForm($partAssetId);

        if ($this->request->isPost()) {
            $partAsset = $this->partAssetService->editRecord($this->identity(), $this->request->getPost(), $partAsset);

            if ($partAsset instanceof PartAssetInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the part asset.');

                return $this->redirect()->toRoute('rocket-admin/products/parts/view/asset', array('id' => $partId));
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the part asset.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'partAssetId' => $partAssetId,
            'partId'   => $partId,
        ));
    }

    /**
     * Delete an existing part asset record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $partId = (int) $this->params()->fromRoute('id', null);

        if (null === $partId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a part in order to access the part asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $part = $this->partService->getPart($partId);

        if (!($part instanceof PartsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select a part in order to access the part asset component.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $partAssetId = (int) $this->params()->fromRoute('partassetid', null);

        if (null === $partAssetId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts/view/asset', array('id' => $partId));
        }

        $partAsset = $this->partAssetService->getPartAsset($partAssetId);

        if (!($partAsset instanceof PartAssetInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts/view/asset', array('id' => $partId));
        }

        $this->partAssetService->delete($this->identity(), $partAsset);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the part asset.');

        return $this->redirect()->toRoute('rocket-admin/products/parts/view/asset', array('id' => $partId));
    }
}
