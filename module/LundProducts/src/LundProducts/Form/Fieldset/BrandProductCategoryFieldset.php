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
 * BrandProductCategory fieldset
 *
 * @category   Zend
 * @package    LundProducts\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class BrandProductCategoryFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('brand-product-category-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundProducts\Entity\BrandProductCategory'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'brandProductCategoryId',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'disabled',
            'options' => array(
                'label'         => 'Disabled',
                'value_options' => array(
                    '0' => 'No',
                    '1'  => 'Yes',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'shortDescr',
            'options' => array(
                'label' => 'Short Description',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a short description',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'longDescr',
            'options' => array(
                'label' => 'Long Description',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a long description',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'displayStyles',
            'options' => array(
                'label'         => 'Display Style in Long Description',
                'value_options' => array(
                    '0' => 'No',
                    '1'  => 'Yes',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'featured',
            'options' => array(
                'label'         => 'Featured',
                'value_options' => array(
                    '0' => 'No',
                    '1'  => 'Yes',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'position',
            'options' => array(
                'label' => 'Position',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter the position',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'metaTitle',
            'options' => array(
                'label' => 'META Title',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a META title',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'metaKeywords',
            'options' => array(
                'label' => 'META Keywords',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter META keywords',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'metaDescr',
            'options' => array(
                'label' => 'META Description',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a META description',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'productCategory',
            'options' => array(
                'label' => 'Product Category',
                'object_manager' => $objectManager,
                'target_class'   => 'LundProducts\Entity\ProductCategories',
                'property'       => 'displayName',
                'disable_inarray_validator' => true,
                'empty_option'  => 'Please select',
            ),
            'attributes' => array(
                'required' => 'required',
                'class' => 'select',
            ),
        ));
    }
}
