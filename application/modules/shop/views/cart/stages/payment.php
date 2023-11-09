<?php
/**
 * @var \yii\web\View $this
 * @var \yii\bootstrap5\ActiveForm $form
 * @var \app\modules\shop\models\PaymentType[] $paymentTypes
 * @var integer $totalPayment
 */






use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use \app\modules\user\models\RegistrationForm;

    $currency = \app\modules\shop\models\Currency::getMainCurrency();
    $model = new \app\modules\user\models\RegistrationForm;

?>
<div class="col mx-auto ">
    <div class="row">
        <div>К оплате: <?= $currency->format($totalPayment); ?></div>
        <?= \yii\bootstrap5\Html::dropDownList('PaymentType', null, array_reduce($paymentTypes,
            function($result, $item)
            {
                /** @var \app\modules\shop\models\PaymentType $item */
                $result[$item->id] = $item->name;
                return $result;
            }, []),
            [
                'class' => 'form-control',
            ]
        ); ?>

        <!-- <?= $form->field($model, 'сonvention')
            ->checkbox([
                'label' => 'Я принимаю условия '. Html::a('договора-оферты', ['/publichnaya-oferta'], ['class' => 'profile-link']) .'.',
                'labelOptions' => [
                    'style' => 'padding-left:20px;'
                ],
                ])?>

        <?= $form->field($model, 'reCaptcha')->widget(
            \himiklab\yii2\recaptcha\ReCaptcha3::className(),
            [
                'siteKey' => '6LfH-6cUAAAAAHRHB3XzICAgUcFXLzYEr1st5LjW', // unnecessary is reCaptcha component was set up
                'action' => 'homepage',
            ]
        ) ?> -->

    </div>