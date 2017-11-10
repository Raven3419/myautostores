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
use LundSite\Service\FaqService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\FaqInterface;

/**
 * Faq controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class FaqController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\FaqService
     */
    protected $faq;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService         $siteService
     * @param FaqService  		  $faqService
     * @param HelperPluginManager $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        FaqService $faqService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->faqService       = $faqService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of faq
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->faqService->getActiveFaq(),
        ));
    }

    /**
     * View a single faq record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $faqId = (int) $this->params()->fromRoute('id', null);

        if (null === $faqId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/faq');
        }

        $faq = $this->faqService->getFaq($faqId);

        if (!($faq instanceof FaqInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/faq');
        }

        $form = $this->faqService->getEditFaqForm($faqId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $faqId,
        ));
    }

    /**
     * Create a new faq record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->faqService->getCreateFaqForm();

        if ($this->request->isPost()) {
            $faq = $this->faqService->create($this->identity(), $this->request->getPost());

            if ($faq instanceof FaqInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a faq.');

                return $this->redirect()->toRoute('rocket-admin/lund/faq');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new faq.');

                $form->setData($this->request->getPost());
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
            ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('HeadLink')
            ->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css');
        $this->viewHelperManager->get('InlineScript')
            ->appendScript("$(function () {CKEDITOR.replace('faq-fieldset[html]');});", 'text/javascript');

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing faq record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $faqId = (int) $this->params()->fromRoute('id', null);

        if (null === $faqId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/faq');
        }

        $faq = $this->faqService->getFaq($faqId);

        if (!($faq instanceof FaqInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/faq');
        }

        $form = $this->faqService->getEditFaqForm($faqId);

        if ($this->request->isPost()) {
            $faq = $this->faqService->edit($this->identity(), $this->request->getPost(), $faq);

            if ($faq instanceof FaqInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the faq.');

                return $this->redirect()->toRoute('rocket-admin/lund/faq');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the faq.');

                $form->setData($this->request->getPost());
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
            ->appendFile($base . '/assets/rocket-admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('HeadLink')
            ->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css');
        $this->viewHelperManager->get('InlineScript')
            ->appendScript("$(function () {CKEDITOR.replace('faq-fieldset[html]');});", 'text/javascript');

        return new ViewModel(array(
            'form'     => $form,
            'faqId' => $faqId,
        ));
    }

    /**
     * Delete an existing faq record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $faqId = (int) $this->params()->fromRoute('id', null);

        if (null === $faqId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/faq');
        }

        $faq = $this->faqService->getFaq($faqId);

        if (!($faq instanceof FaqInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/faq');
        }

        $this->faqService->delete($this->identity(), $faq);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the faq.');

        return $this->redirect()->toRoute('rocket-admin/lund/faq');
    }
}
