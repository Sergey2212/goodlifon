<?php

/**
 * @var $breadcrumbs array
 * @var $category_group_id integer
 * @var $model \app\modules\shop\models\Product
 * @var $object \app\models\BaseObject
 * @var $selected_category \app\modules\shop\models\Category
 * @var $selected_category_id integer
 * @var $selected_category_ids integer[]
 * @var $this yii\web\View
 * @var $values_by_property_id integer
 */

use app\modules\image\models\Image;
use app\modules\shop\models\Product;
use app\modules\image\widgets\ObjectImageWidget;
use kartik\helpers\Html;
use yii\helpers\Url;
use app\modules\shop\widgets\AddToWishlistWidget;

//foreach ($model->subcategoryTittle as $subcategory){
//    if ($subcategory['title_append'] !== 'Нижнее бельё' && $subcategory['title_append'] !== 'Чулочно-носочные' && $subcategory['title_append'] !== 'Трикотаж' && $subcategory['title_append'] !== 'Корректирующее бельё' && $subcategory['title_append'] !== 'Термо') {
//        $arrSubcategory[] = $subcategory['title_append'];
//    }
//}
//array_shift($arrSubcategory);
//$strCategory = implode('  ', $arrSubcategory);

$productName = $breadcrumbs[array_key_last($breadcrumbs)];

//$productCategory = (array_pop($model->subcategoryTittle)['title_append']);
$productCategory = $model->subcategoryTittle[0]['title_append'];

$this->title = $productCategory  .' '.  $model->brand->name  .' '.  $model->name  . ' купить в Волгограде. В интернет-магазине Гудлифон' ;

$textDescription =  $productCategory  .' '.  $model->brand->name  .' '.  $model->name  . ' купить в магазине нижнего белья Гудлифон. Имеющийся размер и цвет уточняйте на сайте или по телефону 8(961)691-58-94. Постоянным клиентам скидка';

$this->registerMetaTag([
    'name' => 'description',
    'content' => $textDescription,
], 'description');

$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $this->title
]);

$this->registerMetaTag([
    'property' => 'og:description',
    'content' => $textDescription
]);

$this->registerMetaTag([
    'property' => 'og:type',
    'content' => 'website'
]);

$this->registerMetaTag([
    'property' => 'og:url',
    'content' => "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']
]);

$this->registerMetaTag([
    'property' => 'og:image',
    'content' => "https://".$_SERVER['SERVER_NAME']. "/files/".$model->image->filename
]);

$this->registerMetaTag([
    'property' => 'og:site_name',
    'content' => 'Гудлифон-Магазин бюстгальтеров, купальников, колготок.'
]);


$this->params['breadcrumbs'] = $breadcrumbs;
$listView = isset($_COOKIE['listViewType']) && $_COOKIE['listViewType'] == 'listView';
$parentAnnounce = Product::find()
    ->select([
        'announce'
    ])
    ->where(['in', 'id', $model->parent_id]) 
    ->one();

$propertiesShowedInAnnounce = false;

?>
        <!--start product detail-->
        <section class="py-4">
            <div class="container">
                <div class="product-detail-card">
                    <div class="product-detail-body">
                        <div class="row g-0 product-show">
                            <div class="col-12 col-lg-5">
                                <?php if ($model->parent_id == 0): ?>
                                    <div class="product-images">
                                        <div class="first-image text-center">
                                            <?=
                                            ObjectImageWidget::widget(
                                                [
                                                    'limit' => 1,
                                                    'model' => $model,
                                                ]
                                            )
                                            ?>
                                        </div>
                                        <?php if (count($model->images)>1): ?>
                                            <div class="other-images">
                                                <?=
                                                ObjectImageWidget::widget(
                                                    [
                                                        'model' => $model,
                                                    ]
                                                )
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="product-images">
                                        <div class="first-image">
                                            <?=
                                            \app\modules\image\widgets\CartImageWidget::widget([
                                                'limit' => 1,
                                                'model' => $model,
                                            ])
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
            <div class="col-12 col-lg-7">
                                <h1 itemprop="name">
                                    <?=Html::encode($productCategory  . ' ' . $model->h1)?>
                                </h1>
                                <div class="row">
                <div class="col-md-12 col-lg-8">

                    <?php if ($model->parent_id == 0): ?>

                      <?php if (isset($model->optionsQuantity)): ?>
                        <div class="varieties">  <!-- Разновидности товара -->
                            <?php
                                echo \app\properties\PropertiesWidget::widget(
                                [
                                'model' => $model,
                                'viewFile' => 'show-announce-widget',
                                ]
                                );
                            ?>
                                <div id="opisanie" itemprop="description">
                                    <?php echo $this->blocks['announce'];?>
                                </div>
                            <div class="text-center" id="varieties-product">
                                <h3>Разновидности товара</h3>
                                <?php
                                echo app\web\theme\module\widgets\varieties\VarietiesWidget::widget(
                                    [
                                        'model' => $model,
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                            <?php else: ?>
                            <div class="varieties">  <!-- Разновидности товара -->
                             <h3>Характеристики товара</h3>
                                <?php
                                echo \app\properties\PropertiesWidget::widget(
                                [
                                'model' => $model,
                                'viewFile' => 'show-properties-widget',
                                ]
                                );
                             ?>
                                <p>Наличие нужного вам цвета или размера уточняйте </p>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="varieties">
                            <h3>Характеристики товара</h3>
                            <div itemprop="description">
                                <?php
                                    echo $parentAnnounce->announce;
                                    $propertiesShowedInAnnounce = true;
                                    echo \app\properties\PropertiesWidget::widget(
                                        [
                                            'model' => $model,
                                            'viewFile' => 'show-properties-widget',
                                        ]
                                    );
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>


                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="price-block">
                        <?php if ($model->price < $model->old_price): ?>
                            <div class="old">
                                <div class="price-name">
                                    <?= Yii::t('app', 'Old price:') ?>
                                </div>
                                <div class="price">
                                    <?=$model->nativeCurrencyPrice(true, false)?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="price-name">
                            <?= Yii::t('app', 'Price:') ?>
                            <div class="price">
                                <?=$model->nativeCurrencyPrice(false, true)?>
                            </div>
                        </div>

                        </div>
                        <div class="cta">

                        <a  class="btn btn-success btn-add-to-cart add-to-cart-disabled" id="add-to-cart"  data-action="add-to-cart" data-id = "<?= $model->id?>">
                            <?=Yii::t('app', 'Add to')?> корзину <i class="bi bi-cart-plus-fill"></i>
                        </a>

                       <br><br>
                        <a href='#' class="btn-add-to-wishlist" rel="nofollow" data-toggle="modal" data-target="#wishlist">
                           <?=Yii::t('app', 'Add to wishlist')?>
                        </a>
                        <?= AddToWishlistWidget::widget(['id' => $model->id]) ?>
                        <br><br>

                        <a href="/shop/cart" class="btn btn-success go-cart" role="button" >Перейти в корзину</a>

                        <br><br>
                        <!-- Button trigger modal -->
                        <button type="button" id="wearsize" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Таблицы размеров
                        </button>

                    </div>
                </div>
            </div>                         
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </section>
        <!--end product detail-->

    <!--start product more info-->
    <section class="py-4">
        <div class="container">
            <div class="product-more-info">
                <?php
                $tabs = [];
                if ($propertiesShowedInAnnounce === false) {
                    $tabs[] = [
                        'label' => Yii::t('app', 'Properties'),
                        'content' =>
                            \app\properties\PropertiesWidget::widget(
                                [
                                    'model' => $model,
                                    'viewFile' => 'show-properties-widget',
                                ]
                            ),
                        'active' => true,
                    ];
                }
                if (!empty($this->blocks['content'])) {
                    $tabs[] = [
                        'label' => Yii::t('app', 'Description'),
                        'content' => $this->blocks['content'],
                        'options' => [
                            'class' => 'description-tab'
                        ]
                    ];
                }
                $tabs[] = [
                    'label' => Yii::t('app', 'Reviews'),
                    'content' => \app\modules\review\widgets\ReviewsWidget::widget(
                        [
                            'model' => $model,
                            'formId' => 1,
                            'ratingGroupName' => 'First',
                            'additionalParams' => [
                                'model' => $model,
                            ],
                        ]
                    )
                ];
                ?>

                <?= \yii\bootstrap5\Tabs::widget([
                    'items' => $tabs,
                    'options' => [
                        'class' => 'product-tabs',
                    ]
                ]) ?>
            </div>
        </div>
    </section>
    <!--end product more info-->

    <!-- Modal  Таблица размеров-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">

                    <div class="box-content">
                        <h1>Таблицы размеров на разные категории одежды</h1>

                        <table class="wearsize" data-gender="female" data-type-wear="bust" data-trade-mark="">
                            <caption>Таблица размеров на бюстовую группу</caption>
                            <tbody><tr>
                                <th rowspan="3">Размер бюстгальтера</th>
                                <th>Россия</th>
                                <td>65</td>
                                <td>70</td>
                                <td>75</td>
                                <td>80</td>
                                <td>85</td>
                                <td>90</td>
                                <td>95</td>
                                <td>100</td>
                                <td>105</td>
                                <td>110</td>
                            </tr>
                            <tr>
                                <th>Франция</th>
                                <td>80</td>
                                <td>85</td>
                                <td>90</td>
                                <td>95</td>
                                <td>100</td>
                                <td>105</td>
                                <td>110</td>
                                <td>115</td>
                                <td>120</td>
                                <td>125</td>
                            </tr>
                            <tr>
                                <th>Италия</th>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                                <td>x</td>
                                <td>x</td>
                                <td>x</td>
                            </tr>
                            <tr>
                                <th colspan="2">Объем под грудью, см.</th>
                                <td>63-67</td>
                                <td>68-72</td>
                                <td>73-77</td>
                                <td>78-82</td>
                                <td>83-87</td>
                                <td>88-92</td>
                                <td>93-97</td>
                                <td>98-102</td>
                                <td>103-107</td>
                                <td>108-112</td>
                            </tr>
                            <tr>
                                <th colspan="2">Размер чашки</th>
                                <th colspan="8">Обхват груди, см.</th>
                            </tr>
                            <tr>
                                <td colspan="2">AA (11 см)</td>
                                <td>75-77</td>
                                <td>80-82</td>
                                <td>85-87</td>
                                <td>90-92</td>
                                <td>95-97</td>
                                <td>100-102</td>
                                <td>105-107</td>
                                <td>x</td>
                                <td>x</td>
                                <td>x</td>
                            </tr>
                            <tr>
                                <td colspan="2">A (13 см)</td>
                                <td>77-79</td>
                                <td>82-84</td>
                                <td>87-89</td>
                                <td>92-94</td>
                                <td>97-99</td>
                                <td>102-104</td>
                                <td>107-109</td>
                                <td>112-114</td>
                                <td>117-119</td>
                                <td>122-124</td>
                            </tr>
                            <tr>
                                <td colspan="2">B (15 см)</td>
                                <td>79-81</td>
                                <td>84-86</td>
                                <td>89-91</td>
                                <td>94-96</td>
                                <td>99-101</td>
                                <td>104-106</td>
                                <td>109-111</td>
                                <td>114-116</td>
                                <td>119-121</td>
                                <td>124-126</td>
                            </tr>
                            <tr>
                                <td colspan="2">C (17 см)</td>
                                <td>81-83</td>
                                <td>86-88</td>
                                <td>91-93</td>
                                <td>96-98</td>
                                <td>101-103</td>
                                <td>106-108</td>
                                <td>111-113</td>
                                <td>116-118</td>
                                <td>121-123</td>
                                <td>126-128</td>
                            </tr>
                            <tr>
                                <td colspan="2">D (19 см)</td>
                                <td>83-85</td>
                                <td>88-90</td>
                                <td>93-95</td>
                                <td>98-100</td>
                                <td>103-105</td>
                                <td>108-110</td>
                                <td>113-115</td>
                                <td>118-120</td>
                                <td>123-125</td>
                                <td>128-130</td>
                            </tr>
                            <tr>
                                <td colspan="2">E (21 см)</td>
                                <td>85-87</td>
                                <td>90-92</td>
                                <td>95-97</td>
                                <td>100-102</td>
                                <td>105-107</td>
                                <td>110-112</td>
                                <td>115-117</td>
                                <td>120-122</td>
                                <td>125-127</td>
                                <td>130-132</td>
                            </tr>
                            <tr>
                                <td colspan="2">F (23 см)</td>
                                <td>87-89</td>
                                <td>92-94</td>
                                <td>97-99</td>
                                <td>102-104</td>
                                <td>107-109</td>
                                <td>112-114</td>
                                <td>117-119</td>
                                <td>122-124</td>
                                <td>127-129</td>
                                <td>132-134</td>
                            </tr>
                            <tr>
                                <td colspan="2">G (25 см)</td>
                                <td>89-91</td>
                                <td>94-96</td>
                                <td>99-101</td>
                                <td>104-106</td>
                                <td>109-111</td>
                                <td>114-116</td>
                                <td>119-121</td>
                                <td>124-126</td>
                                <td>129-131</td>
                                <td>134-136</td>
                            </tr>
                            <tr>
                                <td colspan="2">H (27 см)</td>
                                <td>91-93</td>
                                <td>96-98</td>
                                <td>101-103</td>
                                <td>106-108</td>
                                <td>111-113</td>
                                <td>116-118</td>
                                <td>121-123</td>
                                <td>126-128</td>
                                <td>131-133</td>
                                <td>136-138</td>
                            </tr>
                            <tr>
                                <td colspan="2">I (29 см)</td>
                                <td>93-95</td>
                                <td>98-100</td>
                                <td>103-105</td>
                                <td>108-110</td>
                                <td>113-115</td>
                                <td>118-120</td>
                                <td>123-125</td>
                                <td>128-130</td>
                                <td>133-135</td>
                                <td>138-140</td>
                            </tr>
                            </tbody>
                        </table>

                        <table class="wearsize">
                            <caption>Таблица размеров на женскую одежду из трикотажа</caption>
                            <tbody><tr>
                                <th class="first">&nbsp;</th>
                                <th>XS</th>
                                <th>S</th>
                                <th>M</th>
                                <th>L</th>
                                <th>XL</th>
                                <th>2XL</th>
                                <th>3XL</th>
                                <th>4XL</th>
                            </tr>
                            <tr>
                                <th class="first">размер</th>
                                <td>42</td>
                                <td>44</td>
                                <td>46</td>
                                <td>48</td>
                                <td>50</td>
                                <td>52</td>
                                <td>54</td>
                                <td>56</td>
                            </tr>
                            <tr>
                                <th class="first">рост</th>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                            </tr>
                            <tr>
                                <th class="first">обхват груди</th>
                                <td>84</td>
                                <td>88</td>
                                <td>92</td>
                                <td>96</td>
                                <td>100</td>
                                <td>104</td>
                                <td>108</td>
                                <td>112</td>
                            </tr>
                            <tr>
                                <th class="first">обхват бёдер</th>
                                <td>90</td>
                                <td>94</td>
                                <td>98</td>
                                <td>102</td>
                                <td>106</td>
                                <td>110</td>
                                <td>114</td>
                                <td>118</td>
                            </tr>
                            </tbody></table>

                        <table class="wearsize">
                            <caption>Таблица размеров на купальники </caption>
                            <tbody><tr>
                                <th class="first">&nbsp;</th>
                                <th>XXS</th>
                                <th>XS</th>
                                <th>S</th>
                                <th>M</th>
                                <th>L</th>
                                <th>XL</th>
                                <th>2XL</th>
                            </tr>
                            <tr>
                                <th class="first">размер</th>
                                <th>40</th>
                                <th>42</th>
                                <th>44</th>
                                <th>46</th>
                                <th>48</th>
                                <th>50</th>
                                <th>52</th>
                            </tr>
                            <tr>
                                <th class="first">обхват груди</th>
                                <td>80</td>
                                <td>84</td>
                                <td>88</td>
                                <td>92</td>
                                <td>96</td>
                                <td>100</td>
                                <td>104</td>
                            </tr>
                            <tr>
                                <th class="first">обхват под грудью</th>
                                <td>65</td>
                                <td>70</td>
                                <td>75</td>
                                <td>80</td>
                                <td>85</td>
                                <td>90</td>
                                <td>95</td>
                            </tr>
                            <tr>
                                <th class="first">обхват бёдер</th>
                                <td>86</td>
                                <td>90</td>
                                <td>94</td>
                                <td>98</td>
                                <td>102</td>
                                <td>106</td>
                                <td>110</td>
                            </tr>
                            </tbody></table>

                        <table class="wearsize">
                            <caption>Таблица размеров на женскую одежду швейной группы</caption>
                            <tbody><tr>
                                <th class="first">&nbsp;</th>
                                <th>XS</th>
                                <th>S</th>
                                <th>M</th>
                                <th>L</th>
                                <th>XL</th>
                                <th>2XL</th>
                                <th>3XL</th>
                                <th>4XL</th>
                            </tr>

                            <tr>
                                <th class="first">размер</th>
                                <td>42</td>
                                <td>44</td>
                                <td>46</td>
                                <td>48</td>
                                <td>50</td>
                                <td>52</td>
                                <td>54</td>
                                <td>56</td>
                            </tr>
                            <tr>
                                <th class="first">рост</th>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                            </tr>
                            <tr>
                                <th class="first">обхват груди</th>
                                <td>84</td>
                                <td>88</td>
                                <td>92</td>
                                <td>96</td>
                                <td>100</td>
                                <td>104</td>
                                <td>108</td>
                                <td>112</td>
                            </tr>
                            <tr>
                                <th class="first">обхват бёдер</th>
                                <td>92</td>
                                <td>96</td>
                                <td>100</td>
                                <td>104</td>
                                <td>108</td>
                                <td>112</td>
                                <td>116</td>
                                <td>120</td>
                            </tr>
                            </tbody></table>
                        <table class="wearsize">
                            <caption>Таблица размеров на мужскую одежду из трикотажа</caption>
                            <tbody><tr>
                                <th class="first">&nbsp;</th>
                                <th>XS</th>
                                <th>S</th>
                                <th>M</th>
                                <th>L</th>
                                <th>XL</th>
                                <th>2XL</th>
                                <th>3XL</th>
                                <th>4XL</th>
                                <th>5XL</th>
                                <th>6XL</th>
                                <th>7XL</th>
                            </tr>
                            <tr>
                                <th class="first">размер</th>
                                <td>42</td>
                                <td>44</td>
                                <td>46</td>
                                <td>48</td>
                                <td>50</td>
                                <td>52</td>
                                <td>54</td>
                                <td>56</td>
                                <td>58</td>
                                <td>60</td>
                                <td>62</td>
                            </tr>
                            <tr>
                                <th class="first">рост</th>
                                <td>170</td>
                                <td>170</td>
                                <td>170</td>
                                <td>176</td>
                                <td>176</td>
                                <td>182</td>
                                <td>182</td>
                                <td>182</td>
                                <td>188</td>
                                <td>188</td>
                                <td>194</td>
                            </tr>
                            <tr>
                                <th class="first">обхват груди</th>
                                <td>84</td>
                                <td>88</td>
                                <td>92</td>
                                <td>96</td>
                                <td>100</td>
                                <td>104</td>
                                <td>108</td>
                                <td>112</td>
                                <td>116</td>
                                <td>120</td>
                                <td>124</td>
                            </tr>
                            <tr>
                                <th class="first">обхват талии</th>
                                <td>74</td>
                                <td>78</td>
                                <td>82</td>
                                <td>86</td>
                                <td>90</td>
                                <td>94</td>
                                <td>98</td>
                                <td>102</td>
                                <td>106</td>
                                <td>110</td>
                                <td>114</td>
                            </tr>
                            </tbody></table>

                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>            
            

            
<?php
app\slider\sliders\slick\SlickAsset::register($this);
$js = <<<JS

jQuery(function(){
     $('.first-image img').addClass('my-foto');
          if($(window).width()>=1170) {
            $(".my-foto").imagezoomsl({
              zoomrange: [2.12, 12],
              magnifiersize: [600, 430],
              scrollspeedanimate: 10,
              loopspeedanimate: 5,
              cursorshadeborder: "10px solid black",
              magnifiereffectanimate: "slideIn"
         });
        }
         if($(window).width()>=750 && $(window).width()<1170) {
              jQuery(function(){
                    $(".my-foto").imagezoomsl({
                      zoomrange: [2.12, 12],
                      magnifiersize: [430, 380],
                      scrollspeedanimate: 10,
                      loopspeedanimate: 5,
                      cursorshadeborder: "10px solid black",
                      magnifiereffectanimate: "slideIn"
                 });
              });
        }
             if($(window).width()<750) {
              jQuery(function(){
                  $(".my-foto").imagezoomsl({
                     zoomrange: [1, 12],
                     zoomstart: 4,
                     innerzoom: true,
                     magnifierborder: "none"
                  });
              });
        }
});

$('.other-images').slick({
    speed: 300,
    variableWidth: true,
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
    ]
});
$(".other-images").on('click', '.slick-slide', function(){
    var that = $(this),
        img = that.find('img');

    $(".first-image img").attr('src', img.attr('src'));

});

var countCart = $('#cart-count').html();

if(countCart > 0){
    $('.go-cart').removeClass('go-cart');
}


JS;
$this->registerJs($js);