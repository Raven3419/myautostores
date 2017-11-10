<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\Form\Fieldset;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;

/**
 * Showroom fieldset
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ShowroomFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('showroom-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundSite\Entity\Showroom'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'showroomId',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'firstName',
            'options' => array(
                'label' => 'First Name',
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'span12',
                'placeholder' => 'Enter a first name',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'lastName',
            'options' => array(
                'label' => 'Last Name',
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'span12',
                'placeholder' => 'Enter a last name',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'emailAddress',
            'options' => array(
                'label' => 'Email Address',
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'validate[required,custom[email]] span12',
                'placeholder' => 'Enter an email address',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Checkbox',
            'name'    => 'haveTruck',
            'options' => array(
                'label' => 'Truck',
                'label_attributes' => array(
                    'class' => 'checkbox inline',
                ),
                'use_hidden_element' => false,
             ),
            'attributes' => array(
                'required' => false,
                'class' => 'styled',
                'id' => 'haveTruck',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Checkbox',
            'name'    => 'haveSuv',
            'options' => array(
                'label' => 'SUV',
                'label_attributes' => array(
                    'class' => 'checkbox inline',
                ),
                'use_hidden_element' => false,
             ), 
            'attributes' => array(
                'required' => false,
                'class' => 'styled',
                'id' => 'haveSuv',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Checkbox',
            'name'    => 'haveCuv',
            'options' => array(
                'label' => 'CUV',
                'label_attributes' => array(
                    'class' => 'checkbox inline',
                ),
                'use_hidden_element' => false,
             ), 
            'attributes' => array(
                'required' => false,
                'class' => 'styled',
                'id' => 'haveCuv',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Checkbox',
            'name'    => 'haveVan',
            'options' => array(
                'label' => 'Van',
                'label_attributes' => array(
                    'class' => 'checkbox inline',
                ),
                'use_hidden_element' => false,
             ), 
            'attributes' => array(
                'required' => false,
                'class' => 'styled',
                'id' => 'haveVan',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Checkbox',
            'name'    => 'haveCar',
            'options' => array(
                'label' => 'Passenger Car',
                'label_attributes' => array(
                    'class' => 'checkbox inline',
                ),
                'use_hidden_element' => false,
             ), 
            'attributes' => array(
                'required' => false,
                'class' => 'styled',
                'id' => 'haveCar',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\TextArea',
            'name'    => 'comments',
            'options' => array(
                'label' => 'Comments',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter some comments',
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
            'type'    => 'Zend\Form\Element\Checkbox',
            'name'    => 'optin',
            'options' => array(
                'label'         => 'Terms and Conditions',
                'value_options' => array(
                    '1'  => 'I Agree to Terms and Conditions',
                ),
                'label_attributes' => array(
                    'class' => 'checkbox inline',
                ),
                'use_hidden_element' => false,
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'styled',
                'id'       => 'optinCheckbox',
            ),
        ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'site',
            'options' => array(
                'label'          => 'Site',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketCms\Entity\Site',
                'property'       => 'name',
                'empty_option'   => '---please choose---',
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'validate[required] select',
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
                'empty_option' => '---please choose---',
                'disable_inarray_validator' => true,
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('parentAsset' => '23'),
                        'orderBy' => array('label' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'required' => false,
                'class' => 'select',
            ),
        ));
    }
}
