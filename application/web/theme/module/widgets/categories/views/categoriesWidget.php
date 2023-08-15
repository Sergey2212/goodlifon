
<?php
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Nav;
use kartik\bs5dropdown\Dropdown;
use kartik\bs5dropdown\ButtonDropdown;
use yii\helpers\Html;

//NavBar::begin([
//    'options' => [
//        'class' => 'navbar-default',
//    ],
//]);
//
//echo Nav::widget([
//    'items' => $tree,
//    'options' => [
//        'class' => 'navbar-nav'
//    ],
//]);
//NavBar::end();

// Usage of Bootstrap 5 dropdown with bootstrap 5 NavBar
NavBar::begin([
    'brandLabel' => 'NavBar',
    'brandOptions' => ['class'=>'p-0'],
    'options' => ['class' => 'navbar navbar-expand-lg navbar-light', 'style' => 'background-color: #e3f2fd']
]);
echo Nav::widget([
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        [
            'label' => 'Dropdown',
            'items' => [
                ['label' => 'Section 1', 'url' => '/'],
                ['label' => 'Section 2', 'url' => '#'],
                [
                    'label' => 'Section 3',
                    'items' => [
                        ['label' => 'Section 3.1', 'url' => '/'],
                        ['label' => 'Section 3.2', 'url' => '#'],
                        [
                            'label' => 'Section 3.3',
                            'items' => [
                                ['label' => 'Section 3.3.1', 'url' => '/'],
                                ['label' => 'Section 3.3.2', 'url' => '#'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        ['label' => 'About', 'url' => ['/site/about']],
    ],
    'dropdownClass' => Dropdown::class, // use the custom dropdown
    'options' => ['class' => 'navbar-nav mr-auto me-auto'],
]);
NavBar::end();















//debug($tree);

?>







