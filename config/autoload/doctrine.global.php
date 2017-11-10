<?php

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    //'host'     => '127.0.0.1',
                    //'port'     => '3306',
                    //'user'     => 'digital_platform',
                    //'password' => 'rocket11Red',
                    //'dbname'   => 'digital_platform_dev',
                    
                    'host'     => '127.0.0.1',
                    'port'     => '3306',
                    'user'     => 'digital_platform',
                    'password' => 'rocket11Red',
                    'dbname'   => 'the_smart_data',
                )
            )
        ),
    ),
);
