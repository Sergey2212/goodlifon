<?php

/**
 * @var $breadcrumbs array
 * @var $category_group_id integer
 * @var $object \app\models\BaseObject
 * @var $pages \yii\data\Pagination
 * @var $products \app\modules\shop\models\Product[]
 * @var $selected_category \app\modules\shop\models\Category
 * @var $selected_category_id integer
 * @var $selected_category_ids integer[]
 * @var $selections
 * @var $this app\components\WebView
 * @var $title_append string
 * @var $values_by_property_id
 */

use app\modules\image\models\Image;
use \app\modules\shop\models\UserPreferences;
use yii\helpers\Url;
use yii\helpers\Html;

$pageNumber='';

foreach ($breadcrumbs as $breadcrumb){
    if ($breadcrumb['label'] !== 'Нижнее белье' && $breadcrumb['label'] !== 'Чулочно-носочные' && $breadcrumb['label'] !== 'Трикотаж') {
        $arrCategories[] = mb_strtolower($breadcrumb['label'], 'utf-8');
    }
}

//$arrCategory = array_reverse($arrCategories);
array_shift($arrCategories);
$strCategory = implode(' ', $arrCategories);

if (isset($_GET['page'])){
    $pageNumber =  ' | страница ' . $_GET['page'];
}

if ($this->blocks['h1'] == 'Каталог'){
    $this->title = 'Каталог магазина нижнего белья Гудлифон ' . $pageNumber;
    $textDescription = 'Каталог товаров которые можно купить в магазине нижнего белья Гудлифон: бюстгальтеры, трусы, купальники и трикотаж'. $pageNumber;
}
else{
    $this->title =  mb_ucfirst($strCategory, $encoding='UTF-8') . ' купить в Волгограде' .$pageNumber .'. В интернет-магазине Гудлифон';
    $textDescription = mb_ucfirst($strCategory, $encoding='UTF-8') . ' купить в Волгограде' .$pageNumber .'. В магазине нижнего белья Гудлифон Вы всегда найдете ' . $strCategory . ' хорошего качества по низким ценам от ведущих отечественных и зарубежных производителей. Скидки постоянным покупателям.';
}

if (!empty($selected_category->images[0]['filename'])){
   $categoryImg=  $selected_category->images[0]['filename'];
}
else{
    $categoryImg=  'nophoto.jpg';
}

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
    'property' => 'og:image',
    'content' => "https://".$_SERVER['SERVER_NAME']. "/files/".$categoryImg
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
    'property' => 'og:site_name',
    'content' => 'Гудлифон-Магазин бюстгальтеров, купальников, колготок.'
]);

$this->params['breadcrumbs'] = $breadcrumbs;
$listView = UserPreferences::preferences()->getAttributes()['listViewType'];

?>
<div id="product-list-block">
<!--
    <div>
        <?php /*foreach ($products as $product):*/ ?>
            <?php /*if ($product->optionsQuantity > 500 && $product->optionsQuantity < 31):*/ ?>
                    <p>
                    <?php /*echo $product->name .  ' - '  . $product->optionsQuantity;*/ ?>
                    </p>
            <?php /*endif;*/ ?>
        <?php /*endforeach;*/ ?>
    </div>
-->
<h1>
    <?=$this->blocks['h1']?>
</h1>
    <div class="alert alert-info"> <p>На сайте представлена лишь малая часть ассортимента нашего магазина. При личном посещении Вы будете приятно удивлены разнообразием товаров на любой вкус и размер. Если у вас есть вопросы по поводу нужного вам товара, пишите, будем рады ответить.</p></div>

<?php if (!empty($this->blocks['announce'])): ?>
    <div class="block-announce">
        <?= $this->blocks['announce'] ?>
    </div>
<?php endif; ?>

<div id="<?=($listView === 'listView' ? 'listView' : 'blockView')?>" class="block-product-list">
    <?php
    if ($listView === 'blockView') {
        echo'<div class="product-grid">';
        echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">';
    }
    $k = 0;
    ?>
    <?php foreach ($products as $product) {

                if ($this->beginCache('Product-item:'.$listView.':'.$product->id, [
                    'duration' => 86400,
                    'dependency' => new \yii\caching\TagDependency([
                        'tags' => $product->getCacheTags(),
                    ])
                ])) {
                    $url = Url::to(
                        [
                            '@product',
                            'model' => $product,
                            'category_group_id' => $category_group_id,
                        ]
                    );

                    echo $this->render(($listView === 'listView' ? 'item-row' : 'item'),
                        ['product' => $product, 'url' => $url]);
                    $this->endCache();
                }
            $k++;
    } ?>
    <?php
    if ($listView === 'blockView') {
        echo '</div>';
        echo'</div>';
    }
    ?>
</div>


<nav class="pagination-section">
    <div class="pagination justify-content-center">
        <?php
        if ($pages->pageCount > 1):
            $_GET = $selections;
            ?>
            <?=yii\bootstrap5\LinkPager::widget(
            [
                'pagination' => $pages,
            ]
        );?>
        <?php endif; ?>
    </div>
</nav>

<?php if (!isset($_GET['page']) && (count($values_by_property_id) === 0 || Yii::$app->response->is_prefiltered_page)): ?>
    <div class="content"><?=$this->blocks['content']?></div>
<?php endif; ?>
</div>

<?php
timurmelnikov\widgets\LoadingOverlayAsset::register($this);
$js = <<<JS
//Настройки (можно не использовать, тогда - все по умолчанию)
$.LoadingOverlaySetup({
        color           : "rgba(245, 210, 217, 0.5)",
        maxSize         : "100px",
        minSize         : "20px",
        resizeInterval  : 0,
        imagePosition   :"top",
        size            : "50%"
});

//Наложение jQuery LoadingOverlay на элемент с ID #p0, при отправке AJAX-запроса
$(document).ajaxSend(function(event, jqxhr, settings){
    $("#product-list-block").LoadingOverlay("show");
});

//Скрытие jQuery LoadingOverlay на элемент с ID #p0, после выполнения AJAX-запроса
$(document).ajaxComplete(function(event, jqxhr, settings){
    $("#product-list-block").LoadingOverlay("hide");
});
JS;
$this->registerJs($js);
?>