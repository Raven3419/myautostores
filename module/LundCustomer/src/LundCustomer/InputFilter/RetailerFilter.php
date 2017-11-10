<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage InputFilter
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer\InputFilter;

use LundCustomer\Options\LundCustomerOptionsInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\InputFilter\InputFilter;

/**
 * Base input filter for the {@see RetailerFieldset}.
 */
class RetailerFilter extends InputFilter
{
    /**
     * @param ObjectRepository             $objectRepository
     * @param LundCustomerOptionsInterface $options
     */
    public function __construct(
        ObjectRepository $objectRepository,
        LundCustomerOptionsInterface $options)
    {
        $this->add(array(
            'name'       => 'companyName',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));

        $this->add(array(
            'name'       => 'retailerType',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));

        $this->add(array(
            'name'       => 'streetAddress',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'       => 'extStreetAddress',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'       => 'locality',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'       => 'region',
            'required'   => false,
        ));

        $this->add(array(
            'name'       => 'postCode',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'       => 'country',
            'required'   => false,
        ));

        $this->add(array(
            'name'       => 'phoneNumber',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'       => 'latitude',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'       => 'longitude',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'     => 'poiAsset',
            'required' => false,
        ));

        $this->add(array(
            'name'       => 'website',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'     => 'discount',
            'required' => true,
        ));

        $this->add(array(
            'name'       => 'discountCopy',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'       => 'discountUrl',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'     => 'disabled',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'logoAsset',
            'required' => false,
        ));

        $this->add(array(
            'name'     => 'discountAsset',
            'required' => false,
        ));
    }
}
