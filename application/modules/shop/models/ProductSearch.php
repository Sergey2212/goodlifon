<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 18.10.2016
 * Time: 0:41
 */

namespace app\modules\shop\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\Product;

class ProductSearch extends Product
{
    public $quantity;
    public $brand;
   // public $size;
    //public $color;
    public $property;

    public function attributes()
    {
        // делаем поле зависимости доступным для поиска
        return array_merge(parent::attributes(), ['property']);
    }

    public function rules()
    {
        return [
            [['id', 'price'], 'integer'],
            [['name', 'brand'], 'string'],
            [['active', 'audit'], 'boolean',],
            [['active'], 'default', 'value' => true],
             [['audit'], 'default', 'value' => false],
            [['brand'], 'safe'],
        ];
    }

    /**
     * Search products
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /* @var $query \yii\db\ActiveQuery */
        $query = Product::find()->where(['parent_id' => 0])
            ->with('images', 'brand');

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
              //  'pagination' => false,
                'pagination' => [
                    'pageSize' =>20,
                ],
            ]
        );
        if (!($this->load($params))) {
            return $dataProvider;
        }
        $query->andFilterWhere(['product.id' => $this->id]);
        $query->andFilterWhere(['like', 'product.name', $this->name]);
        $query->andFilterWhere(['price' => $this->price]);
        $query->andFilterWhere(['quantity' => $this->quantity]);
        $query->andFilterWhere(['like', 'property_static_values.name', $this->brand]);
        $query->andFilterWhere(['audit' => $this->audit]);

        $query->joinWith('brand');
            $dataProvider->sort->attributes['brand'] = [
                'asc' => [ 'property_static_values.name' => SORT_ASC],
                'desc' => [ 'property_static_values.name' => SORT_DESC],
            ];


        return $dataProvider;
    }

}