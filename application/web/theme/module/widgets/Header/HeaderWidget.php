<?php

namespace app\web\theme\module\widgets\Header;

use app\extensions\DefaultTheme\components\BaseWidget;

class HeaderWidget extends BaseWidget
{
    public function widgetRun()
    {
        return $this->render('header-widget');
    }
}