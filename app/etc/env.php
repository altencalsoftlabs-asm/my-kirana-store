<?php
return [
    'backend' => [
        'frontName' => 'admin_6eo5dm'
    ],
    'crypt' => [
        'key' => 'f7acda632148b9b0e60a8bed44ce1b7a'
    ],
    'db' => [
        'table_prefix' => 'mg',
        'connection' => [
            'default' => [
                'host' => 'localhost',
                'dbname' => 'mg_kirana',
                'username' => 'root',
                'password' => 'root',
                'active' => '1'
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'default',
    'session' => [
        'save' => 'files'
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1
    ],
    'install' => [
        'date' => 'Tue, 06 Nov 2018 12:54:54 +0000'
    ]
];
