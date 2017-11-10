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
 * Base input filter for the {@see VideoTestimonialsFieldset}.
 */
class VideoTestimonialsFilter extends InputFilter
{
    /**
     * @param ObjectRepository $objectRepository
     */
    public function __construct( ObjectRepository $objectRepository )
    {
        $this->add(array(
            'name'       => 'status',
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
            'name'       => 'title',
            'filters'    => array(array('name' => 'Zend\Filter\StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));
        
        $this->add(array(
            'name'       => 'comment',
            'filters'    => array(array('name' => 'Zend\Filter\StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));
        
        $this->add(array(
            'name'       => 'url',
            'required'   => true,
            'filters'    => array(array('name' => 'Zend\Filter\StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'Zend\Validator\NotEmpty',
                    'options' => array('type' => 'string'),
                ),
            ),
        ));
    }
}
