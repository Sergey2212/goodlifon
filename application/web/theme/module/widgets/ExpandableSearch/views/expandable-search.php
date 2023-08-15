<?php

/** @var bool $autocomplete */
/** @var bool $useFontAwesome */
use kartik\form\ActiveForm;
use yii\helpers\Html;
?>
<div class="container text-center align-bottom">
    <div class="row g-0 search-group">
        <div class="col-4">
                <?php
                $form = ActiveForm::begin(
                    [
                        'action' => ['/default/search'],
                        'id' => 'search-form',
                        'method' => 'get',
                        'type' => ActiveForm::TYPE_INLINE,

                        'options' => [
                           //'class' => 'search-form',
                            'placeholder' => Yii::t('app', 'Search'),
                        ],

                    ]
                );
                $model = new \app\models\Search;
                $model->load(Yii::$app->request->get());
                $icon =  Html::tag('span', '', ['class' => 'bi bi-search']);
                $field = $form->field(
                    $model,
                    'q',
                    [
                        'options' => [
                           // 'placeholder' => Yii::t('app', 'Search'),
                        ],
                        'addon' => [
                            'append' => [
                            ],
                        ],
                    ]
                );
                if ($autocomplete === true) {
                    echo $field->widget(
                        \app\widgets\AutoCompleteSearch::className(),
                        [
                            'id' => 'search-autocomplete-' . uniqid(),
                        ]
                    );
                } else {
                    echo $field;
                }
                ActiveForm::end();
                ?>
        </div>

        <div class="col-7">
<!--            <div type="button" id="form-select" class="btn-group data-bs-toggle="dropdown"  input-group" data-bs-toggle="dropdown" aria-expanded="false" >-->
            <div class="dropdown">
                <div  id="form-select"  class="form-select flex-shrink-0" type="button" data-bs-toggle="dropdown"  aria-expanded="false">
                    Категории
                </div>
                <ul class="dropdown-menu" >
                    <?php
                    if (!empty($tree)) {
                        foreach ($tree as $category){
                            echo Html::beginTag('li');
                            echo Html::a($category['label'], [$category['url']], ['class' => 'dropdown-item']);
                            echo Html::endTag('li');
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-1">
                <span id="button-search" class="input-group-text cursor-pointer bg-transparent d-flex justify-content-center"><i class='bi bi-search'></i></span>
        </div>
    </div>
</div>



<?php
$js = <<<JS
$(".search-form input[type=text]").blur(function(){
    $(this).removeClass('active');
});
$(".search-form .search-append").click(function(){
    $(".search-form input[type=text]").addClass('active').focus();
    return false;
});
JS;
$this->registerJs($js);