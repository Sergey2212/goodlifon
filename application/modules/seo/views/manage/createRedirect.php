<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\seo\models\Redirect $model
 */

$this->title = Yii::t('app', 'Create Redirect');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'SEO'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Redirects'), 'url' => ['redirect']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="row">
    <div class="col-xs-12">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <div class="redirects-create">
            <?=
            $this->render('_redirectForm', [
                'model' => $model,
            ]);
            ?>
        </div>
    </div>
</div>