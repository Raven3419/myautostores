<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Changesets controller for LundProducts module
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\ChangesetDetailsVehiclesService;
use LundProducts\Options\LundProductsOptionsInterface;

class ChangesetsController extends AbstractActionController
{
    /**
     * @var \LundProducts\Service\ChangesetsService
     */
    protected $changesetService;

    /**
     * @var \LundProducts\Service\ChangesetDetailsService
     */
    protected $changesetDetailsService;

    /**
     * @var \LundProducts\Service\ChangesetDetailsVehiclesService
     */
    protected $changesetDetailsVehiclesService;

    /**
     * @var \LundProducts\Options\LundProductsOptionsInterface
     */
    protected $options;

    /**
     * @param \LundProducts\Service\ChangesetsService               $changesetService
     * @param \LundProducts\Service\ChangesetDetailsService         $changesetDetailsService
     * @param \LundProducts\Service\ChangesetDetailsVehiclesService $changesetDetailsVehiclesService
     * @param \LundProducts\Options\LundProductsOptionsInterface    $options
     */
    public function __construct(
        ChangesetsService               $changesetService,
        ChangesetDetailsService         $changesetDetailsService,
        ChangesetDetailsVehiclesService $changesetDetailsVehiclesService,
        LundProductsOptionsInterface    $options
    )
    {
        $this->changesetService                = $changesetService;
        $this->changesetDetailsService         = $changesetDetailsService;
        $this->changesetDetailsVehiclesService = $changesetDetailsVehiclesService;
        $this->options                         = $options;
    }

    /**
     * Display a table of Changesets
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->changesetService->getActiveChangesets(),
        ));
    }

    /**
     * View a single changeset record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        $record = $this->changesetService->getChangeset($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        $records = $this->changesetDetailsService->getChangesetDetailsByChangesetid($record->getChangesetId());

        if (null === $records) {
            $this->flashMessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        return new ViewModel(array(
            'record'   => $record,
            'records'  => $records,
            'recordId' => $recordId,
        ));
    }

    /**
     * View a single changeset details records vehicles
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewvehiclesAction()
    {
        $recordId = (int) $this->params()->fromRoute('changesetdetailid', null);

        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        $records = $this->changesetDetailsVehiclesService
                        ->getChangesetDetailsVehiclesByChangesetDetailsId($recordId);

        if (null === $records) {
            $this->flashMessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        return new ViewModel(array(
            'records'  => $records,
            'recordId' => $recordId,
        ));
    }

    /**
     * Changeset deploy action (approved == 1)
     */
    public function approveAction()
    {
        $changesetId = (INT)$this->params()->fromRoute('id', null);

        if (null === $changesetId) {
            $this->flashmessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect('rocket-admin/products/changesets');
        }

        $changeset_details = $this->changesetDetailsService->getChangesetDetailsByChangesetId($changesetId);

        if (null === $changeset_details) {
            $this->flashMessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        $changesetApprove = $this->changesetService->approveChangeset($this->identity(), $changeset_details);
        $this->flashMessenger()->setNamespace('success')
                               ->addMessage('You have successfully approved a changeset.');

        return $this->redirect()->toRoute('rocket-admin/products/changesets');
    }

    /**
     * Fire off ACES/PIES generation for specific changeset.
     */
    public function deployAction()
    {
        $changesetId = (INT)$this->params()->fromRoute('id', null);

        if (null === $changesetId) {
            $this->flashmessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        $changeset = $this->changesetService->getChangeset($changesetId);

        // if not approved, redirect
        if ($changeset->getApproved() == false) {
            $this->flashmessenger()->setNamespace('error')
                                   ->addMessage('You cannot deploy a changeset that has not been approved yet.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        if (null === $changeset) {
            $this->flashmessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        // deploy changeset
        $this->changesetService->deployChangeset($changeset);

        $this->flashMessenger()->setNamespace('success')
                               ->addMessage('You have successfully deployed a changeset.');

        return $this->redirect()->toRoute('rocket-admin/products/changesets');
    }

    /**
    * Deny changeset record
    */
    public function denyAction()
    {
        $changesetId = (INT)$this->params()->fromRoute('id', null);

        if (null === $changesetId) {
            $this->flashmessenger()->setNamespace('error')
                                   ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        $changeset = $this->changesetService->getChangeset($changesetId);

        if (null === $changeset) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/changesets');
        }

        $this->changesetService->denyChangeset($this->identity(), $changeset);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully denied the changeset.');

        return $this->redirect()->toRoute('rocket-admin/products/changesets');
    }
}
