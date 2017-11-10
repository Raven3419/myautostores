<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Entity
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Entity;

/**
 * PartVehCollection
 *
 * @see PartVehCollectionInterface
 */
class PartVehCollection
{
    /**
     * @var integer
     */
    protected $sequence;

    /**
     * @var string
     */
    protected $subdetail;

    /**
     * @var integer
     */
    protected $makeId;

    /**
     * @var integer
     */
    protected $modelId;

    /**
     * @var integer
     */
    protected $submodelId;

    /**
     * @var integer
     */
    protected $bodyTypeId;

    /**
     * @var integer
     */
    protected $bodyNumDoorsId;

    /**
     * @var integer
     */
    protected $bedTypeId;

    /**
     * @var integer
     */
    protected $partVehCollectionId;

    /**
     * @var \LundProducts\Entity\ChangesetDetails
     */
    protected $changesetDetail;

    /**
     * @var \LundProducts\Entity\Parts
     */
    protected $part;

    /**
     * @var \LundProducts\Entity\VehCollection
     */
    protected $vehCollection;

    /**
     * Set sequence
     *
     * @param  integer           $sequence
     * @return PartVehCollection
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return integer
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Set subdetail
     *
     * @param  string            $subdetail
     * @return PartVehCollection
     */
    public function setSubdetail($subdetail)
    {
        $this->subdetail = $subdetail;

        return $this;
    }

    /**
     * Get subdetail
     *
     * @return string
     */
    public function getSubdetail()
    {
        return $this->subdetail;
    }

    /**
     * Get partVehCollectionId
     *
     * @return integer
     */
    public function getPartVehCollectionId()
    {
        return $this->partVehCollectionId;
    }

    /**
     * Set changesetDetail
     *
     * @param  \LundProducts\Entity\ChangesetDetails $changesetDetail
     * @return PartVehCollection
     */
    public function setChangesetDetail(\LundProducts\Entity\ChangesetDetails $changesetDetail = null)
    {
        $this->changesetDetail = $changesetDetail;

        return $this;
    }

    /**
     * Get changesetDetail
     *
     * @return \LundProducts\Entity\ChangesetDetails
     */
    public function getChangesetDetail()
    {
        return $this->changesetDetail;
    }

    /**
     * Set part
     *
     * @param  \LundProducts\Entity\Parts $part
     * @return PartVehCollection
     */
    public function setPart(\LundProducts\Entity\Parts $part = null)
    {
        $this->part = $part;

        return $this;
    }

    /**
     * Get part
     *
     * @return \LundProducts\Entity\Parts
     */
    public function getPart()
    {
        return $this->part;
    }

    /**
     * Set vehCollection
     *
     * @param  \LundProducts\Entity\VehCollection $vehCollection
     * @return PartVehCollection
     */
    public function setVehCollection(\LundProducts\Entity\VehCollection $vehCollection = null)
    {
        $this->vehCollection = $vehCollection;

        return $this;
    }

    /**
     * Get vehCollection
     *
     * @return \LundProducts\Entity\VehCollection
     */
    public function getVehCollection()
    {
        return $this->vehCollection;
    }
}
