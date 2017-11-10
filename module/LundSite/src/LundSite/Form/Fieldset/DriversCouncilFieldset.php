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
 * DriversCouncil fieldset
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class DriversCouncilFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('drivers-council-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundSite\Entity\DriversCouncil'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'driversCouncilId',
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
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'streetAddress',
            'options' => array(
                'label' => 'Street Address',
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'span12',
                'placeholder' => 'Enter a street address',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'extStreetAddress',
            'options' => array(
                'label' => 'Extended Street Address',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an extended street address',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'locality',
            'options' => array(
                'label' => 'City',
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'span12',
                'placeholder' => 'Enter a locality',
             ),
        ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'region',
            'options' => array(
                'label'          => 'State',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketBase\Entity\State',
                'property'       => 'subdivisionName',
                'empty_option'   => '---please choose---',
                'is_method'      => true,
                'find_method'    => array(
                    'name'   => 'findBy',
                    'params' => array(
                        'criteria' => array('codeChar3' => array('USA','CAN')),
                        'orderBy'  => array('subdivisionName' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'postCode',
            'options' => array(
                'label' => 'Postal Code',
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'span12',
                'placeholder' => 'Enter a postal code',
             ),
        ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'country',
            'options' => array(
                'label'          => 'Country',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketBase\Entity\Country',
                'property'       => 'name',
                'empty_option'   => '---please choose---',
                'is_method'      => true,
                'find_method'    => array(
                    'name'   => 'findBy',
                    'params' => array(
                        'criteria' => array('codeChar3' => array('USA','CAN')),
                        'orderBy'  => array('name' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'phoneNumber',
            'options' => array(
                'label' => 'Phone Number',
             ),
            'attributes' => array(
                'type'        => 'tel',
                'class'       => 'span12',
                'placeholder' => 'Enter a telephone number',
                'pattern'     => '^\(?[0-9]{3}\)?[-.]?([0-9]{3})[-.]?([0-9]{4})$',
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
    }
}
