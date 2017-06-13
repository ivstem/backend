<?php

    error_reporting(0);
    // or error_reporting(E_ALL & ~E_NOTICE); to show errors but not notices
    ini_set("display_errors", 0);
    
    /* My extra logic */

    if (isset($_COOKIE['_debug'])) {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');
    } else {
        defined('YII_DEBUG') or define('YII_DEBUG', false);
        // defined('YII_ENV') or define('YII_ENV', 'prod');
    }

    require(__DIR__ . '/../vendor/autoload.php');
    require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
    
    $config = require(__DIR__ . '/../config/web.php');
    
    (new yii\web\Application($config))->run();
