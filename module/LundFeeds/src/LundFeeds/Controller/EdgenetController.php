<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundFeeds\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;
use LundFeeds\Edgenet\EdgenetFactory;
use RocketDam\Service\AssetService;
use LundProducts\Service\FileLogService;
use LundProducts\Service\ChangesetsService;
use RocketAdmin\Service\AuditService;

/**
 * Edgenet file generation through CLI.
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class EdgenetController extends AbstractActionController
{
    /**
     * @var AssetService
     */
    protected $assetService;

    /**
     * @var FileLogService
     */
    protected $fileLogService;

    /**
     * @var AuditService
     */
    protected $auditService;

    /**
     * @var ChangesetsService
     */
    protected $changesetsService;

    /**
     * @param AssetService      $assetService
     * @param FileLogService    $fileLogService
     * @param AuditService      $auditService
     * @param ChangesetsService $changesetsService
     */
    public function __construct(
        AssetService   $assetService,
        FileLogService $fileLogService,
        AuditService   $auditService,
        ChangesetsService $changesetsService
    )
    {
        $this->assetService   = $assetService;
        $this->fileLogService = $fileLogService;
        $this->auditService   = $auditService;
        $this->changesetsService = $changesetsService;
    }

    /*
     * Generate Edgenet XML file with given version from CLI.
     * @return void
     */
    public function generateEdgenetAction()
    {
var_dump(date('Ymd H:i:s'));
        $version      = $this->getRequest()->getParam('version');
        $brand        = $this->getRequest()->getParam('brand');
        $generate     = $this->getRequest()->getParam('generate');
        $changeset_id = $this->getRequest()->getParam('changeset_id');

        $edgenet = EdgenetFactory::getEdgenet(
            $version,
            $this->getServiceLocator()->get('LundProducts\Service\PartService'),
            $this->getServiceLocator()->get('LundFeeds\Service\EdgenetService'),
            $this->getServiceLocator()->get('LundProducts\Service\ProductLineFeatureService'),
            $this->getServiceLocator()->get('LundProducts\Repository\BrandsRepository'),
            $this->getServiceLocator()->get('LundProducts\Service\ChangesetsService'),
            $this->getServiceLocator()->get('LundProducts\Service\ChangesetDetailsService'),
            $this->getServiceLocator()->get('LundProducts\Service\ChangesetDetailsVehiclesService'),
            $brand,
            $generate,
            $changeset_id
        );

        $filename = 'Edgenet_' . $version . '_' . strtolower(str_replace(' ', '', $brand)) . '_' . $generate . '_' . date('Ymdhis') . '.xml';

        // generate audit log entry BEFORE
        $this->auditService->create([
            'createdBy' => 'system',
            'object'    => 'LundFeeds',
            'action'    => 'Edgenet Generation',
            'summary'   => 'Starting Edgenet file generation for file \'' . $filename . '\'',
            'result'    => 'success',
        ]);

        $filepath = realpath(__DIR__ . '/../../../../../data/edgenet') . '/' . $filename;
        $filesave = $edgenet->saveXML($filepath);

     
        // move edgenet file to public dir
        shell_exec('cp ' . $filepath . ' ' . realpath(__DIR__ . '/../../../../../public/assets/library/products/edgenet') . '/' . $filename);

        // create asset
        $hashPath = 'library/products/edgenet/'.$filename;
        $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
        $hash = rtrim($hash, '.');
        $hash = 'l1_'.$hash;
        $asset = $this->assetService->saveFile('library/products/edgenet', $filename, ['mime'     => 'application/xml',
                                                                                    'size'     => filesize($filepath),
                                                                                    'ext'      => 'xml',
                                                                                    'filetype' => 'edgenet'], $hash);

        if ($changeset_id > 0) {
            $changesets = $this->changesetsService->getChangeset($changeset_id);
        } else {
            $changesets = null;
        }

        // create file_log
        $fileLog = $this->fileLogService->create(['brand' => $brand, // string,
                                                  'type'  => 'edgenet-' . $generate, // string,
                                                  'changesets' => $changesets,
                                                  'asset' => $asset, ]); // obj ref]);

        // generate audit log entry AFTER
        $this->auditService->create([
            'createdBy' => 'system',
            'object'    => 'LundFeeds',
            'action'    => 'Edgenet Generation',
            'summary'   => 'Finished Edgenet file generation for file \'' . $filename . '\'',
            'result'    => 'success',
        ]);
        var_dump(date('Ymd H:i:s'));
    }
}
