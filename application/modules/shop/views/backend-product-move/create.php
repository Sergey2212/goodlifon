<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\ProductMove */

$this->title = 'Create Product Move';
$this->params['breadcrumbs'][] = ['label' => 'Product Moves', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-move-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
