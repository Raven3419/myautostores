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
use LundSite\Service\ShowroomService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\ShowroomInterface;

/**
 * Showrooms controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ShowroomController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\ShowroomService
     */
    protected $showroomService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService              $siteService
     * @param ShowroomService $showroomService
     * @param HelperPluginManager      $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        ShowroomService $showroomService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->showroomService       = $showroomService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of showrooms
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->showroomService->getActiveShowrooms(),
        ));
    }

    /**
     * View a single showroom record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $showroomId = (int) $this->params()->fromRoute('id', null);

        if (null === $showroomId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/showroom');
        }

        $showroom = $this->showroomService->getShowroom($showroomId);

        if (!($showroom instanceof ShowroomInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/showroom');
        }

        $form = $this->showroomService->getEditShowroomForm($showroomId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $showroomId,
        ));
    }

    /**
     * Create a new showroom record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->showroomService->getCreateShowroomForm();

        if ($this->request->isPost()) {
            $showroom = $this->showroomService->create($this->identity(), $this->request->getPost());

            if ($showroom instanceof ShowroomInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a showroom.');

                return $this->redirect()->toRoute('rocket-admin/lund/showroom');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new showroom.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing showroom record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $showroomId = (int) $this->params()->fromRoute('id', null);

        if (null === $showroomId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/showroom');
        }

        $showroom = $this->showroomService->getShowroom($showroomId);

        if (!($showroom instanceof ShowroomInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/showroom');
        }

        $form = $this->showroomService->getEditShowroomForm($showroomId);

        if ($this->request->isPost()) {
            $showroom = $this->showroomService->edit($this->identity(), $this->request->getPost(), $showroom);

            if ($showroom instanceof ShowroomInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the showroom.');

                return $this->redirect()->toRoute('rocket-admin/lund/showroom');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the showroom.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'showroomId' => $showroomId,
        ));
    }

    /**
     * Delete an existing showroom record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $showroomId = (int) $this->params()->fromRoute('id', null);

        if (null === $showroomId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/showroom');
        }

        $showroom = $this->showroomService->getShowroom($showroomId);

        if (!($showroom instanceof ShowroomInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/showroom');
        }

        $this->showroomService->delete($this->identity(), $showroom);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the showroom.');

        return $this->redirect()->toRoute('rocket-admin/lund/showroom');
    }
}
