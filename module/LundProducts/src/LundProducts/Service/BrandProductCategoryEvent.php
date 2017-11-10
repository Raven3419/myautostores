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

use LundProducts\Entity\BrandProductCategoryInterface;
use Zend\EventManager\Event;

/**
 * BrandProductCategory events.
 */
class BrandProductCategoryEvent extends Event
{
    const EVENT_BRANDPRODUCTCATEGORY_CREATED = 'brandProductCategoryCreated';
    const EVENT_BRANDPRODUCTCATEGORY_EDITED  = 'brandProductCategoryEdited';
    const EVENT_BRANDPRODUCTCATEGORY_DELETED = 'brandProductCategoryDeleted';

    /**
     * @var BrandProductCategoryInterface
     */
    protected $brandProductCategory;

    /**
     * @param string                    $name
     * @param BrandProductCategoryInterface $brandProductCategory
     */
    public function __construct($name, BrandProductCategoryInterface $brandProductCategory)
    {
        parent::__construct($name);
        $this->brandProductCategory = $brandProductCategory;
    }

    /**
     * @param  BrandProductCategoryInterface $brandProductCategory
     * @return BrandProductCategoryEvent
     */
    public function setBrandProductCategory($brandProductCategory)
    {
        $this->brandProductCategory = $brandProductCategory;

        return $this;
    }

    /**
     * @return BrandProductCategoryInterface
     */
    public function getBrandProductCategory()
    {
        return $this->brandProductCategory;
    }
}
