<?php

namespace app\web\theme\module\widgets\HeaderTop;

use yii\base\Widget;

class HeaderTopWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('header-top');
    }
}