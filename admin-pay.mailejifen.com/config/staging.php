<?php
require_once(VDIR . '/framework/vendor/php-console/src/PhpConsole/__autoload.php');
function d($var, $tags = null) {
    PhpConsole\Connector::getInstance()->getDebugDispatcher()->dispatchDebug($var, $tags, 1);
}
$params = require(__DIR__ . '/staging_params.php');
$config = [
    'id' => 'basic',
    'language'=>'zh-CN',
    'vendorPath' => VDIR . '/framework/vendor',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
        'smarty' => [
            'class' => 'yii\smarty\Smarty',
            'debug' => false,
            'caching' => false,
            'cache_lifetime' => 5,
            'config' => [
                'template_dir' => dirname(__DIR__).'/views',
                'compile_dir' => dirname(__DIR__).'/compile',
                'config_dir' => dirname(__DIR__).'/config',
                'cache_dir' => dirname(__DIR__).'/cache',
                'left_delimiter' => '{{',
                'right_delimiter' => '}}',
            ],
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.exmail.qq.com',  //每种邮箱的host配置不一样
                'username' => 'm@mailejifen.com',
                'password' => 'Admin123321',
                'port' => '25',
                'encryption' => 'tls',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['m@mailejifen.com'=>'admin']
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'log' => [
            'traceLevel' => 1,
            'targets' => [
                [
                    'class' => 'BaseComponents\customLog\CustomFileLog',
                    'logFile' => '/usr/local/logs/php/test-admin-pay.mailejifen.com/' . date('Y-m-d') . '.log',
                    'levels' => ['info', 'error', 'warning'],
                    'logVars' => [],
                    'exportInterval' => 0,
                ],
            ],
        ],
        'db'=>[
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=120.76.152.62;dbname=pay',
            'username' => 'pay',
            'password' => 'a@wrexz3DF2F23d',
            'charset' => 'utf8',
            'tablePrefix' => 'pay_',
        ],
        'redis' => [
            'class' => 'BaseComponents\base\RedisConn',
            'hostname' => '120.76.152.62',
            'port' => 6379,
            'auth' => 'redisYy1024',
        ],
        'curl' => [
            'class' => 'yii\curl\Curl',
        ],
        'message' => [
            'class' => 'BaseComponents\base\Message',
        ]
    ],
    'params' => $params,
];

if (YII_ENV == 'dev') {

    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '192.168.*.*', '::1']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '192.168.*.*', '::1']
    ];
}


return $config;
