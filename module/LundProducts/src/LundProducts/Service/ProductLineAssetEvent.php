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

use LundProducts\Entity\ProductLineAssetInterface;
use Zend\EventManager\Event;

/**
 * ProductLineAsset events.
 */
class ProductLineAssetEvent extends Event
{
    const EVENT_PRODUCTLINEASSET_CREATED = 'productLineAssetCreated';
    const EVENT_PRODUCTLINEASSET_EDITED  = 'productLineAssetEdited';
    const EVENT_PRODUCTLINEASSET_DELETED = 'productLineAssetDeleted';

    /**
     * @var ProductLineAssetInterface
     */
    protected $productLineAsset;

    /**
     * @param string                    $name
     * @param ProductLineAssetInterface $productLineAsset
     */
    public function __construct($name, ProductLineAssetInterface $productLineAsset)
    {
        parent::__construct($name);
        $this->productLineAsset = $productLineAsset;
    }

    /**
     * @param  ProductLineAssetInterface $productLineAsset
     * @return ProductLineAssetEvent
     */
    public function setProductLineAsset($productLineAsset)
    {
        $this->productLineAsset = $productLineAsset;

        return $this;
    }

    /**
     * @return ProductLineAssetInterface
     */
    public function getProductLineAsset()
    {
        return $this->productLineAsset;
    }
}
