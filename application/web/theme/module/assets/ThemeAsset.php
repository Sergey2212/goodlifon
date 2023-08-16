<?php

namespace app\web\theme\module\assets;
use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $basePath = '@webroot/theme';
    public $baseUrl = '@web/theme';
    public $css = [
        // your css files will be here
           "css/main.css",
           "css/header.css",
           "css/fonts.css",
           // "css/simple-line-icons.css",
            "css/app.css",
//        "css/navbar.css",
//        "css/variaties.css",
//        "css/default-theme.css",
          "css/jscrollpane.css",
//        "css/sweet-alert.css",
    ];
    public $js = [
        // your js files will be here
//        "js/main.js",
//        "js/jquery.mousewheel.js",
        "js/jscrollpane.min.js",
        "js/app.js",
//        "js/sweet-alert.min.js",
        "js/zoomsl-3.0.min.js",
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}