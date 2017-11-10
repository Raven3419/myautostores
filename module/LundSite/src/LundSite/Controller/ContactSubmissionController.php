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
use LundSite\Service\ContactSubmissionService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\ContactSubmissionInterface;

/**
 * ContactSubmissions controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ContactSubmissionController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\ContactSubmissionService
     */
    protected $contactSubmissionService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService              $siteService
     * @param ContactSubmissionService $contactSubmissionService
     * @param HelperPluginManager      $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        ContactSubmissionService $contactSubmissionService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->contactSubmissionService       = $contactSubmissionService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of contactSubmissions
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->contactSubmissionService->getActiveContactSubmissions(),
        ));
    }

    /**
     * View a single contactSubmission record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $contactSubmissionId = (int) $this->params()->fromRoute('id', null);

        if (null === $contactSubmissionId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/contact-submission');
        }

        $contactSubmission = $this->contactSubmissionService->getContactSubmission($contactSubmissionId);

        if (!($contactSubmission instanceof ContactSubmissionInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/contact-submission');
        }

        $form = $this->contactSubmissionService->getEditContactSubmissionForm($contactSubmissionId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $contactSubmissionId,
        ));
    }

    /**
     * Create a new contactSubmission record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->contactSubmissionService->getCreateContactSubmissionForm();

        if ($this->request->isPost()) {
            $contactSubmission = $this->contactSubmissionService->create($this->identity(), $this->request->getPost());

            if ($contactSubmission instanceof ContactSubmissionInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a contact submission.');

                return $this->redirect()->toRoute('rocket-admin/lund/contact-submission');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new contact submission.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing contactSubmission record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $contactSubmissionId = (int) $this->params()->fromRoute('id', null);

        if (null === $contactSubmissionId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/contact-submission');
        }

        $contactSubmission = $this->contactSubmissionService->getContactSubmission($contactSubmissionId);

        if (!($contactSubmission instanceof ContactSubmissionInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/contact-submission');
        }

        $form = $this->contactSubmissionService->getEditContactSubmissionForm($contactSubmissionId);

        if ($this->request->isPost()) {
            $contactSubmission = $this->contactSubmissionService->edit($this->identity(), $this->request->getPost(), $contactSubmission);

            if ($contactSubmission instanceof ContactSubmissionInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the contact submission.');

                return $this->redirect()->toRoute('rocket-admin/lund/contact-submission');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the contact submission.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'contactSubmissionId' => $contactSubmissionId,
        ));
    }

    /**
     * Delete an existing contactSubmission record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $contactSubmissionId = (int) $this->params()->fromRoute('id', null);

        if (null === $contactSubmissionId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/contact-submission');
        }

        $contactSubmission = $this->contactSubmissionService->getContactSubmission($contactSubmissionId);

        if (!($contactSubmission instanceof ContactSubmissionInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/contact-submission');
        }

        $this->contactSubmissionService->delete($this->identity(), $contactSubmission);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the contact submission.');

        return $this->redirect()->toRoute('rocket-admin/lund/contact-submission');
    }
}
