<?php

/**
 * @var $attribute_name string
 * @var $form \yii\widgets\ActiveForm
 * @var $label string
 * @var $model \app\properties\AbstractModel
 * @var $multiple boolean
 * @var $property_id integer
 * @var $property_key string
 * @var $this \app\properties\handlers\Handler
 * @var $values array
 */

use app\models\Property;
use kartik\helpers\Html;

?>

    <?php
    if (count($values->values) == 0) {
        return;
    }
    ?>
<dl>
    <?php
    $property = Property::findById($property_id);
    $result = "";
    $valuesRendered = 0;
    foreach ($values->values as $val) {
        if (isset($val['value'])) {
            if ($valuesRendered === 0) {
                //$result .= '<meta itemprop="main" content="True"/>';
                $result .= '';
            }
            $valuesRendered++;
            $result .= Html::tag('dd', $val['value'], [
                'itemprop' => 'description',
            ]);
        }
    }
    if (!empty($result)) {
        echo Html::tag('dt', $property->name, ['itemprop'=>'name']) . $result;
    }
    ?>
</dl>