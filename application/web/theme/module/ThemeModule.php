<?php

namespace app\web\theme\module;

use Yii;
use yii\base\Module;
use yii\base\BootstrapInterface;
use yii\base\Application;

/**
 * Class ThemeModule is the Module class for your Theme and site-specific functions
 * @package app\web\theme\module
 */
class ThemeModule extends Module implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // prevent bootstraping in console application
        if ($app instanceof \yii\console\Application) {
            return;
        }

        // Example of binding to before action application event

        $app->on(
            Application::EVENT_BEFORE_ACTION,
            function ($event) use ($app)
            {
                // add live reload for `gulp watch`
              /*  if (YII_DEBUG) {
                    $app->view->registerJs(<<<JS
    $('body').append(
        $('<script>').attr('src', 'http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1')
    );
JS
);
                }*/
                return true;
            }
        );

    }
}