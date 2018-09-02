<?php

return [
	'configCachePath' => dirname(__FILE__).'/',
    'adminEmail' => 'admin@example.com',
    'emailVerifyLife' => 1800,
    'domain' => 'http://test-admin-pay.mailejifen.com',
    'tongjiDomain' => 'http://tongji.mailejifen.com',
    'erpDomain' => 'http://test-erp.mailejifen.com',
    'uploadDomain'=>  'http://test-upload.mailejifen.com',
    'oauthKey' => 'SuND03yIZcd5ClvM',
    'oauthSecret' => 'I1V96hdCUKKuexENSWASTMzncHRjoqjM',
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
    'bucket' =>'mailejifen-test',
    'PROXY_SUFFIX' => '.cn-gd.ufileos.com',
    'PUBLIC_KEY' => 'fsdhzl8tzDiYo9LrQVkn0Gjfcx8PvgjKyURc5gojeacJvBjWqoci2g==',
    'PRIVATE_KEY' => '6dc95fd420ee40863e003bc91873ba16ca1cb8dd',
    'uploadDir' => 'upload',
    
   
    'allowLoginRedirectDomain' => [
        'mailejifen.com'
    ],
];
