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
 * VehCollection interface
 */
interface VehCollectionInterface
{
    /**
     * @return integer
     */
    public function getVehCollectionId();

    /**
     * Add vehCollections
     *
     * @param  \LundProducts\Entity\PartVehCollection $vehCollections
     * @return VehCollection
     */
    public function addVehCollection(\LundProducts\Entity\PartVehCollection $vehCollections);

    /**
     * Remove vehCollections
     *
     * @param \LundProducts\Entity\PartVehCollection $vehCollections
     */
    public function removeVehCollection(\LundProducts\Entity\PartVehCollection $vehCollections);

    /**
     * Get vehCollections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehCollections();

    /**
     * @param  \LundProducts\Entity\VehMake $vehMake
     * @return VehCollection
     */
    public function setVehMake(\LundProducts\Entity\VehMake $vehMake = null);

    /**
     * @return \LundProducts\Entity\VehMake
     */
    public function getVehMake();

    /**
     * @param  \LundProducts\Entity\VehModel $vehModel
     * @return VehCollection
     */
    public function setVehModel(\LundProducts\Entity\VehModel $vehModel = null);

    /**
     * @return \LundProducts\Entity\VehModel
     */
    public function getVehModel();

    /**
     * @param  \LundProducts\Entity\VehSubmodel $vehSubmodel
     * @return VehCollection
     */
    public function setVehSubmodel(\LundProducts\Entity\VehSubmodel $vehSubmodel = null);

    /**
     * @return \LundProducts\Entity\VehSubmodel
     */
    public function getVehSubmodel();

    /**
     * @param  \LundProducts\Entity\VehYear $vehYear
     * @return VehCollection
     */
    public function setVehYear(\LundProducts\Entity\VehYear $vehYear = null);

    /**
     * @return \LundProducts\Entity\VehYear
     */
    public function getVehYear();

    /**
     * @param  \LundProducts\Entity\Parts $part
     * @return VehCollection
     */
    public function addPart(\LundProducts\Entity\Parts $part);

    /**
     * @param \LundProducts\Entity\Parts $part
     */
    public function removePart(\LundProducts\Entity\Parts $part);

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPart();

    /**
     * Set makeId
     *
     * @param  integer       $makeId
     * @return VehCollection
     */
    public function setMakeId($makeId);

    /**
     * Get makeId
     *
     * @return integer
     */
    public function getMakeId();

    /**
     * Set modelId
     *
     * @param  integer       $modelId
     * @return VehCollection
     */
    public function setModelId($modelId);

    /**
     * Get modelId
     *
     * @return integer
     */
    public function getModelId();

    /**
     * Set submodelId
     *
     * @param  integer       $submodelId
     * @return VehCollection
     */
    public function setSubmodelId($submodelId);

    /**
     * Get submodelId
     *
     * @return integer
     */
    public function getSubmodelId();

    /**
     * Set bodyTypeId
     *
     * @param  integer       $bodyTypeId
     * @return VehCollection
     */
    public function setBodyTypeId($bodyTypeId);

    /**
     * Get bodyTypeId
     *
     * @return integer
     */
    public function getBodyTypeId();

    /**
     * @param  string        $bodyType
     * @return VehCollection
     */
    public function setBodyType($bodyType);

    /**
     * @return string
     */
    public function getBodyType();

    /**
     * Set bodyNumDoorsId
     *
     * @param  integer       $bodyNumDoorsId
     * @return VehCollection
     */
    public function setBodyNumDoorsId($bodyNumDoorsId);

    /**
     * Get bodyNumDoorsId
     *
     * @return integer
     */
    public function getBodyNumDoorsId();

    /**
     * Set bedTypeId
     *
     * @param  integer       $bedTypeId
     * @return VehCollection
     */
    public function setBedTypeId($bedTypeId);

    /**
     * Get bedTypeId
     *
     * @return integer
     */
    public function getBedTypeId();

    /**
     * @param  string        $bedType;
     * @return VehCollection
     */
    public function setBedType($bedType);

    /**
     * @return string
     */
    public function getBedType();

    /**
     * Set modelType
     *
     * @param  string $modelType
     * @return VehCollection
     */
    public function setModelType($modelType);

    /**
     * Get modelType
     *
     * @return string
     */
    public function getModelType();
    


    /**
     * Set baseVehId
     *
     * @param  string $baseVehId
     * @return VehCollection
     */
    public function setBaseVehId($baseVehId);
    
    /**
     * Get baseVehId
     *
     * @return string
    */
    public function getBaseVehId();
    
    /**
     * Set fitCode1
     *
     * @param  string $fitCode1
     * @return VehCollection
     */
    public function setFitCode1($fitCode1);
    
    /**
     * Get fitCode1
     *
     * @return string
     */
    public function getFitCode1();
    
    /**
     * Set fitCode1Desc
     *
     * @param  string $fitCode1Desc
     * @return VehCollection
     */
    public function setFitCode1Desc($fitCode1Desc);
    
    /**
     * Get fitCode1Desc
     *
     * @return string
     */
    public function getFitCode1Desc();
    
    /**
     * Set fitCode2
     *
     * @param  string $fitCode2
     * @return VehCollection
     */
    public function setFitCode2($fitCode2);
    
    /**
     * Get fitCode2
     *
     * @return string
     */
    public function getFitCode2();
    
    /**
     * Set fitCode2Desc
     *
     * @param  string $fitCode2Desc
     * @return VehCollection
     */
    public function setFitCode2Desc($fitCode2Desc);
    
    /**
     * Get fitCode2Desc
     *
     * @return string
     */
    public function getFitCode2Desc();
    
    /**
     * Set fitCode3
     *
     * @param  string $fitCode3
     * @return VehCollection
     */
    public function setFitCode3($fitCode3);
    
    /**
     * Get fitCode3
     *
     * @return string
     */
    public function getFitCode3();
    
    /**
     * Set fitCode3Desc
     *
     * @param  string $fitCode3Desc
     * @return VehCollection
     */
    public function setFitCode3Desc($fitCode3Desc);
    
    /**
     * Get fitCode3Desc
     *
     * @return string
     */
    public function getFitCode3Desc();
    
    /**
     * Set fitCode4
     *
     * @param  string $fitCode4
     * @return VehCollection
     */
    public function setFitCode4($fitCode4);
    
    /**
     * Get fitCode4
     *
     * @return string
     */
    public function getFitCode4();
    
    /**
     * Set fitCode4Desc
     *
     * @param  string $fitCode4Desc
     * @return VehCollection
     */
    public function setFitCode4Desc($fitCode4Desc);
    
    /**
     * Get fitCode4Desc
     *
     * @return string
     */
    public function getFitCode4Desc();
    
    /**
     * Set fitCode5
     *
     * @param  string $fitCode5
     * @return VehCollection
     */
    public function setFitCode5($fitCode5);
    
    /**
     * Get fitCode5
     *
     * @return string
     */
    public function getFitCode5();
    
    /**
     * Set fitCode5Desc
     *
     * @param  string $fitCode5Desc
     * @return VehCollection
     */
    public function setFitCode5Desc($fitCode5Desc);
    
    /**
     * Get fitCode5Desc
     *
     * @return string
     */
    public function getFitCode5Desc();
    
    /**
     * Set jeepClearance
     *
     * @param  integer $jeepClearance
     * @return VehCollection
     */
    public function setJeepClearance($jeepClearance);
    
    /**
     * Get jeepClearance
     *
     * @return string
     */
    public function getJeepClearance();
    
}
