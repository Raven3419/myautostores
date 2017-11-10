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
use LundSite\Service\DriversCouncilService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\DriversCouncilInterface;

/**
 * DriversCouncils controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class DriversCouncilController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\DriversCouncilService
     */
    protected $driversCouncilService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService           $siteService
     * @param DriversCouncilService $driversCouncilService
     * @param HelperPluginManager   $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        DriversCouncilService $driversCouncilService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->driversCouncilService       = $driversCouncilService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of driversCouncils
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->driversCouncilService->getActiveDriversCouncils(),
        ));
    }

    /**
     * View a single driversCouncil record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $driversCouncilId = (int) $this->params()->fromRoute('id', null);

        if (null === $driversCouncilId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/drivers-council');
        }

        $driversCouncil = $this->driversCouncilService->getDriversCouncil($driversCouncilId);

        if (!($driversCouncil instanceof DriversCouncilInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/drivers-council');
        }

        $form = $this->driversCouncilService->getEditDriversCouncilForm($driversCouncilId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $driversCouncilId,
        ));
    }

    /**
     * Create a new driversCouncil record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->driversCouncilService->getCreateDriversCouncilForm();

        if ($this->request->isPost()) {
            $driversCouncil = $this->driversCouncilService->create($this->identity(), $this->request->getPost());

            if ($driversCouncil instanceof DriversCouncilInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a drivers council.');

                return $this->redirect()->toRoute('rocket-admin/lund/drivers-council');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new drivers council.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing driversCouncil record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $driversCouncilId = (int) $this->params()->fromRoute('id', null);

        if (null === $driversCouncilId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/drivers-council');
        }

        $driversCouncil = $this->driversCouncilService->getDriversCouncil($driversCouncilId);

        if (!($driversCouncil instanceof DriversCouncilInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/drivers-council');
        }

        $form = $this->driversCouncilService->getEditDriversCouncilForm($driversCouncilId);

        if ($this->request->isPost()) {
            $driversCouncil = $this->driversCouncilService->edit($this->identity(), $this->request->getPost(), $driversCouncil);

            if ($driversCouncil instanceof DriversCouncilInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the drivers council.');

                return $this->redirect()->toRoute('rocket-admin/lund/drivers-council');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the drivers council.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'driversCouncilId' => $driversCouncilId,
        ));
    }

    /**
     * Delete an existing driversCouncil record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $driversCouncilId = (int) $this->params()->fromRoute('id', null);

        if (null === $driversCouncilId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/drivers-council');
        }

        $driversCouncil = $this->driversCouncilService->getDriversCouncil($driversCouncilId);

        if (!($driversCouncil instanceof DriversCouncilInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/drivers-council');
        }

        $this->driversCouncilService->delete($this->identity(), $driversCouncil);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the drivers council.');

        return $this->redirect()->toRoute('rocket-admin/lund/drivers-council');
    }
}
