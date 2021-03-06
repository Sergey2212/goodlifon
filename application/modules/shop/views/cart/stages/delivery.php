<?php
/**
 * @var \yii\web\View $this
 * @var \yii\bootstrap\ActiveForm $form
 * @var \app\modules\shop\models\DeliveryInformation $deliveryInformation
 * @var \app\modules\shop\models\OrderDeliveryInformation|\app\properties\HasProperties $orderDeliveryInformation
 * @var \app\properties\AbstractModel $abstractModel
 */

use app\properties\AbstractModel;

?>
<div class="col-md-6 mx-auto">
    <div class="row">
    <?= $form->field($deliveryInformation, 'country_id')->dropDownList(\app\components\Helper::getModelMap(\app\models\Country::className(), 'id', 'name')); ?>
    <?= $form->field($deliveryInformation, 'city_id')->dropDownList(\app\components\Helper::getModelMap(\app\models\City::className(), 'id', 'name')); ?>
    <?//= $form->field($deliveryInformation, 'zip_code'); ?>
    <?= $form->field($deliveryInformation, 'zip_code')->dropDownList(['400066' => '400066']); ?>
    <?//= $form->field($deliveryInformation, 'address')->textarea(); ?>
    <?= $form->field($deliveryInformation, 'address')->dropDownList(['ул. Порт-Саида д. 9' => 'ул. Порт-Саида д. 9']); ?>

    <?= $form->field($orderDeliveryInformation, 'shipping_option_id')
        ->dropDownList(\app\components\Helper::getModelMap(\app\modules\shop\models\ShippingOption::className(), 'id', 'name'))->label('Способ доставки'); ?>
    <?php
        $abstractModel = $orderDeliveryInformation->getAbstractModel();
        $abstractModel->setArrayMode(false);
        foreach ($abstractModel->attributes() as $attr) {
            echo $form->field($abstractModel, $attr);
        }
    ?>
    </div>
</div>