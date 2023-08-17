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
                                <div class="product-info-section p-3">
                                    <h3 class="mt-3 mt-lg-0 mb-0">Allen Solly Men's Polo T-Shirt</h3>
                                    <div class="product-rating d-flex align-items-center mt-2">
                                        <div class="rates cursor-pointer font-13">	<i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-light-4"></i>
                                        </div>
                                        <div class="ms-1">
                                            <p class="mb-0">(24 Ratings)</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mt-3 gap-2">
                                        <h5 class="mb-0 text-decoration-line-through text-light-3">$98.00</h5>
                                        <h4 class="mb-0">$49.00</h4>
                                    </div>
                                    <div class="mt-3">
                                        <h6>Discription :</h6>
                                        <p class="mb-0">Virgil Abloh’s Off-White is a streetwear-inspired коллекция that continues to break away from the conventions of mainstream fashion. Made in Italy, these black and brown Odsy-1000 low-top sneakers.</p>
                                    </div>
                                    <dl class="row mt-3">	<dt class="col-sm-3">Product id</dt>
                                        <dd class="col-sm-9">#BHU5879</dd>	<dt class="col-sm-3">Delivery</dt>
                                        <dd class="col-sm-9">Russia, USA, and Europe</dd>
                                    </dl>
                                    <div class="row row-cols-auto align-items-center mt-3">
                                        <div class="col">
                                            <label class="form-label">Quantity</label>
                                            <select class="form-select form-select-sm">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Size</label>
                                            <select class="form-select form-select-sm">
                                                <option>S</option>
                                                <option>M</option>
                                                <option>L</option>
                                                <option>XS</option>
                                                <option>XL</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Colors</label>
                                            <div class="color-indigators d-flex align-items-center gap-2">
                                                <div class="color-indigator-item bg-primary"></div>
                                                <div class="color-indigator-item bg-danger"></div>
                                                <div class="color-indigator-item bg-success"></div>
                                                <div class="color-indigator-item bg-warning"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="javascript:;" class="btn btn-white btn-ecomm">	<i class="bx bxs-cart-add"></i>Add to Cart</a> <a href="javascript:;" class="btn btn-light btn-ecomm"><i class="bx bx-heart"></i>Add to Wishlist</a>
                                    </div>
                                    <hr/>
                                    <div class="product-sharing">
                                        <ul class="list-inline">
                                            <li class="list-inline-item"> <a href="javascript:;"><i class='bx bxl-facebook'></i></a>
                                            </li>
                                            <li class="list-inline-item">	<a href="javascript:;"><i class='bx bxl-linkedin'></i></a>
                                            </li>
                                            <li class="list-inline-item">	<a href="javascript:;"><i class='bx bxl-twitter'></i></a>
                                            </li>
                                            <li class="list-inline-item">	<a href="javascript:;"><i class='bx bxl-instagram'></i></a>
                                            </li>
                                            <li class="list-inline-item">	<a href="javascript:;"><i class='bx bxl-google'></i></a>
                                            </li>
                                        </ul>
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