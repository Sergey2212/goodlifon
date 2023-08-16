<?php
/** @var \app\models\Slider $slider */
/** @var array $slider_params */
/** @var string $slide_viewFile */
/** @var string $css_class */
/** @var \app\components\WebView $this */
$slides = $slider->getSlides(true);
?>

<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <!-- Indicators -->
    <div class="carousel-indicators">
        <?php
        foreach ($slides as $index => $slide) :
        ?>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?=$index?>" class="<?= ($index==0?'active':'') ?>"></button>
        <?php endforeach; ?>

    </div>

<!--     Wrapper for slides-->

    <div class="carousel-inner">
        <?php
            foreach ($slides as $index => $slide) {

                echo $this->render(
                    $slide_viewFile,
                    [
                        'slide' => $slide,
                        'slide_index' => $index,
                    ]
                );

            }
        ?>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Предыдущий</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Следующий</span>
    </button>
<!--    <a class="left carousel-control" href="#--><?//=$id?><!--" role="button" data-slide="prev">-->
<!--        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>-->
<!--    </a>-->
<!--    <a class="right carousel-control" href="#--><?//=$id?><!--" role="button" data-slide="next">-->
<!--        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>-->
<!--    </a>-->

</div>

<?php
if(count($slider_params)>0) {
    $this->registerJs(
       "$(\"#$id\").carousel(".\yii\helpers\Json::encode($slider_params).");",
        \yii\web\View::POS_READY
    );
}
$height = $slider->image_height.'px';
$this->registerCss(
    <<<CSS
#$id, #$id .item {
    max-height: $height;
}

CSS
);