<?php

namespace app\web\theme\module\widgets\PreHeader;

use Yii;
use app\extensions\DefaultTheme\assets\BootstrapHoverDropdown;
use app\extensions\DefaultTheme\components\BaseWidget;
use app\modules\shop\models\Order;
use yii\helpers\ArrayHelper;

class PreHeaderWidget extends BaseWidget
{
    public function widgetRun()
    {
        // this header needs this plugin
        BootstrapHoverDropdown::register($this->view);

        $order = Order::getOrder(false);
        return $this->render(
            'pre-header-widget',
            [
                'order' => $order,
            ]
        );
    }

    public function getCacheTags()
    {
        $tags = ArrayHelper::merge(parent::getCacheTags(), [
            'Session:'.Yii::$app->session->id,
        ]);
        return $tags;
    }
}