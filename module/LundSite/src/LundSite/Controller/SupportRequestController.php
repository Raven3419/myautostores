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
use LundSite\Service\SupportRequestService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\SupportRequestInterface;

/**
 * SupportRequests controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class SupportRequestController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\SupportRequestService
     */
    protected $supportRequestService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService           $siteService
     * @param SupportRequestService $supportRequestService
     * @param HelperPluginManager   $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        SupportRequestService $supportRequestService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->supportRequestService       = $supportRequestService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of supportRequests
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->supportRequestService->getActiveSupportRequests(),
        ));
    }

    /**
     * View a single supportRequest record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $supportRequestId = (int) $this->params()->fromRoute('id', null);

        if (null === $supportRequestId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/support-request');
        }

        $supportRequest = $this->supportRequestService->getSupportRequest($supportRequestId);

        if (!($supportRequest instanceof SupportRequestInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/support-request');
        }

        $form = $this->supportRequestService->getEditSupportRequestForm($supportRequestId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $supportRequestId,
        ));
    }

    /**
     * Create a new supportRequest record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->supportRequestService->getCreateSupportRequestForm();

        if ($this->request->isPost()) {
            $supportRequest = $this->supportRequestService->create($this->identity(), $this->request->getPost());

            if ($supportRequest instanceof SupportRequestInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a support request.');

                return $this->redirect()->toRoute('rocket-admin/lund/support-request');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new support request.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing supportRequest record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $supportRequestId = (int) $this->params()->fromRoute('id', null);

        if (null === $supportRequestId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/support-request');
        }

        $supportRequest = $this->supportRequestService->getSupportRequest($supportRequestId);

        if (!($supportRequest instanceof SupportRequestInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/support-request');
        }

        $form = $this->supportRequestService->getEditSupportRequestForm($supportRequestId);

        if ($this->request->isPost()) {
            $supportRequest = $this->supportRequestService->edit($this->identity(), $this->request->getPost(), $supportRequest);

            if ($supportRequest instanceof SupportRequestInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the support request.');

                return $this->redirect()->toRoute('rocket-admin/lund/support-request');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the support request.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'supportRequestId' => $supportRequestId,
        ));
    }

    /**
     * Delete an existing supportRequest record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $supportRequestId = (int) $this->params()->fromRoute('id', null);

        if (null === $supportRequestId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/support-request');
        }

        $supportRequest = $this->supportRequestService->getSupportRequest($supportRequestId);

        if (!($supportRequest instanceof SupportRequestInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/support-request');
        }

        $this->supportRequestService->delete($this->identity(), $supportRequest);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the support request.');

        return $this->redirect()->toRoute('rocket-admin/lund/support-request');
    }
}
