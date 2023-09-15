<?php
/**
 * @var \app\modules\shop\models\Order $model
 * @var \app\modules\shop\models\OrderItem[] $items
 * @var \yii\web\View $this
 */

use app\modules\shop\models\Product;
use kartik\helpers\Html;

$immutable = isset($immutable) && $immutable;
$mainCurrency = \app\modules\shop\models\Currency::getMainCurrency();
$subItems = [];
foreach ($items as $i => $item) {
    if ($item->parent_id != 0) {
        if (isset($subItems[$item->parent_id])) {
            $subItems[$item->parent_id][] = $item;
        } else {
            $subItems[$item->parent_id] = [$item];
        }
        unset($items[$i]);
    }
}

?>

 <?php

// debug($item);
// debug($item->product->quantity->in_warehouse * $item->product->price);

 ?>


<table class="table table-bordered table-hover" id="cart-table">
    <thead>
        <tr>
            <th></th>
            <th><?=Yii::t('app', 'Name')?></th>
            <th><?=Yii::t('app', 'Price')?></th>
            <th><?=Yii::t('app', 'Quantity')?></th>
            <th><?=Yii::t('app', 'Sum')?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td class="product-image">
                <?=
                \app\modules\image\widgets\CartImageWidget::widget([
                    'limit' => 1,
                    'model' => $item->product,
                ])
                ?>
            </td>
            <td>
                <?= Html::a(
                        Html::encode($item->entity->getName()),
                        \yii\helpers\Url::to([
                            '/shop/product/show',
                            'model' => $item->product,
                            'category_group_id' => $item->product->category->category_group_id,
                        ])
                ); ?>
            </td>
            <td class="priceCart" title="<?= $mainCurrency->format($item->product->quantity->in_warehouse * $item->product->price) ?>">
                <?=
                $mainCurrency->format(
                    $item->price_per_pcs
                )
                ?>
            </td>
            <td>
                <?php if ($immutable === true): ?>
                    <?= $item->quantity ?>
                <?php else: ?>
                    <div class="form-inline">
                        <div class="form-group">
                            <div class="btn-group">
                            <input class="form-control quantity" style="float: left; margin-right: -2px; max-width:80px;" placeholder="1" size="16" type="text" data-type="quantity" data-id="<?= $item->id ?>"  title="<?= $item->product->quantity->in_warehouse ?>" value="<?= $item->quantity ?>" data-nominal="<?= $item->product->measure->nominal ?>" />
                                <button class="btn btn-primary minus" type="button" data-action="change-quantity">
                                    <i class="fa fa-minus"></i></button>
                                <button class="btn btn-success plus" type="button" data-action="change-quantity">
                                    <i class="fa fa-plus"></i></button>
                                <button class="btn btn-danger" type="button" data-action="delete" data-id="<?= $item->id ?>" data-url="<?= \yii\helpers\Url::toRoute([
                                    'delete',
                                    'id' => $item->id
                                ]) ?>"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </td>
            <td>
                <span class="item-price" title="<?=$mainCurrency->format($item->total_price)?>">
                    <?php
                    if ($item->discount_amount > 0) {
                        echo Html::tag('span',
                            $mainCurrency->format(
                                $item->total_price_without_discount
                            ),
                            [
                                'style' => 'text-decoration: line-through;'
                            ]
                        ).'<br>';
                    }
                    ?>

                    <?=
                    $mainCurrency->format(
                        $item->total_price
                   )
                    ?>
                </span>
            </td>
        </tr>
        <?php if (isset($subItems[$item->product_id])): ?>
            <?=
                $this->render(
                    'sub-items',
                    [
                        'mainCurrency' => $mainCurrency,
                        'model' => $model,
                        'immutable' => $immutable,
                        'items' => $subItems[$item->product_id],
                    ]
                )
            ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php foreach($model->specialPriceObjects as $object): ?>
        <tr class="shipping-data">
            <td colspan="4"><?= $object->name ?></td>
            <td><?= $mainCurrency->format($object->price) ?></td>
        </tr>
    <?php endforeach; ?>


    <tr>
        <td colspan="3"></td>
        <td><strong><span class="items-count"><?= $model->items_count ?></span></strong></td>
        <td>
            <span class="label label-info">
                <span class="total-price ">
                    <?= $mainCurrency->format($model->total_price) ?>
                </span>

            </span>
        </td>
    </tr>
    </tbody>
</table>
<style>
@media print {
    header, .header, footer, .footer, .quantity {
        display: none;
    }

    input[data-type=quantity] {
        border: none;
        width: 100px;
    }
}
</style>
 <?php
 $js = <<<JS
    "use strict";
    $('.plus').on('click mousemove', function (event) {
     var body = $('body');
         var thisBtn = $(this);
          var thisSum = Number(thisBtn.parents('tr').children('.priceCart').attr('title').replace(/\s+/g, '').slice(0, -4));//Товар * цена на складе
         var thisExistenceSum = Number(thisBtn.parents('tr').eq(0).find('.item-price').attr('title').replace(/\s+/g, '').slice(0, -4));//Товар * цена в корзине
         
         //alert(thisSum < thisExistenceSum);
         
       if(thisSum <= thisExistenceSum){
       //if(0){
        swal({
            title:"Невозможно добавить! Превышение лимита товара на складе",
            type: "error",
            confirmButtonText: "Хорошо",
            allowOutsideClick:   "true"
        }); 
    }else{
           
    }
              
});
     
    
JS;
 $this->registerJs($js);
?>