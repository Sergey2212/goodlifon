//Возвращает совпадение в массивах
function getMatchArray(arr1, arr2) {
    var arr3 = [];
    for (var i = 0; i < arr1.length; i++) {
        if(inArray(arr1[i], arr2)) {
            arr3.push(arr1[i]);
        }
    }
    return arr3;
}

//Сравнивает двухмерный и одномерный массивы
//Возвращает массив совпадений    arr1-двухмерный
function getMultiIntersection(arr1, arr2) {
    var arr3 = [];
    for(var i = 0; i < arr1.length; i++) {
        for (var j = 0; j < arr1[i].length; j++) {
            for (var k = 0; k < arr2.length; k++) {
                if (arr1[i][j] == arr2[k]) {
                    arr3.push(arr2[k]);
                }
            }
        }
    }
    return arr3;
}

//Сливает двухмерные массивы. Возвращает позиции подмассивов arr2
//в которых есть числа из arr1
function getIntersection(arr1, arr2) {
    var arr3 = [];
    for (var i = 0; i < arr1[0].length; i++) {
        for (var j = 0; j < arr2.length; j++) {
            if(inArray(arr1[0][i], arr2[j])) {
                arr3.push(j);
            }
        }

    }
    return arr3;
}

//Создает массив, используя один массив для ключей и другой для его значений
function array_combine( keys, values ) {
    var new_array = {}, keycount=keys.length, i;
    if( !keys || !values || keys.constructor !== Array || values.constructor !== Array ){
        return false;
    }
    if(keycount != values.length){
        return false;
    }
    for ( i=0; i < keycount; i++ ){
        new_array[keys[i]] = values[i];
    }
    return new_array;
}

// Есть ли число(value) в массиве
function inArray(value, arr) {
    for (var i = 0; i < arr.length; i++) {
        if(arr[i] == value) {
            return true;
        }
    }
    return false;
}

// Есть ли число(value) в двухмерном массиве
function inMultiArray(value, arr) {
    for (var j = 0; j < arr.length; j++) {
        for (var k = 0; k < arr[j].length; k++) {
            if(arr[j][k] == value) {
                return true;
            }
        }
    }
    return false;
}

//Преобразует строку в массив
function makeArrayFromString(str){
    var arr = [];
    var strSplit = str.split(',');
    arr.push(strSplit);
    return arr;
}

//Возвращает строку с числом которое есть в обоих массивах
function getStrMatchArray (arr1, arr2) {
    var str = getMatchArray(arr1, arr2).join('');
    return str;
}

    $('label.label-color').click(function(){
        $('label.label-color').removeClass('selected').addClass('not-selected');
        $(this).removeClass('not-selected').addClass('selected');
    });

$(function () { //Всплывающая подсказка на кнопках
    $("[data-toggle='tooltip']").tooltip();
});

var objColor = $(':input.input-color');
var arrColorProductId = [];//Массив ID продуктов по цветам
var strColId;
for (var i = 0; i < objColor.length; i++) {
    strColId =  objColor[i]['value'];
    var arrColId = strColId.split(',');
   var keys= arrColorProductId.push(arrColId);
}

var arrCountProduct = [];//Массив количеств продуктов по цветам
var strCount;
var values = [];
$('label.label-color').each(function(){
    strCount = $(this).attr('data-count');
    var arrCount = strCount.split(',');
    values =arrCountProduct.push(arrCount);
});

var objSize = $(':input.input-size');
var arrSizeProductId = [];//Массив ID продуктов по размерам
var strSzId;
for (var i = 0; i < objSize.length; i++) {
    strSzId =  objSize[i]['value'];
    var arrSzId = strSzId.split(',');
    arrSizeProductId.push(arrSzId);
}

$('label.label-size').click(function(){
    var dataSelect = $(this).attr('data-select');
    if (dataSelect == 1){
        $('label.label-size.selected-size').removeClass('selected-size').addClass('halh-selected');
        $('label.label-size.not-selected').removeClass('halh-selected not-size-selected');
        $(this).removeClass('halh-selected').addClass('selected-size');
    }else{
        $('label.label-size.selected-size').removeClass('selected-size').addClass('halh-selected');
        $('label.label-size.not-size-selected').removeClass('not-size-selected');
        $(this).addClass('not-size-selected');
    }
});


$("#add-to-cart").click(function() {
    if(!$(this).attr("disabled")) {
        var artName = $(this).attr('article');
        //alert(artName + '\nДобавлен в корзину');
        swal(artName , "Добавлен в корзину!", "success");
        setTimeout("endPart()", 750);
    }
});

function endPart()
{
    location.reload();
}

var sizeValue = []; //Массив значений у кнопок размеров
    $(".label-size").each(function () {
        sizeValue.push($(this).html());
    });

function setSizes(colorProdId, $arrCountProduct) {
    $('.btn-added-to-cart').removeClass('btn-added-to-cart').addClass('add-to-cart-disabled btn-add-to-cart').attr({'data-id': "", 'article': ""});
    //, 'disabled' : true
     $('.btn-add-to-cart').attr({'data-action'  : ""});
        //Получим данные обратно из localStorage в виде JSON:
        var jsonA = localStorage.getItem('obj');
        //Преобразуем их обратно в объект JavaScript:
         var arrJson = JSON.parse(jsonA);
    if (arrJson != null) {
        for (var i = 0; i < sizeValue.length; i++) {
            $('.label-size').html(function (index, value) {
                for (var j = 0; j < arrJson.length; j++) {
                    if (index == arrJson[j]) {
                        return value = sizeValue[arrJson[j]];
                    }
                }
            });
        }
    }

        var arr = getIntersection(makeArrayFromString(colorProdId), arrSizeProductId);
        $('label.label-size').removeClass('selected-size halh-selected not-size-selected').addClass('not-selected');
        var arr2 = [];
        $('.label-size').attr({'data-original-title': 'Нет в наличии Можно заказать', 'data-select': "0"});
        for (var i = 0; i < arr.length; i++) {
            $('.label-size').eq(arr[i]).removeClass('not-selected').addClass('halh-selected').attr({
                'data-original-title': 'Добавить в корзину',
                'data-select': "1"
            });
            arr2.push(arr[i]);
}
}


function setCount (sizeProdId, prodCount) {
    arrClassLabelSize = new Array(); //Массив классов у кнопок размеров
    $(".label-size").each(function () {
        arrClassLabelSize.push($(this).attr("class"));
    });
    var arColorFor = sizeProdId.split(','); //ID продуктов в кнопках Цвет
    var arCountProd = prodCount.split(','); //Массив количеств продуктов
    var arrProdAndCount = array_combine(arColorFor, arCountProd);//ID : count
    var arrSizeFor = []; //ID продуктов в кнопках Размер
    var arrAtrFor = [];
    $('.halh-selected').each(function (){
        var strAtrFor = ($(this).attr('id'));
        arrAtrFor =  strAtrFor.split(',');
        arrSizeFor.push(arrAtrFor);
    });
    $('.selected-size').each(function (){
        var strAtrFor = ($(this).attr('id'));
        arrAtrFor =  strAtrFor.split(',');
        arrSizeFor.push(arrAtrFor);
    });
    var mult = getMultiIntersection(arrSizeFor, arColorFor);
    for(var i = 0; i < mult.length; i++) {
        $('.halh-selected').html(function (index, value) {
            if (index == i) {
                        return value  + '('+ arrProdAndCount[mult[i]] + ')';
            }
        })
    }

    var keySize = Object.keys(arrClassLabelSize);

    arrSelClass = [];
    for(var i = 0; i < arrClassLabelSize.length; i++){
        if(arrClassLabelSize[i].indexOf('halh-selected') >0){
            arrSelClass.push(keySize[i]);
        }
    }
    //Сериализуем его в "arr": [1, 2, 3]}':
    var jsonA = JSON.stringify(arrSelClass);
    //Запишем в localStorage с ключом obj:
    localStorage.setItem('obj', jsonA);

    for(var i = 0; i < sizeValue.length; i++){
        var y = $('.label-size').eq(i).html();
        var lastWord = y.substring(y.lastIndexOf(" ") + 1);
        if (lastWord === '(0)') {
            $('label.label-size').eq(i).removeClass('selected-size halh-selected not-size-selected').addClass('not-selected');
            $('.label-size').eq(i).attr({'data-original-title': 'Нет в наличии Можно заказать', 'data-select': "0"});
        }
    }

}

function setColor (sizeProdId, nameSize, thisButton) {

    if (!$(thisButton).hasClass("not-selected") ) {
        var arSzProdId = sizeProdId.split(',');
        var strColProdId = $('div#colorButtons .selected').attr('id');
        var nameColor = $('div#colorButtons .selected').attr('data-name');
        if (strColProdId) {
            var arColProdId = strColProdId.split(',');
            var idProdCard = getStrMatchArray(arSzProdId, arColProdId);
            $('.btn-added-to-cart').attr({'data-id': idProdCard, 'article': nameColor +  nameSize});
            if (idProdCard) {
                $('.btn-add-to-cart').attr({'data-id': idProdCard, 'data-action': "add-to-cart", 'add-to-cart-disabled': false, 'article': nameColor +  nameSize}).removeClass('add-to-cart-disabled');
                $('.btn-add-to-cart').removeClass('btn-add-to-cart').addClass('btn-added-to-cart');
            } else {
                $('.btn-added-to-cart').attr({'data-id': ""}).removeClass('btn-added-to-cart').addClass('btn-add-to-cart');
                $('.btn-add-to-cart').attr({'data-action': "", 'data-id': ""}).addClass('add-to-cart-disabled').removeAttr('article');
            }
        }
    } else {
        $('.btn-added-to-cart').attr({'data-id': ""}).removeClass('btn-added-to-cart').addClass('btn-add-to-cart');
        $('.btn-add-to-cart').attr({'data-action': "", 'data-id': ""}).addClass('add-to-cart-disabled').removeAttr('article');
    }
}