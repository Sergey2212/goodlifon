<?php

namespace app\slider\sliders\bootstrap5;

use app;
use Yii;

class Bootstrap5CarouselWidget extends \app\slider\AbstractSliderWidget
{

    /**
     * Register slider-specific assets(js, css, etc.)
     * @return void
     */
    public function registerAssets()
    {
        \yii\bootstrap5\BootstrapPluginAsset::register($this->getView());
    }
}