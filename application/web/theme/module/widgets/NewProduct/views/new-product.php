<?php
use yii\helpers\Url;
use app\modules\image\widgets\ObjectImageWidget;
use yii\helpers\Html;

//debug($newProducts);
?>

    <h2 class="title text-center">Новинки</h2>

<div id="listView" class="block-product-list">
    <?php
    $k = 0;
    ?>
    <?php foreach ($newProducts as $product) {
            $url = Url::to(
                [
                    '@product',
                    'model' => $product,
                    'category_group_id' => 1,
                ]
            );
?>
    <div class="col-md-3 col-lg-2 col-sm-3 col-xs-6">
    <div class="product-item">
        <div style="text-align: center; padding-top: 5px;">
            <h4>
                <?php
                    if (isset($product->brand->name)) {
                        echo $product->brand->name;
                    }
                ?>
    </h4>
    <?php if (Yii::$app->user->can('administrate')) : ?>
        <a href="<?=$url?>">
            <?= Html::encode($product->name) ?>
        </a>
    <?php endif; ?>
    </div>
    <div class="product-image">
        <?=
        ObjectImageWidget::widget(
            [
                'limit' => 1,
                'model' => $product,
            ]
        )
        ?>
    </div>
    <div style="text-align: center">
        <?php  if (Yii::$app->user->can('administrate')) : ?>
            <h5>
                <a href="shop/move/?id=<?= Html::encode($product->id) ?>">
                    <?= $product->quantity->in_warehouse; ?>
                    / <?= $product->optionsQuantity; ?>
                </a>
            </h5>
            <a href="<?=$url?>" class="product-name">
                <?=$product->formattedPrice(null, false, false)?>
            </a>
        <?php else:?>
            <div class="face-price">
                <a href="<?=$url?>" class="product-name">
                    <?=$product->formattedPrice(null, false, false)?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!--<div class="product-info">      <div class="face-price">
            <div class="cta">
                <a class="btn btn-add-to-cart" href="<?//=$url?>" class="product-name">
                   Подробнее
                </a>
            </div>
        </div>-->
    </div>
    </div>

<?php
        $k++;
    } ?>
</div>

<?php

$js = <<<JS
$(".product-item .product-image,.product-item .product-announce").click(function() {
    var that = $(this),
        parent = null;
    if (that.hasClass('product-image')) {
        parent = that.parent();
    } else {
        parent = that.parent().parent();
    }

    document.location = parent.find('a.product-name').attr('href');
    return false;
});
JS;
$this->registerJs($js, \app\components\WebView::POS_READY, 'product-item-click');