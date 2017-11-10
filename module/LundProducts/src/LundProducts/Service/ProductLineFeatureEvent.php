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

use LundProducts\Entity\ProductLineFeatureInterface;
use Zend\EventManager\Event;

/**
 * ProductLineFeature events.
 */
class ProductLineFeatureEvent extends Event
{
    const EVENT_PRODUCTLINEFEATURE_CREATED = 'productLineFeatureCreated';
    const EVENT_PRODUCTLINEFEATURE_EDITED  = 'productLineFeatureEdited';
    const EVENT_PRODUCTLINEFEATURE_DELETED = 'productLineFeatureDeleted';

    /**
     * @var ProductLineFeatureInterface
     */
    protected $productLineFeature;

    /**
     * @param string                    $name
     * @param ProductLineFeatureInterface $productLineFeature
     */
    public function __construct($name, ProductLineFeatureInterface $productLineFeature)
    {
        parent::__construct($name);
        $this->productLineFeature = $productLineFeature;
    }

    /**
     * @param  ProductLineFeatureInterface $productLineFeature
     * @return ProductLineFeatureEvent
     */
    public function setProductLineFeature($productLineFeature)
    {
        $this->productLineFeature = $productLineFeature;

        return $this;
    }

    /**
     * @return ProductLineFeatureInterface
     */
    public function getProductLineFeature()
    {
        return $this->productLineFeature;
    }
}
