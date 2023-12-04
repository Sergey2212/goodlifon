<?php
/**
 * @var \app\modules\shop\models\Order $model
 * @var \app\modules\shop\models\OrderCode $orderCode
 * @var \yii\web\View $this
 */
use kartik\form\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Cart');

?>
<h1><?= Yii::t('app', 'Cart') ?></h1>
<div class="cart text-center">
    <?php if (!is_null($model) && $model->items_count > 0): ?>
        <?= $this->render('items', ['model' => $model, 'items' => $model->items]) ?>

        <div class="d-md-flex justify-content-md-end pb-15">
            <?= \yii\helpers\Html::a(Yii::t('app', $model->stage->isInitial() ? 'Перейти к оформлению заказа' : 'Continue checkout'), ['/shop/cart/stage'], ['class' => 'btn btn-outline-success']); ?>
        </div>

    <?php else: ?>
        <h3><?= Yii::t('app', 'В корзине пока пусто') ?></h3>
        <?= Html::img('@web/theme/img/empty-cart.png', ['class'=>'mr-3 align-self-center pb-15','alt' => 'В корзине пока пусто']) ?>
    <?php endif; ?>
</div>