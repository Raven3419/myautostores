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
use LundSite\Service\VideoTestimonialsService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\VideoTestimonialsInterface;

/**
 * VideoTestimonials controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class VideoTestimonialsController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\VideoTestimonialsService
     */
    protected $videoTestimonialsService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService         	$siteService
     * @param VideoTestimonialsService  	$videoTestimonialsService
     * @param HelperPluginManager 	$viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        VideoTestimonialsService $videoTestimonialsService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->videoTestimonialsService  = $videoTestimonialsService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of videoTestimonials
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        echo "hi";exit;
        return new ViewModel(array(
            'records' => $this->videoTestimonialsService->getActiveVideoTestimonials(),
        ));
    }

    /**
     * View a single videoTestimonials record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $videoTestimonialsId = (int) $this->params()->fromRoute('id', null);

        if (null === $videoTestimonialsId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/video-testimonials');
        }

        $videoTestimonials = $this->videoTestimonialsService->getVideoTestimonials($videoTestimonialsId);

        if (!($videoTestimonials instanceof VideoTestimonialsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/video-testimonials');
        }

        $form = $this->videoTestimonialsService->getEditVideoTestimonialsForm($videoTestimonialsId);
        
        

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $videoTestimonialsId,
        ));
    }

    /**
     * Create a new videoTestimonials record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->videoTestimonialsService->getCreateVideoTestimonialsForm();

        if ($this->request->isPost()) {
            $videoTestimonials = $this->videoTestimonialsService->create($this->identity(), $this->request->getPost());

            if ($videoTestimonials instanceof VideoTestimonialsInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a VideoTestimonials.');

                return $this->redirect()->toRoute('rocket-admin/lund/video-testimonials');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new VideoTestimonials.');

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
            ->appendScript("$(function () {CKEDITOR.replace('videoTestimonials-fieldset[answer]');});", 'text/javascript');

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing VideoTestimonials record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $videoTestimonialsId = (int) $this->params()->fromRoute('id', null);

        if (null === $videoTestimonialsId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/video-testimonials');
        }

        $videoTestimonials = $this->videoTestimonialsService->getVideoTestimonials($videoTestimonialsId);

        if (!($videoTestimonials instanceof VideoTestimonialsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/video-testimonials');
        }

        $form = $this->videoTestimonialsService->getEditVideoTestimonialsForm($videoTestimonialsId);

        if ($this->request->isPost()) {

            $videoTestimonials = $this->videoTestimonialsService->edit($this->identity(), $this->request->getPost(), $videoTestimonials);

            if ($videoTestimonials instanceof VideoTestimonialsInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the VideoTestimonials.');

                return $this->redirect()->toRoute('rocket-admin/lund/video-testimonials');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the VideoTestimonials.');

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
            ->appendScript("$(function () {CKEDITOR.replace('videoTestimonials-fieldset[answer]');});", 'text/javascript');

        return new ViewModel(array(
            'form'     => $form,
            'videoTestimonialsId' => $videoTestimonialsId,
        ));
    }

    /**
     * Delete an existing VideoTestimonials record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $videoTestimonialsId = (int) $this->params()->fromRoute('id', null);

        if (null === $videoTestimonialsId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/video-testimonials');
        }

        $videoTestimonials = $this->videoTestimonialsService->getVideoTestimonials($videoTestimonialsId);

        if (!($videoTestimonials instanceof VideoTestimonialsInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/video-testimonials');
        }

        $this->videoTestimonialsService->delete($this->identity(), $videoTestimonials);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the VideoTestimonials.');

        return $this->redirect()->toRoute('rocket-admin/lund/video-testimonials');
    }
}
