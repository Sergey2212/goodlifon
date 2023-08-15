<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\ProductMove */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Moves', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-move-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_id',
            'warehouse_id',
            'quantity',
            'product_parent_id',
            'time',
            'row_id',
        ],
    ]) ?>

</div>
