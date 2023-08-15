<?php

namespace app\web\theme\module\widgets\NewProduct;

use app\extensions\DefaultTheme\components\BaseWidget;
use app\modules\shop\models\Product;
use Yii;
use yii\web\Response;
use yii\helpers\Json;

class NewProductWidget extends BaseWidget
{

    public $newProducts = '';


    public function init()
    {
        parent::init();

        $this->newProducts = Product::find()
            ->where(['new' => 1])
            ->with('images')
            ->all();

    }


    public function widgetRun()
    {
       // Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->render('new-product', array(
            'newProducts' => $this->newProducts,
        ));
    }
}



