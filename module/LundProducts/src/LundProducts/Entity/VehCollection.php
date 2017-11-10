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

use Zend\XmlRpc\Value\Integer;
/**
 * VehCollection
 *
 * @see VehCollectionInterface
 */
class VehCollection implements VehCollectionInterface
{
    /**
     * @var integer
     */
    protected $vehCollectionId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $vehCollections;

    /**
     * @var \LundProducts\Entity\VehMake
     */
    protected $vehMake;

    /**
     * @var \LundProducts\Entity\VehModel
     */
    protected $vehModel;

    /**
     * @var \LundProducts\Entity\VehSubmodel
     */
    protected $vehSubmodel;

    /**
     * @var \LundProducts\Entity\VehYear
     */
    protected $vehYear;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $part;

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
     * @var string
     */
    protected $bodyType;

    /**
     * @var integer
     */
    protected $bodyNumDoorsId;

    /**
     * @var integer
     */
    protected $bedTypeId;

    /**
     * @var string
     */
    protected $bedType;

    /**
     * @var string
     */
    protected $modelType;
    
    /**
     * @var Integer
     */
    protected $baseVehId;
    
    /**
     * @var string
     */
    protected $fitCode1;
    
    /**
     * @var string
     */
    protected $fitCode1Desc;
    
    /**
     * @var string
     */
    protected $fitCode2;
    
    /**
     * @var string
     */
    protected $fitCode2Desc;
    
    /**
     * @var string
     */
    protected $fitCode3;
    
    /**
     * @var string
     */
    protected $fitCode3Desc;
    
    /**
     * @var string
     */
    protected $fitCode4;
    
    /**
     * @var string
     */
    protected $fitCode4Desc;
    
    /**
     * @var string
     */
    protected $fitCode5;
    
    /**
     * @var string
     */
    protected $fitCode5Desc;
    
    /**
     * @var Integer
     */
    protected $jeepClearance;
    
    
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vehCollections = new \Doctrine\Common\Collections\ArrayCollection();
        $this->part = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get vehCollectionId
     *
     * @return integer
     */
    public function getVehCollectionId()
    {
        return $this->vehCollectionId;
    }

    /**
     * Add vehCollections
     *
     * @param  \LundProducts\Entity\PartVehCollection $vehCollections
     * @return VehCollection
     */
    public function addVehCollection(\LundProducts\Entity\PartVehCollection $vehCollections)
    {
        $this->vehCollections[] = $vehCollections;

        return $this;
    }

    /**
     * Remove vehCollections
     *
     * @param \LundProducts\Entity\PartVehCollection $vehCollections
     */
    public function removeVehCollection(\LundProducts\Entity\PartVehCollection $vehCollections)
    {
        $this->vehCollections->removeElement($vehCollections);
    }

    /**
     * Get vehCollections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehCollections()
    {
        return $this->vehCollections;
    }

    /**
     * Set vehMake
     *
     * @param  \LundProducts\Entity\VehMake $vehMake
     * @return VehCollection
     */
    public function setVehMake(\LundProducts\Entity\VehMake $vehMake = null)
    {
        $this->vehMake = $vehMake;

        return $this;
    }

    /**
     * Get vehMake
     *
     * @return \LundProducts\Entity\VehMake
     */
    public function getVehMake()
    {
        return $this->vehMake;
    }

    /**
     * Set vehModel
     *
     * @param  \LundProducts\Entity\VehModel $vehModel
     * @return VehCollection
     */
    public function setVehModel(\LundProducts\Entity\VehModel $vehModel = null)
    {
        $this->vehModel = $vehModel;

        return $this;
    }

    /**
     * Get vehModel
     *
     * @return \LundProducts\Entity\VehModel
     */
    public function getVehModel()
    {
        return $this->vehModel;
    }

    /**
     * Set vehSubmodel
     *
     * @param  \LundProducts\Entity\VehSubmodel $vehSubmodel
     * @return VehCollection
     */
    public function setVehSubmodel(\LundProducts\Entity\VehSubmodel $vehSubmodel = null)
    {
        $this->vehSubmodel = $vehSubmodel;

        return $this;
    }

    /**
     * Get vehSubmodel
     *
     * @return \LundProducts\Entity\VehSubmodel
     */
    public function getVehSubmodel()
    {
        return $this->vehSubmodel;
    }

    /**
     * Set vehYear
     *
     * @param  \LundProducts\Entity\VehYear $vehYear
     * @return VehCollection
     */
    public function setVehYear(\LundProducts\Entity\VehYear $vehYear = null)
    {
        $this->vehYear = $vehYear;

        return $this;
    }

    /**
     * Get vehYear
     *
     * @return \LundProducts\Entity\VehYear
     */
    public function getVehYear()
    {
        return $this->vehYear;
    }

    /**
     * Add part
     *
     * @param  \LundProducts\Entity\Parts $part
     * @return VehCollection
     */
    public function addPart(\LundProducts\Entity\Parts $part)
    {
        $this->part[] = $part;

        return $this;
    }

    /**
     * Remove part
     *
     * @param \LundProducts\Entity\Parts $part
     */
    public function removePart(\LundProducts\Entity\Parts $part)
    {
        $this->part->removeElement($part);
    }

    /**
     * Get part
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPart()
    {
        return $this->part;
    }

    /**
     * Set makeId
     *
     * @param  integer       $makeId
     * @return VehCollection
     */
    public function setMakeId($makeId)
    {
        $this->makeId = $makeId;

        return $this;
    }

    /**
     * Get makeId
     *
     * @return integer
     */
    public function getMakeId()
    {
        return $this->makeId;
    }

    /**
     * Set modelId
     *
     * @param  integer       $modelId
     * @return VehCollection
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * Get modelId
     *
     * @return integer
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * Set submodelId
     *
     * @param  integer       $submodelId
     * @return VehCollection
     */
    public function setSubmodelId($submodelId)
    {
        $this->submodelId = $submodelId;

        return $this;
    }

    /**
     * Get submodelId
     *
     * @return integer
     */
    public function getSubmodelId()
    {
        return $this->submodelId;
    }

    /**
     * Set bodyTypeId
     *
     * @param  integer       $bodyTypeId
     * @return VehCollection
     */
    public function setBodyTypeId($bodyTypeId)
    {
        $this->bodyTypeId = $bodyTypeId;

        return $this;
    }

    /**
     * Get bodyTypeId
     *
     * @return integer
     */
    public function getBodyTypeId()
    {
        return $this->bodyTypeId;
    }

    /**
     * Set bodyType
     *
     * @param  string        $bodyType
     * @return VehCollection
     */
    public function setBodyType($bodyType)
    {
        $this->bodyType = $bodyType;

        return $this;
    }

    /**
     * Get bodyType
     *
     * @return string
     */
    public function getBodyType()
    {
        return $this->bodyType;
    }

    /**
     * Set bodyNumDoorsId
     *
     * @param  integer       $bodyNumDoorsId
     * @return VehCollection
     */
    public function setBodyNumDoorsId($bodyNumDoorsId)
    {
        $this->bodyNumDoorsId = $bodyNumDoorsId;

        return $this;
    }

    /**
     * Get bodyNumDoorsId
     *
     * @return integer
     */
    public function getBodyNumDoorsId()
    {
        return $this->bodyNumDoorsId;
    }

    /**
     * Set bedTypeId
     *
     * @param  integer       $bedTypeId
     * @return VehCollection
     */
    public function setBedTypeId($bedTypeId)
    {
        $this->bedTypeId = $bedTypeId;

        return $this;
    }

    /**
     * Get bedTypeId
     *
     * @return integer
     */
    public function getBedTypeId()
    {
        return $this->bedTypeId;
    }

    /**
     * Set bedType
     *
     * @param  string        $bedType
     * @return VehCollection
     */
    public function setBedType($bedType)
    {
        $this->bedType = $bedType;

        return $this;
    }

    /**
     * Get bedType
     *
     * @return string
     */
    public function getBedType()
    {
        return $this->bedType;
    }

    /**
     * Set modelType
     *
     * @param  string $modelType
     * @return VehCollection
     */
    public function setModelType($modelType)
    {
        $this->modelType = $modelType;

        return $this;
    }

    /**
     * Get modelType
     *
     * @return string
     */
    public function getModelType()
    {
        return $this->modelType;
    }
    
    /**
     * Set baseVehId
     *
     * @param  string $baseVehId
     * @return VehCollection
     */
    public function setBaseVehId($baseVehId)
    {
    	$this->baseVehId = $baseVehId;
    
    	return $this;
    }
    
    /**
     * Get baseVehId
     *
     * @return string
     */
    public function getBaseVehId()
    {
    	return $this->baseVehId;
    }
    
    /**
     * Set fitCode1
     *
     * @param  string $fitCode1
     * @return VehCollection
     */
    public function setFitCode1($fitCode1)
    {
        $this->fitCode1= $fitCode1;
        
        return $this;
    }
    
    /**
     * Get fitCode1
     *
     * @return string
     */
    public function getFitCode1()
    {
        return $this->fitCode1;
    }
    
    /**
     * Set fitCode1Desc
     *
     * @param  string $fitCode1Desc
     * @return VehCollection
     */
    public function setFitCode1Desc($fitCode1Desc)
    {
        $this->fitCode1Desc= $fitCode1Desc;
        
        return $this;
    }
    
    /**
     * Get fitCode1Desc
     *
     * @return string
     */
    public function getFitCode1Desc()
    {
        return $this->fitCode1Desc;
    }
    
    /**
     * Set fitCode2
     *
     * @param  string $fitCode2
     * @return VehCollection
     */
    public function setFitCode2($fitCode2)
    {
        $this->fitCode2= $fitCode2;
        
        return $this;
    }
    
    /**
     * Get fitCode2
     *
     * @return string
     */
    public function getFitCode2()
    {
        return $this->fitCode2;
    }
    
    /**
     * Set fitCode2Desc
     *
     * @param  string $fitCode2Desc
     * @return VehCollection
     */
    public function setFitCode2Desc($fitCode2Desc)
    {
        $this->fitCode2Desc= $fitCode2Desc;
        
        return $this;
    }
    
    /**
     * Get fitCode2Desc
     *
     * @return string
     */
    public function getFitCode2Desc()
    {
        return $this->fitCode2Desc;
    }
    
    /**
     * Set fitCode3
     *
     * @param  string $fitCode3
     * @return VehCollection
     */
    public function setFitCode3($fitCode3)
    {
        $this->fitCode3= $fitCode3;
        
        return $this;
    }
    
    /**
     * Get fitCode3
     *
     * @return string
     */
    public function getFitCode3()
    {
        return $this->fitCode3;
    }
    
    /**
     * Set fitCode3Desc
     *
     * @param  string $fitCode3Desc
     * @return VehCollection
     */
    public function setFitCode3Desc($fitCode3Desc)
    {
        $this->fitCode3Desc= $fitCode3Desc;
        
        return $this;
    }
    
    /**
     * Get fitCode3Desc
     *
     * @return string
     */
    public function getFitCode3Desc()
    {
        return $this->fitCode3Desc;
    }
    
    /**
     * Set fitCode4
     *
     * @param  string $fitCode4
     * @return VehCollection
     */
    public function setFitCode4($fitCode4)
    {
        $this->fitCode4= $fitCode4;
        
        return $this;
    }
    
    /**
     * Get fitCode4
     *
     * @return string
     */
    public function getFitCode4()
    {
        return $this->fitCode4;
    }
    
    /**
     * Set fitCode4Desc
     *
     * @param  string $fitCode4Desc
     * @return VehCollection
     */
    public function setFitCode4Desc($fitCode4Desc)
    {
        $this->fitCode4Desc= $fitCode4Desc;
        
        return $this;
    }
    
    /**
     * Get fitCode4Desc
     *
     * @return string
     */
    public function getFitCode4Desc()
    {
        return $this->fitCode4Desc;
    }
    
    /**
     * Set fitCode5
     *
     * @param  string $fitCode5
     * @return VehCollection
     */
    public function setFitCode5($fitCode5)
    {
        $this->fitCode5= $fitCode5;
        
        return $this;
    }
    
    /**
     * Get fitCode5
     *
     * @return string
     */
    public function getFitCode5()
    {
        return $this->fitCode5;
    }
    
    /**
     * Set fitCode5Desc
     *
     * @param  string $fitCode5Desc
     * @return VehCollection
     */
    public function setFitCode5Desc($fitCode5Desc)
    {
        $this->fitCode5Desc= $fitCode5Desc;
        
        return $this;
    }
    
    /**
     * Get fitCode5Desc
     *
     * @return string
     */
    public function getFitCode5Desc()
    {
        return $this->fitCode5Desc;
    }
    
    /**
     * Set jeepClearance
     *
     * @param  integer $jeepClearance
     * @return VehCollection
     */
    public function setJeepClearance($jeepClearance)
    {
        $this->jeepClearance= $jeepClearance;
        
        return $this;
    }
    
    /**
     * Get jeepClearance
     *
     * @return string
     */
    public function getJeepClearance()
    {
        return $this->jeepClearance;
    }
}
