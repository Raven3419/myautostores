<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * This source file is part of Commander.
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundCustomer\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\HelperPluginManager as ViewHelperManager;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use LundCustomer\Service\RetailerService;
use LundCustomer\Entity\RetailerInterface;
use LundCustomer\Options\LundCustomerOptionsInterface;

/**
 * Retailers controller for admin module
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class RetailerController extends AbstractActionController
{
    /**
     * @var \LundCustomer\Service\RetailerService
     */
    protected $retailerService;

    /**
     * @var \LundCustomer\Option\LundCustomerOptions
     */
    protected $options;

    /**
     * @var HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param RetailerService              $retailerService
     * @param LundCustomerOptionsInterface $options
     * @param HelperPluginManager          $viewHelperManager
     */
    public function __construct(
        RetailerService $retailerService,
        LundCustomerOptionsInterface $options,
        ViewHelperManager $viewHelperManager
    ) {
        $this->retailerService = $retailerService;
        $this->options         = $options;
        $this->viewHelperManager      = $viewHelperManager;
    }

    /**
     * Display a table of retailers
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $records = $this->retailerService->getRetailerListings($this, (INT)$this->params()->fromQuery('iDisplayLength'),
                (INT)$this->params()->fromQuery('iDisplayStart'),
                (INT)$this->params()->fromQuery('sEcho'),
                (INT)$this->params()->fromQuery('iSortingCols'),
                (STRING)$this->params()->fromQuery('sSearch'));

            return new JsonModel($records);
        }

        return new ViewModel();
    }

    /**
     * View a single retailer record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $retailerId = (int) $this->params()->fromRoute('id', null);

        if (null === $retailerId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/retailer');
        }

        $retailer = $this->retailerService->getRetailer($retailerId);

        if (!($retailer instanceof RetailerInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/retailer');
        }

        $form = $this->retailerService->getEditRetailerForm($retailerId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $retailerId,
            'retailer' => $retailer,
        ));
    }

    /**
     * Create a new retailer record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->retailerService->getCreateRetailerForm();

        if ($this->request->isPost()) {
            $retailer = $this->retailerService->create($this->identity(), $this->request->getPost());

            if ($retailer instanceof RetailerInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a retailer.');

                return $this->redirect()->toRoute('rocket-admin/accounts/retailer');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new retailer.');

                $form->setData($this->request->getPost());
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
            ->offsetSetFile(200, $base . '/assets/rocket-admin/js/plugins/elfinder/jquery.elfinder.js');
        $this->viewHelperManager->get('HeadLink')
            ->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css')
            ->appendStylesheet($base . '/assets/rocket-admin/css/adm.elfinder.css')
            ->appendStylesheet($base . '/assets/rocket-admin/css/adm.elfinder.theme.css');

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    /**
     * Edit an existing retailer record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $retailerId = (int) $this->params()->fromRoute('id', null);

        if (null === $retailerId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/retailer');
        }

        $retailer = $this->retailerService->getRetailer($retailerId);

        if (!($retailer instanceof RetailerInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/retailer');
        }

        $form = $this->retailerService->getEditRetailerForm($retailerId);

        if ($this->request->isPost()) {
            $retailer = $this->retailerService->edit($this->identity(), $this->request->getPost(), $retailer);

            if ($retailer instanceof RetailerInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the retailer.');

                return $this->redirect()->toRoute('rocket-admin/accounts/retailer');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the retailer.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
            'retailerId' => $retailerId,
        ));
    }

    /**
     * Delete an existing retailer record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $retailerId = (int) $this->params()->fromRoute('id', null);

        if (null === $retailerId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/retailer');
        }

        $retailer = $this->retailerService->getRetailer($retailerId);

        if (!($retailer instanceof RetailerInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/retailer');
        }

        $this->retailerService->delete($this->identity(), $retailer);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the retailer.');

        return $this->redirect()->toRoute('rocket-admin/accounts/retailer');
    }
}
