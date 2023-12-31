<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\backgroundtasks\models\Task $model
 */

$this->title = Yii::t('app', 'Create Task');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');

?>
<div class="row">
    <div class="col-xs-12">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="tasks-create">
            <?=
                $this->render('_form', [
                    'model' => $model,
                ]);
            ?>
        </div>
    </div>
</div>