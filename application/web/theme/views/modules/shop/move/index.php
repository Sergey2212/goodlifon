<?php

use miloschuman\highcharts\Highstock;
use yii\web\JsExpression;
use miloschuman\highcharts\SeriesDataHelper;
use miloschuman\highcharts\Highcharts;

//debug($model->unpackMove());
// стили подсказки css в application\web\theme\css\jscrollpane.css   142 -  160 строчки
$arrData=$model->unpackMove();

for($i=1; $i <= count($arrData); $i++)
{
    $forData[$i-1]['x'] =  strtotime($arrData[$i][count($arrData[$i])-1]['time'])*1000;
    $forData[$i-1]['y'] =  (float)$arrData[$i][count($arrData[$i])-1]['total'];
        for ($k=1, $j=0; $k <= count($arrData[$i]); $k++, $j++){
            $forData[$i-1]['players'][] = $arrData[$i][$j]['name'] ." : ". $arrData[$i][$j]['quantity'];
            sort($forData[$i-1]['players']);
        }
}


$this->registerAssetBundle('yii\web\YiiAsset');

echo Highstock::widget([
    'scripts' => [
        'modules/exporting',
    ],
    'setupOptions' => [
        'lang' => [
            'loading'=> 'Загрузка...',
            'months'=> ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            'weekdays'=> ["Воскресенье", "Понедельник", 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
            'shortMonths'=> ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек'],
            'exportButtonTitle'=> "Экспорт",
            'printButtonTitle'=> "Печать",
            'rangeSelectorFrom'=> 'С',
            'rangeSelectorTo'=> "По",
            'rangeSelectorZoom'=> "Период",
            'downloadPNG'=> 'Скачать PNG',
            'downloadJPEG'=> 'Скачать JPEG',
            'downloadPDF'=> 'Скачать PDF',
            'downloadSVG'=> 'Скачать SVG',
            'printChart'=> 'Напечатать график'
        ],
    ],
    'options' => [
        'chart'=>['height'=>'700px', 'type'=>'column'],
        'title' => ['text' => 'Движение товара - ' . $model->name],
        'subtitle'=> [
            'text'=> 'Карточка: <a href="http://goodlifon/catalog/'.$model->slug.'">'.$model->name.'</a>'
        ],
        'xAxis'=>[
            'type'=> 'date',
            'categories' => $arrData,
            'labels'=> [
                'rotation'=> -45,
                'style'=> [
                    'fontSize'=> '13px',
                    'fontFamily'=> 'Verdana, sans-serif'
                ]
            ]
        ],
        'yAxis'=> [
            'min'=> 0,
            'title'=> [
                'text'=> 'Количество (штук)'
            ]
        ],
        'legend'=> [
            'enabled'=> true
        ],
        'tooltip' => [
            'shared'=> true,
            'formatter' => new JsExpression('function() {
            var result = "<b>" + Highcharts.dateFormat("%e %b , %Y", this.x) + "</b>";
            $.each(this.points, function(i, datum) {
                result += "<br />" + datum.y + " Штук";
                $.each(datum.point.players, function() {
                    result += "<br/>" + this;
                });
            });
            return result;
        }')
        ],
        'series'=> [[
            'name'=> 'Количество',
            'data'=> $forData,
            'dataLabels'=> [
                'enabled'=> true,
                'rotation'=> -90,
                'color'=> '#FFFFFF',
                'align'=> 'right',
                'format'=> '{point.y}', // one decimal
                'style'=> [
                    'fontSize'=> '13px',
                    'fontFamily'=> 'Verdana, sans-serif'
                ]
            ]
        ]],
    ]
]);



