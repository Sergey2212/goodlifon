<?php

namespace app\web\theme\module\widgets\categories;

use app\modules\shop\models\Category;
use app\extensions\DefaultTheme\components\BaseWidget;

class CategoriesWidget extends BaseWidget
{
    public  $tree;

    public function widgetRun()
    {

        $this->tree = Category::getStructure();

        return $this->render('categoriesWidget',[
                'tree'=>$this->tree,
            ]
        );
    }
}