<?php

$basePath = dirname(__DIR__);

$config = [
    'id' => 'basic',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'basePath' => $basePath,
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => env('COOKIE_KEY', '123'),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'admin' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\Admin',
            'enableAutoLogin' => true,
            'idParam' => '__admin_id',
            'identityCookie' => [
                'name' => '_admin_identity',
                'httpOnly' => true,
            ],
        ],
        'mchRoleAdmin' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\MchRoleAdmin',
            'enableAutoLogin' => true,
            'idParam' => '__mchRoleAdmin_id',
            'identityCookie' => [
                'name' => '_mchRoleAdmin_identity',
                'httpOnly' => true,
            ],
        ],
        'errorHandler' => [
            'class' => 'app\hejiang\ErrorHandler',
            'errorView' => __DIR__ . '/../views/error/error.php',
            'exceptionView' => __DIR__ . '/../views/error/exception.php',
        ],
        'mailer' => [
            // 'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            // 'useFileTransport' => true,
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtpdm.aliyun.com',
                'username' => 'service@mail.cchtw.com',
                'password' => 'Zong7581Fu',
                'port' => '25',
                'encryption' => 'tls',

            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['service@mail.cchtw.com'=>'service']
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'enabled' => env('LOG_ENABLED', false),
                    'levels' => explode(',', env('LOG_LEVELS', 'error')),
                    'logVars' => explode(',' , env('LOG_VARS', '')),
                    'logFile' => env('LOG_FILE', '@runtime/logs/app.log'),
                ],
            ],
        ],
        'cache' => require __DIR__ . '/cache.php',
        'db' => require __DIR__ . '/db.php',
        // 'urlManager' => [
        //     'enablePrettyUrl' => true,
        //     'showScriptName' => false,
        //     'rules' => [
        //     ],
        // ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'name' => 'DBSESSIONID',
        ],
        'serializer' => [
            'class' => 'app\hejiang\Serializer',
        ],
        'sentry' => [
            'class' => 'app\hejiang\Sentry',
            'options' => [
                'dsn' => 'https://72fae1b1870b45f6ac603f1a5b34f556:74a490e3ba1a464d802855ac47cac826@sentry.io/1212625',
                'timeout' => 5,
                'tags' => [
                    'hj_version' => hj_core_version(),
                ],
                'app_path' => $basePath,
                'prefixes' => [$basePath],
                'excluded_app_paths' => [$basePath . '/vendor'],
            ],
        ],
        'storage' => [
            'class' => 'Hejiang\Storage\Components\StorageComponent',
            'basePath' => env('STORAGE_BASEPATH', 'web/uploads'),
        ],
        'storageTemp' => [
            'class' => 'Hejiang\Storage\Components\StorageComponent',
            'basePath' => env('STORAGE_TEMPPATH', 'runtime/temp'),
            'driver' => [
                'class' => 'Hejiang\Storage\Drivers\Local',
            ],
        ],

//        "urlManager" => [
//            //用于表明urlManager是否启用URL美化功能，在Yii1.1中称为path格式URL，
//            // Yii2.0中改称美化。
//            // 默认不启用。但实际使用中，特别是产品环境，一般都会启用。
//            "enablePrettyUrl" => true,
//            // 是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，
//            // 否则认为是无效路由。
//            // 这个选项仅在 enablePrettyUrl 启用后才有效。
//            "enableStrictParsing" => false,
//            // 是否在URL中显示入口脚本。是对美化功能的进一步补充。
//            "showScriptName" => false,
//            // 指定续接在URL后面的一个后缀，如 .html 之类的。仅在 enablePrettyUrl 启用时有效。
//            "suffix" => "",
//            "rules" => [
//                "<controller:\w+>/<id:\d+>"=>"<controller>/view",
//                "<controller:\w+>/<action:\w+>"=>"<controller>/<action>"
//            ],
//        ],

    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'mch' => [
            'class' => 'app\modules\mch\Module',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
    ],

    'params' => require __DIR__ . '/params.php',
];

if (YII_ENV_DEV || YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'log';
} else {
    $config['bootstrap'][] = 'sentry';
}

return $config;
