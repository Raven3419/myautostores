<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * Product Line fieldset for admin module
 *
 * @category   Zend
 * @package    LundProducts\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductLineFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('productlinefieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundProducts\Entity\ProductLines'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'productLineId',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'displayName',
            'options' => array(
                'label' => 'Display Name',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter a display name',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'name',
            'options' => array(
                'label' => 'Name',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter a name',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'shortCode',
            'options' => array(
                'label' => 'Short Code',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter a short code',
            ),
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
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'brand',
            'options' => array(
                'label'          => 'Brand',
                'object_manager' => $objectManager,
                'target_class'   => 'LundProducts\Entity\Brands',
                'property'       => 'name',
                'empty_option'   => '---please choose---',
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'productCategory',
            'options' => array(
                'label'          => 'Product Category',
                'object_manager' => $objectManager,
                'target_class'   => 'LundProducts\Entity\ProductCategories',
                'property'       => 'name',
                'empty_option'   => '---please choose---',
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'overview',
            'options' => array(
                'label' => 'Overview',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an overview',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'websiteOverview',
            'options' => array(
                'label' => 'Website Overview',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an website html',
             ),
        ));
        
        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'teaser',
            'options' => array(
                'label' => 'Teaser',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an website teaser',
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
                'placeholder' => 'Enter an position',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'brandPosition',
            'options' => array(
                'label' => 'Brand Position',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a brand position',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'saleable',
            'options' => array(
                'label'         => 'Saleable',
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
            'name'    => 'installationVideo',
            'options' => array(
                'label' => 'Installation Video',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an installation video',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'bpcsCode',
            'options' => array(
                'label' => 'BPCS Code',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a bpcs code',
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
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'comparisonChart',
            'options' => array(
                'label'          => 'Comparison Chart',
                'object_manager' => $objectManager,
                'target_class'   => 'LundSite\Entity\ComparisonChart',
                'property'       => 'name',
                'empty_option'   => '---please choose---',
            ),
            'attributes' => array(
                'required' => false,
                'class' => 'select',
            ),
        ));
    }
}
