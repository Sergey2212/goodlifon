<?php

include_once(__DIR__ . '/../modules/seo/redirects/redirects.php');

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('YII_CONSOLE') or define('YII_CONSOLE', false);
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');
require_once __DIR__ . '/../../functions.php';

(new yii\web\Application($config))->run();
