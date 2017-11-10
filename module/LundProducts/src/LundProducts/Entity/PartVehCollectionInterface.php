<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Entity;

/**
 * PartVehCollectionInterface
 */
interface PartVehCollectionInterface
{
    /**
     * Set sequence
     *
     * @param  integer           $sequence
     * @return PartVehCollection
     */
    public function setSequence($sequence);

    /**
     * Get sequence
     *
     * @return integer
     */
    public function getSequence();

    /**
     * Set subdetail
     *
     * @param  string            $subdetail
     * @return PartVehCollection
     */
    public function setSubdetail($subdetail);

    /**
     * Get subdetail
     *
     * @return string
     */
    public function getSubdetail();

    /**
     * Get partVehCollectionId
     *
     * @return integer
     */
    public function getPartVehCollectionId();

    /**
     * Set changesetDetail
     *
     * @param  \LundProducts\Entity\ChangesetDetails $changesetDetail
     * @return PartVehCollection
     */
    public function setChangesetDetail(\LundProducts\Entity\ChangesetDetails $changesetDetail = null);

    /**
     * Get changesetDetail
     *
     * @return \LundProducts\Entity\ChangesetDetails
     */
    public function getChangesetDetail();

    /**
     * Set part
     *
     * @param  \LundProducts\Entity\Parts $part
     * @return PartVehCollection
     */
    public function setPart(\LundProducts\Entity\Parts $part = null);

    /**
     * Get part
     *
     * @return \LundProducts\Entity\Parts
     */
    public function getPart();

    /**
     * Set vehCollection
     *
     * @param  \LundProducts\Entity\VehCollection $vehCollection
     * @return PartVehCollection
     */
    public function setVehCollection(\LundProducts\Entity\VehCollection $vehCollection = null);

    /**
     * Get vehCollection
     *
     * @return \LundProducts\Entity\VehCollection
     */
    public function getVehCollection();

}
