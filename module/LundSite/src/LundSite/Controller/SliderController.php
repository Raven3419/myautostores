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
use LundSite\Service\SliderService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\SliderInterface;

/**
 * Sliders controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class SliderController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\SliderService
     */
    protected $sliderService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService              $siteService
     * @param SliderService $sliderService
     * @param HelperPluginManager      $viewHelperManager
     */
    public function __construct(
        SiteService $siteService,
        SliderService $sliderService,
        ViewHelperManager $viewHelperManager
    ) {
        $this->siteService       = $siteService;
        $this->sliderService       = $sliderService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of sliders
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        $max = $this->sliderService->getMaxPosition();

        return new ViewModel(array(
            'records' => $this->sliderService->getAllSliders(),
            'max'     => $max,
        ));
    }

    /**
     * View a single slider record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $sliderId = (int) $this->params()->fromRoute('id', null);

        if (null === $sliderId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $slider = $this->sliderService->getSlider($sliderId);

        if (!($slider instanceof SliderInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $form = $this->sliderService->getEditSliderForm($sliderId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $sliderId,
        ));
    }

    /**
     * Create a new slider record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->sliderService->getCreateSliderForm();

        if ($this->request->isPost()) {
            $slider = $this->sliderService->create($this->identity(), $this->request->getPost());

            if ($slider instanceof SliderInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a slider.');

                return $this->redirect()->toRoute('rocket-admin/lund/slider');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new slider.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing slider record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $sliderId = (int) $this->params()->fromRoute('id', null);

        if (null === $sliderId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $slider = $this->sliderService->getSlider($sliderId);

        if (!($slider instanceof SliderInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $form = $this->sliderService->getEditSliderForm($sliderId);

        if ($this->request->isPost()) {
            $slider = $this->sliderService->edit($this->identity(), $this->request->getPost(), $slider);

            if ($slider instanceof SliderInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the slider.');

                return $this->redirect()->toRoute('rocket-admin/lund/slider');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the slider.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'     => $form,
            'sliderId' => $sliderId,
        ));
    }

    /**
     * Rank Up an existing slider record
     *
     * @return void
     */
    public function rankUpAction()
    {
        $sliderId = (int) $this->params()->fromRoute('id', null);

        if (null === $sliderId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $slider = $this->sliderService->getSlider($sliderId);

        if (!($slider instanceof SliderInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $slider = $this->sliderService->rankUpSlider($this->identity(), $slider);

        if ($slider) {
            $this->flashMessenger()->setNamespace('success')
                ->addMessage('You have successfully ranked up the slider.');
        }

        return $this->redirect()->toRoute('rocket-admin/lund/slider');
    }

    /**
     * Rank Down an existing slider record
     *
     * @return void
     */
    public function rankDownAction()
    {
        $sliderId = (int) $this->params()->fromRoute('id', null);
     
        if (null === $sliderId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $slider = $this->sliderService->getSlider($sliderId);

        if (!($slider instanceof SliderInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $slider = $this->sliderService->rankDownSlider($this->identity(), $slider);

        if ($slider) {
            $this->flashMessenger()->setNamespace('success')
                ->addMessage('You have successfully ranked down the slider.');
        }

        return $this->redirect()->toRoute('rocket-admin/lund/slider');
    }

    /**
     * Delete an existing slider record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $sliderId = (int) $this->params()->fromRoute('id', null);

        if (null === $sliderId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $slider = $this->sliderService->getSlider($sliderId);

        if (!($slider instanceof SliderInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/slider');
        }

        $this->sliderService->delete($this->identity(), $slider);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the slider.');

        return $this->redirect()->toRoute('rocket-admin/lund/slider');
    }
}
