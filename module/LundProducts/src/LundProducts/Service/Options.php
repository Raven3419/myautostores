<?php

namespace LundProducts\Service;

use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    public function __construct(array $options= null)
    {
        parent::__construct($options);
    }

    /**
     * @var array
     */
    protected $messages = array(
        'brand-creation-success' => 'You have successfully created a new brand.',
        'brand-creation-error'   => 'There was an error creating a new brand.',
        'brand-edit-success'     => 'You have successfully edited the brand.',
        'brand-edit-error'       => 'There was an error editing the brand.',
        'brand-delete-success'   => 'You have successfully deleted the brand.',
        'global-invalid-id'      => 'You have attempted to access an invalid record.',
    );

    /**
    * @param array $messages
    */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
    * @return array
    */
    public function getMessages()
    {
        return $this->messages;
    }
}
