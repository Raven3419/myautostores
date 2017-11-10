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
use LundSite\Service\NewsReleaseService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\NewsReleaseInterface;

/**
 * NewsReleases controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class NewsReleaseController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\NewsReleaseService
     */
    protected $newsReleaseService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService         $siteService
     * @param NewsReleaseService  $newsReleaseService
     * @param HelperPluginManager $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        NewsReleaseService $newsReleaseService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->newsReleaseService       = $newsReleaseService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of newsReleases
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->newsReleaseService->getActiveNewsReleases(),
        ));
    }

    /**
     * View a single newsRelease record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $newsReleaseId = (int) $this->params()->fromRoute('id', null);

        if (null === $newsReleaseId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/news-release');
        }

        $newsRelease = $this->newsReleaseService->getNewsRelease($newsReleaseId);

        if (!($newsRelease instanceof NewsReleaseInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/news-release');
        }

        $form = $this->newsReleaseService->getEditNewsReleaseForm($newsReleaseId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $newsReleaseId,
        ));
    }

    /**
     * Create a new newsRelease record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->newsReleaseService->getCreateNewsReleaseForm();

        if ($this->request->isPost()) {
            $newsRelease = $this->newsReleaseService->create($this->identity(), $this->request->getPost());

            if ($newsRelease instanceof NewsReleaseInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a news release.');

                return $this->redirect()->toRoute('rocket-admin/lund/news-release');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new news release.');

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
            ->appendScript("$(function () {CKEDITOR.replace('news-release-fieldset[html]');});", 'text/javascript');

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing newsRelease record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $newsReleaseId = (int) $this->params()->fromRoute('id', null);

        if (null === $newsReleaseId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/news-release');
        }

        $newsRelease = $this->newsReleaseService->getNewsRelease($newsReleaseId);

        if (!($newsRelease instanceof NewsReleaseInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/news-release');
        }

        $form = $this->newsReleaseService->getEditNewsReleaseForm($newsReleaseId);

        if ($this->request->isPost()) {
            $newsRelease = $this->newsReleaseService->edit($this->identity(), $this->request->getPost(), $newsRelease);

            if ($newsRelease instanceof NewsReleaseInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the news release.');

                return $this->redirect()->toRoute('rocket-admin/lund/news-release');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the news release.');

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
            ->appendScript("$(function () {CKEDITOR.replace('news-release-fieldset[html]');});", 'text/javascript');

        return new ViewModel(array(
            'form'     => $form,
            'newsReleaseId' => $newsReleaseId,
        ));
    }

    /**
     * Delete an existing newsRelease record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $newsReleaseId = (int) $this->params()->fromRoute('id', null);

        if (null === $newsReleaseId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/news-release');
        }

        $newsRelease = $this->newsReleaseService->getNewsRelease($newsReleaseId);

        if (!($newsRelease instanceof NewsReleaseInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/news-release');
        }

        $this->newsReleaseService->delete($this->identity(), $newsRelease);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the news release.');

        return $this->redirect()->toRoute('rocket-admin/lund/news-release');
    }
}
