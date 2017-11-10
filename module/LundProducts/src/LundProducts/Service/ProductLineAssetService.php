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
use LundProducts\Entity\ProductLineAsset;
use LundProducts\Entity\ProductLineAssetInterface;
use LundProducts\Entity\ProductLinesInterface;
use RocketDam\Entity\AssetInterface;
use LundProducts\Repository\ProductLineAssetRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use LundProducts\Repository\ProductLinesRepositoryInterface;
use RocketDam\Repository\AssetRepositoryInterface;
use LundProducts\Form\ProductLineAssetForm;
use LundProducts\Options\LundProductsOptionsInterface;
use LundProducts\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;

/**
 * Service managing the management of product line assets.
 */
class ProductLineAssetService implements EventManagerAwareInterface
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
     * @var ProductLineAssetRepositoryInterface
     */
    protected $productLineAssetRepository;

    /**
     * @var ProductLinesRepositoryInterface
     */
    protected $productLinesRepository;

    /**
     * @var AssetRepositoryInterface
     */
    protected $assetRepository;

    /**
     * @var ProductLineAssetForm
     */
    protected $productLineAssetForm;

    /**
     * @var LundProductsOptionsInterface
     */
    protected $options;

    /**
     * @var ProductLineAssetInterface
     */
    protected $productLineAssetPrototype;

    /**
     * @param ObjectManager                       $objectManager
     * @param UserRepositoryInterface             $userRepository
     * @param ProductLineAssetRepositoryInterface $productLineAssetRepository
     * @param ProductLinesRepositoryInterface     $productLinesRepository
     * @param AssetRepositoryInterface            $assetRepository
     * @param FormInterface                       $productLineAssetForm
     * @param LundProductsOptionsInterface        $options
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        ProductLineAssetRepositoryInterface $productLineAssetRepository,
        ProductLinesRepositoryInterface $productLinesRepository,
        AssetRepositoryInterface $assetRepository,
        FormInterface $productLineAssetForm,
        LundProductsOptionsInterface $options
    ) {
        $this->objectManager  = $objectManager;
        $this->userRepository = $userRepository;
        $this->productLineAssetRepository = $productLineAssetRepository;
        $this->productLinesRepository     = $productLinesRepository;
        $this->assetRepository     = $assetRepository;
        $this->productLineAssetForm       = $productLineAssetForm;
        $this->options        = $options;
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getProductLineAsset($recordId)
    {
        return $this->productLineAssetRepository->find($recordId);
    }

    /**
     * Return a list of prpdict line assets for a product line
     *
     * @param  ProductLinesInterface     $productLine
     * @return ProductLineAssetInterface
     */
    public function getProductLineAssetsByProductLine(ProductLinesInterface $productLine)
    {
        return $this->productLineAssetRepository->findBy(
            array(
                'productLine' => $productLine->getProductLineId(),
            ),
            array(
                'assetSeq' => 'ASC',
            )
        );
    }

    /**
     * Return a list of product line assets for an asset
     *
     * @param  AssetInterface            $asset
     * @return ProductLineAssetInterface
     */
    public function getProductLineAssetsByAsset(AssetInterface $asset)
    {
        return $this->productLineAssetrepository->findBy(
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
     * @param  ProductLinesInterface $productLine
     * @param  AssetInterface        $asset
     * @return boolean
     */
    public function duplicateCheck(ProductLinesInterface $productLine, AssetInterface $asset)
    {
        return $this->productLineAssetRepository->findBy(
            array(
                'productLine'  => $productLine->getProductLineId(),
                'asset' => $asset->getAssetId(),
            )
        );
    }

    /**
     * Return create product line asset form
     *
     * @return ProductLineAssetForm
     */
    public function getCreateProductLineAssetForm()
    {
        $this->productLineAssetForm->bind(clone $this->getProductLineAssetPrototype());

        return $this->productLineAssetForm;
    }

    /**
     * Return edit product line asset form
     *
     * @param  string               $productLineAssetId
     * @return ProductLineAssetForm
     */
    public function getEditProductLineAssetForm($productLineAssetId)
    {
        $productLineAsset = $this->productLineAssetRepository->find($productLineAssetId);

        $this->productLineAssetForm->bind($productLineAsset);

        return $this->productLineAssetForm;
    }

    /**
     * Create a new product line asset relationship
     *
     * @param  ProductLinesInterface          $part
     * @param  AssetInterface                 $asset
     * @param  integer                        $assetSeq
     * @param  string                         $assetType
     * @param  string                         $videoType
     * @return null|ProductLineAssetInterface
     */
    public function create(ProductLinesInterface $productLine, AssetInterface $asset, $assetSeq = null, $assetType = null, $videoType = null)
    {
        $productLineAsset = clone $this->getProductLineAssetPrototype();
        $productLineAsset->setProductLine($productLine)
            ->setAsset($asset)
            ->setAssetType($assetType)
            ->setVideoType($videoType)
            ->setAssetSeq($assetSeq);

        $this->objectManager->persist($productLineAsset);
        $this->objectManager->flush();

        return $productLineAsset;
    }

    /**
     * Flush entitymanager
     */
    public function flushObject()
    {
        $this->objectManager->clear();
    }

    /**
     * Creates a new product line asset.
     *
     * @param  UserInterface                      $identity
     * @param  ProductLinesInterface              $productLine
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|ProductLineAssetInterface
     */
    public function createRecord(UserInterface $identity, ProductLinesInterface $productLine, \Zend\Stdlib\Parameters $data)
    {
        $this->productLineAssetForm->bind(clone $this->getProductLineAssetPrototype());
        $this->productLineAssetForm->setData($data);

        if (!$this->productLineAssetForm->isValid()) {
            return null;
        }

        $productLineAsset = $this->productLineAssetForm->getData();

        if (!$productLineAsset instanceof ProductLineAssetInterface) {
            throw Exception\UnexpectedValueException::invalidProductLineAssetEntity($productLineAsset);
        }

        $productLineAsset->setProductLine($productLine);

        $this->objectManager->persist($productLineAsset);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductLineAssetEvent('productLineAssetCreated', $productLineAsset));

        return $productLineAsset;
    }

    /**
     * Edit an existing product lien asset.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  ProductLineAssetInterface          $productLineAsset
     * @throws Exception\UnexpectedValueException
     * @return null|ProductLineAssetInterface
     */
    public function editRecord(UserInterface $identity, \Zend\Stdlib\Parameters $data, ProductLineAssetInterface $productLineAsset)
    {
        $this->productLineAssetForm->bind($productLineAsset);
        $this->productLineAssetForm->setData($data);

        if (!$this->productLineAssetForm->isValid()) {
            return null;
        }

        $productLineAsset = $this->productLineAssetForm->getData();

        if (!$productLineAsset instanceof ProductLineAssetInterface) {
            throw Exception\UnexpectedValueException::invalidProductLineAssetEntity($productLineAsset);
        }

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductLineAssetEvent('productLineAssetEdited', $productLineAsset));

        return $productLineAsset;
    }

    /**
     * Delete an existing product line asset.
     *
     * @param  UserInterface                      $identity
     * @param  ProductLineAssetInterface          $productLineAsset
     * @throws Exception\UnexpectedValueException
     * @return null|ProductLineAssetInterface
     */
    public function delete(UserInterface $identity, ProductLineAssetInterface $productLineAsset)
    {
        if (!$productLineAsset instanceof ProductLineAssetInterface) {
            throw Exception\UnexpectedValueException::invalidProductLineAssetEntity($productLineAsset);
        }

        $this->objectManager->remove($productLineAsset);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductLineAssetEvent('productLineAssetDeleted', $productLineAsset));

        return $productLineAsset;
    }

    /**
     * @return ProductLineAssetInterface
     */
    public function getProductLineAssetPrototype()
    {
        if ($this->productLineAssetPrototype === null) {
            $this->setProductLineAssetPrototype(new ProductLineAsset());
        }

        return $this->productLineAssetPrototype;
    }

    /**
     * @param  ProductLineAssetInterface $productLineAssetPrototype
     * @return ProductLineAssetService
     */
    public function setProductLineAssetPrototype(ProductLineAssetInterface $productLineAssetPrototype)
    {
        $this->productLineAssetPrototype = $productLineAssetPrototype;

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
