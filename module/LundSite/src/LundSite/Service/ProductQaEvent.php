<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Service;

use LundSite\Entity\ProductQaInterface;
use Zend\EventManager\Event;

/**
 * ProductQa events.
 */
class ProductQaEvent extends Event
{
    const EVENT_PRODUCTQA_CREATED = 'productQaCreated';
    const EVENT_PRODUCTQA_EDITED  = 'productQaEdited';
    const EVENT_PRODUCTQA_DELETED = 'productQaDeleted';

    /**
     * @var ProductQaInterface
     */
    protected $productQa;

    /**
     * @param string               $name
     * @param ProductQaInterface $productQa
     */
    public function __construct($name, ProductQaInterface $productQa)
    {
        parent::__construct($name);
        $this->productQa = $productQa;
    }

    /**
     * @param  ProductQaInterface $productQa
     * @return ProductQaEvent
     */
    public function setProductQa($productQa)
    {
        $this->productQa = $productQa;

        return $this;
    }

    /**
     * @return ProductQaInterface
     */
    public function getProductQa()
    {
        return $this->productQa;
    }
}
