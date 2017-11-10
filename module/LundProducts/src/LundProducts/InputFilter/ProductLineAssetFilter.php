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
 * Base input filter for the {@see ProductLineAssetFieldset}.
 */
class ProductLineAssetFilter extends InputFilter
{
    /**
     * @param ObjectRepository $objectREpository
     */
    public function __construct(
        ObjectRepository $objectRepository)
    {
        $this->add(array(
            'name'     => 'assetSeq',
            'required' => false,
            'filters'  => array(array('name' => 'Zend\Filter\StringTrim')),
        ));

        $this->add(array(
            'name'     => 'asset',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'assetType',
            'required' => true,
        ));

        $this->add(array(
            'name'     => 'videoType',
            'required' => false,
        ));
    }
}
