<?php
/** @var app\components\WebView $this */
/** @var boolean $isInSidebar */
/** @var boolean $hideEmpty */
/** @var \app\modules\shop\models\FilterSets[] $filterSets */
/** @var boolean $displayHeader */
/** @var string $header  */
/** @var string $id */
use app\models\BaseObject;
use app\modules\shop\models\Product;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\Url;
?>
    <div class="filter-sets-widget<?= $isInSidebar ? ' sidebar-widget' : ''; ?>">

        <?php if (true === $displayHeader): ?>
            <div class="widget-header">
                <?= $header; ?>
            </div>
        <?php endif; ?>

        <div class="filters" id="<?= $id; ?>">
            <?php
            $urlParams = [
                '@category',
                'properties' => array_merge(Yii::$app->request->get('properties', []), Yii::$app->request->post('properties', [])),
                'last_category_id' => Yii::$app->request->get('last_category_id', 1),
            ];

            // Checked items
            $checkedIds = '';
            array_walk_recursive($urlParams['properties'],
                function ($v, $k) use (&$checkedIds)
                {
                    if (!is_array($v)) {
                        $checkedIds .= '#filter-check-' . $v . ',';
                    }
                });
            $checkedIds = rtrim($checkedIds, ',');

            if (!Yii::$app->request->isAjax) {
$_js = <<<JS
$('$checkedIds').prop('checked', true);
$('#$id').dotPlantSmartFilters();
JS;
                $this->registerJs($_js);
            }
            ?>
            <form action="<?= Url::toRoute(['@category', 'last_category_id' => $urlParams['last_category_id']]); ?>" method="post" class="filter-form">


                <!-- ---------------------------------------Блок выбранные фильтры -------------------------- -->
                <?php if ($checkedIds):?>
                    <div id="selected-filters">
                        <div class="selected-header">Вы выбрали</div>
                        <ul id="list-selected">

                        </ul>
                        <div id="clean"><button type="submit" id="button-reset" class="btn btn-outline-danger btn-sm">Очистить фильтры</button></div>

                    </div>

                <?php endif;?>
                <!-- ^^^^----------------------Блок выбранные фильтры -----------------^^^^ -->

                <?php
                $cacheParams = [
                    'duration' => 86400,
                    'dependency' => new \yii\caching\TagDependency([
                        'tags' => \devgroup\TagDependencyHelper\ActiveRecordHelper::getCommonTag(\app\modules\shop\models\FilterSets::className())
                    ])
                ];
                if ($this->beginCache('FilterSets:'.json_encode($urlParams).':'.(int) $hideEmpty, $cacheParams)) {
                    $_tplHtml = <<<'TPL'
<div class="filter-property">
    <div class="property-name">%s</div>
    <div class="scroll-pane">
        <ul class="property-values">
            %s
        </ul>
    </div>
</div>
TPL;
                    echo array_reduce($filterSets,
                        function ($result, $item) use ($urlParams, $_tplHtml)
                        {
                            /** @var \app\modules\shop\models\FilterSets $item */
                            $property = $item->getProperty();
                            if (!$property->has_static_values) {
                                return $result;
                            }
                            $selections = \app\models\PropertyStaticValues::getValuesForFilter(
                                $property->id,
                                $urlParams['last_category_id'],
                                $urlParams['properties']
                            );
                            if (empty($selections)) {
                                return $result;
                            }
                            $items = array_reduce($selections,
                                function ($r, $i) use ($urlParams, $property)
                                {
                                    /** @var \app\models\PropertyStaticValues $i */
                                    $urlParams['properties'][$property->id] = [$i['id']];
                                    $r .= '<li>' . Html::checkbox('properties[' . $property->id . '][]',
                                            false,
                                            [
                                                'value' => $i['id'],
                                                'class' => 'filter-check filter-check-property-' . $property->id,
                                                'id' => 'filter-check-' . $i['id'],
                                                'data-property-id' => $property->id,
                                            ]
                                        ) . Html::a($i['name'],
                                            Url::toRoute($urlParams),
                                            [
                                                'class' => 'filter-link',
                                                'data-selection-id' => $i['id'],
                                                'data-property-id' => $property->id,
                                            ]
                                        ) . '</li>';
                                    return $r;
                                }, '');
                            $result .= sprintf($_tplHtml,
                                Html::encode($property->name),
                                $items
                            );
                            return $result;
                        }, '');
                    $this->endCache();
                }
                ?>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-secondary btn-filter-show btn-sm"><?= Yii::t('app', 'Show'); ?></button>
                </div>

                <?php
                if (Yii::$app->request->isAjax) {
                    echo '<script>
                    $("' . $checkedIds . '").prop("checked", true);


                    var valSelect = $("' . $checkedIds . '").siblings().clone().addClass(\'sel-prop-link\').prepend(\' <span class="bi bi-eye-slash-fill"></span>  \');

                    $("#list-selected").append(valSelect);
                    $(\'.sel-prop-link\').wrap(\'<li class="sel-prop-li"></li>\');
                    
                    
 $(function()
    {
        $(\'.scroll-pane\').jScrollPane(
            {
                showArrows: true,
                horizontalGutter: 30,
                verticalGutter: 30
            }
        );
    })   
 
                 </script>';
                }
                ?>
            </form>
            <div class="overlay"></div>
        </div>

    </div>


<?php

$my_js = <<<JS

$(document).on('click', '#button-reset', function() {
    $('.filter-form input[type=\'checkbox\']').prop("checked",false);
});
 


$(document).ready(function(){ //После перезагрузки выводит выбранные свойства                    
            var valSelect = $(' $checkedIds ').siblings().clone().addClass('sel-prop-link').prepend(' <span class="bi bi-eye-slash-fill"></span>  ');
            $("#list-selected").append(valSelect);
            $('.sel-prop-link').wrap('<li class="sel-prop-li"></li>');
});

 $(function()
    {
        $('.scroll-pane').jScrollPane(
            {
                showArrows: true,
                horizontalGutter: 30,
                verticalGutter: 30
            }
        );
    });

JS;
$this->registerJs($my_js);
//debug($checkedIds);
?>