<?php

return [
    'configCachePath' => dirname(__FILE__) . '/',
    'adminEmail' => 'admin@example.com',
    'emailVerifyLife' => 1800,
    'oauthKey' => 'PQ2DnkaTgCj6UEtw', //测试
    'oauthSecret' => '2cbAbe5zsOFPpRR2rYGS78jv4JEAlJVc', //测试
    'domain' => 'http://admin-pay.mailejifen.com',
    //'tongjiDomain' => 'http://tongji.test.mailejifen.com',
    'uploadDomain' => 'http://upload.test.mailejifen.com',
    'tongjiDomain' => 'http://tongji.mailejifen.com',
    'erpDomain' => 'http://erp.test.mailejifen.com',
    'loginAction' => 'site/login',
    'allowGuestAction' => [
        'site/login',
        'site/code',
        'site/logout',
        'site/start-captcha',
        'merchant/address',
        'statistics/run'
    ],
    'allowImageSize' => 1048576,
    'deployDomain' => 'mailejifen-test.ufile.ucloud.com.cn',
    'bucket' => 'mailejifen-test',
    'PROXY_SUFFIX' => '.cn-gd.ufileos.com',
    'PUBLIC_KEY' => 'fsdhzl8tzDiYo9LrQVkn0Gjfcx8PvgjKyURc5gojeacJvBjWqoci2g==',
    'PRIVATE_KEY' => '6dc95fd420ee40863e003bc91873ba16ca1cb8dd',
    'uploadDir' => 'upload',

    'allowLoginRedirectDomain' => [
        'mailejifen.com'
    ],
];
