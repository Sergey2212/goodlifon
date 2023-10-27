<?php

namespace app\web\theme\module\widgets\HeaderMiddle;

use Yii;
use yii\base\Widget;;
use app\modules\shop\models\Order;
use yii\helpers\ArrayHelper;


class HeaderMiddleWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function Run()
    {
        $order = Order::getOrder(false);
        return $this->render(
            'header-middle',
            [
                'order' => $order,
            ]
        );
    }
}