<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Service;

use LundSite\Entity\ContactSubmissionInterface;
use Zend\EventManager\Event;

/**
 * ContactSubmission events.
 */
class ContactSubmissionEvent extends Event
{
    const EVENT_CONTACTSUBMISSION_CREATED = 'contactSubmissionCreated';
    const EVENT_CONTACTSUBMISSION_EDITED  = 'contactSubmissionEdited';
    const EVENT_CONTACTSUBMISSION_DELETED = 'contactSubmissionDeleted';

    /**
     * @var ContactSubmissionInterface
     */
    protected $contactSubmission;

    /**
     * @param string                     $name
     * @param ContactSubmissionInterface $contactSubmission
     */
    public function __construct($name, ContactSubmissionInterface $contactSubmission)
    {
        parent::__construct($name);
        $this->contactSubmission = $contactSubmission;
    }

    /**
     * @param  ContactSubmissionInterface $contactSubmission
     * @return ContactSubmissionEvent
     */
    public function setContactSubmission($contactSubmission)
    {
        $this->contactSubmission = $contactSubmission;

        return $this;
    }

    /**
     * @return ContactSubmissionInterface
     */
    public function getContactSubmission()
    {
        return $this->contactSubmission;
    }
}
