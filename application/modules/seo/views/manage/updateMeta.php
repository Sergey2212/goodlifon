<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\seo\models\Meta $model
 */

$this->title = Yii::t('app', 'Update Meta Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'SEO'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Meta Tags'), 'url' => ['meta']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
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
            $this->render('_metaForm', [
                'model' => $model,
            ]);
            ?>
        </div>
    </div>
</div>