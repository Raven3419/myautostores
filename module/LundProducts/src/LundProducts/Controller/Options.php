<?php

namespace LundProducts\Controller;

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
        'global-invalid-id'               => 'You have attempted to access an invalid record.',
        'login-invalid-credentials'       => 'You have entered invalid credentials.',
        'login-invalid-username'          => 'You must enter your username to proceed.',
        'login-request-password-success'  => 'Your password reset request has been sent. Please check the email associated with your account.',
        'login-request-password-error'    => 'We were unable to locate the username you provided.',
        'login-reset-password-success'    => 'Your password has been reset. Please check the email associated with your account.',
        'login-reset-password-error'      => 'We were unable to locate the username you provided.',
        'login-invalid-email'             => 'You must enter your email address to proceed.',
        'login-request-username-success'  => 'Your username recovery request has been sent. Please check the email associated with your account.',
        'login-request-username-error'    => 'We were unable to locate the email address you provided.',
        'logout-success'                  => 'You have successfully logged out of the website.',
        'user-create-success'             => 'You have successfully create a new user.',
        'user-create-error'               => 'There was an error creating a new user.',
        'user-edit-success'               => 'You have successfully edited the user.',
        'user-edit-error'                 => 'There was an error editing the user.',
        'user-delete-success'             => 'You have successfully deleted the user.',
        'profile-edit-success'            => 'You have successfully edited your profile.',
        'profile-edit-error'              => 'There was an error editing your profile.',
        'brand-create-success'            => 'You have successfully created a new brand.',
        'brand-create-error'              => 'There was an error creating a new brand.',
        'brand-edit-success'              => 'You have successfully edited the brand.',
        'brand-edit-error'                => 'There was an error editing the brand.',
        'product-category-create-success' => 'You have successfully created a new product category.',
        'product-category-create-error'   => 'There was an error creating a new product category.',
        'product-category-edit-success'   => 'You have successfully edited the product category.',
        'product-category-edit-error'     => 'There was an error editing the product category.',
        'product-category-delete-sucess'  => 'You have successfully deleted the product category.',
        'product-line-create-success'     => 'You have successfully created a new product line.',
        'product-line-create-error'       => 'There was an error creating a new product line.',
        'product-line-edit-success'       => 'You have successfully edited the product line.',
        'product-line-edit-error'         => 'There was an error editing the product line.',
        'product-line-delete-success'     => 'You have successfully deleted the product line.',
        'part-create-success'             => 'You have successfully created a new part.',
        'part-create-error'               => 'There was an error creating a new part.',
        'part-edit-success'               => 'You have successfully edited the part.',
        'part-edit-error'                 => 'There was an error editing the part.',
        'part-delete-success'             => 'You have successfully deleted the part.',
        'product-review-approve-success'  => 'You have successfully approved the product review.',
        'product-review-create-success'   => 'You have successfully created a new product review.',
        'product-review-create-error'     => 'There was an error creating a new product review.',
        'product-review-edit-success'     => 'You have successfully edited the product review.',
        'product-review-edit-error'       => 'There was an error editing the product review.',
        'product-review-delete-success'   => 'You have successfully deleted the product review.',
        'site-create-success'             => 'You have successfully created a new site.',
        'site-create-error'               => 'There was an error creating a new site.',
        'site-edit-success'               => 'You have successfully edited the site.',
        'site-edit-error'                 => 'There was an error editing the site.',
        'site-delete-success'             => 'You have successfully deleted the site.',
        'layout-create-success'           => 'You have successfully created a new layout.',
        'layout-create-error'             => 'There was an error creating a new layout.',
        'layout-edit-success'             => 'You have successfully edited the layout.',
        'layout-edit-error'               => 'There was an error editing the layout.',
        'layout-delete-success'           => 'You have successfully deleted the layout.',
        'template-create-success'         => 'You have successfully created a new template.',
        'template-create-error'           => 'There was an error creating a new template.',
        'template-edit-success'           => 'You have successfully edited the template.',
        'template-edit-error'             => 'There was an error editing the template.',
        'template-delete-success'         => 'You have successfully deleted the template.',
        'page-create-success'             => 'You have successfully created a new page.',
        'page-create-error'               => 'There was an error creating a new page.',
        'page-edit-success'               => 'You have successfully edited the page.',
        'page-edit-error'                 => 'There was an error editing the page.',
        'page-delete-success'             => 'You have successfully deleted the page.',
        'menu-create-success'             => 'You have successfully created a new menu.',
        'menu-create-error'               => 'There was an error creating a new menu.',
        'menu-edit-success'               => 'You have successfully edited the menu.',
        'menu-edit-error'                 => 'There was an error editing the menu.',
        'menu-delete-success'             => 'You have successfully deleted the menu.',
        'menu-element-create-success'     => 'You have successfully created a new menu element.',
        'menu-element-create-error'       => 'There was an error creating a new menu element.',
        'menu-element-edit-success'       => 'You have successfully edited the menu element.',
        'menu-element-edit-error'         => 'There was an error editing the menu element.',
        'menu-element-delete-success'     => 'You have successfully deleted the menu element.',
        'message-read-success'            => 'You have successfully marked the message as read.',
        'message-create-success'          => 'You have successfully created a new message.',
        'message-create-error'            => 'There was an error creating a new message.',
        'message-edit-success'            => 'You have successfully edited the message.',
        'message-edit-error'              => 'There was an error editing the message.',
        'message-delete-success'          => 'You have successfully deleted the message.',
        'task-create-success'             => 'You have successfully created a new task.',
        'task-create-error'               => 'There was an error creating a new task.',
        'task-edit-success'               => 'You have successfully edited the task.',
        'task-edit-error'                 => 'There was an error editing the task.',
        'task-complete-success'           => 'You have successfully marked the task as completed.',
        'task-delete-success'             => 'You have successfully deleted the task.',
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
