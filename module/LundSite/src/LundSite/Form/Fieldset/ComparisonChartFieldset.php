<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundSite\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * Product Line fieldset for admin module
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ComparisonChartFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('comparisonChartfieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundSite\Entity\ComparisonChart'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'comparisonChartId',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'name',
            'options' => array(
                'label' => 'Name',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter a name',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'disabled',
            'options' => array(
                'label'         => 'Disabled',
                'value_options' => array(
                    '0' => 'No',
                    '1'  => 'Yes',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'profile',
            'options' => array(
                'label' => 'Profile',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a profile',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'vehicleType',
            'options' => array(
                'label' => 'Vehicle Type',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an vehicle type',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'areaOfProtection',
            'options' => array(
                'label' => 'Area Of Protection',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a area of protection',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'material',
            'options' => array(
                'label' => 'Material',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a material',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'availableColors',
            'options' => array(
                'label' => 'Available Colors',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a available colors',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'drilling',
            'options' => array(
                'label'         => 'Installs without drilling',
                'value_options' => array(
                    '0' => 'No',
                    '1'  => 'Yes',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'safe',
            'options' => array(
                'label'         => 'Car wash safe',
                'value_options' => array(
                    '0' => 'No',
                    '1'  => 'Yes',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'usa',
            'options' => array(
                'label'         => 'Made in the USA',
                'value_options' => array(
                    '0' => 'No',
                    '1'  => 'Yes',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'warranty',
            'options' => array(
                'label'         => 'Warranty Information',
                'value_options' => array(
                    '0' => 'Lifetime Warranty',
                    '1'  => 'Limited Lifetime Warranty',
                    '2'  => '3 year Limited Warranty',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'asset',
            'options' => array(
                'label' => 'Style',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketDam\Entity\Asset',
                'property'       => 'label',
                'disable_inarray_validator' => true,
                'is_method' => true,
                'empty_option'  => 'Please select',
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('parentAsset' => '18863', 'disabled' => '0', 'deleted' => '0'),
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
