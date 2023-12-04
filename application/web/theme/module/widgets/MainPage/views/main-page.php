<?php
use yii\helpers\Url;
use app\modules\image\widgets\ObjectImageWidget;
use yii\helpers\Html;
use app\modules\shop\widgets\AddToWishlistWidget;

/** @var  $newProducts */
//debug($newProducts);
?>


<div id="main-message">
    <div class="text-justify col-xs-12 col-md-10 offset-md-1 ">

        <h1 class="text-center">Магазин нижнего белья Гудлифон</h1>
        <div id="text-main-message">
            <blockquote>
            <p class="lh-1">
                    &nbsp;Мы рады приветсвовать Вас в нашем магазине, где вы сможете купить нижнее бельё (бюстгальтеры, трусики), купальники, термобельё, трикотажные и чулочно-носочные изделия. Гарантируем профессиональный и индивидуальный подход к каждому клиенту. Мы ценим наших покупателей и понимаем, что лучшей рекламы чем рекомендация нет.
            </p>
            <p>
                    &nbsp;На этом сайте представлена лишь малая часть ассортимента нашего магазина.
            </p>
            <p>
                    &nbsp;При личном посещении магазина по адресу г. Волгоград ул. Порт-Саида д.9 Вы наверняка найдёте товар, который придётся Вам по душе.
            </p>
            </blockquote>
        </div>
    </div>
</div>

    <!--start Featured product-->

<!--start Featured product-->
<section class="py-4">
    <div class="container-fluid">

        <h2 class="title text-center">ПОПУЛЯРНЫЕ ПРОДУКТЫ</h2>
        <hr/>
        <div class="product-grid">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                <?php
                    $k = 0;
                    ?>
                    <?php
                    foreach ($newProducts as $product) {
                        $url = Url::to(
                            [
                                '@product',
                                'model' => $product,
                                'category_group_id' => 1,
                            ]
                        );
                ?>
                <div class="col product-item">
                    <div class="card rounded-0 product-card">
                        <?php if ($product->new):?>
                        <span class="badge badge-danger top-left">New</span>
                        <?php endIf?>
                        <?php if ($product->optionsQuantity < 1):?>
                        <span class="badge badge-danger top-left">Распродано</span>
                        <?php endIf?>
                        <!-- <div class="card-header bg-transparent border-bottom-0">
                            <div class="d-flex align-items-center justify-content-end gap-3 product-image">
                                <a href="<?//=$url?>">
                                    <div class="product-compare">
                                        <a href='#' class="btn-add-to-compare" rel="nofollow" data-action="add-to-compare" data-id="<?//=$product->id?>">
                                            <?//= Yii::t('app', 'Сравнить') ?>
                                        </a>
                                    </div>
                                </a>
                                <a href='#' class="btn-add-to-wishlist" rel="nofollow" data-bs-toggle="modal" data-bs-target="#wishlist" >
                                    <div class="product-wishlist"> <i class='bx bx-heart'></i>
                                    </div>
                                </a>
                                <?//= AddToWishlistWidget::widget(['id' => $product->id]) ?>
                            </div>
                        </div> -->
                       <h4 class="text-center">
			                <?php
			                    //if (isset($product->brand->name)) {
			                        //echo $product->brand->name;
			                    //}
			                    echo(array_slice($product->subcategoryTittle, -1)[0]['title_append']);
			                ?>
            			</h4>
                        <a href="<?=$url?>">
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
                        </a>
                        <div class="card-body">
                            <div class="product-info">
                                <a href="<?=$url?>">
                                    <p class="product-category font-13 mb-1" style="text-align: center">
                                        <?= Html::encode($product->brand->name) ?>
                                        <?= Html::encode($product->name) ?>
                                    </p>
                                </a>
                                <a href="<?=$url?>">
                                    <p class="product-category font-12 mb-1" id="short-description"><?= strip_tags($product->content)."… " ?></p>
                                </a>
                                <div class="d-flex align-items-center">
                                    <div class="mb-1 product-price">
<!--                                        <span class="me-1 text-decoration-line-through">$99.00</span>-->
                                        <span class="fs-5">
                                            <?=$product->formattedPrice(null, false, false)?>
                                        </span>
                                        <?php if($product->optionsQuantity < 1):?>
                                         <span class="fs-5 text-end">
                                            Нет в наличии
                                        </span>
                                        <?php endif;?>
                                    </div>
                                    <div class="cursor-pointer ms-auto">
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                    </div>
                                </div>
                                <div class="product-action mt-2">
                                    <div class="d-grid gap-2">
                                        <a href="<?=$url?>" class="btn btn-dark btn-ecomm">	<i class='bx bxs-cart-add'></i>Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
                    $k++;
                } ?>
            </div>
        </div>
    </div>
</section>
