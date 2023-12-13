<?php
use yii\helpers\Url;

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

        <h2 class="title text-center">НОВИНКИ</h2>
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
				
				echo $this->render(('_item'),
                        ['product' => $product, 'url' => $url]);

                    $k++;
                } ?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="container-fluid">

    <h2 class="title text-center">ПОПУЛЯРНЫЕ ПРОДУКТЫ</h2>
    <hr/>
    <div class="product-grid">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
            <?php
                $k = 0;
                ?>
                <?php
                foreach ($topProducts as $product) {
                    $url = Url::to(
                        [
                            '@product',
                            'model' => $product,
                            'category_group_id' => 1,
                        ]
                    );
			
			echo $this->render(('_item'),
                    ['product' => $product, 'url' => $url]);

                $k++;
            } ?>
        </div>
    </div>
</div>
</section>
