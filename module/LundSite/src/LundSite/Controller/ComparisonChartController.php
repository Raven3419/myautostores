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
use LundSite\Service\ComparisonChartService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\ComparisonChartInterface;

/**
 * ComparisonChart controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ComparisonChartController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\ComparisonChartService
     */
    protected $comparisonChartService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService         	$siteService
     * @param ComparisonChartService  	$comparisonChartService
     * @param HelperPluginManager 	$viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        ComparisonChartService $comparisonChartService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->comparisonChartService  = $comparisonChartService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of comparisonChart
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->comparisonChartService->getActiveComparisonChart(),
        ));
    }

    /**
     * View a single comparisonChart record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $comparisonChartId = (int) $this->params()->fromRoute('id', null);

        if (null === $comparisonChartId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/comparison-chart');
        }

        $comparisonChart = $this->comparisonChartService->getComparisonChart($comparisonChartId);

        if (!($comparisonChart instanceof ComparisonChartInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/comparison-chart');
        }

        $form = $this->comparisonChartService->getEditComparisonChartForm($comparisonChartId);
        
        

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $comparisonChartId,
        ));
    }

    /**
     * Create a new comparisonChart record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->comparisonChartService->getCreateComparisonChartForm();

        if ($this->request->isPost()) {
            $comparisonChart = $this->comparisonChartService->create($this->identity(), $this->request->getPost());

            if ($comparisonChart instanceof ComparisonChartInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a comparisonChart.');

                return $this->redirect()->toRoute('rocket-admin/lund/comparison-chart');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new comparisonChart.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing comparisonChart record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $comparisonChartId = (int) $this->params()->fromRoute('id', null);

        if (null === $comparisonChartId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/comparison-chart');
        }

        $comparisonChart = $this->comparisonChartService->getComparisonChart($comparisonChartId);

        if (!($comparisonChart instanceof ComparisonChartInterface)) {

            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/comparison-chart');
        }

        $form = $this->comparisonChartService->getEditComparisonChartForm($comparisonChartId);

        if ($this->request->isPost()) {

            $comparisonChart = $this->comparisonChartService->edit($this->identity(), $this->request->getPost(), $comparisonChart);

            if ($comparisonChart instanceof ComparisonChartInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the comparisonChart.');

                return $this->redirect()->toRoute('rocket-admin/lund/comparison-chart');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the ComparisonChart.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'comparisonChartId' => $comparisonChartId,
        ));
    }

    /**
     * Delete an existing comparisonChart record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $comparisonChartId = (int) $this->params()->fromRoute('id', null);

        if (null === $comparisonChartId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/comparison-chart');
        }

        $comparisonChart = $this->comparisonChartService->getComparisonChart($comparisonChartId);

        if (!($comparisonChart instanceof ComparisonChartInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/comparison-chart');
        }

        $this->comparisonChartService->delete($this->identity(), $comparisonChart);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the comparisonChart.');

        return $this->redirect()->toRoute('rocket-admin/lund/comparison-chart');
    }
}
