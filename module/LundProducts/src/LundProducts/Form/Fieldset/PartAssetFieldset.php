<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Form\Fieldset;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;

/**
 * PartAsset fieldset
 *
 * @category   Zend
 * @package    LundProducts\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class PartAssetFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('part-asset-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundProducts\Entity\PartAsset'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'partAssetId',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'assetType',
            'options' => array(
                'label'         => 'Asset Type',
                'empty_option'  => 'Please select',
                'value_options' => array(
                    'picture' => 'Picture',
                    'video' => 'Video',
                ),
             ),
             'attributes' => array(
                'required'  => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'picType',
            'options' => array(
                'label'         => 'Picture Type',
                'empty_option'  => 'Please select',
                'value_options' => array(
                    'P01' => 'P01 - Off Vehicle',
                    'P03' => 'P03 - Lifestyle',
                    'P04' => 'P04 - Primary Photo',
                    'P05' => 'P05 - Closeup',
                    'P06' => 'P06 - Mounted',
                    'P07' => 'P07 - Unmounted',
                ),
             ),
             'attributes' => array(
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'videoType',
            'options' => array(
                'label'         => 'Video Type',
                'empty_option'  => 'Please select',
                'value_options' => array(
                    'installation' => 'Installation Video',
                    'other' => 'Other Video',
                ),
             ),
             'attributes' => array(
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'amazonName',
            'options' => array(
                'label' => 'Amazon Name',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an Amazon name',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'assetSeq',
            'options' => array(
                'label' => 'Asset Sequence',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an asset sequence',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'asset',
            'options' => array(
                'label' => 'Media Asset',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketDam\Entity\Asset',
                'property'       => 'label',
                'disable_inarray_validator' => true,
                'is_method' => true,
                'empty_option'  => 'Please select',
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('parentAsset' => '9', 'assetType' => array('partimage','file')),
                        'orderBy' => array('label' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'select',
            ),
        ));
    }
}
