<?php

/**
 * @var $product \app\modules\shop\models\Product
 * @var $this \app\components\WebView
 * @var $url string
 */

use app\modules\image\widgets\ObjectImageWidget;
use kartik\helpers\Html;

?>


        <div class="col product-item">
                    <div class="card rounded-0 product-card">
                        <?php if ($product->new):?>
                        <span class="badge badge-danger top-left">New</span>
                        <?php endIf?>
                        <div class="card-header bg-transparent border-bottom-0">
                            <div class="d-flex align-items-center justify-content-end gap-3 product-image">
                                <a href="<?=$url?>">
                                    <div class="product-compare">
                                        <span>
                                            <i>
                                                <img style="height: 15px;" src="../upload/images/icons/git-compare.png" alt="">
                                            </i>
                                            Сравнить
                                        </span>
                                    </div>
                                </a>
                                <a href="javascript:;">
                                    <div class="product-wishlist"> <i class='bx bx-heart'></i>
                                    </div>
                                </a>
                            </div>
                        </div>
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
                                        <a href="<?=$url?>" class="btn btn-dark btn-ecomm"> <i class='bx bxs-cart-add'></i>Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
