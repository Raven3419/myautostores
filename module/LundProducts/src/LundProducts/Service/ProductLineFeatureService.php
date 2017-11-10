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
use LundProducts\Entity\ProductLineFeature;
use LundProducts\Entity\ProductLineFeatureInterface;
use LundProducts\Entity\ProductLinesInterface;
use LundProducts\Repository\ProductLineFeatureRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use LundProducts\Repository\ProductLinesRepositoryInterface;
use LundProducts\Form\ProductLineFeatureForm;
use LundProducts\Options\LundProductsOptionsInterface;
use LundProducts\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;

/**
 * Service managing the management of product line features.
 */
class ProductLineFeatureService implements EventManagerAwareInterface
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
     * @var ProductLineFeatureRepositoryInterface
     */
    protected $productLineFeatureRepository;

    /**
     * @var ProductLinesRepositoryInterface
     */
    protected $productLinesRepository;

    /**
     * @var ProductLineFeatureForm
     */
    protected $productLineFeatureForm;

    /**
     * @var LundProductsOptionsInterface
     */
    protected $options;

    /**
     * @var ProductLineFeatureInterface
     */
    protected $productLineFeaturePrototype;

    /**
     * @param ObjectManager                       $objectManager
     * @param UserRepositoryInterface             $userRepository
     * @param ProductLineFeatureRepositoryInterface $productLineFeatureRepository
     * @param ProductLinesRepositoryInterface     $productLinesRepository
     * @param FormInterface                       $productLineFeatureForm
     * @param LundProductsOptionsInterface        $options
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        ProductLineFeatureRepositoryInterface $productLineFeatureRepository,
        ProductLinesRepositoryInterface $productLinesRepository,
        FormInterface $productLineFeatureForm,
        LundProductsOptionsInterface $options
    ) {
        $this->objectManager  = $objectManager;
        $this->userRepository = $userRepository;
        $this->productLineFeatureRepository = $productLineFeatureRepository;
        $this->productLinesRepository     = $productLinesRepository;
        $this->productLineFeatureForm       = $productLineFeatureForm;
        $this->options        = $options;
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getProductLineFeature($recordId)
    {
        return $this->productLineFeatureRepository->find($recordId);
    }

    /**
     * Return a list of product line features for a product line
     *
     * @param  ProductLinesInterface     $productLine
     * @return ProductLineFeatureInterface
     */
    public function getProductLineFeaturesByProductLine(ProductLinesInterface $productLine)
    {
        return $this->productLineFeatureRepository->findBy(
            array(
                'productLine' => $productLine->getProductLineId(),
            ),
            array(
                'featureSeq' => 'ASC',
            )
        );
    }

    /**
     * Return a list of product line features by position
     *
     * @param  ProductLinesInterface  $productLine
     * @param  integer                $position
     * @return ProductLineFeatureInterface
     */
    public function getFeatureByPosition(ProductLinesInterface $productLine, $position = null)
    {
        return $this->productLineFeatureRepository->findOneBy(
            array(
                'productLine' => $productLine->getProductLineId(),
                'featureSeq'  => $position,
            )
        );
    }

    /**
     * Return new position
     *
     * @param ProductLinesInterface         $productLine
     * @return ProductLineFeatureInterface
     */
    public function getMaxPosition(ProductLinesInterface $productLine)
    {
        $dql = 'SELECT MAX(r.featureSeq) FROM LundProducts\Entity\ProductLineFeature r
                WHERE r.productLine = ' . $productLine->getProductLineId();;
        $q = $this->objectManager->createQuery($dql);

        return $q->getSingleScalarResult();
    }

    /**
     * Return create product line feature form
     *
     * @return ProductLineFeatureForm
     */
    public function getCreateProductLineFeatureForm()
    {
        $this->productLineFeatureForm->bind(clone $this->getProductLineFeaturePrototype());

        return $this->productLineFeatureForm;
    }

    /**
     * Return edit product line feature form
     *
     * @param  string               $productLineFeatureId
     * @return ProductLineFeatureForm
     */
    public function getEditProductLineFeatureForm($productLineFeatureId)
    {
        $productLineFeature = $this->productLineFeatureRepository->find($productLineFeatureId);

        $this->productLineFeatureForm->bind($productLineFeature);

        return $this->productLineFeatureForm;
    }

    /**
     * Create a new product line feature relationship
     *
     * @param  ProductLinesInterface          $part
     * @param  integer                        $featureSeq
     * @param  string                         $featureCopy
     * @return null|ProductLineFeatureInterface
     */
    public function create(ProductLinesInterface $productLine, $featureSeq = null, $featureCopy = null)
    {
        $productLineFeature = clone $this->getProductLineFeaturePrototype();
        $productLineFeature->setProductLine($productLine)
            ->setFeatureCopy($featureCopy)
            ->setFeatureSeq($featureSeq);

        $this->objectManager->persist($productLineFeature);
        $this->objectManager->flush();

        return $productLineFeature;
    }

    /**
     * Flush entitymanager
     */
    public function flushObject()
    {
        $this->objectManager->clear();
    }

    /**
     * Creates a new product line feature.
     *
     * @param  UserInterface                      $identity
     * @param  ProductLinesInterface              $productLine
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|ProductLineFeatureInterface
     */
    public function createRecord(UserInterface $identity, ProductLinesInterface $productLine, \Zend\Stdlib\Parameters $data)
    {
        $this->productLineFeatureForm->bind(clone $this->getProductLineFeaturePrototype());
        $this->productLineFeatureForm->setData($data);

        if (!$this->productLineFeatureForm->isValid()) {
            return null;
        }

        $productLineFeature = $this->productLineFeatureForm->getData();

        if (!$productLineFeature instanceof ProductLineFeatureInterface) {
            throw Exception\UnexpectedValueException::invalidProductLineFeatureEntity($productLineFeature);
        }

        $replacedFeature = $this->getFeatureByPosition($productLine, $productLineFeature->getFeatureSeq());

        if (null != $replacedFeature) {
            $this->rankDownFeature($identity, $replacedFeature);
        }

        $productLineFeature->setProductLine($productLine);

        $this->objectManager->persist($productLineFeature);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductLineFeatureEvent('productLineFeatureCreated', $productLineFeature));

        return $productLineFeature;
    }

    /**
     * Edit an existing product lien feature.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  ProductLineFeatureInterface          $productLineFeature
     * @param  ProductLinesInterface              $productLine
     * @throws Exception\UnexpectedValueException
     * @return null|ProductLineFeatureInterface
     */
    public function editRecord(UserInterface $identity, \Zend\Stdlib\Parameters $data, ProductLineFeatureInterface $productLineFeature, ProductLinesInterface $productLine)
    {
        $this->productLineFeatureForm->bind($productLineFeature);
        $this->productLineFeatureForm->setData($data);

        if (!$this->productLineFeatureForm->isValid()) {
            return null;
        }

        $productLineFeature = $this->productLineFeatureForm->getData();

        if (!$productLineFeature instanceof ProductLineFeatureInterface) {
            throw Exception\UnexpectedValueException::invalidProductLineFeatureEntity($productLineFeature);
        }

        $replacedFeature = $this->getFeatureByPosition($productLine, $productLineFeature->getFeatureSeq());

        if (null != $replacedFeature) {
            if ($replacedFeature->getProductLineFeatureId() != $productLineFeature->getProductLineFeatureId()) {
                $this->rankDownFeature($identity, $replacedFeature);
            }
        }

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductLineFeatureEvent('productLineFeatureEdited', $productLineFeature));

        return $productLineFeature;
    }

    /**
     * Rank up an existing product line feature
     *
     * @param UserInterface   $identity
     * @param ProductLineFeatureInterface $productLineFeature
     * @throws Exception\UnexpectedValueException
     * @returns null|ProductLineFeatureInterface
     */
    public function rankUpFeature(UserInterface $identity, ProductLineFeatureInterface $productLineFeature)
    {
        $currentRank = $productLineFeature->getFeatureSeq();
        $newRank     = $productLineFeature->getFeatureSeq()-1;

        $otherFeatures = $this->getProductLineFeaturesByProductLine($productLineFeature->getProductLine());

        foreach ($otherFeatures as $otherFeature) {
            if ($otherFeature->getProductLineFeatureId() != $productLineFeature->getProductLineFeatureId()) {
                if ($otherFeature->getFeatureSeq() == $newRank) {
                    $newOtherRank = $otherFeature->getFeatureSeq()+1;
                    $otherFeature->setFeatureSeq($newOtherRank);
                    $this->objectManager->flush();
                    $this->getEventManager()->trigger(new ProductLineFeatureEvent('productLineFeatureEdited', $otherFeature));
                }
            } else {
                $productLineFeature->setFeatureSeq($newRank);
                $this->objectManager->flush();
                $this->getEventManager()->trigger(new ProductLineFeatureEvent('productLineFeatureEdited', $productLineFeature));
            }
        }

        return true;
    }

    /**
     * Rank down an existing product line feature
     *
     * @param UserInterface   $identity
     * @param ProductLineFeatureInterface $productLineFeature
     * @throws Exception\UnexpectedValueException
     * @returns null|ProductLineFeatureInterface
     */
   					
    public function rankDownFeature(UserInterface $identity, ProductLineFeatureInterface $productLineFeature)
    {
        $currentRank = $productLineFeature->getFeatureSeq();
        $newRank     = $productLineFeature->getFeatureSeq()+1;

        $otherFeatures = $this->getProductLineFeaturesByProductLine($productLineFeature->getProductLine());

        foreach ($otherFeatures as $otherFeature) {
            if ($otherFeature->getProductLineFeatureId() != $productLineFeature->getProductLineFeatureId()) {
                if ($otherFeature->getFeatureSeq() == $newRank) {
                    $newOtherRank = $otherFeature->getFeatureSeq()-1;
                    $otherFeature->setFeatureSeq($newOtherRank);
                    $this->objectManager->flush();
                    $this->getEventManager()->trigger(new ProductLineFeatureEvent('productLineFeatureEdited', $otherFeature));
                }
            } else {
                $productLineFeature->setFeatureSeq($newRank);
                $this->objectManager->flush();
                $this->getEventManager()->trigger(new ProductLineFeatureEvent('productLineFeatureEdited', $productLineFeature));
            }
        }

        return true;
    }

    /**
     * Delete an existing product line feature.
     *
     * @param  UserInterface                      $identity
     * @param  ProductLineFeatureInterface          $productLineFeature
     * @throws Exception\UnexpectedValueException
     * @return null|ProductLineFeatureInterface
     */
    public function delete(UserInterface $identity, ProductLineFeatureInterface $productLineFeature)
    {
        if (!$productLineFeature instanceof ProductLineFeatureInterface) {
            throw Exception\UnexpectedValueException::invalidProductLineFeatureEntity($productLineFeature);
        }

        $this->objectManager->remove($productLineFeature);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductLineFeatureEvent('productLineFeatureDeleted', $productLineFeature));

        return $productLineFeature;
    }

    /**
     * @return ProductLineFeatureInterface
     */
    public function getProductLineFeaturePrototype()
    {
        if ($this->productLineFeaturePrototype === null) {
            $this->setProductLineFeaturePrototype(new ProductLineFeature());
        }

        return $this->productLineFeaturePrototype;
    }

    /**
     * @param  ProductLineFeatureInterface $productLineFeaturePrototype
     * @return ProductLineFeatureService
     */
    public function setProductLineFeaturePrototype(ProductLineFeatureInterface $productLineFeaturePrototype)
    {
        $this->productLineFeaturePrototype = $productLineFeaturePrototype;

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
