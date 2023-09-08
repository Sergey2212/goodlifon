<?php

namespace app\backend\assets;

use yii\web\AssetBundle;

/**
 * Backend asset class defining common needed assets for admin panel.
 *
 *
 * > **Note:** 
 * > Backend uses commercial bootstrap 3 theme - SmartAdmin. 
 * > Therefore theme assets(js, css, images, etc.) are loaded in backend 
 * > from third-party static domains(st-[1-4].dotplant.ru). 
 * > 
 * > Please consider buying SmartAdmin license
 * > at https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0?ref=dotplant_ru_cms) 
 * > for your project if you want to modify original files or relocate them to another domain.
 * > 
 * > Until you don't change this assets location you don't need to buy separate license.
 * 
 */
class BackendAsset extends AssetBundle
{
    public $sourcePath = '@app/backend/assets/backend';
    public $css = [
//        'css/smartadmin-production.min.css',
        'css/smartadmin-production-plugins.min.css',
        'css/admin.css',
    ];
    public $js = [
        'js/admin.js',
        'js/DialogActions.js',
        'js/select2sortable.js',
        'js/SmartNotification_jarvis.uglify.min.js',
        'js/jquery.mb.browser.min.js',
        'js/app.min.js',
        'js/jquery.fullcalendar.min.js',
        'js/lodash.min.js',
        'js/bootbox.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
        'devgroup\JsTreeWidget\JsTreeAssetBundle',
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\jui\JuiAsset',
        'app\backend\assets\LaddaAsset',
    ];
}
