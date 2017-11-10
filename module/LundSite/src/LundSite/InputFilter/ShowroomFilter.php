<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage InputFilter
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\InputFilter;

use Doctrine\Common\Persistence\ObjectRepository;
use Zend\InputFilter\InputFilter;
use Zend\Validator\ValidatorInterface;

/**
 * Base input filter for the {@see ShowroomFieldset}.
 */
class ShowroomFilter extends InputFilter
{
    /**
     * @param ObjectRepository $objectRepository
     */
    public function __construct(
        ObjectRepository $objectRepository)
    {
        $this->add(array(
            'name'       => 'firstName',
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
            'name'       => 'lastName',
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
            'name'       => 'emailAddress',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string'),
                )
            ),
        ));

        $this->add(array(
            'name'     => 'haveTruck',
            'required' => false,
        ));

        $this->add(array(
            'name'     => 'haveSuv',
            'required' => false,
        ));

        $this->add(array(
            'name'     => 'haveCuv',
            'required' => false,
        ));

        $this->add(array(
            'name'     => 'haveVan',
            'required' => false,
        ));

        $this->add(array(
            'name'     => 'haveCar',
            'required' => false,
        ));

        $this->add(array(
            'name'       => 'comments',
            'required'   => false,
            'filters'    => array(array('name' => 'StringTrim')),
        ));

        $this->add(array(
            'name'     => 'disabled',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'asset',
            'required' => false,
            'allow_empty' => true,
        ));

        $this->add(array(
            'name'       => 'site',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));
    }
}
