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
 * NewsRelease fieldset
 *
 * @category   Zend
 * @package    LundSite\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class NewsReleaseFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('news-release-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundSite\Entity\NewsRelease'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'newsReleaseId',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'title',
            'options' => array(
                'label' => 'Title',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter a title',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'newsType',
            'options' => array(
                'label'         => 'News Release Type',
                'value_options' => array(
                    'onsite' => 'On Site',
                    'external'  => 'External Site',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'validate[required] select',
             ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'url',
            'options' => array(
                'label' => 'URL',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter a URL',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Date',
            'name'    => 'displayDate',
            'options' => array(
                'label' => 'Display Date',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter a date',
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
                'placeholder' => 'Enter a teaser',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'html',
            'options' => array(
                'label' => 'Release Content',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a teaser',
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
                 'class'    => 'validate[required] select',
             ),
         ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'site',
            'options' => array(
                'label'          => 'Site',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketCms\Entity\Site',
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
            'name'    => 'brand',
            'options' => array(
                'label'          => 'Brand',
                'object_manager' => $objectManager,
                'target_class'   => 'LundProducts\Entity\Brands',
                'property'       => 'name',
                'empty_option'   => '---please choose---',
            ),
            'attributes' => array(
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'image',
            'options' => array(
                'label' => 'Media Asset',
                'object_manager' => $objectManager,
                'target_class'   => 'RocketDam\Entity\Asset',
                'property'       => 'label',
                'empty_option' => '---please choose---',
                'disable_inarray_validator' => true,
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('parentAsset' => '1099'),
                        'orderBy' => array('label' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'validate[required] select',
            ),
        ));
    }
}
