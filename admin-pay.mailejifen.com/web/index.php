<?php
require(__DIR__ . '/../config/define.config.php');

if (isset($_SERVER['APPLICATION']) && $_SERVER['APPLICATION'] == 'production') {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_ENV') or define('YII_ENV', 'pro');
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 1);
    define('VDIR', '/www');
    $config = require (__DIR__ . '/../config/production.php');
} elseif (isset($_SERVER['APPLICATION']) && $_SERVER['APPLICATION'] == 'staging') {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_ENV') or define('YII_ENV', 'staging');
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 1);
    define('VDIR', '/www');
    $config = require (__DIR__ . '/../config/staging.php');
} else {
    ini_set('display_errors', 'on');
    error_reporting(E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
    define('VDIR', dirname(dirname(__DIR__)));
    $config = require (__DIR__ . '/../config/development.php');
}

require(VDIR . '/framework/vendor/autoload.php');
require(VDIR . '/framework/vendor/yiisoft/yii2/Yii.php');

# 目录映射
Yii::setAlias('@BaseComponents', VDIR . '/framework/components/');
Yii::setAlias('@BaseModels', VDIR . '/framework/models/');

(new yii\web\Application($config))->run();