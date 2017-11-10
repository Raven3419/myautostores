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

use Doctrine\Common\Persistence\ObjectRepository;
use Zend\InputFilter\InputFilter;

/**
 * Base input filter for the {@see BrandProductCategoryFieldset}.
 */
class BrandProductCategoryFilter extends InputFilter
{
    /**
     * @param ObjectRepository $objectREpository
     */
    public function __construct(
        ObjectRepository $objectRepository)
    {
        $this->add(array(
            'name'     => 'productCategory',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'shortDescr',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'longDescr',
            'required' => false,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'     => 'displayStyles',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'disabled',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'featured',
            'required' => true,
        ));

        $this->add(array(
            'name'       => 'position',
            'required'   => false,
            'filters'    => array(
                array('name' => 'Zend\Filter\StringTrim'),
            ),
            'validators' => array(
                array('name' => 'Zend\Validator\Digits'),
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
