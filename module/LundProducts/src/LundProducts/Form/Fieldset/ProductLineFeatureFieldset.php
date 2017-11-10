<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Form\Fieldset;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;

/**
 * ProductLineFeature fieldset
 *
 * @category   Zend
 * @package    LundProducts\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductLineFeatureFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('product-line-feature-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundProducts\Entity\ProductLineFeature'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'productLineFeatureId',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'featureCopy',
            'options' => array(
                'label'         => 'Feature Copy'
            ),
            'attributes' => array(
                'required'  => 'required',
                'class'    => 'span12',
                'placeholder' => 'Enter some copy',
            ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'featureSeq',
            'options' => array(
                'label' => 'Feature Sequence',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a feature sequence',
            ),
        ));
    }
}
