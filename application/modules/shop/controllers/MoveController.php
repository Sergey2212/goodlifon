<?php

namespace app\modules\shop\controllers;

use app\components\Controller;
use app\modules\shop\models\Move;
use yii\web\NotFoundHttpException;


class MoveController extends Controller
{
    public function actionIndex($id)
    {
        $model = Move::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCategory($id)
    {
        $category = $this->findCategoryModel($id);

        $dataProvider = new ActiveDataProvider([
            'query' => Move::find()->active()->forCategory($category->id)->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }



}