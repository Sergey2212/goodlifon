<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
/** @var app\components\WebView $this */
/** @var bool $useFontAwesome */
/** @var \app\extensions\DefaultTheme\Module $theme */
/** @var integer $rootNavigationId */
?>

<footer class="footer bg-secondary bg-gradient text-white">
    <div class="container">
        <div class="row">
            <div class="col-xs-3 col-md-3 footer-widget text-center">
                <?=
                    \app\widgets\navigation\NavigationWidget::widget([
                        'rootId' => $rootNavigationId,
                    ])
                ?>
            </div>
            <div class="col-xs-9 col-md-6 footer-widget text-center">
                <p class="oferta"><a href="<?= \yii\helpers\Url::toRoute(['/politika-konfidencialnosti']) ?>">Политика конфиденциальности</a></p>
                <p class="oferta"><a href="<?= \yii\helpers\Url::toRoute(['/publichnaya-oferta']) ?>">Публичная оферта</a></p>
            </div>
            <div class="col-md-3 footer">

            </div>
        </div>
    </div>
</footer>