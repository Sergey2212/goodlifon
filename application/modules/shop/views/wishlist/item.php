<?php

/**
 * @var $product \app\modules\shop\models\Product
 * @var $this \app\components\WebView
 * @var $url string
 * @var $wishlist app\modules\shop\models\Wishlist
 * @var $item app\modules\shop\models\WishlistProduct
 */

use app\modules\image\widgets\ObjectImageWidget;
use kartik\helpers\Html;
use yii\helpers\Url;

?>
<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
	<div class="position-relative">
	    <a href="<?= Url::toRoute([
	        '/shop/wishlist/remove',
	        'id' => $item->product_id,
	        'wishlistId' => $wishlist->id,
	    ]) ?>" class="btn-remove-from-wishlist btn-close position-absolute top-0 end-0">
	    </a>
	    <?= Html::checkbox('selection[]', false, [
	        'form' => 'move-wishlist-' . $wishlist->id,
	        'value' => $product->id,
	        'style' => [
	            'position' => 'absolute',
	            'right' => 0,
	            'top' => '25px',
	            'right' => '3px'
	        ],
	    ]) ?>
	</div>    
    <div class="product-item">
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
        <div class="product">
            <a href="<?= $url ?>" class="product-name">
                <?= Html::encode($product->name) ?>
            </a>
            <div class="product-price">
                <?= $product->formattedPrice(null, false, false) ?>
            </div>
        </div>
        <div class="product-info">
            <div class="product-announce">
                <p class="product-category font-12 mb-1" id="short-description"><?= strip_tags($product->content)."… " ?></p>
            </div>
            <div class="cta">
                <a class="btn btn-light btn-sm" href="<?= $url ?>">
                    <?= Yii::t('app', 'Выбрать цвет и размер') ?>
                    <i class="fa fa-shopping-cart"></i>
                </a>
            </div>
        </div>
    </div>
</div>
