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
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\ChangesetDetails;
use LundProducts\Repository\ChangesetDetailsRepositoryInterface;
use RocketUser\Entity\User;
use DateTime;

/*
 * Service managing the CRUD of changeset details.
 */
class ChangesetDetailsService implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @param $objectManager
     * @param $repository
     */
    public function __construct(ObjectManager $objectManager, ChangesetDetailsRepositoryInterface $repository)
    {
        $this->objectManager = $objectManager;
        $this->repository    = $repository;
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getChangesetDetails($recordId)
    {
        return $this->repository->find($recordId);
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getChangesetDetailsByChangesetId($recordId)
    {
        return $this->repository->findBy(array(
            'changesets' => $recordId
        ));
    }

    /**
     * @param \LundProducts\Entity\ChangesetDetails $recordEntity
     * @param \RocketUser\Entity\User               $usersEntity
     *
     * @return \LundProducts\Entity\ChangesetDetails $recordEntity
     */
    public function createChangesetDetails(ChangesetDetails $recordEntity, User $usersEntity)
    {
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        //$this->flushCache();
        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\ChangesetDetails $recordEntity
     * @param \RocketUser\Entity\User               $usersEntity
     *
     * @return \LundProducts\Entity\ChangesetDetails $recordEntity
     */
    public function editChangesetDetails(ChangesetDetails $recordEntity, User $usersEntity)
    {
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        //$this->flushCache();
        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\ChangesetDetails $recordEntity
     * @param \RocketUser\Entity\User               $usersEntity
     *
     * @return \LundProducts\Entity\ChangesetDetails $recordEntity
     */
    public function deleteChangesetDetails(ChangesetDetails $recordEntity, User $usersEntity)
    {
        //$recordEntity->setModifiedAt(new DateTime('now'))
        //             ->setModifiedBy($usersEntity->getUsername())
        //             ->setDeleted(true)
        //             ->setDisabled(true);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        //$this->flushCache();
        return $recordEntity;
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
