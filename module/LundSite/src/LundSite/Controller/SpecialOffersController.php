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
use LundSite\Service\SpecialOffersService;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\SpecialOffersInterface;

/**
 * SpecialOffers controller for admin module
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class SpecialOffersController extends AbstractActionController
{
    /**
     * @var \RocketCms\Service\SiteService
     */
    protected $siteService;

    /**
     * @var \LundSite\Service\SpecialOffersService
     */
    protected $specialOffersService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param SiteService         	$siteService
     * @param SpecialOffersService  $specialOffersService
     * @param HelperPluginManager 	$viewHelperManager
     */
    public function __construct(
        SiteService 			$siteService,
        SpecialOffersService 	$specialOffersService,
        ViewHelperManager 		$viewHelperManager
    ) {
        $this->siteService       		= $siteService;
        $this->specialOffersService  	= $specialOffersService;
        $this->viewHelperManager 		= $viewHelperManager;
    }

    /**
     * Display a table of specialOffers
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->specialOffersService->getActiveSpecialOffers(),
        ));
    }

    /**
     * View a single specialOffers record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $specialOffersId = (int) $this->params()->fromRoute('id', null);

        if (null === $specialOffersId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/special-offers');
        }

        $specialOffers = $this->specialOffersService->getSpecialOffers($specialOffersId);

        if (!($specialOffers instanceof SpecialOffersInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/special-offers');
        }

        $form = $this->specialOffersService->getEditSpecialOffersForm($specialOffersId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $specialOffersId,
        ));
    }

    /**
     * Create a new specialOffers record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->specialOffersService->getCreateSpecialOffersForm();

        if ($this->request->isPost()) {
            $specialOffers = $this->specialOffersService->create($this->identity(), $this->request->getPost());

            if ($specialOffers instanceof SpecialOffersInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a special offers.');

                return $this->redirect()->toRoute('rocket-admin/lund/special-offers');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new special offers.');

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
            ->appendScript("$(function () {CKEDITOR.replace('special-offers-fieldset[html]');});", 'text/javascript');

        return new ViewModel(array(
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing specialOffers record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $specialOffersId = (int) $this->params()->fromRoute('id', null);

        if (null === $specialOffersId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/special-offers');
        }

        $specialOffers = $this->specialOffersService->getSpecialOffers($specialOffersId);

        if (!($specialOffers instanceof SpecialOffersInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/special-offers');
        }

        $form = $this->specialOffersService->getEditSpecialOffersForm($specialOffersId);

        if ($this->request->isPost()) {
            $specialOffers = $this->specialOffersService->edit($this->identity(), $this->request->getPost(), $specialOffers);

            if ($specialOffers instanceof SpecialOffersInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the special offers.');

                return $this->redirect()->toRoute('rocket-admin/lund/special-offers');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the special offers.');

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
            ->appendScript("$(function () {CKEDITOR.replace('special-offers-fieldset[html]');});", 'text/javascript');

        return new ViewModel(array(
            'form'     => $form,
            'specialOffersId' => $specialOffersId,
        ));
    }

    /**
     * Delete an existing specialOffers record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $specialOffersId = (int) $this->params()->fromRoute('id', null);

        if (null === $specialOffersId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/special-offers');
        }

        $specialOffers = $this->specialOffersService->getSpecialOffers($specialOffersId);

        if (!($specialOffers instanceof SpecialOffersInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/lund/special-offers');
        }

        $this->specialOffersService->delete($this->identity(), $specialOffers);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the special offers.');

        return $this->redirect()->toRoute('rocket-admin/lund/special-offers');
    }
}
