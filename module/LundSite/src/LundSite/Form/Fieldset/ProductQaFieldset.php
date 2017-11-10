<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\Form\Fieldset;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;

/**
 * ProductQa fieldset
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductQaFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('productQa-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundSite\Entity\ProductQa'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'productQaId',
        ));
        
        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'question',
            'options' => array(
                'label' => 'Question',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a question',
            ),
        ));
        
        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'answer',
            'options' => array(
                'label' => 'Answer',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a answer',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'status',
            'options' => array(
                'label' => 'Status',
                'value_options' => array(
                    '0' => 'Published',
                    '1'  => 'Disabled',
                    '2'  => 'Pending',
                ),
             ),
            'attributes' => array(
                'required' => 'required',
                'class'       => 'validate[required select]',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'email',
            'options' => array(
                'label' => 'Email',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an email',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'name',
            'options' => array(
                'label' => 'Name',
             ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an name',
             ),
        ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'productLine',
            'options' => array(
                'label'          => 'Product Line',
                'object_manager' => $objectManager,
                'target_class'   => 'LundProducts\Entity\ProductLines',
                'property'       => 'name',
                'empty_option'   => '---please choose---',
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'validate[required] select',
            ),
        ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'ecomCustomer',
            'options' => array(
                'label'          => 'Ecom Customer',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketEcom\Entity\EcomCustomer',
                'property'       => 'email',
                'empty_option'   => '---please choose---',
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'validate[required] select',
            ),
        ));
    }
}
