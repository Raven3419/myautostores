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
use Zend\Validator\ValidatorInterface;

/**
 * Base input filter for the {@see CustomerFieldset}.
 */
class CustomerFilter extends InputFilter
{
    /**
     * @param ObjectRepository             $objectRepository
     * @param ValidatorInterface           $emailValidator
     * @param LundCustomerOptionsInterface $options
     */
    public function __construct(
        ObjectRepository $objectRepository,
        ValidatorInterface $emailValidator,
        LundCustomerOptionsInterface $options)
    {

        $this->add(array(
            'name'       => 'name',
            'required'   => true,
            'filters'    => array(array('name' => 'Zend\Filter\StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'contactName',
            'required' => false,
            'filters'  => array(array('name' => 'Zend\Filter\StringTrim')),
        ));

        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'filters'    => array(array('name' => 'Zend\Filter\StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));

        $this->get('email')->getValidatorChain()->attach($emailValidator);

        $this->add(array(
            'name'     => 'filePickup',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'filePush',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'ftpSite',
            'required' => false,
            'filters'  => array(array('name' => 'Zend\Filter\StringTrim')),
        ));

        $this->add(array(
            'name'     => 'ftpUser',
            'required' => false,
            'filters'  => array(array('name' => 'Zend\Filter\StringTrim')),
        ));

        $this->add(array(
            'name'     => 'ftpPass',
            'required' => false,
            'filters'  => array(array('name' => 'Zend\Filter\StringTrim')),
        ));

        $this->add(array(
            'name'     => 'updateType',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'frequency',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'acesVersion',
            'required' => false,
            'filters'  => array(array('name' => 'Zend\Filter\StringTrim')),
        ));

        $this->add(array(
            'name'     => 'piesVersion',
            'required' => false,
            'filters'  => array(array('name' => 'Zend\Filter\StringTrim')),
        ));

        $this->add(array(
            'name'     => 'lund',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'dfmal',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'avs',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'nifty',
            'required' => 'true',
        ));

        $this->add(array(
            'name'     => 'tradesman',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'lmp',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'amp',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'htam',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'belmor',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'lundAll',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'rampage',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'bushwacker',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'stampede',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'imageType',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'renameImages',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'acceptVideo',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'videoType',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'disabled',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'customerOrDealer',
            'required' => true,
        ));
    }
}
