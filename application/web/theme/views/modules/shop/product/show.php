<?php

/**
 * @var $breadcrumbs array
 * @var $category_group_id integer
 * @var $model \app\modules\shop\models\Product
 * @var $object \app\models\BaseObject
 * @var $selected_category \app\modules\shop\models\Category
 * @var $selected_category_id integer
 * @var $selected_category_ids integer[]
 * @var $this yii\web\View
 * @var $values_by_property_id integer
 */

use app\modules\image\models\Image;
use app\modules\shop\models\Product;
use app\modules\image\widgets\ObjectImageWidget;
use kartik\helpers\Html;
use yii\helpers\Url;
use app\modules\shop\widgets\AddToWishlistWidget;

//foreach ($model->subcategoryTittle as $subcategory){
//    if ($subcategory['title_append'] !== 'Нижнее бельё' && $subcategory['title_append'] !== 'Чулочно-носочные' && $subcategory['title_append'] !== 'Трикотаж' && $subcategory['title_append'] !== 'Корректирующее бельё' && $subcategory['title_append'] !== 'Термо') {
//        $arrSubcategory[] = $subcategory['title_append'];
//    }
//}
//array_shift($arrSubcategory);
//$strCategory = implode('  ', $arrSubcategory);

//$productName = $breadcrumbs[array_key_last($breadcrumbs)];

$productCategory = $model->subcategoryTittle[0]['title_append'];
$this->title = $productCategory  .' '.  $model->brand->name  .' '.  $model->name  . ' купить в Волгограде. В интернет-магазине Гудлифон' ;

$textDescription =  $productCategory  .' '.  $model->brand->name  .' '.  $model->name  . ' купить в магазине нижнего белья Гудлифон. Имеющийся размер и цвет уточняйте на сайте или по телефону 8(961)691-58-94. Постоянным клиентам скидка';

$this->registerMetaTag([
    'name' => 'description',
    'content' => $textDescription,
], 'description');

$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $this->title
]);

$this->registerMetaTag([
    'property' => 'og:description',
    'content' => $textDescription
]);

$this->registerMetaTag([
    'property' => 'og:type',
    'content' => 'website'
]);

$this->registerMetaTag([
    'property' => 'og:url',
    'content' => "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']
]);

$this->registerMetaTag([
    'property' => 'og:image',
    'content' => "https://".$_SERVER['SERVER_NAME']. "/files/".$model->image->filename
]);

$this->registerMetaTag([
    'property' => 'og:site_name',
    'content' => 'Гудлифон-Магазин бюстгальтеров, купальников, колготок.'
]);


$this->params['breadcrumbs'] = $breadcrumbs;
$listView = isset($_COOKIE['listViewType']) && $_COOKIE['listViewType'] == 'listView';
$parentAnnounce = Product::find()
    ->select([
        'announce'
    ])
    ->where(['in', 'id', $model->parent_id]) 
    ->one();

$propertiesShowedInAnnounce = false;

?>
        <!--start product detail-->
        <section class="py-4">
            <div class="container">
                <div class="product-detail-card">
                    <div class="product-detail-body">
                        <div class="row g-0 product-show">
                            <div class="col-12 col-lg-5">
                                <?php if ($model->parent_id == 0): ?>
                                    <div class="product-images">
                                        <div class="first-image text-center">
                                            <?=
                                            ObjectImageWidget::widget(
                                                [
                                                    'limit' => 1,
                                                    'model' => $model,
                                                ]
                                            )
                                            ?>
                                        </div>
                                        <?php if (count($model->images)>1): ?>
                                            <div class="other-images">
                                                <?=
                                                ObjectImageWidget::widget(
                                                    [
                                                        'model' => $model,
                                                    ]
                                                )
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="product-images">
                                        <div class="first-image">
                                            <?=
                                            \app\modules\image\widgets\CartImageWidget::widget([
                                                'limit' => 1,
                                                'model' => $model,
                                            ])
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
            <div class="col-12 col-lg-7">
                                <h1 itemprop="name">
                                    <?=Html::encode($productCategory  . ' ' . $model->h1)?>
                                </h1>
                                <div class="row">
                <div class="col-md-12 col-lg-8">

                    <?php if ($model->parent_id == 0): ?>

                      <?php if (isset($model->optionsQuantity)): ?>
                        <div class="varieties">  <!-- Разновидности товара -->
                            <?php
                                echo \app\properties\PropertiesWidget::widget(
                                [
                                'model' => $model,
                                'viewFile' => 'show-announce-widget',
                                ]
                                );
                            ?>
                                <div id="opisanie" itemprop="description">
                                    <?php echo $this->blocks['announce'];?>
                                </div>
                            <div class="text-center" id="varieties-product">
                                <h2>Разновидности товара</h2>
                                <?php
                                echo app\web\theme\module\widgets\varieties\VarietiesWidget::widget(
                                    [
                                        'model' => $model,
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                            <?php else: ?>
                            <div class="varieties">  <!-- Разновидности товара -->
                             <h2>Характеристики товара</h2>
                                <?php
                                echo \app\properties\PropertiesWidget::widget(
                                [
                                'model' => $model,
                                'viewFile' => 'show-properties-widget',
                                ]
                                );
                             ?>
                                <p>Наличие нужного вам цвета или размера уточняйте </p>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="varieties">
                            <h2>Характеристики товара</h2>
                            <div itemprop="description">
                                <?php
                                    echo $parentAnnounce->announce;
                                    $propertiesShowedInAnnounce = true;
                                    echo \app\properties\PropertiesWidget::widget(
                                        [
                                            'model' => $model,
                                            'viewFile' => 'show-properties-widget',
                                        ]
                                    );
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>


                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="price-block">
                        <?php if ($model->price < $model->old_price): ?>
                            <div class="old">
                                <div class="price-name">
                                    <?= Yii::t('app', 'Old price:') ?>
                                </div>
                                <div class="price">
                                    <?=$model->nativeCurrencyPrice(true, false)?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="price-name">
                            <?= Yii::t('app', 'Price:') ?>
                            <div class="price">
                                <?=$model->nativeCurrencyPrice(false, true)?>
                            </div>
                        </div>

                        </div>
                        <div class="cta">
                        <a  class="btn btn-add-to-cart add-to-cart-disabled" id="add-to-cart"  data-action="" data-id = "<?= $model->id?>">
                            <?=Yii::t('app', 'Add to')?> <i class="fa fa-shopping-cart"></i>
                        </a>

                       <br><br>
                        <a href='#' class="btn-add-to-wishlist" rel="nofollow" data-toggle="modal" data-target="#wishlist">
                            <?=Yii::t('app', 'Add to wishlist')?>
                        </a>
                        <?= AddToWishlistWidget::widget(['id' => $model->id]) ?>
                        <br><br>

                        <a href="/shop/cart" class="btn btn-success go-cart" role="button" >Перейти в корзину</a>

                        <br><br>
                        <!-- Button trigger modal -->
                        <button type="button" id="wearsize" class="btn btn-light btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">
                            Подобрать размер
                        </button>

                    </div>
                </div>
            </div>                         
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </section>
        <!--end product detail-->

            
            

            
<?php
app\slider\sliders\slick\SlickAsset::register($this);
$js = <<<JS

jQuery(function(){
     $('.first-image img').addClass('my-foto');
          if($(window).width()>=1170) {
            $(".my-foto").imagezoomsl({
              zoomrange: [2.12, 12],
              magnifiersize: [600, 430],
              scrollspeedanimate: 10,
              loopspeedanimate: 5,
              cursorshadeborder: "10px solid black",
              magnifiereffectanimate: "slideIn"
         });
        }
         if($(window).width()>=750 && $(window).width()<1170) {
              jQuery(function(){
                    $(".my-foto").imagezoomsl({
                      zoomrange: [2.12, 12],
                      magnifiersize: [430, 380],
                      scrollspeedanimate: 10,
                      loopspeedanimate: 5,
                      cursorshadeborder: "10px solid black",
                      magnifiereffectanimate: "slideIn"
                 });
              });
        }
             if($(window).width()<750) {
              jQuery(function(){
                  $(".my-foto").imagezoomsl({
                     zoomrange: [1, 12],
                     zoomstart: 4,
                     innerzoom: true,
                     magnifierborder: "none"
                  });
              });
        }
});

$('.other-images').slick({
    speed: 300,
    variableWidth: true,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
    ]
});
$(".other-images").on('click', '.slick-slide', function(){
    var that = $(this),
        img = that.find('img');

    $(".first-image img").attr('src', img.attr('src'));

});

var countCart = $('#cart-count').html();

if(countCart > 0){
    $('.go-cart').removeClass('go-cart');
}


JS;
$this->registerJs($js);