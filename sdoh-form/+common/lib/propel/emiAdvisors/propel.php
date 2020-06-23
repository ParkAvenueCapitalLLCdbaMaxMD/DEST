<?php
return [
    'propel' => [
        'database' => [
            'connections' => [
                'emi_advisors' => [
                    'adapter' => 'mysql',
                    'dsn' => 'mysql:host=10.9.8.16;port=3306;dbname=emi_advisors',
                    'user' => 'apache',
                    'password' => 'michA3lchab0N',
                    'settings' => [
                        'charset' => 'utf8'
                    ]
                ]
            ]
        ]
    ]
];
