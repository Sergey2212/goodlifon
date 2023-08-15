<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
use app\modules\shop\models\Wishlist;
/** @var yii\web\View $this */
/**
 * @var \app\modules\shop\models\Order $order
 */
/** @var bool $collapseOnSmallScreen */
/** @var bool $useFontAwesome */
/** @var \app\extensions\DefaultTheme\Module $theme */

$mainCurrency = \app\modules\shop\models\Currency::getMainCurrency();
if (is_null($order)) {
    $itemsCount = 0;
} else {
    $itemsCount = $order->items_count;
}

$navStyles = '';

?>

    <div class="pre-header one-row-header-with-cart">
        <div class="container">

            <div class="hidden-xs">
                <div class="row">

                    <ul class="col-sm-6 col-md-6 top-panel-ul">
                        <li>
                            <a href="<?= \yii\helpers\Url::toRoute(['/about']) ?>">О нас</a>
                        </li>
                        <li>
                            <a href="<?= \yii\helpers\Url::toRoute(['/delivery']) ?>">Доставка</a>
                        </li>
                        <li>
                            <a href="<?= \yii\helpers\Url::toRoute(['/payment']) ?>">Оплата</a>
                        </li>
                    </ul>

                    <div class="col-sm-6 col-md-6 top-panel-div">

                        <div class="pull-right personal-area">

                            <?php if (Yii::$app->user->isGuest === true): ?>

                                <a href="<?= \yii\helpers\Url::toRoute(['/user/user/login']) ?>" class="btn btn-login">
                                    <i class="glyphicon glyphicon-user login-icon fa-lg"></i>
                                    <span id="a-ligin">Вход</span>
                                </a>

                            <?php else: ?>
                                <?= Yii::t('app', 'Hi') ?>,
                                <span class="dropdown">
                            <a href="<?= \yii\helpers\Url::toRoute(['/shop/cabinet']) ?>" class="link-cabinet" data-toggle="dropdown" data-hover="dropdown"><?= Html::encode(Yii::$app->user->identity->username) ?></a>!
                                    <?= \yii\widgets\Menu::widget([
                                        'items' => [
                                            [
                                                'label' => Yii::t('app', 'User profile'),
                                                'url' => ['/user/user/profile'],
                                                [
                                                    'class' => 'user-profile-link',
                                                ]
                                            ],
                                            [
                                                'label' => Yii::t('app', 'Personal cabinet'),
                                                'url' => ['/shop/cabinet'],
                                                [
                                                    'class' => 'shop-cabinet-link',
                                                ]
                                            ],
                                            [
                                                'label' => Yii::t('app', 'Orders list'),
                                                'url' => ['/shop/orders/list'],
                                                [
                                                    'class' => 'shop-orders-list',
                                                ]
                                            ],
                                            [
                                                'label' => Yii::t('app', 'Logout'),
                                                'url' => ['/user/user/logout'],
                                                [
                                                    'data-action' => 'post',
                                                    'class' => 'logout-link',
                                                ],
                                            ]
                                        ],
                                        'options' => [
                                            'class' => 'dropdown-menu personal-menu',
                                        ],
                                    ]) ?>
                        </span>
                            <?php endif; ?>


                            <a href="<?= \yii\helpers\Url::toRoute(['/shop/cart']) ?>" class="btn btn-show-cart">
                                <i class="fa fa-shopping-cart cart-icon fa-lg"></i>
                                <span class="badge items-count" id="cart-count">
                                        <?= $itemsCount ?>
                                    </span>
                            </a>

                            <a href="<?=Url::to(['/shop/product-compare/compare'])?>" class="btn btn-comparison" title="<?=Yii::t('app', 'Compare products')?>">
                                <i class="glyphicon glyphicon-stats compare-icon fa-lg"></i>
                                <span class="badge items-count" id="compare-count">
                                    <?php
                                           $comparisonProductCount = Yii::$app->session->get('comparisonProductList');
                                        if($comparisonProductCount){
                                        	echo(count($comparisonProductCount));
                                        }else{
                                        	echo(0);
                                        }
                                        //echo count(Yii::$app->session->get('comparisonProductList'));                                    		?>
                                </span>
                            </a>

                            <a href="<?=Url::to(['/shop/wishlist'])?>" class="btn btn-wishlist">
                                <i class="fa fa-heart wishlist-icon fa-lg"></i>
                                <span class="badge items-count" id="wishlist-count">
                                        <?= Wishlist::countItems((!Yii::$app->user->isGuest ? Yii::$app->user->id : 0), Yii::$app->session->get('wishlists', [])) ?>
                                    </span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>


            <div class='top-panel visible-xs'>
                <div class="row">


                    <div class="mobile-toggle">
                        <ul class="nav nav-pills">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-bars fa-2x"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?= \yii\helpers\Url::toRoute(['/about']) ?>">О нас</a>
                                    </li>
                                    <li>
                                        <a href="<?= \yii\helpers\Url::toRoute(['/delivery']) ?>">Доставка</a>
                                    </li>
                                    <li>
                                        <a href="<?= \yii\helpers\Url::toRoute(['/payment']) ?>">Оплата</a>
                                    </li>

                                    <li role="presentation" class="divider"></li>
                                    <li class="dropdown-header mobile-about">Наши телефоны</li>
                                    <li class="mobile-about">8 (8442) 38-12-12</li>
                                    <li class="mobile-about">8 (961) 691-58-94</li>

                                    <li role="presentation" class="divider"></li>
                                    <li class="dropdown-header mobile-about">Время работы</li>
                                    <li class="mobile-about">Пн-Пт: 09.30 - 18.00</li>
                                    <li class="mobile-about">Субб : 10.00 - 16.00</li>

                                </ul>
                            </li>
                        </ul>
                    </div>


                    <a href="<?= \yii\helpers\Url::toRoute(['/']) ?>">
                        <img src="<?= Html::encode($theme->logotypePath) ?>" class="img-responsive pre-header-logo" alt="<?= Html::encode($theme->siteName) ?>"/>
                    </a>




                    <div class="mobile-icons-top">

                        <span class="fa fa-search fa-lg search-append "></span>


                            <?php if (Yii::$app->user->isGuest === true): ?>

                                <a href="<?= \yii\helpers\Url::toRoute(['/user/user/signup']) ?>" class="btn btn-signup hidden-xs">
                                    <?= Yii::t('app', 'Sign up') ?>
                                </a>
                                <a href="<?= \yii\helpers\Url::toRoute(['/user/user/login']) ?>" class="btn btn-login">
                                    <i class="fa fa-user btn-mobile btn-mobile-user"></i>
                                </a>

                            <?php else: ?>
                                <span class="dropdown">
                    <a href="<?= \yii\helpers\Url::toRoute(['/shop/cabinet']) ?>" class="link-cabinet" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user fa-user-authorized"></i></a>
                                    <?= \yii\widgets\Menu::widget([
                                        'items' => [
                                            [
                                                'label' => Yii::t('app', 'User profile'),
                                                'url' => ['/user/user/profile'],
                                                [
                                                    'class' => 'user-profile-link',
                                                ]
                                            ],
                                            [
                                                'label' => Yii::t('app', 'Personal cabinet'),
                                                'url' => ['/shop/cabinet'],
                                                [
                                                    'class' => 'shop-cabinet-link',
                                                ]
                                            ],
                                            [
                                                'label' => Yii::t('app', 'Orders list'),
                                                'url' => ['/shop/orders/list'],
                                                [
                                                    'class' => 'shop-orders-list',
                                                ]
                                            ],
                                            [
                                                'label' => Yii::t('app', 'Logout'),
                                                'url' => ['/user/user/logout'],
                                                [
                                                    'data-action' => 'post',
                                                    'class' => 'logout-link',
                                                ],
                                            ]
                                        ],
                                        'options' => [
                                            'class' => 'dropdown-menu mobile-personal-menu',
                                        ],
                                    ]) ?>
                </span>
                            <?php endif; ?>

                            <a href="<?= \yii\helpers\Url::toRoute(['/shop/cart']) ?>" class="btn btn-show-cart">
                                <i class="fa fa-shopping-cart cart-icon btn-mobile btn-mobile-cart">
                                    <span class="badge items-count" id="mobile-cart-count">
                                        <?= $itemsCount ?>
                                    </span>
                                </i>
                            </a>

                    </div>



                </div>
            </div>

        </div>
    </div>

<?php

$js = <<<JS
    $('.search-append').click(function () {
    $('.search-header ').slideToggle(300);
});
    

JS;
$this->registerJs($js);

if (Yii::$app->user->isGuest === false) {
    $js = <<<JS
$('.link-cabinet').dropdownHover();
JS;
    $this->registerJs($js);

}