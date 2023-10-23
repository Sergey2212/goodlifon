<?php

use app\backend\widgets\BackendWidget;
use app\modules\shop\controllers\BackendProductController;
use app\modules\shop\models\Product;
use app\backend\widgets\GridView;
use kartik\helpers\Html;
use kartik\icons\Icon;
use app\backend\components\ActiveForm;
use kartik\widgets\DateTimePicker;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * @var $this \yii\web\View
 * @var $model \app\modules\shop\models\Product
 */
$this->title = Yii::t('app', 'Product edit');

$this->params['breadcrumbs'][] = ['url' => ['index'], 'label' => Yii::t('app', 'Products')];
if ($parent !== null) {
    $this->params['breadcrumbs'][] = ['url' => ['edit', 'id' => $parent->id], 'label' => $parent->name];
}
$this->params['breadcrumbs'][] = $this->title;

?>

<?= app\widgets\Alert::widget([
    'id' => 'alert',
]); ?>

<?php
    $form = ActiveForm::begin(
    [
        'id' => 'product-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]);
?>

<?php $this->beginBlock('submit'); ?>
<div class="form-group no-margin">
    <?php if (!$model->isNewRecord): ?>
        <?=
        Html::a(
            Icon::show('eye') . Yii::t('app', 'Preview'),
            [
                '@product',
                'model' => $model,
                'category_group_id' => is_null($model->mainCategory) ? null : $model->mainCategory->category_group_id,
            ],
            [
                'class' => 'btn btn-info',
                'target' => '_blank',
            ]
        )
        ?>
    <?php endif; ?>
    <?=
    Html::a(
        Icon::show('arrow-circle-left') . Yii::t('app', 'Back'),
        Yii::$app->request->get('returnUrl', ['index']),
        ['class' => 'btn btn-danger']
    )
    ?>
    <?php if ($model->isNewRecord): ?>
        <?=
        Html::submitButton(
            Icon::show('save') . Yii::t('app', 'Save & Go next'),
            [
                'class' => 'btn btn-success',
                'name' => 'action',
                'value' => 'next',
            ]
        )
        ?>
    <?php endif; ?>
    <?= Html::submitButton(
        Icon::show('save') . Yii::t('app', 'Save & Go back'),
        [
            'class' => 'btn btn-warning',
            'name' => 'action',
            'value' => 'back',
        ]
    ); ?>
    <?=
    Html::submitButton(
        Icon::show('save') . Yii::t('app', 'Save'),
        [
            'class' => 'btn btn-primary',
            'name' => 'action',
            'value' => 'save',
        ]
    )
    ?>
</div>
<?php $this->endBlock(); ?>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-main" type="button" role="tab" aria-selected="true"><?= Yii::t('app', 'Main') ?></button>
            <button class="nav-link"  data-bs-toggle="tab" data-bs-target="#tab-seo" type="button" role="tab"  aria-selected="false"><?= Yii::t('app', 'SEO') ?></button>
        <?php if (false === $model->isNewRecord): ?><button class="nav-link" data-bs-toggle="tab" data-bs-target="#product-tab-images" type="button" role="tab" aria-selected="false"><?= Yii::t('app', 'Images') ?></button><?php endif; ?>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#tab-properties" type="button" role="tab"  aria-selected="false"><?= Yii::t('app', 'Properties') ?></button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#tab-addons" type="button" role="tab"  aria-selected="false"><?= Yii::t('app', 'Addons') ?></button>
<?php if (!empty($model->options)): ?><button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#tab-options" type="button" role="tab"  aria-selected="false"><?= Yii::t('app', 'Product Options') ?></button><?php endif; ?>
        </div>
    </nav>


<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="tab-main" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                <?php
                BackendWidget::begin(
                    [
                        'title'=> Yii::t('app', 'Product'),
                        'icon'=>'shopping-cart',
                        'footer'=>$this->blocks['submit']
                    ]
                ); ?>

                <?= $form->field($model, 'active')->widget(\kartik\switchinput\SwitchInput::className()) ?>
                <?= $form->field($model, 'name')?>
                <?= $form->field($model, 'price',[
                    'addon' => [
                        'append' => [
                            'content' => Html::activeDropDownList($model, 'currency_id', app\modules\shop\models\Currency::getSelection()),
                        ],
                    ],
                ])?>
                <?= $form->field($model, 'old_price')?>

                <?=
                $form->field(app\models\ViewObject::getByModel($model, true), 'view_id')
                    ->dropDownList(
                        app\models\View::getAllAsArray()
                    );
                ?>

                <?php
                if (!$model->isNewRecord && is_array($model->relatedProductsArray)):
                    $data = \yii\helpers\ArrayHelper::map($model->relatedProducts, 'id', 'name');
                ?>
                    <?=
                        \app\backend\widgets\Select2Ajax::widget([
                            'initialData' => $data,
                            'form' => $form,
                            'model' => $model,
                            'modelAttribute' => 'relatedProductsArray',
                            'multiple' => true,
                            'searchUrl' => '/shop/backend-product/ajax-related-product',
                            'additional' => [
                                'placeholder' => Yii::t('app', 'Search products...'),
                            ],
                        ]);
                    ?>
                <?php
                endif;
                ?>

                <?=
                $form->field($model, 'measure_id')
                    ->dropDownList(
                        \app\components\Helper::getModelMap(\app\modules\shop\models\Measure::className(), 'id', 'name')
                    );
                ?>

                <?php BackendWidget::end(); ?>


            </div>
            <div class="col-md-6">
                <?php
                BackendWidget::begin(
                    [
                        'title'=> Yii::t('app', 'Categories'),
                        'icon'=>'tree',
                        'footer'=>$this->blocks['submit']
                    ]
                ); ?>

                <?=
                \app\backend\widgets\JSSelectableTree::widget([
                    'flagFieldName' => 'main_category_id',
                    'fieldName' => 'categories',
                    'model' => $model,
                    'selectedItems' => $selected,
                    'selectOptions' => ['class' => 'form-control'],
                    'selectLabel' => Yii::t('app', 'Main category'),
                    'routes' => [
                        'getTree' => ['getCatTree'],
                    ],
                    'stateKey' => $model->id . $model->isNewRecord?time() : '',
                ]);
                ?>
                <br />

                <?php
                BackendWidget::end();
                ?>

                <?php
                BackendWidget::begin(
                    [
                        'title'=> Yii::t('app', 'Warehouse'),
                        'icon'=>'archive',
                        'footer'=>$this->blocks['submit']
                    ]
                ); ?>

                <?= $form->field($model, 'sku') ?>
                <?= $form->field($model, 'unlimited_count')->widget(\kartik\switchinput\SwitchInput::className())?>
                <?= \app\backend\widgets\WarehousesRemains::widget([
                    'model' => $model,
                ]) ?>
                <?php BackendWidget::end(); ?>

            </div>
        </div>
    </div>
     <div class="tab-pane fade" id="tab-seo" role="tabpanel">
         <div class="row">
        <div class="col-md-6">
            <?php BackendWidget::begin(['title'=> Yii::t('app', 'SEO'), 'icon'=>'cogs', 'footer'=>$this->blocks['submit']]); ?>

            <?=
            $form->field($model, 'slug', [

                'makeSlug' => [
                    "#product-name",
                    "#product-title",
                    "#product-h1",
                    "#product-breadcrumbs_label",
                ]

            ])
            ?>

            <?=
            $form->field($model, 'title', [
                'copyFrom' => [
                    "#product-name",
                    "#product-h1",
                    "#product-breadcrumbs_label",
                ]
            ])
            ?>

            <?=
            $form->field($model, 'h1', [
                'copyFrom' => [
                    "#product-name",
                    "#product-title",
                    "#product-breadcrumbs_label",
                ]
            ])
            ?>

            <?=
            $form->field($model, 'breadcrumbs_label', [
                'copyFrom' => [
                    "#product-name",
                    "#product-title",
                    "#product-h1",
                ]
            ])
            ?>

            <?= $form->field($model, 'meta_description')->textarea() ?>

            <?php BackendWidget::end(); ?>
        </div>


        <div class="col-md-6"> <!-- Content -->

            <?php
            BackendWidget::begin(
                [
                    'title'=> Yii::t('app', 'Content'),
                    'icon'=>'file-text',
                    'footer'=>$this->blocks['submit']
                ]
            ); ?>

            <?= $form->field($model, 'content')->widget(Yii::$app->getModule('core')->wysiwyg_class_name(), Yii::$app->getModule('core')->wysiwyg_params()); ?>

            <?= $form->field($model, 'announce')->widget(Yii::$app->getModule('core')->wysiwyg_class_name(), Yii::$app->getModule('core')->wysiwyg_params()); ?>

            <?= $form->field($model, 'sort_order'); ?>

            <?=$form->field($model, 'date_added')->widget(
                DateTimePicker::classname(),
                [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'todayHighlight' => true,
                        'todayBtn' => true,

                    ]
                ]
            );?>

            <?php BackendWidget::end(); ?>

        </div>

         </div>
    </div>
        <div class="tab-pane fade" id="product-tab-images" role="tabpanel">

        <div class="col-md-12">
            <?php
            BackendWidget::begin(
                [
                    'title'=> Yii::t('app', 'Images'),
                    'icon'=>'image',
                    'footer'=>$this->blocks['submit']
                ]
            ); ?>

            <?=
            \yii\helpers\Html::tag(
                'span',
                Icon::show('plus') . Yii::t('app', 'Add files..'),
                [
                    'class' => 'btn btn-success fileinput-button'
                ]
            ) ?>
            <?php
            if (Yii::$app->getModule('elfinder')) {
                echo \DotPlant\ElFinder\widgets\ElfinderFileInput::widget(
                    ['url' => Url::toRoute(['addImage', 'objId' => $object->id, 'objModelId' => $model->id])]
                );
            }
            ?>
            <?=
            \app\modules\image\widgets\ImageDropzone::widget([
                'name' => 'file',
                'url' => ['upload'],
                'removeUrl' => ['remove'],
                'uploadDir' => '/theme/resources/product-images',
                'sortable' => true,
                'sortableOptions' => [
                    'items' => '.dz-image-preview',
                ],
                'objectId' => $object->id,
                'modelId' => $model->id,
                'htmlOptions' => [
                    'class' => 'table table-striped files',
                    'id' => 'previews',
                ],
                'options' => [
                    'clickable' => ".fileinput-button",
                ],
            ]);
            ?>

            <?php BackendWidget::end(); ?>
        </div>


    </div>

     <div class="tab-pane fade" id="tab-properties" role="tabpanel">
     
            <div class="row">
                <div class="col-md-6">
                <?=
                \app\properties\PropertiesWidget::widget([
                    'model' => $model,
                    'form' => $form,
                ]);
                ?>
            </div>
                <div class="col-md-6">
                <?php if ($model->parent_id == 0) : ?>
                    <?=
                    \app\modules\shop\widgets\OptionGenerate::widget([
                        'model' => $model,
                        'form' => $form,
                        'footer' => $this->blocks['submit'],
                    ]);
                    ?>
                <?php endif; ?>
            </div>
            </div>
    </div>


        <div class="tab-pane fade" id="tab-addons" role="tabpanel">
        <div class="col-md-12">
            <?=
            \app\modules\shop\widgets\AddonsWidget::widget([
                'form' => $form,
                'model' => $model
            ])
            ?>
        </div>
    </div>


    <div class="tab-pane fade" id="tab-options" role="tabpanel">

    </div>
</div>

<?php
$event = new \app\backend\events\BackendEntityEditFormEvent($form, $model);
$this->trigger(BackendProductController::EVENT_BACKEND_PRODUCT_EDIT_FORM, $event);
?>
<?php ActiveForm::end(); ?>



    <section class="col-md-12">
        <article>
            <?php  // Разновидности продукта  с фильтрацией
            $product = Yii::$container->get(Product::class);
            if (!empty($model->options)) : ?>
                <?php
                BackendWidget::begin(
                    [
                        'title'=> Yii::t('app', 'Product Options'),
                        'icon'=>'shopping-cart',
                        'footer'=>$this->blocks['submit']
                    ]
                ); ?>

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => new app\modules\shop\models\ProductOptionSearch,
                    'columns' => [
                        [
                            'class' => 'yii\grid\DataColumn',
                            'attribute' => 'id',
                        ],
                        [
                            'class' => 'app\backend\columns\TextWrapper',
                            'attribute' => 'name',
                            'callback_wrapper' => function ($content, $model, $key, $index, $parent) {

                                return $content;
                            }
                        ],
                        [
                            'class'=>\kartik\grid\EditableColumn::className(),
                            'header' => 'Наличие',
                            'contentOptions' => ['class' => 'kv-quantity-column'],
                            'value' => function($model){
                                if(!isset($model->quantity->in_warehouse)){
                                    \app\backend\widgets\WarehousesRemains::widget([
                                        'model' => $model,
                                    ]);
                                }
                            },
                            'editableOptions' => function ($model) {
                                if(!isset($model->quantity->in_warehouse)){
                                    return   [
                                        'value' => 'Обновите',
                                        'name' => 'no',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'formOptions' => [
                                            'action' => Url::toRoute('/shop/backend-warehouse/update-remains'),
                                        ],
                                        'inputType' => \kartik\editable\Editable::INPUT_SPIN,
                                        'options' => ['pluginOptions' => ['min' => 0, 'max' => 5000]],
                                        'placement' => 'top',
                                    ];
                                }else{
                                    return   [
                                        'value' => $model->quantity->in_warehouse,
                                        'name' => 'remain['.$model->quantity->id.'][in_warehouse]',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'formOptions' => [
                                            'action' => Url::toRoute('/shop/backend-warehouse/update-remains'),
                                        ],
                                        'inputType' => \kartik\editable\Editable::INPUT_SPIN,
                                        'options' => ['pluginOptions' => ['min' => 0, 'max' => 5000]],
                                        'placement' => 'top',
                                    ];
                                }

                            },
                        ],
                        [
                            'class' => \kartik\grid\EditableColumn::className(),
                            'attribute' => 'price',
                            'editableOptions' => [
                                'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                'formOptions' => [
                                    'action' => Url::toRoute('/shop/backend-product/update-editable'),
                                ],
                            ],
                        ],
                        'old_price', //Старая цена
                        [
                            'class' => \kartik\grid\EditableColumn::className(),
                            'attribute' => 'active',
                            'editableOptions' => [
                                'data' => [
                                    0 => Yii::t('app', 'Inactive'),
                                    1 => Yii::t('app', 'Active'),
                                ],
                                'inputType' => 'dropDownList',
                                'placement' => 'left',
                                'formOptions' => [
                                    'action' => 'update-editable',
                                ],
                            ],
                            'filter' => [
                                0 => Yii::t('app', 'Inactive'),
                                1 => Yii::t('app', 'Active'),
                            ],
                            'format' => 'raw',
                            'value' => function (Product $model) {
                                if ($model === null || $model->active === null) {
                                    return null;
                                }
                                if ($model->active === 1) {
                                    $label_class = 'label-success';
                                    $value = 'Active';
                                } else {
                                    $value = 'Inactive';
                                    $label_class = 'label-default';
                                }
                                return \yii\helpers\Html::tag(
                                    'span',
                                    Yii::t('app', $value),
                                    ['class' => "label $label_class"]
                                );
                            },
                        ],
                        [
                            'class' => 'app\backend\components\ActionColumn',
                            'buttons' => function ($model, $key, $index, $parent) {
                                return null;
                            }
                        ],
                    ],
                    'hover' => true,
                ]);
                ?>
                <?php BackendWidget::end(); ?>
                <?php
            endif; ?>
        </article>
    </section>




<?php
$tab_errors = <<<JS
jQuery('#product-form').on('afterValidate', function (e) {
    jQuery('.nav-tabs a').removeClass('has-error');

    var \$errors = jQuery('#product-form').find('.form-group.has-error');
    if ('undefined' !== typeof(\$errors) && \$errors.length > 0) {
        \$errors.each(function(i, e) {
            var tab_id = $(e).closest('.tab-pane').attr('id');
            jQuery('#product-form').find('[data-toggle=tab][href="#' + tab_id + '"]').addClass('has-error');
        });
        return false;
    }
    return true;
});

jQuery(".product-tabs a[data-toggle='tab']").on("shown.bs.tab", function(event) {
    localStorage.setItem("productActiveTab", "#" + event.target.id);
});

jQuery(localStorage.getItem("productActiveTab")).click();
JS;
$this->registerJs($tab_errors);
