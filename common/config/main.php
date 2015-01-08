<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                'login' => 'site/login',
                
                'my-projects' => 'projects/index',
                'new-project' => 'projects/create',
                'companies' => 'clients/companies',
                'all-clients' => 'clients/index',
                'new-client' => 'clients/create',
            ],
        ]
    ],
];
