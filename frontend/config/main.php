<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'name' => '饶舌者Rappers-搜罗高品质的中文说唱音乐-说唱音乐爱好者的家园-www.raoshezhe.com', // 需根据项目修改
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'idParam' => '__frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'qq' => [
                    'class' => 'xj\oauth\QqAuth',
                    'clientId' => '101245590', // 需根据项目修改
                    'clientSecret' => '744e47178c5cfcaca10bc215e19bffdf', // 需根据项目修改

                ],
                'weibo' => [
                    'class' => 'xj\oauth\WeiboAuth',
                    'clientId' => '3629375066', // 需根据项目修改
                    'clientSecret' => '3ba1db72a48bd4a4639dc2f676889968', // 需根据项目修改
                ],
                'weixin' => [
                    'class' => 'xj\oauth\WeixinAuth',
                    'clientId' => 'wxee59c66028b0bb43', // 需根据项目修改
                    'clientSecret' => '85899da4aa52b12c9fba1fcd4a47ac3d', // 需根据项目修改
                ],
            ]
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
