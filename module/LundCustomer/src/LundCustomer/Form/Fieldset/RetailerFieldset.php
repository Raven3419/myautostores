<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer\Form\Fieldset;

use LundCustomer\Options\LundCustomerOptionsInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;

/**
 * Retailer fieldset
 *
 * @category   Zend
 * @package    LundCustomer\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class RetailerFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param LundCustomerOptionsInterface $options
     * @param ObjectManager                $objectManager
     */
    public function __construct(LundCustomerOptionsInterface $options, ObjectManager $objectManager)
    {
        parent::__construct('retailer-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundCustomer\Entity\Retailer'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'retailerId',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'retailerType',
            'options' => array(
                'label'         => 'Retailer Type',
                'empty_option'  => '---please choose---',
                'value_options' => array(
                    'physical' => 'Physical',
                    'online'  => 'Online',
                ),
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'companyName',
            'options' => array(
                'label' => 'Company Name',
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'span12',
                'placeholder' => 'Enter a company name',
             ),
         ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'logoAsset',
            'options' => array(
                'label' => 'Logo Asset',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketDam\Entity\Asset',
                'property'       => 'label',
                'empty_option'  => '---please choose---',
                'disable_inarray_validator' => true,
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('parentAsset' => '20'),
                        'orderBy' => array('label' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'streetAddress',
            'options' => array(
                'label' => 'Street Address',
             ),
            'attributes' => array(
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
                'label' => 'Locality',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a locality',
             ),
        ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'region',
            'options' => array(
                'label'          => 'Region',
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
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'latitude',
            'options' => array(
                'label' => 'Latitude',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a latitude coordinate',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'longitude',
            'options' => array(
                'label' => 'Longitude',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a longitude coordinate',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'poiAsset',
            'options' => array(
                'label' => 'POI Asset',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketDam\Entity\Asset',
                'property'       => 'label',
                'empty_option'  => '---please choose---',
                'disable_inarray_validator' => true,
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('parentAsset' => '20'),
                        'orderBy' => array('label' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'website',
            'options' => array(
                'label' => 'Website URL',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a website url',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'discount',
            'options' => array(
                'label'         => 'Has Discount',
                'value_options' => array(
                    '0' => 'No',
                    '1'  => 'Yes',
                ),
            ),
            'attributes' => array(
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'discountAsset',
            'options' => array(
                'label' => 'Discount Asset',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketDam\Entity\Asset',
                'property'       => 'label',
                'empty_option'  => '---please choose---',
                'disable_inarray_validator' => true,
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('parentAsset' => '20'),
                        'orderBy' => array('label' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\TextArea',
            'name'    => 'discountCopy',
            'options' => array(
                'label' => 'Discount Copy',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter some discount copy',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'discountUrl',
            'options' => array(
                'label' => 'Discount URL',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a discount url',
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
    }
}
