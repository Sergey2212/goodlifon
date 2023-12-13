<?php

namespace app\web\theme\module\widgets\MainPage;

use app\extensions\DefaultTheme\components\BaseWidget;
use app\modules\shop\models\Product;
use Yii;
use yii\web\Response;
use yii\helpers\Json;

class MainPageWidget extends BaseWidget
{

    public $newProducts = '';
    public $topProducts = '';


    public function init()
    {
        parent::init();

        $this->newProducts = Product::find()
            ->where(['new' => 1])
            ->with('images', 'brand')
            ->orderBy(['date_added' => SORT_DESC])
            //->asArray()
            ->all();
            
            $this->topProducts = Product::find()
            ->where(['top' => 1])
            ->with('images', 'brand')
            ->orderBy(['date_added' => SORT_DESC])
            //->asArray()
            ->all();    

    }


    public function widgetRun()
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->render('main-page', array(
            'newProducts' => $this->newProducts,
            'topProducts' => $this->topProducts,
        ));
    }
}