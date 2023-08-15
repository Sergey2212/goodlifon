<?php

namespace app\web\theme\module\widgets\PrimaryMenu;

use app\modules\shop\models\Category;
use yii\base\Widget;

class PrimaryMenuWidget extends Widget
{
    public  $tree;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->tree = Category::getStructure();
        return $this->render('primary-menu',[
                'tree'=>$this->tree,
            ]
        );
    }

}