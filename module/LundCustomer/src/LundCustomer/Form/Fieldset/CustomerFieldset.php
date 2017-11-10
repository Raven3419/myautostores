<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer\Form\Fieldset;

use LundCustomer\Options\LundCustomerOptionsInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;

/**
 * Customer fieldset
 *
 * @category   Zend
 * @package    LundCustomer\Form
 * @subpackage Fieldset
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class CustomerFieldset extends Fieldset
{
    /**
     * Constructor
     *
     * @param LundCustomerOptionsInterface $options
     * @param ObjectManager                $objectManager
     */
    public function __construct(LundCustomerOptionsInterface $options, ObjectManager $objectManager)
    {
        parent::__construct('customer-fieldset');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'LundCustomer\Entity\Customer'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'customerId',
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
            'name'    => 'custId',
            'options' => array(
                'label' => 'BPCS Customer ID',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter a BPCS customer id',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'contactName',
            'options' => array(
                'label' => 'Contact Name',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a contact name',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'email',
            'options' => array(
                'label' => 'Email Address',
            ),
            'attributes' => array(
                'required'    => 'required',
                'class'       => 'validate[required] span12',
                'placeholder' => 'Enter an email address',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'filePickup',
            'options' => array(
                'label'         => 'File Pickup',
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
            'name'    => 'filePush',
            'options' => array(
                'label'         => 'File Push',
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
            'name'    => 'ftpSite',
            'options' => array(
                'label' => 'FTP Site',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a ftp site',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'ftpUser',
            'options' => array(
                'label' => 'FTP User',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a ftp user',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'ftpPass',
            'options' => array(
                'label' => 'FTP Pass',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a ftp pass',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'updateType',
            'options' => array(
                'label'         => 'Update Type',
                'value_options' => array(
                    'net'  => 'Net Change',
                    'full' => 'Full',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'frequency',
            'options' => array(
                'label'         => 'Frequency',
                'value_options' => array(
                    'week'  => 'Weekly',
                    'month' => 'Monthly',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'acesVersion',
            'options' => array(
                'label' => 'ACES Version',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter an ACES version',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'piesVersion',
            'options' => array(
                'label' => 'PIES Version',
            ),
            'attributes' => array(
                'class'       => 'span12',
                'placeholder' => 'Enter a PIES version',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'lund',
            'options' => array(
                'label'         => 'Include LUND',
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
            'name'    => 'dfmal',
            'options' => array(
                'label'         => 'Include DFSA',
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
            'name'    => 'avs',
            'options' => array(
                'label'         => 'Include AVS',
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
            'name'    => 'nifty',
            'options' => array(
                'label'         => 'Include Nifty',
                'value_options' => array(
                    '0' => 'No',
                    '1' => 'Yes',
                ),
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'select',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'tradesman',
            'options' => array(
                'label'         => 'Include Tradesman',
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
            'name'    => 'lmp',
            'options' => array(
                'label'         => 'Include LMP',
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
            'name'    => 'amp',
            'options' => array(
                'label'         => 'Include AMP',
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
            'name'    => 'htam',
            'options' => array(
                'label'         => 'Include HT-AM',
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
            'name'    => 'belmor',
            'options' => array(
                'label'         => 'Include Belmor',
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
            'name'    => 'lundAll',
            'options' => array(
                'label'         => 'Include LundAll',
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
            'name'    => 'rampage',
            'options' => array(
                'label'         => 'Include Rampage',
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
            'name'    => 'bushwacker',
            'options' => array(
                'label'         => 'Include Bushwacker',
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
            'name'    => 'stampede',
            'options' => array(
                'label'         => 'Include Stampede',
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
            'name'    => 'imageType',
            'options' => array(
                'label'         => 'Image Type',
                'value_options' => array(
                    'HIGH' => 'High Resolution',
                    'LOW'  => 'Low Resolution',
                    'WEB'  => 'Web Ready',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
             ),
         ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'renameImages',
            'options' => array(
                'label'         => 'Rename Images',
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
            'name'    => 'acceptVideo',
            'options' => array(
                'label'         => 'Accept Video',
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
            'name'    => 'videoType',
            'options' => array(
                'label'         => 'Video Type',
                'value_options' => array(
                    'MPEG4' => 'MPEG4',
                ),
             ),
             'attributes' => array(
                 'required' => 'required',
                 'class'    => 'select',
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
        		'type'    => 'Zend\Form\Element\Select',
        		'name'    => 'customerOrDealer',
        		'options' => array(
        				'label'         => 'Customer Or Dealer',
        				'value_options' => array(
        						'C' => 'Customer',
        						'D' => 'Dealer',
        						'R' => 'Rep',
        				),
        		),
        		'attributes' => array(
        				'required' => 'required',
        				'class'    => 'select',
        		),
        ));
    }
}
