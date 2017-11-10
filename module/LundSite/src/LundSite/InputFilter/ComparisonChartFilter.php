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
use Zend\Validator\ValidatorInterface;
use Zend\InputFilter\InputFilter;

/**
 * Base input filter for the {@see ComparisonChartFieldset}.
 */
class ComparisonChartFilter extends InputFilter
{
    /**
     * @param ObjectRepository     $objectRepository
     */
    public function __construct(
        ObjectRepository             $objectRepository
    )
    {
        $this->add(array(
            'name'     => 'comparisonChartId',
            'required' => false
        ));

        $this->add(array(
            'name'       => 'name',
            'required'   => true,
            'filters'    => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name'    => 'NotEmpty',
                    'options' => array('type' => 'string')
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'profile',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'vehicleType',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'areaOfProtection',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'material',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'availableColors',
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
            'name'     => 'drilling',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'safe',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'usa',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'warranty',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

       $this->add(array(
          'name'     => 'asset',
          'required' => true,
       ));

    }
}
