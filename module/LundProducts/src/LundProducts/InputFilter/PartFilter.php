<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage InputFilter
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\InputFilter;

use LundProducts\Options\LundProductsOptionsInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Validator\ValidatorInterface;
use Zend\InputFilter\InputFilter;

/**
 * Base input filter for the {@see PartFieldset}.
 */
class PartFilter extends InputFilter
{
    /**
     * @param ObjectRepository     $objectRepository
     * @param ValidatorInterface   $partNumberValidator
     * @param UserOptionsInterface $options
     */
    public function __construct(
        ObjectRepository             $objectRepository,
        ValidatorInterface           $partNumberValidator,
        LundProductsOptionsInterface $options
    )
    {
        $this->add(array(
            'name'     => 'partId',
            'required' => false
        ));

        $this->add(array(
            'name'       => 'partNumber',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string')
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'partVariant',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'disabled',
            'required' => true,
        ));

        $this->add(array(
            'name'       => 'productClass',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'detail',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'jobberPrice',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'msrpPrice',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'salePrice',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'shippingPrice',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'color',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'popCode',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'upcCode',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'status',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'weight',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'height',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'width',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'length',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'       => 'productLine',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'parentPart',
            'required' => false,
            'filters'  => array(
                array('name' => 'Null'),
            ),
        ));

        // attach partNumber validator
        $this->get('partNumber')->getValidatorChain()->attach($partNumberValidator);

        $this->add(array(
            'name'     => 'isheet',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'bedLength',
            'required' => false,
            'filters'  => array(
                array('name' => 'Null'),
            ),
        ));

        $this->add(array(
            'name'     => 'bedLengthId',
            'required' => false,
            'filters'  => array(
                array('name' => 'Null'),
            ),
        ));

        $this->add(array(
            'name'     => 'flareHeight',
            'required' => false,
            'filters'  => array(
                array('name' => 'Null'),
            ),
        ));

        $this->add(array(
            'name'     => 'flareTireCoverage',
            'required' => false,
            'filters'  => array(
                array('name' => 'Null'),
            ),
        ));

        $this->add(array(
            'name'     => 'vehicleType',
            'required' => false,
            'filters'  => array(
                array('name' => 'Null'),
            ),
        ));

        $this->add(array(
            'name'     => 'noDrill',
            'required' => false,
            'filters'  => array(
                array('name' => 'Null'),
            ),
        ));

        $this->add(array(
            'name'     => 'metaTitle',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'metaKeywords',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'metaDescr',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));
    }
}
