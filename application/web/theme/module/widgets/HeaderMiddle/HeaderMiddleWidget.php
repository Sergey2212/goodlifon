<?php

namespace app\web\theme\module\widgets\HeaderMiddle;

use yii\base\Widget;

class HeaderMiddleWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('header-middle');
    }
}