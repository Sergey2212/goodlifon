
<?php
use app\models\ObjectStaticValues;
use app\models\PropertyStaticValues;
use app\modules\shop\models\WarehouseProduct;
use app\modules\shop\models\Product;
use kartik\helpers\Html;
?>

<div id="pushbutton">

    <!--Вывод вариантов продукта-->
    <?php

    $parentsID= [];
    foreach ($model->options as $parentId) {
        $parentsID[] = $parentId->id;
    }

    //property_static_value_id   дочерних продуктов
    $valuesID = ObjectStaticValues::findAll([
        'object_model_id' => $parentsID
    ]);
    $valueID=[];
    foreach ($valuesID  as $valu ){
        $valueID[] = $valu->property_static_value_id.', ';
    }
    ?>


    <h3>Цвет</h3>
    <?php
    $color = PropertyStaticValues::find()
        ->where (['id' => $valueID, 'property_id' => 8])
        ->all();
    ?>
    <div id="colorButtons">
        <?php foreach ($color  as $value ):?>

            <?php
            //Номера ID продуктов по ID статического свойства продукта (размер, цвет)

            $propStatValId = $value->id;
            $productsId= PropertyStaticValues::find()
                ->where(['id' => $propStatValId])
                ->one();
            $productIds= $productsId->productsId;
            $productIdsID= [];
            foreach ($productIds as $productIds ){
                if (in_array($productIds->id, $parentsID)) {
                    $productIdsID [] = $productIds->id;
                }
            }


            //Получаем строку количеств товара определённого цвета
            $arrIdSortName = Product::find() //Массив id товаров отсортированный по названию
            ->select(['id'])
                ->where(['id' => $productIdsID])
                //->orderBy('name ASC')
                ->asArray()
                ->all();
            
            $i = count($arrIdSortName);
            $arrIdProducts=[];
            $j = 0;
            while ($j < $i) {
                array_push($arrIdProducts, $arrIdSortName[$j]['id']);
                $j++;
            }
            //Строка id товаров отсортированных по названию
            $strIdProducts = implode(",", $arrIdProducts);


            //Считает сколько продуктов определённого размера или цвета по ID размера или цвета
            $count = WarehouseProduct::find()
                ->select([
                    'warehouse_product.in_warehouse', // select all customer fields
                ])
                ->where(['in', 'product_id', $arrIdProducts])
                ->sum('[[in_warehouse]]');


            //Получаем строку количеств товара определённого цвета
            $arrInWarehouse = WarehouseProduct::find() //массив количеств товара по цвету
            ->select(['in_warehouse'])
                ->where(['product_id' => $arrIdProducts])
                ->orderBy('product_id ASC')
                ->asArray()
                ->all();
            $i = count($arrIdProducts);
            $InWarehouse=[];
            $j = 0;
            while ($j < $i) {
                array_push($InWarehouse, $arrInWarehouse[$j]['in_warehouse']);
                $j++;
            }
            $strInWarehouse = implode(",", $InWarehouse);//строка количеств

            //Строка ID продуктов определённого цвета
            $stringColorId = implode(",", $productIdsID );

            ?>
            <input type="radio"
                   name="option"
                   value="<?= $strIdProducts;?>"
                   class="none input-color"/>
            <!--<input type="radio"
                   name="option"
                   value="<?//= $strIdProducts;?>"
                   id="value"
                   class="none input-color"/>-->
            <label id="<?= $strIdProducts;?>"
                   data-toggle="tooltip"
                   data-trigger="hover"
                   data-count="<?= $strInWarehouse;?>"
                   data-name ="<?= $value->name?>"
                   title="<?= $value->name?>"
                   class="not-selected label-color"
                   onclick = "setSizes('<?=$strIdProducts?>'), setCount('<?=$strIdProducts?>', '<?=$strInWarehouse?>')" >
                <?= $value->name.' <b>(' .$count.')</b>'?>
            </label>
        <?php endforeach;?>
    </div>
    <br style="clear:both">


    <h3>Размер</h3>
    <?php
    $size = PropertyStaticValues::find()
        ->where (['id' => $valueID, 'property_id' => 9])
        ->orderBy('name')
        ->all();
    ?>


    <div id="sizeButtons">
        <?php foreach ($size as $value ):?>

            <?php
            //Номера ID продуктов по ID статического свойства продукта (размер, цвет)

            $propStatValId = $value->id;
            $productsId= PropertyStaticValues::find()
                ->where(['id' => $propStatValId])
                ->one();
            $productIds= $productsId->productsId;
            $productIdsID= [];
            foreach ($productIds as $productIds ){
                if (in_array($productIds->id, $parentsID)) {
                    $productIdsID [] = $productIds->id ;
                }
            }

            //Считает сколько продуктов определённого размера или цвета по ID размера или цвета
            $count = WarehouseProduct::find()
                ->select([
                    'warehouse_product.in_warehouse', // select all customer fields
                ])
                ->where(['in', 'product_id', $productIdsID])
                ->sum('[[in_warehouse]]');
            //echo $count;

            //Строка ID продуктов определённого размера
            $stringSizeId = implode(",", $productIdsID );

            ?>
            <input type="radio"
                   name="option"
                   value="<?= $stringSizeId?>"
                   class="none input-size"/>
            <!--<input type="radio"
                   name="option"
                   value="<?//= $stringSizeId?>"
                   id="value"
                   class="none input-size"/>-->
            <label id="<?= $stringSizeId?>"
                   data-toggle="tooltip"
                   data-trigger="hover"
                   data-select="1"
                   title="Выберите цвет"
                   class="not-selected label-size"
                   onclick = "setColor('<?=$stringSizeId?>', ' <?=$value->name?>', this)">
                <?= $value->name?>
            </label>
        <?php endforeach;?>
    </div>
    <br style="clear:both">

</div> <!-- /properties-widget -->

<?php


$js = <<<JS

//var objCount = $('label.label-color');





//console.log(arrColorProductId);
//console.log(arrCountProduct);
//console.log(arrSizeProductId);


JS;
$this->registerJs($js);