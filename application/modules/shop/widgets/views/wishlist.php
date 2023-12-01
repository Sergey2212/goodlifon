<?php

/**
 * @var $id integer
 * @var $wishlists array
 * @var $model Wishlist
 */

use yii\bootstrap5\Modal;
use yii\widgets\ActiveForm;
use app\modules\shop\models\Wishlist;
use yii\helpers\Html;
use kartik\icons\Icon;

Modal::begin([
    'title' => '<h4>' . Yii::t('app', 'Добавление в список желаний') . '</h4>',
    'size' => Modal::SIZE_DEFAULT,
    'id' => 'wishlist',
    'options' => [
        'style' => [
            'text-align' => 'left',
        ],
    ],
    'titleOptions' => [
        'style' => [
            'text-align' => 'center',
        ],
    ],
]);

$form = ActiveForm::begin([
    'id' => 'wishlist-form',
    'action' => null,
]);
foreach ($wishlists as $wishlist) {
    /** @var Wishlist $wishlist */
       
    echo Html::tag('div',
        Html::label(Html::radio('wishlistId', ($wishlist->default) ? true : false, ['value' => $wishlist->id]) . Html::encode($wishlist->title) . '<span>(' . count($wishlist->items) . ')</span>'),
        [
            'class' => 'form-group',
        ]
    );
}
echo Html::tag('div',
    Html::label(Html::radio('wishlistId', false, ['value' => 0]) . $form->field($model, 'title', [
            'inputOptions' => [
            	'class' => 'form-control',
                'placeholder' => Yii::t('app', 'Придумайте название списка'),
                'name' => 'title',
            ],
            'options' => [
                'style' => [
                    'float' => 'right',
                    'width' => '400px'
                ]
            ]
        ])->label('')),
    [
        'class' => 'form-group required',
    ]
);



echo Html::button(Icon::show('check') . Yii::t('app', 'Добавить'), [
    'class' => 'btn btn-success',
    'data-action' => 'add-to-wishlist',
    'data-bs-dismiss' => 'modal',
    'data-id' => $id,
    'style' => [
        'margin' => '0 auto',
        'display' => 'block',
    ],
]);
ActiveForm::end();
Modal::end();

$js = <<<JS
    $('form#wishlist-form [type=text]').on('focus', function(){
        $(this).parent().siblings('[type=radio]').prop("checked", true);
    });
JS;
$this->registerJs($js);
