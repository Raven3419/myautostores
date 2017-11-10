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
 * DealersEdge fieldset
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class DealersEdgeFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('dealers-edge-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundSite\Entity\DealersEdge'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'dealersEdgeId',
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
                'label' => 'Locality',
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
                'required'    => 'required',
                'type'        => 'tel',
                'class'       => 'span12',
                'placeholder' => 'Enter a telephone number',
                'pattern'     => '^\(?[0-9]{3}\)?[-.]?([0-9]{3})[-.]?([0-9]{4})$',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'faxNumber',
            'options' => array(
                'label' => 'Fax Number',
             ),
            'attributes' => array(
                'type'        => 'tel',
                'class'       => 'span12',
                'placeholder' => 'Enter a fax number',
                'pattern'     => '^\(?[0-9]{3}\)?[-.]?([0-9]{3})[-.]?([0-9]{4})$',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Radio',
            'name'    => 'existingDealer',
            'options' => array(
                'label' => 'Existing Dealer?',
                'value_options' => array(
                    '1' => 'Already a Dealer',
                    '0' => 'New Dealer',
                ),
                'label_attributes' => array(
                    'class' => 'radio inline',
                ),
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'styled',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'distributor',
            'options' => array(
                'label' => 'Warehouse Distributor(s)',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a distributor',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'brands',
            'options' => array(
                'label'         => 'Retailer of the following brands:',
                'value_options' => array(
                    'all'  => 'All Brands',
                    'avs'  => 'AVS',
                    'lund' => 'LUND',
                ),
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'select',
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
