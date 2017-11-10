<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Service;

use Zend\EventManager\Eventmanager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Log\Logger;
use RocketUser\Repository\UserRepositoryInterface;
use RocketUser\Entity\RbacRole;
use RocketAdmin\Service\MessageService;
use Doctrine\Common\Persistence\ObjectManager;
use PDO;
use DateTime;
use Zend\Mail;

class ParseSupplementService implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /*
     * @var PDO
     */
    protected $connection = null;

    /*
     * @var Logger
     */
    protected $logger = null;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var MessageService
     */
    protected $messageService;

    /*
     * @param ObjectManager           $objectManager
     * @param PDO                     $connection
     * @param Logger                  $logger
     * @param UserRepositoryInterface $userRepository
     * @param MessageService          $messageService
     */
    public function __construct(
        ObjectManager           $objectManager,
        PDO                     $connection,
        Logger                  $logger,
        UserRepositoryInterface $userRepository,
        MessageService          $messageService
    )
    {
        $this->objectManager  = $objectManager;
        $this->connection     = $connection;
        $this->logger         = $logger;
        $this->userRepository = $userRepository;
        $this->messageService = $messageService;
    }

    /**
     * @param string $role_name
     * @param string $title
     * @param string $notification
     */
    public function createMessageForRole($role_name, $title, $notification)
    {
        // find role by name
        $role = $this->objectManager->getRepository('RocketUser\Entity\RbacRole')->findBy(['roleName' => $role_name]);

        // find all users with role_id
        $users = $this->userRepository->findBy(['role' => $role]);

        // iterate through all users by role
        foreach ($users as $user) {
            $message = clone $this->messageService->getMessagePrototype();

            $message->setCreatedAt(new DateTime('now'))
                ->setCreatedBy('system')
                ->setDeleted(false)
                ->setDisabled(false)
                ->setHasRead(false)
                ->setUser($user)
                // info, important, warning
                ->setClassification('info')
                ->setTitle($title)
                ->setNotification($notification);

            $this->objectManager->persist($message);
            $this->objectManager->flush();
            
        }

            $mail = new Mail\Message();
            $mail->setBody($notification);
            $mail->setFrom('rsampson@thesmartdata.com');
            $mail->addTo('webit@thesmartdata.com');
            // TODO: switch to user email
            //$mail->addTo($user->getEmailAddress());
            $mail->setSubject($title);
            $transport = new Mail\Transport\Sendmail();
            $transport->send($mail);
        
    }

    /*
     * @param string $created_at
     * @param string $created_by
     * @param string $modified_at
     * @param string $modified_by
     * @param int    $deleted
     * @param int    $disabled
     * @param string $uploaded_at
     * @param string $summary
     * @param string $upload_location
     *
     * @return []
     */
    public function createChangeset($created_at = null, $created_by = null, $modified_at = null, $modified_by = null, $deleted = 0,
                                    $disabled = 0, $uploaded_at = null, $summary = null, $upload_location = null)
    {
        if (null == $created_at) {
            $created_at = date('Y-m-d H:i:s');
        }

        if (null == $deleted) {
            $deleted = 0;
        }

        if (null == $disabled) {
            $disabled = 0;
        }

        $approved = 0;
        $deployed = 0;

        $return = array(
            'changeset_id'    => null,
            'created_at'      => $created_at,
            'created_by'      => $created_by,
            'modified_at'     => $modified_at,
            'modified_by'     => $modified_by,
            'deleted'         => $deleted,
            'disabled'        => $disabled,
            'approved'        => $approved,
            'deployed'        => $deployed,
            'uploaded_at'     => $uploaded_at,
            'summary'         => $summary,
            'upload_location' => $upload_location
        );

        $changeset = $this->prepare('INSERT INTO changesets (created_at, created_by, modified_at, modified_by, deleted, disabled, approved, deployed, uploaded_at, summary, upload_location)
                                     VALUES (:created_at, :created_by, :modified_at, :modified_by, :deleted, :disabled, :approved, :deployed, :uploaded_at, :summary, :upload_location)');

        $changeset->bindParam(':created_at', $return['created_at']);
        $changeset->bindParam(':created_by', $return['created_by']);
        $changeset->bindParam(':modified_at', $return['modified_at']);
        $changeset->bindParam(':modified_by', $return['modified_by']);
        $changeset->bindParam(':deleted', $return['deleted']);
        $changeset->bindParam(':disabled', $return['disabled']);
        $changeset->bindParam(':approved', $return['approved']);
        $changeset->bindParam(':deployed', $return['deployed']);
        $changeset->bindParam(':uploaded_at', $return['uploaded_at']);
        $changeset->bindParam(':summary', $return['summary']);
        $changeset->bindParam(':upload_location', $return['upload_location']);
        $changeset->execute();

        $return['changeset_id'] = $this->lastInsertId();

        return $return;
    }

    /**
     * Create changeset_details_vehicles record.
     *
     * @param array $vehicle_record
     *
     * @return null|array
     */
    public function createChangesetDetailsVehicle($vehicle_record = null)
    {
        if ((null == $vehicle_record) || (!is_array($vehicle_record))) {
            return null;
        }

        $vehicle = $this->prepare('INSERT INTO changeset_details_vehicles
                                   (veh_collection_id, veh_make_id, veh_model_id, veh_submodel_id, veh_year_id, veh_class_id, changeset_detail_id,
                                    veh_make_label, veh_model_label, veh_submodel_label, veh_year_label, veh_class_label)
                                   VALUES
                                   (:veh_collection_id, :veh_make_id, :veh_model_id, :veh_submodel_id, :veh_year_id, :veh_class_id, :changeset_detail_id,
                                    :veh_make_label, :veh_model_label, :veh_submodel_label, :veh_year_label, :veh_class_label)');

        $vehicle->bindParam('veh_collection_id', $vehicle_record['veh_collection_id']);
        $vehicle->bindParam('veh_make_id', $vehicle_record['veh_make_id']);
        $vehicle->bindParam('veh_model_id', $vehicle_record['veh_model_id']);
        $vehicle->bindParam('veh_submodel_id', $vehicle_record['veh_submodel_id']);
        $vehicle->bindParam('veh_year_id', $vehicle_record['veh_year_id']);
        $vehicle->bindParam('veh_class_id', $vehicle_record['veh_class_id']);
        $vehicle->bindParam('changeset_detail_id', $vehicle_record['changeset_detail_id']);
        $vehicle->bindParam('veh_make_label', $vehicle_record['veh_make_label']);
        $vehicle->bindParam('veh_model_label', $vehicle_record['veh_model_label']);
        $vehicle->bindParam('veh_submodel_label', $vehicle_record['veh_submodel_label']);
        $vehicle->bindParam('veh_year_label', $vehicle_record['veh_year_label']);
        $vehicle->bindParam('veh_class_label', $vehicle_record['veh_class_label']);
        $vehicle->execute();

        $vehicle_record['changeset_details_vehicle_id'] = $this->lastInsertId();

        return $vehicle_record;
    }

    /**
     * Create changeset_details record.
     *
     * @param array $detail_record
     *
     * @return null|array
     */
    public function createChangesetDetail($detail_record = null)
    {
        if ((null == $detail_record) || (!is_array($detail_record))) {
            return null;
        }

        $detail = $this->prepare('INSERT INTO changeset_details
                                   (part_id, brand_id, product_category_id, product_line_id, changeset_id,
                                    part_number, brand_label, product_category_label, product_line_label, `change`,
                                    app_changed, status_changed, country_changed, pop_changed, color_changed, dims_changed,
                                    class_changed, image_changed, change_file_row, year_changed)
                                  VALUES
                                   (:part_id, :brand_id, :product_category_id, :product_line_id, :changeset_id,
                                    :part_number, :brand_label, :product_category_label, :product_line_label, :change,
                                    :app_changed, :status_changed, :country_changed, :pop_changed, :color_changed,
                                    :dims_changed, :class_changed, :image_changed, :change_file_row, :year_changed)');

        $detail->bindParam('part_id', $detail_record['part_id']);
        $detail->bindParam('brand_id', $detail_record['brand_id']);
        $detail->bindParam('product_category_id', $detail_record['product_category_id']);
        $detail->bindParam('product_line_id', $detail_record['product_line_id']);
        $detail->bindParam('changeset_id', $detail_record['changeset_id']);
        $detail->bindParam('part_number', $detail_record['part_number']);
        $detail->bindParam('brand_label', $detail_record['brand_label']);
        $detail->bindParam('product_category_label', $detail_record['product_category_label']);
        $detail->bindParam('product_line_label', $detail_record['product_line_label']);
        $detail->bindParam('change', $detail_record['change']);
        $detail->bindParam('app_changed', $detail_record['app_changed']);
        $detail->bindParam('status_changed', $detail_record['status_changed']);
        $detail->bindParam('country_changed', $detail_record['country_changed']);
        $detail->bindParam('pop_changed', $detail_record['pop_changed']);
        $detail->bindParam('color_changed', $detail_record['color_changed']);
        $detail->bindParam('dims_changed', $detail_record['dims_changed']);
        $detail->bindParam('class_changed', $detail_record['class_changed']);
        $detail->bindParam('image_changed', $detail_record['image_changed']);
        $detail->bindParam('change_file_row', $detail_record['change_file_row']);
        $detail->bindParam('year_changed', $detail_record['year_changed']);
        $detail->execute();
        

        $detail_record['changeset_detail_id'] = $this->lastInsertId();

        return $detail_record;
    }

    /*
     * Find product line.
     *
     * @param string $short_code
     *
     * @return array
     */
    public function findProductLine($short_code = null)
    {
        $foundProductLine = $this->prepare('SELECT * FROM product_lines
                                            WHERE short_code = ' . $this->quote($short_code) . ' LIMIT 1');

        $foundProductLine->execute();
        $return = $foundProductLine->fetch(PDO::FETCH_ASSOC);

        return $return;
    }

    /*
     * Find product category by short code.
     *
     * @param string $product_category
     *
     * @return array
     */
    public function findProductCategory($product_category = null)
    {
        $foundProductCategory = $this->prepare('SELECT * FROM product_categories
                                                WHERE short_code = ' . $this->quote($product_category) . ' LIMIT 1');

        $foundProductCategory->execute();

        $return = $foundProductCategory->fetch(PDO::FETCH_ASSOC);

        return $return;
    }

    /*
     * Find part.
     *
     * @param string $part_number
     *
     * @return array
     */
    public function findPart($part_number = null)
    {
        $foundPart = $this->prepare('SELECT * FROM parts
                                     WHERE part_number = ' . $this->quote($part_number) . ' LIMIT 1');
        $foundPart->execute();
        $return = $foundPart->fetch(PDO::FETCH_ASSOC);

        return $return;
    }

    /**
     * Find veh_collection record.
     *
     * @param string $veh_make_id
     * @param string $veh_model_id
     * @param string $veh_submodel_id
     * @param string $veh_year_id
     * @param string $body_type
     *
     * @return array|null
     */
    public function findVehCollection($veh_make_id = null, $veh_model_id = null, $veh_submodel_id = null, $veh_year_id = null, $body_type = null)
    {
        if ((null == $veh_make_id) || (null == $veh_model_id) || (null == $veh_year_id)) {
            return null;
        }

        if (null == $veh_submodel_id) {
            $submodel = 'IS NULL';
        } else {
            $submodel = '= ' . $this->quote($veh_submodel_id) . '';
        }

        $foundVehCollection = $this->prepare('SELECT * FROM veh_collection
                                              WHERE veh_make_id = ' . $this->quote($veh_make_id) . '
                                              AND   veh_model_id = ' . $this->quote($veh_model_id) . '
                                              ' . ((null != $body_type) ? ' AND body_type = "' . $body_type . '"' : '') . '
                                              AND   veh_submodel_id ' . $submodel . '
                                              AND   veh_year_id = ' . $this->quote($veh_year_id) . '
                                              LIMIT 1');

        $foundVehCollection->execute();
        $return = $foundVehCollection->fetch(PDO::FETCH_ASSOC);

        return $return;
    }

    /**
     * Update changeset summary after changeset processing.
     *
     * @param string $changeset_id
     * @param string $summary
     *
     * @return null|true|false
     */
    public function updateChangesetSummary($changeset_id = null, $summary = null)
    {
        if ((null == $changeset_id) || (null == $summary)) {
            return null;
        }

        $updateChangeset = $this->prepare('UPDATE changesets
                                           SET summary = ' . $this->quote($summary) . '
                                           WHERE changeset_id = ' . $this->quote((INT)$changeset_id));

        $updateChangeset->execute();

        return $updateChangeset;
    }

    /**
     * Update changeset asset_id after changeset processing.
     *
     * @param string $changeset_id
     * @param string $asset_id
     *
     * @return null|true|false
     */
    public function updateChangesetAsset($changeset_id = null, $asset_id = null)
    {
        if ((null == $changeset_id) || (null == $asset_id)) {
            return null;
        }

        $updateChangeset = $this->prepare('UPDATE changesets
                                           SET asset_id = ' . $this->quote((INT)$asset_id) . '
                                           WHERE changeset_id = ' . $this->quote((INT)$changeset_id));

        $updateChangeset->execute();

        return $updateChangeset;
    }

    /*
     * Proxy method to PDO->beginTransaction()
     */
    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    /*
     * Proxy method to PDO->rollBack()
     */
    public function rollBack()
    {
        $this->connection->rollBack();
    }

    /*
     * Proxy method to PDO->commit()
     */
    public function commit()
    {
        $this->connection->commit();
    }

    /*
     * @param  string $sql
     * @return PDO
     */
    private function prepare($sql = null)
    {
        return $this->connection->prepare($sql);
    }

    /*
     * @param  string $quote
     * @return PDO
     */
    private function quote($quote = null)
    {
        return $this->connection->quote($quote);
    }

    /*
     * @return int
     */
    private function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /*
     * @return PDO
     */
    private function getPDOConnection()
    {
        return $this->connection;
    }

    /*
     * @return \Zend\Log\Logger
     */
    private function getLogger()
    {
        return $this->logger;
    }

    /**
     * setEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::setEventManager()
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__, get_class($this)));

        $this->eventManager = $eventManager;
    }

    /**
     * getEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::getEventManager()
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }

        return $this->eventManager;
    }
}
