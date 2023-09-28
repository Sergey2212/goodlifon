
<?php

/**
 * @var $footer string
 * @var $groupModel \app\models\PropertyGroup
 * @var $this \yii\web\View
 * F:\OpenServer\domains\goodlifon\application\modules\shop\widgets\views\OptionGenerate.php
 */

use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\Url;

?>
<div class="jarviswidget">

    <header>
        <h2><?= Icon::show('sitemap') ?> <?= Yii::t('app', 'Generate Product Options') ?></h2>
    </header>

    <div>
        <!-- widget edit box -->
        <div class="jarviswidget-editbox">
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text" />
        </div>
        <!-- end widget edit box -->
        <!-- widget content -->
        <div class="widget-body">
            <?= $form->field($groupModel, 'id')->dropDownList($groups) ?>
            <?php
            foreach ($properties as $prop) :
                if ($prop->has_static_values == 0) {
                    continue;
                }
                $property_values = app\models\PropertyStaticValues::getValuesForPropertyId($prop->id); ?>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?=$prop->name?></label>

                    <div class="col-md-10">
                        <input type="text" id="myInput" class="myInput" onkeyup="searchProperty()" placeholder="Поиск по значению...">
                        <div class="scrollable-options-list myUL" id="myUL">
                            <?php foreach ($property_values as $property_value): ?>

                                <?=
                                Html::checkbox(
                                    'GeneratePropertyValue[' . $prop->id . '][' . $property_value['id'] . ']',
                                    $checked = '',
                                    ['label' => $property_value['name']]
                                )
                                ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
            <div class="clearfix"></div>
            <?= $footer ?>
        </div>
        <!-- end widget content -->
    </div>
    <!-- end widget div -->
</div><!-- end widget -->
<?php $this->beginBlock('optionsJs'); ?>
$('#propertygroup-id').change(function () {
$("[name=action]").val("save");
$(this).parents('form').submit();
});
$('#btn-generate').click(function () {
$.ajax({
'url': '<?= Url::toRoute(['generate', 'id' => $model->id]) ?>',
'method': 'POST',
'data': $('form').serialize()
}).done(function () {
location.reload();
});
return false;
});
$('.form-group').attr("autocomplete", "off");
<?php $this->endBlock(); ?>
<?php $this->registerJs($this->blocks['optionsJs'], \yii\web\View::POS_READY);?>


<script>

    function searchProperty() {
        var input, filter, ul, li, a, i, j;
        input = document.getElementById('myInput');
        var elems = document.getElementsByClassName('myInput');
        ul = document.getElementsByClassName("myUL");
        for (var i = 0; i < elems.length; i++) {
            filter = elems[i].value.toUpperCase();
            var reg = new RegExp( filter);
            li = ul[i].getElementsByTagName('label');

            for (j = 0; j < li.length; j++) {
                a = li[j];
                if ($(a).text().toUpperCase().search(reg) > -1) {
                    li[j].style.display = "";
                } else {
                    li[j].style.display = "none";
                }
            }
        }
    }
</script>