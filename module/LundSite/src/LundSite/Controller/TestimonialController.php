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
use LundSite\Service\TestimonialService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\TestimonialInterface;

/**
 * Testimonials controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class TestimonialController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\TestimonialService
     */
    protected $testimonialService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService              $siteService
     * @param TestimonialService $testimonialService
     * @param HelperPluginManager      $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        TestimonialService $testimonialService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->testimonialService       = $testimonialService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of testimonials
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        $max = $this->testimonialService->getMaxPosition();

        return new ViewModel(array(
            'records' => $this->testimonialService->getActiveTestimonials(),
            'max'     => $max,
        ));
    }

    /**
     * View a single testimonial record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $testimonialId = (int) $this->params()->fromRoute('id', null);

        if (null === $testimonialId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $testimonial = $this->testimonialService->getTestimonial($testimonialId);

        if (!($testimonial instanceof TestimonialInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $form = $this->testimonialService->getEditTestimonialForm($testimonialId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $testimonialId,
        ));
    }

    /**
     * Create a new testimonial record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->testimonialService->getCreateTestimonialForm();

        if ($this->request->isPost()) {
            $testimonial = $this->testimonialService->create($this->identity(), $this->request->getPost());

            if ($testimonial instanceof TestimonialInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a testimonial.');

                return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new testimonial.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing testimonial record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $testimonialId = (int) $this->params()->fromRoute('id', null);

        if (null === $testimonialId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $testimonial = $this->testimonialService->getTestimonial($testimonialId);

        if (!($testimonial instanceof TestimonialInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $form = $this->testimonialService->getEditTestimonialForm($testimonialId);

        if ($this->request->isPost()) {
            $testimonial = $this->testimonialService->edit($this->identity(), $this->request->getPost(), $testimonial);

            if ($testimonial instanceof TestimonialInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the testimonial.');

                return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the testimonial.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'testimonialId' => $testimonialId,
        ));
    }

    /**
     * Rank Up an existing testimonial record
     *
     * @return void
     */
    public function rankUpAction()
    {
        $testimonialId = (int) $this->params()->fromRoute('id', null);

        if (null === $testimonialId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $testimonial = $this->testimonialService->getTestimonial($testimonialId);

        if (!($testimonial instanceof TestimonialInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $testimonial = $this->testimonialService->rankUpTestimonial($this->identity(), $testimonial);

        if ($testimonial) {
            $this->flashMessenger()->setNamespace('success')
                ->addMessage('You have successfully ranked up the testimonial.');
        }

        return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
    }

    /**
     * Rank Down an existing testimonial record
     *
     * @return void
     */
    public function rankDownAction()
    {
        $testimonialId = (int) $this->params()->fromRoute('id', null);
     
        if (null === $testimonialId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $testimonial = $this->testimonialService->getTestimonial($testimonialId);

        if (!($testimonial instanceof TestimonialInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $testimonial = $this->testimonialService->rankDownTestimonial($this->identity(), $testimonial);

        if ($testimonial) {
            $this->flashMessenger()->setNamespace('success')
                ->addMessage('You have successfully ranked down the testimonial.');
        }

        return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
    }

    /**
     * Delete an existing testimonial record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $testimonialId = (int) $this->params()->fromRoute('id', null);

        if (null === $testimonialId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $testimonial = $this->testimonialService->getTestimonial($testimonialId);

        if (!($testimonial instanceof TestimonialInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
        }

        $this->testimonialService->delete($this->identity(), $testimonial);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the testimonial.');

        return $this->redirect()->toRoute('rocket-admin/lund/testimonial');
    }
}
