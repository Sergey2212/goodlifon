<?php

return [
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@webroot/theme/views/modules/basic',
                    '@app/modules/shop/views' => '@webroot/theme/views/modules/shop',
                    '@app/modules/page/views' => '@webroot/theme/views/modules/page',
                    '@app/widgets' => '@webroot/theme/views/widgets',
                ],
                'baseUrl' => '@webroot/theme/views',
            ],
        ],
    ],
    'modules' => [
        'site' => [
            'class' => 'app\web\theme\module\ThemeModule'
        ]
    ],
    'bootstrap' => [
        'site',
    ],
];
