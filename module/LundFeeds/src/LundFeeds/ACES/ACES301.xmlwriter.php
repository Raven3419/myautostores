<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage ACES
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\ACES;

use LundProducts\Service\PartService;
use LundProducts\Repository\BrandsRepository;
use LundFeeds\Service\AcesService;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\ChangesetDetailsVehiclesService;
use XMLWriter;
use Exception;

class ACES301 implements AcesInterface
{
    /**
     * @var PartService
     */
    protected $partService = null;

    /**
     * @var AcesService
     */
    protected $acesService = null;

    /**
     * @var int
     */
    protected $recordCount = 0;

    /**
     * @var BrandsRepository
     */
    protected $brandsRepository = null;

    /**
     * @var ChangesetsService
     */
    protected $changesetsService = null;

    /**
     * @var ChangesetDetailsService
     */
    protected $changesetDetailsService = null;

    /**
     * @var ChangesetDetailsVehiclesService
     */
    protected $changesetDetailsVehiclesService = null;

    /**
     * @var string
     */
    protected $brand = null;

    /**
     * @var string
     */
    protected $lundonly = null;

    /**
     * @var string
     */
    protected $generate = null;

    /**
     * @var int
     */
    protected $changeset_id = null;

    /**
     * @param PartService                     $partService
     * @param AcesService                     $acesService
     * @param BrandsRepository                $brandsRepository
     * @param ChangesetsService               $changesetsService
     * @param ChangesetDetailsService         $changesetDetailsService
     * @param ChangesetDetailsVehiclesService $changesetDetaisVehiclesService
     * @param string                          $brand
     * @param string                          $generate
     * @param int                             $changeset_id
     */
    public function __construct(
        PartService      $partService = null,
        AcesService      $acesService = null,
        BrandsRepository $brandsRepository = null,
        ChangesetsService $changesetsService = null,
        ChangesetDetailsService $changesetDetailsService = null,
        ChangesetDetailsVehiclesService $changesetDetailsVehiclesService = null,
        $brand        = null,
        $generate     = null,
        $changeset_id = null)
    {
        $this->partService = $partService;
        $this->acesService = $acesService;
        $this->brandsRepository = $brandsRepository;
        $this->changesetsService = $changesetsService;
        $this->changesetDetailsService = $changesetDetailsService;
        $this->changesetDetailsVehiclesService = $changesetDetailsVehiclesService;

        if (null != $brand) {
            if ($brand == 'LUNDONLY') {
                $this->brand = $this->brandsRepository->findOneBy(['name' => 'LUND']);
                $this->lundonly = true;
            } else {
                $this->brand = $this->brandsRepository->findOneBy(['name' => trim(strtoupper($brand))]);
            }

            if (!$this->brand) {
                throw new Exception('Couldn\'t find brand \'' . $brand . '\'');
            }
        } else {
            $this->brand = null;
        }

        $this->generate = $generate;
        $this->changeset_id = $changeset_id;
    }

    /**
     * @param  string $location
     * @return void
     */
    public function saveXML($location = null)
    {
        $xmlWriter = new XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->setIndent(true);
        $xmlWriter->setIndentString('  ');
        $xmlWriter->startDocument('1.0', 'UTF-8');

        $xmlWriter->startElement('ACES');
        $xmlWriter->writeAttribute('version', '3.0.1');

        /* BEGIN HEADER */
        $xmlWriter->startElement('Header');
        $xmlWriter->writeElement('Company', 'Lund International');
        $xmlWriter->writeElement('SenderName', 'Jamie Drobik');
        $xmlWriter->writeElement('SenderPhone', '6788043786');
        $xmlWriter->writeElement('TrasnferDate', date('Y-m-d'));
        $xmlWriter->writeElement('BrandAAIAID', (null != $this->brand ? $this->brand->getAaiaid() : 'BLHW'));
        if (null != $this->brand) {
            if ($this->brand->getName() == 'LUND' && null == $this->lundonly) {
                $xmlWriter->writeElement('DocumentTitle', 'Lund International ACES LUND +NIFTY +DFS ALUM ' . date('Y-m-d'));
            } else {
                $xmlWriter->writeElement('DocumentTitle', 'Lund International ACES ' . $this->brand->getName() . ' ' . date('Y-m-d'));
            }
        } else {
            $xmlWriter->writeElement('DocumentTitle', 'Lund International ACES ' . date('Y-m-d'));
        }
        $xmlWriter->writeElement('EffectiveDate', date('Y-m-d'));
        $xmlWriter->writeElement('SubmissionType', ($this->generate == 'full' ? 'FULL' : 'NET'));
        $xmlWriter->writeElement('VcdbVersionDate', '2008-01-31');
        $xmlWriter->writeElement('QdbVersionDate', '2006-11-15');
        $xmlWriter->writeElement('PcdbVersionDate', '2007-12-18');
        $xmlWriter->endElement();
        /* END HEADER */

        /* BEGIN BODY */
        $partIdArray = array();
        $iterator = 1;

        if ($this->generate == 'incr' || isset($this->changeset_id)) {

        }

        if ($this->generate == 'full') {
            $records = $this->partService->getAcesParts($this->brand, $this->generate, null, $this->lundonly);

            foreach ($records as $record) {
                $vehicles = array();

                foreach ($record->getVehCollections() as $vehCollection) {
                    $vehColl = $vehCollection->getVehCollection();

                    $this_hash = (STRING)(($vehColl->getVehMake()) ? $vehColl->getVehMake()->getVehMakeId() : '') .
                        (($vehColl->getVehModel()) ? '-' . $vehColl->getVehModel()->getVehModelId() : '') .
                        (($vehColl->getVehSubmodel()) ? '-' . $vehColl->getVehSubmodel()->getVehSubmodelId() : '');

                    $vehicles[$this_hash]['years'][]           = $vehColl->getVehYear()->getName();
                    $vehicles[$this_hash]['make_id']           = $vehColl->getMakeId();
                    $vehicles[$this_hash]['model_id']          = $vehColl->getModelId();
                    $vehicles[$this_hash]['submodel_id']       = $vehColl->getSubmodelId();
                    $vehicles[$this_hash]['body_type_id']      = $vehColl->getBodyTypeId();
                    $vehicles[$this_hash]['body_num_doors_id'] = $vehColl->getBodyNumDoorsId();
                    $vehicles[$this_hash]['bed_type_id']       = $vehColl->getBedTypeId();

                    $partVehicleCollection = $this->changesetsService->getPartVehicleCollection(
                        $record->getPartId(),
                        $vehCollection->getVehCollection()->getVehCollectionId());

                    if (null != $partVehicleCollection) {
                        if (is_array($partVehicleCollection)) {
                            $partVehicleCollection = $partVehicleCollection[0];
                        }

                        $vehicles[$this_hash]['subdetail'] = $partVehicleCollection->getSubdetail();

                        if ($vehColl->getBodyType()) {
                            $vehicles[$this_hash]['subdetail'] .= '; ' . $vehColl->getBodyType();
                        }
                    } else {
                        if ($vehColl->getBodyType()) {
                            $vehicles[$this_hash]['subdetail'] = $vehColl->getBodyType();
                        } else {
                            $vehicles[$this_hash]['subdetail'] = null;
                        }
                    }
                }

                foreach ($vehicles as $vehicle) {
                    $years = [];

                    // generate to/from years
                    foreach ($vehicle['years'] as $year) {
                        $years[] = $year;
                    }

                    $from_year = min($years);
                    $to_year   = max($years);

                    $xmlWriter->startElement('App');
                    $xmlWriter->writeAttribute('action', 'A');
                    $xmlWriter->writeAttribute('id', $iterator);

                    $xmlWriter->startElement('Years');
                    $xmlWriter->writeAttribute('from', (STRING)$from_year);
                    $xmlWriter->writeAttribute('to', (STRING)$to_year);
                    $xmlWriter->endElement();

                    if (!in_array(trim($vehicle['make_id']), array('', '0'))) {
                        $xmlWriter->startElement('Make');
                        $xmlWriter->writeAttribute('id', $vehicle['make_id']);
                        $xmlWriter->endElement();
                    }

                    if (!in_array(trim($vehicle['model_id']), array('', '0'))) {
                        $xmlWriter->startElement('Model');
                        $xmlWriter->writeAttribute('id', $vehicle['model_id']);
                        $xmlWriter->endElement();
                    }

                    if (!in_array(trim($vehicle['submodel_id']), array('', '0'))) {
                        $xmlWriter->startElement('SubModel');
                        $xmlWriter->writeAttribute('id', $vehicle['submodel_id']);
                        $xmlWriter->endElement();
                    }

                    if (!in_array(trim($vehicle['body_type_id']), array('', '0'))) {
                        $xmlWriter->startElement('BodyType');
                        $xmlWriter->writeAttribute('id', $vehicle['body_type_id']);
                        $xmlWriter->endElement();
                    }

                    $note = $record->getProductLine()->getName();
                    $note .= '; ' . $record->getProductLine()->getProductCategory()->getName();
                    $note .= ((null != $record->getColor()) ? '; ' . $record->getColor() : '');
                    $note .= ($vehicle['subdetail'] ? '; ' . $vehicle['subdetail'] : '');

                    $note = preg_replace('/&/', 'and', $note);

                    $xmlWriter->writeElement('Note', $note);
                    $xmlWriter->writeElement('Qty', '1');

                    if (!in_array(trim($record->getPartTypeId()), array('', '0'))) {
                        $xmlWriter->startElement('PartType');
                        $xmlWriter->writeAttribute('id', $record->getPartTypeId());
                        $xmlWriter->endElement();
                    }

                    if (!in_array(trim($vehicle['body_num_doors_id']), array('', '0'))) {
                        $xmlWriter->startElement('BodyNumDoors');
                        $xmlWriter->writeAttribute('id', $vehicle['body_num_doors_id']);
                        $xmlWriter->endElement();
                    }

                    if (!in_array(trim($vehicle['bed_type_id']), array('', '0'))) {
                        $xmlWriter->startElement('BedType');
                        $xmlWriter->writeAttribute('id', $vehicle['bed_type_id']);
                        $xmlWriter->endElement();
                    }

                    $xmlWriter->writeElement('Part', $record->getPartNumber());

                    $xmlWriter->endElement();

                    $iterator++;
                    $this->recordCount++;

                    if (0 == $iterator%50) {
                        file_put_contents($location, $xmlWriter->flush(true), FILE_APPEND);
                    }
                }
            }
        }
        /* END BODY */        

        /* BEGIN FOOTER */
        $xmlWriter->startElement('Footer');
        $xmlWriter->writeElement('RecordCount', $this->recordCount);
        $xmlWriter->endElement();
        /* END FOOTER */

        $xmlWriter->endElement();

        file_put_contents($location, $xmlWriter->flush(true), FILE_APPEND); 
    }
}
