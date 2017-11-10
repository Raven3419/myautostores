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
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\FileLog;
use LundProducts\Entity\FileLogInterface;
use LundProducts\Repository\FileLogRepositoryInterface;
use RocketUser\Entity\User;
use DateTime;
use LundProducts\Entity\ChangesetsInterface;

/*
 * Service managing the the file_log table.
 */
class FileLogService implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var FileLogInterface
     */
    protected $fileLogPrototype;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var FileLogRepositoryInterface
     */
    protected $fileLogRepository;

    /**
     * @param ObjectManager              $objectManager
     * @param FileLogRepositoryInterface $fileLogRepository
     */
    public function __construct(
        ObjectManager              $objectManager,
        FileLogRepositoryInterface $fileLogRepository
    )
    {
        $this->objectManager     = $objectManager;
        $this->fileLogRepository = $fileLogRepository;
    }

    /**
     * @return null|FileLogInterface
     */
    public function getActiveFileLogs()
    {
        return $this->fileLogRepository->findBy(
            array(),
            array(
                'fileLogId' => 'DESC',
            )
        );
    }

    /**
     * @param string $brand
     * @param string $type
     *
     * @return null|FileLogInterface
     */
    public function getFileLog($brand = null, $type = null)
    {
        if ($type == 'master') {
            return $this->fileLogRepository->findOneBy(
                array(
                    'type' => 'master',
                ),
                array(
                    'fileLogId' => 'DESC',
                )
            );
        } else {
            return $this->fileLogRepository->findOneBy(
                array(
                    'brand' => $brand,
                    'type' => $type,
                ),
                array(
                    'fileLogId' => 'DESC',
                )
            );
        }
    }

    /**
     * Return list of file log records based on changeset id
     *
     * @param  ChangesetsInterface   $changeset
     * @return FileLogInterface|null
     */
    public function getFileLogByChangeset(ChangesetsInterface $changeset)
    {
        return $this->fileLogRepository->findBy(
            array(
                'changesets' => $changeset->getChangesetId(),
            ),
            array(
                'fileLogId' => 'ASC',
            )
        );
    }

    /**
     * Creates a new FileLog.
     *
     * @param  array                              $data
     * @throws Exception\UnexpectedValueException
     * @return null|FileLogInterface
     */
    public function create($data)
    {
        $fileLog = clone $this->getFileLogPrototype();

        if (!$fileLog instanceof FileLogInterface) {
            throw Exception\UnexpectedValueException::invalidFileLogEntity($fileLog);
        }

        $fileLog->setCreatedAt(new DateTime('now'))
                ->setBrand($data['brand'])
                ->setType($data['type'])
                ->setChangesets($data['changesets'])
                ->setAsset($data['asset']);

        $this->objectManager->persist($fileLog);
        $this->objectManager->flush();

        return $fileLog;
    }

    /**
     * @return FileLogInterface
     */
    public function getFileLogPrototype()
    {
        if ($this->fileLogPrototype === null) {
            $this->setFileLogPrototype(new FileLog());
        }

        return $this->fileLogPrototype;
    }

    /**
     * @param  FileLogInterface $fileLogPrototype
     * @return FileLogService
     */
    public function setFileLogPrototype(FileLogInterface $fileLogPrototype)
    {
        $this->fileLogPrototype = $fileLogPrototype;

        return $this;
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
