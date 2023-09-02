<?php

/**
 * @var $content string
 * @var $this \app\components\WebView
 */

use app\extensions\DefaultTheme\assets\DefaultThemeAsset;
use app\extensions\DefaultTheme\models\ThemeParts;
use app\web\theme\module\assets\ThemeAsset;
use app\modules\seo\helpers\HtmlTagHelper;
use yii\helpers\Html;

DefaultThemeAsset::register($this);
ThemeAsset::register($this);
HtmlTagHelper::addTagOptions('html', 'lang', Yii::$app->language);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html<?= HtmlTagHelper::registerTagOptions('html')?>>
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<meta name="robots" content="noindex, nofollow"/>
	<meta name="robots" content="none"/>-->
	<meta name="keywords" content="женское белье, трикотаж,  иваново, термобельё, комплект, бюстгальтер, бюст, лифчик, санкт-пербург, трусики, трусы, стринги, купальник, утяжка, корректирующее, магазин, большие размеры, леди люкс, lady lux, милавица, milavitsa, трибуна, tribuna, валерия, valeria, rosme, vova, виз-а-виз, vis-a-vis, клевер, clever">
<!--	<base href="https://goodlifon.ru">-->
    <base href="goodlifon">
	<title><?= Html::encode($this->title) ?></title>
	<?= Html::csrfMetaTags() ?>
    <?php $this->head(); ?>
<!--<script>-->
<!--    (function(i,s,o,g,r,a,m){-->
<!--      i['GoogleAnalyticsObject']=r;-->
<!--      i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},-->
<!--      i[r].l=1*new Date();-->
<!--      a=s.createElement(o),m=s.getElementsByTagName(o)[0];-->
<!--      a.async=1;-->
<!--      a.src=g;-->
<!--      m.parentNode.insertBefore(a,m)-->
<!--    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');-->
<!--    -->
<!--    ga('create', 'UA-139507803-1', 'auto');-->
<!--    ga('send', 'pageview');-->
<!--</script>-->
<!-- <meta name="yandex-verification" content="d9798448354fae6f" /> -->
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="icon" type="image/png" href="/files/favicons/favicon-16x16.png" sizes="16x16" />  
<link rel="icon" type="image/png" href="/files/favicons/favicon-32x32.png" sizes="32x32" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<!--<script src="//code.jivosite.com/widget.js" jv-id="XcBOo0VTa1" async></script>-->
</head>
<body>
<?php $this->beginBody(); ?>

<!-- Yandex.Metrika counter -->
<!--<script>-->
<!--   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};-->
<!--   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})-->
<!--   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");-->
<!---->
<!--   ym(53422477, "init", {-->
<!--        clickmap:true,-->
<!--        trackLinks:true,-->
<!--        accurateTrackBounce:true-->
<!--   });-->
<!--</script>-->
<!--<noscript><div><img src="https://mc.yandex.ru/watch/53422477" style="position:absolute; left:-9999px;" alt="" /></div></noscript>-->
<!-- /Yandex.Metrika counter -->


    <?//= ThemeParts::renderPart('pre-header') ?>
    <?= ThemeParts::renderPart('header') ?>
    <?//= ThemeParts::renderPart('post-header') ?>

<?php

use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;


$leftSidebar = ThemeParts::renderPart('left-sidebar');
$rightSidebar = ThemeParts::renderPart('right-sidebar');
$contentLength = 12;
$leftSidebarLength = 3;
$rightSidebarLength = 3;

if (empty($leftSidebar) === false) {
	$contentLength -= $leftSidebarLength;
}
if (empty($rightSidebar) === false) {
	$contentLength -= $rightSidebarLength;
}

?>

<div class="content-block">
	<?= ThemeParts::renderPart('before-content') ?>
	<div class="container">
		<div class="row">
			<?php
    			if (!empty($leftSidebar)) {
    		?>
                    <div class="col-12 col-xl-3">
                        <div class="btn-mobile-filter d-xl-none">
                            <i class='bi bi-sliders'></i>
                        </div>
                        <div class="filter-sidebar d-none d-xl-flex">
                            <div class="card rounded-0 w-100">
                                <div class="align-items-center d-flex d-xl-none">
                                    <h6 class="text-uppercase mb-0">ФИЛЬТР</h6>
                                    <div class="btn-mobile-filter-close btn-close ms-auto cursor-pointer"></div>
                                </div>
                                <hr class="d-flex d-xl-none" />
                                <?= $leftSidebar ?>
                            </div>
                        </div>
                    </div>
             <?php
                    echo'<div class="col-12 col-xl-9">';
                }
                if (empty($leftSidebar)) {
                    echo'<div class="content-part col-xs-12 col-sm-9 col-md-12">';
                }
			?>

				<?=
				Breadcrumbs::widget(
					[
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						'options' => [
							'itemprop' => "breadcrumb",
							'class' => 'breadcrumb',
						]
					]
				)
				?>
				<?= $content ?>
			</div> <!-- content-part end -->

			<?php

			if (!empty($rightSidebar)) {
				echo '<div class="right-sidebar col-md-'.$rightSidebarLength.' col-xs-12">' . $rightSidebar . '</div>';
			}
			?>
		</div> <!-- /row -->
	</div> <!-- /container  -->
</div>
<?//= ThemeParts::renderPart('pre-footer') ?>
<?= ThemeParts::renderPart('footer') ?>
<?//= ThemeParts::renderPart('post-footer') ?>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage();?>