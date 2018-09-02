<?php

return [
	'configCachePath' => dirname(__FILE__).'/',
    'adminEmail' => 'admin@example.com',
    'emailVerifyLife' => 1800,
    'oauthKey' => '7a1c1kj6Fi5MpHLn',
    'oauthSecret' => '68NgER0htV7GYbdDLgiZJOMR05EaCcL1',
    'domain' => 'http://admin-pay.mailejifen.com',
    'tongjiDomain' => 'http://tongji.mailejifen.com',
    'uploadDomain'=>  'http://upload.mailejifen.com',
    'erpDomain' => 'https://erp.sspoint.mailejifen.com',
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
    'deployDomain' => 'maijifen.ufile.ucloud.com.cn',
    'bucket' =>'maijifen',
    'PROXY_SUFFIX' => '.cn-gd.ufileos.com',
    'PUBLIC_KEY' => 'JZKCSzkTH8WN0XgxkCdfjdkmQpb/8SMWqaBgX76+GOd69mpHimswNA==',
    'PRIVATE_KEY' => '6cd8343a127487284edae64179fe81dcdfc63e1d',
    'uploadDir' => 'upload',
    
   
    'allowLoginRedirectDomain' => [
        'mailejifen.com'
    ],
];
