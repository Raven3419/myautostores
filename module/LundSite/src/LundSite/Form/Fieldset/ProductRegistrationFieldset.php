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
 * ProductRegistration fieldset
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductRegistrationFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('product-registration-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundSite\Entity\ProductRegistration'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'productRegistrationId',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'title',
            'options' => array(
                'label'         => 'Title',
                'empty_option'   => '---please choose---',
                'value_options' => array(
                    'Mr.'  => 'Mr.',
                    'Mrs.' => 'Mrs.',
                    'Ms.'  => 'Ms.',
                    'Miss' => 'Miss',
                ),
            ),
            'attributes' => array(
                'class'    => 'select',
            ),
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
            'name'    => 'middleInitial',
            'options' => array(
                'label' => 'Initial',
             ),
            'attributes' => array(
                'class'       => 'span4',
                'placeholder' => 'Enter a middle initial',
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
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'productCategory',
            'options' => array(
                'label'          => 'Product Purchased',
                'object_manager' => $objectManager,
                'target_class'   => 'LundProducts\Entity\ProductCategories',
                'property'       => 'displayName',
                'empty_option'   => '---please choose---',
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'upcCode',
            'options' => array(
                'label' => 'Product UPC',
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'span12',
                'placeholder' => 'Enter a upc',
             ),
        ));
    }
}
