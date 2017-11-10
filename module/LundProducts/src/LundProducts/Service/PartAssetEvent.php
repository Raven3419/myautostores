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

use LundProducts\Entity\PartAssetInterface;
use Zend\EventManager\Event;

/**
 * PartAsset events.
 */
class PartAssetEvent extends Event
{
    const EVENT_PARTASSET_CREATED = 'partAssetCreated';
    const EVENT_PARTASSET_EDITED  = 'partAssetEdited';
    const EVENT_PARTASSET_DELETED = 'partAssetDeleted';

    /**
     * @var PartAssetInterface
     */
    protected $partAsset;

    /**
     * @param string             $name
     * @param PartAssetInterface $partAsset
     */
    public function __construct($name, PartAssetInterface $partAsset)
    {
        parent::__construct($name);
        $this->partAsset = $partAsset;
    }

    /**
     * @param  PartAssetInterface $partAsset
     * @return PartAssetEvent
     */
    public function setPartAsset($partAsset)
    {
        $this->partAsset = $partAsset;

        return $this;
    }

    /**
     * @return PartAssetInterface
     */
    public function getPartAsset()
    {
        return $this->partAsset;
    }
}
