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

use RocketUser\Entity\UserInterface;
use LundProducts\Entity\PartAsset;
use LundProducts\Entity\PartAssetInterface;
use LundProducts\Entity\PartsInterface;
use RocketDam\Entity\AssetInterface;
use LundProducts\Repository\PartAssetRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use LundProducts\Repository\PartsRepositoryInterface;
use RocketDam\Repository\AssetRepositoryInterface;
use LundProducts\Form\PartAssetForm;
use LundProducts\Options\LundProductsOptionsInterface;
use LundProducts\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;

/**
 * Service managing the management of part assets.
 */
class PartAssetService implements EventManagerAwareInterface
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
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var PartAssetRepositoryInterface
     */
    protected $partAssetRepository;

    /**
     * @var PartsRepositoryInterface
     */
    protected $partsRepository;

    /**
     * @var AssetRepositoryInterface
     */
    protected $assetRepository;

    /**
     * @var PartAssetForm
     */
    protected $partAssetForm;

    /**
     * @var LundProductsOptionsInterface
     */
    protected $options;

    /**
     * @var PartAssetInterface
     */
    protected $partAssetPrototype;

    /**
     * @param ObjectManager                $objectManager
     * @param UserRepositoryInterface      $userRepository
     * @param PartAssetRepositoryInterface $partAssetRepository
     * @param PartsRepositoryInterface     $partsRepository
     * @param AssetRepositoryInterface     $assetRepository
     * @param FormInterface                $partAssetForm
     * @param LundProductsOptionsInterface $options
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        PartAssetRepositoryInterface $partAssetRepository,
        PartsRepositoryInterface $partsRepository,
        AssetRepositoryInterface $assetRepository,
        FormInterface $partAssetForm,
        LundProductsOptionsInterface $options
    ) {
        $this->objectManager  = $objectManager;
        $this->userRepository = $userRepository;
        $this->partAssetRepository = $partAssetRepository;
        $this->partsRepository     = $partsRepository;
        $this->assetRepository     = $assetRepository;
        $this->partAssetForm       = $partAssetForm;
        $this->options        = $options;
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getPartAsset($recordId)
    {
        return $this->partAssetRepository->find($recordId);
    }

    /**
     * Return a list of part assets for a part
     *
     * @param  PartsInterface     $part
     * @return PartAssetInterface
     */
    public function getPartAssetsByPart(PartsInterface $part)
    {
        return $this->partAssetRepository->findBy(
            array(
                'part' => $part->getPartId(),
            ),
            array(
                'amazonName' => 'ASC',
            )
        );
    }

    /**
     * Return a list of part assets for an asset
     *
     * @param  AssetInterface     $asset
     * @return PartAssetInterface
     */
    public function getPartAssetsByAsset(AssetInterface $asset)
    {
        return $this->partAssetrepository->findBy(
            array(
                'asset' => $asset->getAssetId(),
            ),
            array(
                'amazonName' => 'ASC',
            )
        );
    }

    /**
     * Return boolean on duplicate check
     *
     * @param  PartsInterface $part
     * @param  AssetInterface $asset
     * @return boolean
     */
    public function duplicateCheck(PartsInterface $part, AssetInterface $asset)
    {
        return $this->partAssetRepository->findBy(
            array(
                'part'  => $part->getPartId(),
                'asset' => $asset->getAssetId(),
            )
        );
    }

    /**
     * Return create part asset form
     *
     * @return PartAssetForm
     */
    public function getCreatePartAssetForm()
    {
        $this->partAssetForm->bind(clone $this->getPartAssetPrototype());

        return $this->partAssetForm;
    }

    /**
     * Return edit part asset form
     *
     * @param  string        $partAssetId
     * @return PartAssetForm
     */
    public function getEditPartAssetForm($partAssetId)
    {
        $partAsset = $this->partAssetRepository->find($partAssetId);

        $this->partAssetForm->bind($partAsset);

        return $this->partAssetForm;
    }

    /**
     * Create a new part asset relationship
     *
     * @param  PartsInterface          $part
     * @param  AssetInterface          $asset
     * @param  string                  $amazonName
     * @param  string                  $picType
     * @param  integer                 $assetSeq
     * @param  string                  $assetType
     * @param  string                  $videoType
     * @return null|PartAssetInterface
     */
    public function create(PartsInterface $part, AssetInterface $asset, $amazonName = null, $picType = null, $assetSeq = null, $assetType = null, $videoType = null)
    {
        $partAsset = clone $this->getPartAssetPrototype();
        $partAsset->setPart($part)
            ->setAsset($asset)
            ->setAmazonName($amazonName)
            ->setPicType($picType)
            ->setAssetType($assetType)
            ->setVideoType($videoType)
            ->setAssetSeq($assetSeq);

        $this->objectManager->persist($partAsset);
        $this->objectManager->flush();

        return $partAsset;
    }

    /**
     * Flush entitymanager
     */
    public function flushObject()
    {
        $this->objectManager->clear();
    }

    /**
     * Edit part asset and add amazon name
     *
     * @param  PartAssetInterface      $partAsset
     * @param  string                  $amazonName
     * @return null|PartAssetInterface
     */
    public function editPartAsset(PartAssetInterface $partAsset, $amazonName = null)
    {
        $partAsset->setAmazonName($amazonName);

        $this->objectManager->flush();

        return $partAsset;
    }

    /**
     * Creates a new part asset.
     *
     * @param  UserInterface                      $identity
     * @param  PartsInterface                     $part
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|PartAssetInterface
     */
    public function createRecord(UserInterface $identity, PartsInterface $part, \Zend\Stdlib\Parameters $data)
    {
        $this->partAssetForm->bind(clone $this->getPartAssetPrototype());
        $this->partAssetForm->setData($data);

        if (!$this->partAssetForm->isValid()) {
            return null;
        }

        $partAsset = $this->partAssetForm->getData();

        if (!$partAsset instanceof PartAssetInterface) {
            throw Exception\UnexpectedValueException::invalidPartAssetEntity($partAsset);
        }

        $partAsset->setPart($part);

        $this->objectManager->persist($partAsset);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new PartAssetEvent('partAssetCreated', $partAsset));

        return $partAsset;
    }

    /**
     * Edit an existing part asset.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  PartAssetInterface                 $partAsset
     * @throws Exception\UnexpectedValueException
     * @return null|PartAssetInterface
     */
    public function editRecord(UserInterface $identity, \Zend\Stdlib\Parameters $data, PartAssetInterface $partAsset)
    {
        $this->partAssetForm->bind($partAsset);
        $this->partAssetForm->setData($data);

        if (!$this->partAssetForm->isValid()) {
            return null;
        }

        $partAsset = $this->partAssetForm->getData();

        if (!$partAsset instanceof PartAssetInterface) {
            throw Exception\UnexpectedValueException::invalidPartAssetEntity($partAsset);
        }

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new PartAssetEvent('partAssetEdited', $partAsset));

        return $partAsset;
    }

    /**
     * Delete an existing part asset.
     *
     * @param  UserInterface                      $identity
     * @param  PartAssetInterface                 $partAsset
     * @throws Exception\UnexpectedValueException
     * @return null|PartAssetInterface
     */
    public function delete(UserInterface $identity, PartAssetInterface $partAsset)
    {
        if (!$partAsset instanceof PartAssetInterface) {
            throw Exception\UnexpectedValueException::invalidPartAssetEntity($partAsset);
        }

        $this->objectManager->remove($partAsset);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new PartAssetEvent('partAssetDeleted', $partAsset));

        return $partAsset;
    }

    /**
     * @return PartAssetInterface
     */
    public function getPartAssetPrototype()
    {
        if ($this->partAssetPrototype === null) {
            $this->setPartAssetPrototype(new PartAsset());
        }

        return $this->partAssetPrototype;
    }

    /**
     * @param  PartAssetInterface $partAssetPrototype
     * @return PartAssetService
     */
    public function setPartAssetPrototype(PartAssetInterface $partAssetPrototype)
    {
        $this->partAssetPrototype = $partAssetPrototype;

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
