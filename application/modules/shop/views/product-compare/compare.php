<?php

/**
 * @var $error integer
 * @var $message string
 * @var $object \app\models\BaseObject
 * @var $products \app\modules\shop\models\Product[]
 * @var $this \yii\web\View
 */

use yii\helpers\Html;

    $this->title = Yii::t('app', 'Products comparison');

    echo Html::tag('h1', $this->title);
   
?>
<?php if(isset($error) && $error): ?>
 <div class="compare text-center">
 	<?= Html::tag('h3', Html::encode($message), ['class' => 'username'])?>
 	<?= Html::img('@web/theme/img/compare.png', ['class'=>'mr-3 align-self-center pb-15','alt' => 'Нет продуктов для сравнения'])?>
 </div>
<?php else: ?>
 <?= \app\modules\shop\widgets\ProductCompare::widget()?>
<?php endif; 