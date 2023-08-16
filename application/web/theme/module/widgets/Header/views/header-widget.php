<?php
use app\web\theme\module\widgets\HeaderTop\HeaderTopWidget;
use app\web\theme\module\widgets\HeaderMiddle\HeaderMiddleWidget;
use app\web\theme\module\widgets\PrimaryMenu\PrimaryMenuWidget;
?>

<header>

<?= HeaderTopWidget::widget()?>
<?= HeaderMiddleWidget::widget()?>
<?= PrimaryMenuWidget::widget()?>

</header>