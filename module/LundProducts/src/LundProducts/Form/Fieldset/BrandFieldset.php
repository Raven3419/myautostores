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
 * Brand fieldset for admin module
 *
 * @category   Zend
 * @package    LundProducts\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class BrandFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('brand-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundProducts\Entity\Brands'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'brandId',
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
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'label',
            'options' => array(
                'label' => 'Label',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter a label',
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
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'aaiaid',
            'options' => array(
                'label' => 'AAIA ID',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter an aaia id',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'html',
            'options' => array(
                'label' => 'HTML',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter some html',
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
            'name' => 'parentBrand',
            'options' => array(
                'label' => 'Parent Brand',
                'object_manager' => $objectManager,
                'target_class' => 'LundProducts\Entity\Brands',
                'property' => 'name',
                'empty_option' => '---please choose---',
            ),
            'attributes' => array(
                'required' => false,
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'asset',
            'options' => array(
                'label' => 'Logo Asset',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketDam\Entity\Asset',
                'property'       => 'label',
                'disable_inarray_validator' => true,
                'is_method' => true,
                'empty_option'  => 'Please select',
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('parentAsset' => '26', 'assetType' => array('partimage','file')),
                        'orderBy' => array('label' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'select',
            ),
        ));
    }
}
