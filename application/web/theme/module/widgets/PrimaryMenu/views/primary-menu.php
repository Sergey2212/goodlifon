
<?php
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Nav;
use kartik\bs5dropdown\Dropdown;
use kartik\nav\NavXBs5;

?>
<div class="primary-menu">
    <div class="container-fluid ">
        <?php
        NavBar::begin([
            'brandLabel' => 'Все категории',
            'options' => [
                'id' => 'navbar_main',
                'class' => 'navbar navbar-expand-lg',
            ],
        ]);

        if (isset($tree)) {
            try {
                echo NavXBs5::widget([
                    'items' => $tree,
                    'options' => [
                        'class' => 'navbar-nav hero-side-category w-100 justify-content-center',
                        'aria-expanded' => 'true'
                    ],
                ]);
            } catch (Throwable $e) {
            }
        }
        NavBar::end();
        ?>
    </div>
</div>

<p></p>

<?php
//debug($tree);

