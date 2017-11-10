<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * RocketUser
 *
 * @category   Zend
 * @package    RocketUser
 * @subpackage Config
 * @author     Raven Sampson
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @since      File available since Release 0.1.0
 */

namespace RocketUser;

return array(
    'rocket_user' => array(
        // User settings
        'user' => array(
            // Enable or disable the username field for users
            'enable_username' => true,
        ),
        // Password settings
        'password' => array(
            // This is a Zend\ServiceManager compatible configuration containing
            // the various password hashing handlers. Add your own handler here
            // if your password hashing technique differs from the provided
            // ones.
            //'handler_manager' => array(
                //'invokables' => array(
                //    'my-hash-method' => 'My\Hash\Method',
                //),
                //'factories' => array(
                //    'bcrypt' => 'RocketUser\Password\Factory\BcryptFactory',
                //),
            //),

            // Configuration for the aggregate handler. Aggregate handler is the
            // default password handler that decides which password hashing
            // technique to use based on the handler manager.
            //'handler_aggregate' => array(
                // Sorted list of password hashing techniques to use to check
                // stored hashes.
                //'hashing_methods' => array(
                //    'Bcrypt',
                //),

                // Default hash method to use.
                //'default_hashing_method' => 'bcrypt',

                // Whether to migrate other hashes to default hashing method.
                //'migrate_to_default_hashing_method' => true,
            //),

            // Bcrypt hashing method settings. These settings are for the
            // provided BcryptFactory.
            'bcrypt' => array(
                // Cost factor. Higher value means slower hashing.
                'cost' => 14,
                // Salt. 
                'salt' => '60e4fffbd2f16b2a6b40032ecf8f8dcf',
            ),
        ),

        // Reset password settings
        'password_reset' => array(
            // The time interval for which a token is valid (for security reasons, do not
            // set a very high interval)
            'token_validity_interval' => '+24 hours'
        )
    ),
);
