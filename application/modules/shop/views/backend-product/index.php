<?php

use app\modules\shop\models\Product;
use app\modules\shop\models\WarehouseProduct;
use app\models\PropertyStaticValues;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use devgroup\JsTreeWidget\widgets\TreeWidget;
use devgroup\JsTreeWidget\helpers\ContextMenuHelper;
use app\backend\components\Helper;

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
$parent_id = Yii::$app->request->get('parent_id', app\modules\shop\models\Category::findRootForCategoryGroup(1)->id);
?>

<?=app\widgets\Alert::widget(
    [
        'id' => 'alert',
    ]
);?>

<?php
$this->beginBlock('add-button');
?>
<?=\app\backend\widgets\CategoryMovementsButtons::widget([
    'url' => Url::toRoute(['categoryMovements']),
    'gridSelector' => '.grid-view',
]) ?>
<a href="<?=Url::toRoute(
    ['edit', 'parent_id' => $parent_id, 'returnUrl' => \app\backend\components\Helper::getReturnUrl()]
)?>" class="btn btn-success">
    <?=Icon::show('plus')?>
    <?=Yii::t('app', 'Add')?>
</a>
<?= \app\backend\widgets\PublishSwitchButtons::widget([
    'url' => Url::toRoute(['publish-switch']),
    'gridSelector' => '.grid-view',
]) ?>

<?= \app\modules\shop\widgets\BatchEditPriceButton::widget([
    'context' => $this->context->id,
])?>
<?=\app\backend\widgets\RemoveAllButton::widget(
    [
        'url' => Url::toRoute(['remove-all', 'parent_id' => $parent_id]),
        'gridSelector' => '.grid-view',
        'htmlOptions' => [
            'class' => 'btn btn-danger pull-right'
        ],
    ]
);?>
<?php
$this->endBlock();
?>

<div class="row">
    <div class=" col col-md-3">
        <?=TreeWidget::widget(
            [
                'treeDataRoute' => ['getTree'],
                'doubleClickAction' => ContextMenuHelper::actionUrl(
                    ['index', 'returnUrl' => Helper::getReturnUrl()],
                    [
                        'parent_id' => 'id',
                    ]
                ),
                'contextMenuItems' => [
                    'show' => [
                        'label' => 'Показать продукты этой категории',
                        'icon' => 'fa fa-folder-open',
                        'action' => ContextMenuHelper::actionUrl(
                            ['index'],
                            [
                                'parent_id' => 'id',
                            ]
                        ),
                    ],
                    'createProduct' => [
                        'label' => 'Создать продукт в этой категории',
                        'icon' => 'fa fa-plus-circle',
                        'action' => ContextMenuHelper::actionUrl(
                            ['edit', 'returnUrl' => Helper::getReturnUrl()],
                            [
                                'parent_id' => 'id',
                            ]
                        ),
                    ],
                    'edit' => [
                        'label' => 'Edit category',
                        'icon' => 'fas fa-pen',
                        'action' => ContextMenuHelper::actionUrl(
                            ['/shop/backend-category/edit', 'returnUrl' => Helper::getReturnUrl()]
                        ),
                    ],
                    'create' => [
                        'label' => 'Создать категорию',
                        'icon' => 'fa fa-plus-circle',
                        'action' => ContextMenuHelper::actionUrl(
                            ['/shop/backend-category/edit', 'returnUrl' => Helper::getReturnUrl()],
                            [
                                'parent_id' => 'id',
                            ]
                        ),
                    ],
                    'delete' => [
                        'label' => 'Delete',
                        'icon' => 'fas fa-trash',
                        'action' => new \yii\web\JsExpression(
                            "function(node) {
                            jQuery('#delete-category-confirmation')
                                .attr('data-url', '/backend/category/delete?id=' + jQuery(node.reference[0]).data('id'))
                                .attr('data-items', '')
                                .modal('show');
                            return true;
                        }"
                        ),
                    ],
                ],
            ]
        );?>
    </div>
    <div class="col col-md-9" id="jstree-more">
        <?=DynaGrid::widget([

                'storage'=>DynaGrid::TYPE_COOKIE,
                'theme'=>'panel-danger',

                'options' => [
                    'id' => 'Product-grid',
                ],
                'columns' => [
                    [
                        'class' => \kartik\grid\CheckboxColumn::className(),
                        'options' => [
                            'width' => '10px',
                        ],
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'attribute' => 'id',
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'attribute' => 'name',
                    ],
                    [
                        'class'=>\kartik\grid\EditableColumn::className(),
                        'header' => 'Кол-во',
                        'contentOptions' => ['class' => 'kv-quantity-column'],
                        'value' => function($model){
                            if(!$model->quantity->in_warehouse){
                                \app\backend\widgets\WarehousesRemains::widget([
                                    'model' => $model,
                                ]);
                            }
                        },
                        'editableOptions' => function ($model) {
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
                        },
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'attribute' => 'optionsQuantity',
                    ],
                    [
                        'attribute' => 'brand',
                        'vAlign'=>'middle',
                        'width'=>'130px',
                        'value' =>function($model) {
                            if(isset($model->brand->name)){
                                return $model->brand->name;
                            }else{
                                return "Не указан";
                            }
                        },
                        'filter'=>ArrayHelper::map(
                            PropertyStaticValues::find()
                                ->where('property_id  = 7')
                                ->orderBy('name')
                                ->asArray()
                                ->all(), 'name', 'name'
                        ),
                        'filterType'=>GridView::FILTER_SELECT2,
                        'filterWidgetOptions'=>[
                            'pluginOptions'=>['allowClear'=>true, ],
                        ],
                        'filterInputOptions'=>[
                            'placeholder'=>'Все бренды'
                        ],
                        'format'=>'raw'
                    ],
                   /* [
                        'class' => \kartik\grid\EditableColumn::className(),
                        'attribute' => 'audit',
                        'editableOptions' => [
                            'data' => [
                                0 => Yii::t('app', 'Не точно'),
                                1 => Yii::t('app', 'OK'),
                            ],
                            'inputType' => 'dropDownList',
                            'placement' => 'left',
                            'formOptions' => [
                                'action' => 'update-editable',
                            ],
                        ],
                        'filter' => [
                            0 => Yii::t('app', 'Не точно'),
                            1 => Yii::t('app', 'OK'),
                        ],
                        'format' => 'raw',
                        'value' => function (Product $model) {
                            if ($model === null || $model->audit === null) {
                                return null;
                            }
                            if ($model->audit === 1) {
                                $label_class = 'label-success';
                                $value = 'OK';
                            } else {
                                $value = 'Не точно';
                                $label_class = 'label-warning';
                            }
                            return \yii\helpers\Html::tag(
                                'span',
                                Yii::t('app', $value),
                                ['class' => "label $label_class"]
                            );
                        },
                    ],*/
                    [
                        'class' => \kartik\grid\EditableColumn::className(),
                        'attribute' => 'new',
                        'editableOptions' => [
                            'data' => [
                                0 => Yii::t('app', 'Не нов'),
                                1 => Yii::t('app', 'Новый'),
                            ],
                            'inputType' => 'dropDownList',
                            'placement' => 'left',
                            'formOptions' => [
                                'action' => 'update-editable',
                            ],
                        ],
                        'filter' => [
                            0 => Yii::t('app', 'Не нов'),
                            1 => Yii::t('app', 'Новый'),
                        ],
                        'format' => 'raw',
                        'value' => function (Product $model) {
                            if ($model === null || $model->new === null) {
                                return null;
                            }
                            if ($model->new === 1) {
                                $label_class = 'text-bg-success';
                                $value = 'Новый';
                            } else {
                                $value = 'Не нов';
                                $label_class = 'text-bg-warning';
                            }
                            return \yii\helpers\Html::tag(
                                'span',
                                Yii::t('app', $value),
                                ['class' => "badge $label_class"]
                            );
                        },
                    ],
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
                                $label_class = 'text-bg-success';
                                $value = 'Active';
                                $model ->afterActive();
                            } else {
                                $value = 'Inactive';
                                $label_class = 'text-bg-secondary';
                                $model ->afterInActive();
                            }
                            return \yii\helpers\Html::tag(
                                'span',
                                Yii::t('app', $value),
                                ['class' => "badge $label_class"]
                            );
                        },
                    ],
                    [
                        'class' => 'kartik\grid\EditableColumn',
                        'attribute' => 'price',
                        'editableOptions' => [
                            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                            'formOptions' => [
                                'action' => 'update-editable',
                            ],
                        ],
                         'value' =>function($model) {

                                $model ->priceChange();

                        },
                    ],
                    'date_modified',
                    [
                        'class' => 'app\backend\components\ActionColumn',
                        'buttons' => [
                            [
                                'url' => '@product',
                                'icon' => 'eye',
                                'class' => 'btn btn-info',
                                'label' => Yii::t('app', 'Preview'),
                                'appendReturnUrl' => false,
                                'url_append' => '',
                                'attrs' => ['model', 'mainCategory.category_group_id'],
                                'keyParam' => null,
                            ],
                            [
                                'url' => 'edit',
                                'icon' => 'pen',
                                'class' => 'btn btn-primary',
                                'label' => Yii::t('app', 'Edit'),
                            ],
                           /* [
                                'url' => 'clone',
                                'icon' => 'copy',
                                'class' => 'btn-success',
                                'label' => Yii::t('app', 'Clone'),
                            ],*/
                            [
                                'url' => 'delete',
                                'icon' => 'trash',
                                'class' => 'btn-danger',
                                'label' => Yii::t('app', 'Delete'),
                                'options' => [
                                    'data-action' => 'delete',
                                ],
                            ],
                        ],
                    ],
                ],
                'theme' => 'panel-default',
                'gridOptions' => [
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'hover' => true,
                    'panel' => [
                        'heading' => '<h3 class="panel-title">' . $this->title . '</h3>',
                        'after' => $this->blocks['add-button'],
                    ],
                ]
            ]
        );?>
    </div>

</div>