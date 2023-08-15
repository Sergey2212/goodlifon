<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\icons\Icon;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\shop\models\ProductMoveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Moves';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-move-index">

    <h1>Движение товара</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=app\widgets\Alert::widget(
        [
            'id' => 'alert',
        ]
    );?>

    <?php
    $this->beginBlock('add-button');
    ?>

    <?=\app\backend\widgets\RemoveAllButton::widget(
        [
            'url' => Url::toRoute(['remove-all', 'id']),
            'gridSelector' => '.grid-view',
            'htmlOptions' => [
                'class' => 'btn btn-danger pull-right'
            ],
        ]
    );?>
    <?php
    $this->endBlock();
    ?>

    <?=DynaGrid::widget([

        'options' => [
            'id' => 'Move-grid',
        ],

        'columns' => [

            [
                'class' => \kartik\grid\CheckboxColumn::className(),
                'options' => [
                    'width' => '10px',
                ],
            ],

            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'id',
                'options' => [
                    'width' => '70px',
                ],
            ],
            [
                'attribute' => 'name',
                'value' =>function($model) {
                    return $model->name->name;
                },


            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'warehouse_id',
                'options' => [
                    'width' => '80px',
                ],
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' =>  'total',
                /* 'value' =>function($model) {
                     return $model->name->parent_id;
                 },*/
                'options' => [
                    'width' => '90px',
                ],
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' =>  'quantity',
                'options' => [
                    'width' => '90px',
                ],
            ],

           // 'product_parent_id',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' =>  'time',
                'options' => [
                    'width' => '170px',
                ],
            ],
            //'row_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'hover' => true,
            'panel' => [
                'heading' => '<h3 class="panel-title">' . $this->title . '</h3>',
                'after' => $this->blocks['add-button'],
            ],
        ]
    ]); ?>
</div>
