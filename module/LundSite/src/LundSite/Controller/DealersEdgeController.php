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
use LundSite\Service\DealersEdgeService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\DealersEdgeInterface;

/**
 * DealersEdges controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class DealersEdgeController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\DealersEdgeService
     */
    protected $dealersEdgeService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService         $siteService
     * @param DealersEdgeService  $dealersEdgeService
     * @param HelperPluginManager $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        DealersEdgeService $dealersEdgeService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->dealersEdgeService       = $dealersEdgeService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of dealersEdges
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->dealersEdgeService->getActiveDealersEdges(),
        ));
    }

    /**
     * View a single dealersEdge record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $dealersEdgeId = (int) $this->params()->fromRoute('id', null);

        if (null === $dealersEdgeId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/dealers-edge');
        }

        $dealersEdge = $this->dealersEdgeService->getDealersEdge($dealersEdgeId);

        if (!($dealersEdge instanceof DealersEdgeInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/dealers-edge');
        }

        $form = $this->dealersEdgeService->getEditDealersEdgeForm($dealersEdgeId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $dealersEdgeId,
        ));
    }

    /**
     * Create a new dealersEdge record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->dealersEdgeService->getCreateDealersEdgeForm();

        if ($this->request->isPost()) {
            $dealersEdge = $this->dealersEdgeService->create($this->identity(), $this->request->getPost());

            if ($dealersEdge instanceof DealersEdgeInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a dealers edge.');

                return $this->redirect()->toRoute('rocket-admin/lund/dealers-edge');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new dealers edge.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing dealersEdge record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $dealersEdgeId = (int) $this->params()->fromRoute('id', null);

        if (null === $dealersEdgeId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/dealers-edge');
        }

        $dealersEdge = $this->dealersEdgeService->getDealersEdge($dealersEdgeId);

        if (!($dealersEdge instanceof DealersEdgeInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/dealers-edge');
        }

        $form = $this->dealersEdgeService->getEditDealersEdgeForm($dealersEdgeId);

        if ($this->request->isPost()) {
            $dealersEdge = $this->dealersEdgeService->edit($this->identity(), $this->request->getPost(), $dealersEdge);

            if ($dealersEdge instanceof DealersEdgeInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the dealers edge.');

                return $this->redirect()->toRoute('rocket-admin/lund/dealers-edge');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the dealers edge.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'dealersEdgeId' => $dealersEdgeId,
        ));
    }

    /**
     * Delete an existing dealersEdge record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $dealersEdgeId = (int) $this->params()->fromRoute('id', null);

        if (null === $dealersEdgeId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/dealers-edge');
        }

        $dealersEdge = $this->dealersEdgeService->getDealersEdge($dealersEdgeId);

        if (!($dealersEdge instanceof DealersEdgeInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/dealers-edge');
        }

        $this->dealersEdgeService->delete($this->identity(), $dealersEdge);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the dealers edge.');

        return $this->redirect()->toRoute('rocket-admin/lund/dealers-edge');
    }
}
