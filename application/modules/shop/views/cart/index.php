<?php
/**
 * @var \app\modules\shop\models\Order $model
 * @var \app\modules\shop\models\OrderCode $orderCode
 * @var \yii\web\View $this
 */
use kartik\form\ActiveForm;

$this->title = Yii::t('app', 'Cart');

?>
<h1><?= Yii::t('app', 'Cart') ?></h1>
<div class="cart">
    <?php if (!is_null($model) && $model->items_count > 0): ?>
        <?= $this->render('items', ['model' => $model, 'items' => $model->items]) ?>

        <div class="pull-right cta">
            <?= \yii\helpers\Html::a(Yii::t('app', $model->stage->isInitial() ? 'Перейти к оформлению заказа' : 'Continue checkout'), ['/shop/cart/stage'], ['class' => 'btn btn-primary']); ?>
        </div>

    <?php else: ?>
        <p><?= Yii::t('app', 'Your cart is empty') ?></p>
    <?php endif; ?>
</div>