<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\shop\models\Wishlist;
use app\web\theme\module\widgets\ExpandableSearch\ExpandableSearchWidget;

/** @var \app\extensions\DefaultTheme\Module $theme */
$theme = Yii::$app->getModule('DefaultTheme');

$mainCurrency = \app\modules\shop\models\Currency::getMainCurrency();
if (is_null($order)) {
    $itemsCount = 0;
} else {
    $itemsCount = $order->items_count;
}

?>

<!-- header-middle satrt -->
<div class="header-middle pt-15">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6 col-lg-3 order-first">
                <div class="logo text-center text-sm-left mb-30 mb-sm-0">
                    <a href="<?= \yii\helpers\Url::toRoute(['/']) ?>">
                        <img src="<?= Html::encode($theme->logotypePath) ?>" class="img-fluid float-md-start header-logo " alt="<?= Html::encode($theme->siteName) ?>"/>
                    </a>
                </div>
            </div>
            <div class="col-sm-5 col-lg-5 col-xl-5 col-xxl-4">
                <div class="d-flex align-items-center justify-content-center justify-content-sm-end">
                    <div class="media static-media mr-20 d-none d-md-flex">
                        <?= Html::img('@web/theme/img/icon/1.png', ['class'=>'mr-3 align-self-center','alt' => 'phone']) ?>
                        <div class="media-body">
                            <div class="phone">
                                <span class="text-dark">+7(8442)381212</span>
                            </div>
                            <div class="phone">
                                <span class="text-dark">+7(905)4567890</span>
                            </div>
                        </div>
                    </div>
                    <!-- static-media end -->
                    <div class="cart-block-links">
                        <ul class="d-flex list-unstyled">

                            <li>
                                <?php if (Yii::$app->user->isGuest === true): ?>

                                    <a href="<?= \yii\helpers\Url::toRoute(['/user/user/login']) ?>" class="offcanvas-toggle text-decoration-none" title="<?=Yii::t('app', 'Вход/Регистрация')?>">
                                        <i class="bi bi-person"></i>
                                    </a>

                                <?php else: ?>
                                    <?//= Yii::t('app', 'Hi') ?>

                                    <div class="dropdown-center">
                                        <a class="" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-person-check-fill text-success"></i>
                                        </a>

                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="<?= \yii\helpers\Url::toRoute(['/user/user/profile']) ?>">
                                                    <?=Yii::t('app', 'User profile')?>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?= \yii\helpers\Url::toRoute(['/shop/cabinet']) ?>">
                                                    <?=Yii::t('app', 'Personal cabinet')?>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?= \yii\helpers\Url::toRoute(['/shop/orders/list']) ?>">
                                                    <?=Yii::t('app', 'Orders list')?>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?= \yii\helpers\Url::toRoute(['/user/user/logout']) ?>">
                                                    <?=Yii::t('app', 'Logout')?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </li>

                            <li>
                                <a class="btn-compare offcanvas-toggle text-decoration-none" href="<?=Url::to(['/shop/product-compare/compare'])?>" title="<?=Yii::t('app', 'Compare products')?>">
                                        <span class="position-relative">
                                            <i class="bi bi-shuffle"></i>
                                            <span class="alert-count items-count">
                                            <?=count(Yii::$app->session->get('comparisonProductList', [])) ?>
                                            </span>
                                        </span>
                                </a>
                            </li>

                            <li>
                                        <span class="position-relative">
                                <a class="btn-wishlist offcanvas-toggle text-decoration-none" href="<?=Url::to(['/shop/wishlist'])?>" title="<?=Yii::t('app', 'Список желаний')?>">
                                            <i class="bi bi-suit-heart"></i>
                                            <span class="alert-count items-count">
                                            <?= Wishlist::countItems((!Yii::$app->user->isGuest ? Yii::$app->user->id : 0), Yii::$app->session->get('wishlists', [])) ?>
                                            </span>
                                        </span>
                                </a>
                            </li>

                            <li class="nav-item dropdown dropdown-large">
                                <a class="btn-show-cart nav-link  position-relative cart-link" href="<?= \yii\helpers\Url::toRoute(['/shop/cart']) ?>" title="<?=Yii::t('app', 'Корзина')?>">
                                        <span class="position-relative">
                                            <i class="bi bi-cart cart-icon"></i>
                                            <span class="alert-count items-count">
                                                    <?= $itemsCount ?>
                                            </span>
                                        </span>
                                    <!--                                    <span class="cart-total position-relative">$90.00</span>-->
                                </a>
                            </li>
                            <!-- cart block end -->

                        </ul>
                    </div>
                    <div class="mobile-menu-toggle d-lg-none">
                        <a href="" class="offcanvas-toggle">
                            <svg viewbox="0 0 800 600">
                                <path
                                        d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                        id="top"></path>
                                <path d="M300,320 L540,320" id="middle"></path>
                                <path
                                        d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                        id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318)">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- search-form -->
            <div class="col-lg-4 col-xxl-5 order-lg-first">
                <?= ExpandableSearchWidget::widget()?>
            </div>
            <!-- search-form end -->
        </div>
    </div>
</div>
<!-- header-middle end -->


