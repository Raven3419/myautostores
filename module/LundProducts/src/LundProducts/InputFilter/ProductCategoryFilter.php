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
 * Base input filter for the {@see ProductCategoryFieldset}.
 */
class ProductCategoryFilter extends InputFilter
{
    /**
     * @param ObjectRepository     $objectRepository
     * @param ValidatorInterface   $shortCodeValidator
     * @param UserOptionsInterface $options
     */
    public function __construct(
        ObjectRepository             $objectRepository,
        ValidatorInterface           $shortCodeValidator,
        LundProductsOptionsInterface $options
    )
    {
        $this->add(array(
            'name'     => 'productCategoryId',
            'required' => false,
        ));

        $this->add(array(
            'name'       => 'displayName',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));

        $this->add(array(
            'name'       => 'name',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));

        $this->add(array(
            'name'       => 'shortCode',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StringTrim'),
                //array('name' => 'StringToLower'),
            ),
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string')
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'bpcsCode',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'asset',
            'required' => false,
            'allow_empty' => true,
        ));
        
        $this->add(array(
            'name'     => 'headerAsset',
            'required' => false,
            'allow_empty' => true,
        ));

        // attach shortCode validator
        $this->get('shortCode')->getValidatorChain()->attach($shortCodeValidator);
    }
}
