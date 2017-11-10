<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
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
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\ProductReviews;
use LundProducts\Entity\ProductReviewsInterface;
use LundProducts\Repository\ProductReviewsRepositoryInterface;
use RocketUser\Entity\User;
use DateTime;

/*
 * Service managing the CRUD of Product Reviews.
 */
class ProductReviewService
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

    /*
     * @var ProductReviewForm
     */
    protected $productReviewForm;

    /*
     * @var ProductReviewsInterface
     */
    protected $productReviewsPrototype;

    /**
     * @param ObjectManager                     $objectManager
     * @param ProductReviewsRepositoryInterface $repository
     * @param FormInterface                     $productReviewsForm
     */
    public function __construct(
        ObjectManager                     $objectManager,
        ProductReviewsRepositoryInterface $repository,
        FormInterface                     $productReviewForm
    )
    {
        $this->objectManager     = $objectManager;
        $this->repository        = $repository;
        $this->productReviewForm = $productReviewForm;
    }

    /**
     * Return view ProductReviewForm
     *
     * @param  string            $productReviewId
     * @return ProductReviewForm
     */
    public function getViewProductReviewForm($productReviewId)
    {
        $productReview = $this->repository->find($productReviewId);

        $this->productReviewForm->bind($productReview);

        return $this->productReviewForm;
    }

    /**
     * Return create ProductReviewForm
     *
     * @return ProductReviewForm
     */
    public function getCreateProductReviewForm()
    {
        $this->productReviewForm->bind(clone $this->getProductReviewsPrototype());

        return $this->productReviewForm;
    }

    /**
     * Return edit ProductReviewForm
     *
     * @param  string            $productReviewId
     * @return ProductReviewForm
     */
    public function getEditProductReviewForm($productReviewId)
    {
        $productReview = $this->repository->find($productReviewId);

        $this->productReviewForm->bind($productReview);

        return $this->productReviewForm;
    }

    /**
     * @return ProductReviewsInterface
     */
    public function getProductReviewsPrototype()
    {
        if ($this->productReviewsPrototype === null) {
            $this->setProductReviewsPrototype(new ProductReviews());
        }

        return $this->productReviewsPrototype;
    }

    /**
     * @param  ProductReviewsInterface $productReviewsPrototype
     * @return ProductReviewService
     */
    public function setProductReviewsPrototype(ProductReviewsInterface $productReviewsPrototype)
    {
        $this->productReviewsPrototype = $productReviewsPrototype;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActiveProductReviews()
    {
        return $this->repository->findActive();
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getProductReview($recordId)
    {
        return $this->repository->find($recordId);
    }

    /**
     * Return a segment of active product reviews for datatables
     *
     * @return mixed
     */
    public function getProductReviewListings(AbstractActionController $controller, $limit = null, $offset = null, $sEcho = null, $sortingCols = null, $sSearch = null)
    {
        $columns = array('r.createdAt', 'r.productLine', 'r.user', 'r.rating', 'r.review', 'r.disabled');
        $orderBy = array();

        if ($sortingCols > 0) {
            for ($i = 0; $i < $sortingCols; $i++) {
                if ($controller->params()->fromQuery('bSortable_' . $controller->params()->fromQuery('iSortCol_' . $i)) == 'true') {
                    // column name
                    $orderBy[] = $columns[(INT)$controller->params()->fromQuery('iSortCol_' . $i)];
                    // order direction
                    $orderBy[] = (($controller->params()->fromQuery('sSortDir_' . $i) === 'asc') ? 'ASC' : 'DESC');
                }
            }
        }

        $records           = $this->getActiveProductReviewRecords($limit, $offset, $orderBy, $sSearch);
        $recordsCount      = count($records);
        $totalRecordsCount = $this->getProductReviewTotalCount($sSearch);
        $aaData            = array();
        $address           = null;

        if ($recordsCount > 0) {
            foreach ($records as $record) {
                $aaData[] = array($record->getCreatedAt()->format('Y-m-d H:i:s'),
                                  ['id' => $record->getProductLines()->getProductLineId(),
                                   'name' => $record->getProductLines()->getName()],
                                  $record->getUser()->getUsername(),
                                  $record->getRating() . ' out of 5',
                                  $record->getReview(),
                                  ['id' => $record->getProductReviewId(),
                                   'disabled' => ($record->getDisabled() ? 'Yes' : 'No')],
                                  $record->getProductReviewId()
                );
            }
        }

        return array('sEcho'                => $sEcho,
                     'aaData'               => $aaData,
                     'iTotalRecords'        => $totalRecordsCount,
                     'iTotalDisplayRecords' => $totalRecordsCount);
    }

    /**
     * @return mixed
     */
    public function getActiveProductReviewRecords($limit = null, $offset = null, $orderBy = array(), $sSearch = null)
    {
        return $this->repository->findActive($limit, $offset, $orderBy, $sSearch);
    }

    /*
     * @return mixed
     */
    public function getProductReviewTotalCount($sSearch = null)
    {
        return $this->repository->getTotalRows($sSearch);
    }

    /**
     * Return product reviews by product line
     *
     * @param  \LundProducts\Entity\ProductLinesInterface $productLine
     * @return ProductReviewsInterface|null
     */
    public function getProductReviewsByProductLine(\LundProducts\Entity\ProductLinesInterface $productLine)
    {
        return $this->repository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'productLines' => $productLine->getProductLineId(),
            ),
            array(
                'createdAt' => 'DESC',
            )
        );
    }

    /**
     * Create a new product review.
     *
     * @param \RocketUser\Entity\User          $usersEntity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|ProductReviewsInterface
     */
    public function create(User $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->productReviewForm->bind(clone $this->getProductReviewsPrototype());
        $this->productReviewForm->setData($data);

        if (!$this->productReviewForm->isValid()) {
            var_dump($this->productReviewForm->getMessages());exit();
            return null;
        }

        $review = $this->productReviewForm->getData();

        if (!$review instanceof ProductReviewsInterface) {
            throw Exception\UnexpectedValueException::invalidProductReviewEntity($review);
        }

        $review->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($review);
        $this->objectManager->flush();

        return $review;
    }

    /**
     * @param \LundProducts\Entity\ProductReviews $recordEntity
     * @param \RocketUser\Entity\User          $usersEntity
     *
     * @return \LundProducts\Entity\ProductReviews $recordEntity
     */
    public function createProductReview(ProductReviews $recordEntity, User $usersEntity)
    {
        $recordEntity->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($usersEntity->getUsername())
            ->setDeleted(false)
            ->setDisabled(true);

        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\ProductReviews $recordEntity
     * @param \RocketUser\Entity\User          $usersEntity
     *
     * @return \LundProducts\Entity\ProductReviews $recordEntity
     */
    public function createProductReviewParse(ProductReviews $recordEntity, User $usersEntity)
    {
        $recordEntity->setDeleted(false)
            ->setDisabled(true);

        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\ProductReviews $recordEntity
     * @param \RocketUser\Entity\User          $usersEntity
     *
     * @return \LundProducts\Entity\ProductReviews $recordEntity
     */
    public function approveProductReview(ProductReviews $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername())
            ->setDisabled(false);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\ProductReviews $recordEntity
     * @param \RocketUser\Entity\User          $usersEntity
     *
     * @return \LundProducts\Entity\ProductReviews $recordEntity
     */
    public function editProductReview(ProductReviews $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername());
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\ProductReviews $recordEntity
     * @param \RocketUser\Entity\User          $usersEntity
     *
     * @return \LundProducts\Entity\ProductReviews $recordEntity
     */
    public function deleteProductReview(ProductReviews $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername())
            ->setDeleted(true)
            ->setDisabled(true);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * Flush entitymanager
     */
    public function flushObject()
    {
        $this->objectManager->clear();
    }

    /**
     * @return void
     */
    public function flushCache()
    {
        $cacheDriver = $this->objectManager->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('productreviews_find_active');
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
