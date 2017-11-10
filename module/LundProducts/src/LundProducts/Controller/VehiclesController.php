<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
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
use Zend\View\HelperPluginManager as ViewHelperManager;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use LundProducts\Controller\Options;
use LundProducts\Service\VehCollectionService;
use RocketAdmin\Service\MessageService;

/**
 * Vehicles controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class VehiclesController extends AbstractActionController
{
    /**
     * @var VehCollectionService
     */
    protected $vehCollectionService;

    /**
     * @param VehCollectionService $vehCollectionService
     */
    public function __construct(VehCollectionService $vehCollectionService)
    {
        $this->vehCollectionService = $vehCollectionService;
    }

    /**
     * Display a table of vehicles
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $records = $this->vehCollectionService->getVehCollectionListings($this, (INT)$this->params()->fromQuery('iDisplayLength'),
                                                                                    (INT)$this->params()->fromQuery('iDisplayStart'),
                                                                                    (INT)$this->params()->fromQuery('sEcho'),
                                                                                    (INT)$this->params()->fromQuery('iSortingCols'),
                                                                                    (STRING)$this->params()->fromQuery('sSearch'));

            return new JsonModel($records);
        }

        return new ViewModel();
    }

    /**
     * Display a table of parts associated with chosen vehicle
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function partsAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/vehicles');
        }

        $record = $this->vehCollectionService->getVehCollection($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/vehicles');
        }

        return new ViewModel(array(
            'record'   => $record,
            'recordId' => $recordId,
        ));
    }
}
