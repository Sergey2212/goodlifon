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

class ProductOptionSearch extends Product
{

    public $quantity;

    public function rules()
    {
        return [
            [['id', 'price'], 'integer'],
            [['name',], 'string'],
            [['active',], 'boolean',],
            [['active'], 'default', 'value' => true],
            [['quantity'], 'safe'],

        ];
    }

    /**
     * Search products
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params, $model )
    {
        /* @var $query \yii\db\ActiveQuery */
        $query = Product::find()
            ->With(['quantity'])
            //->joinWith('remain')
            ->where(['parent_id' => $model->id])
            ->orderBy('name ASC');
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
              //  'pagination' => false,
                'pagination' => [
                    'pageSize' =>100,
                ],
            ]
        );

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'quantity',
            ]
        ]);

        if (!($this->load($params))) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'product.name', $this->name]);
        $query->andFilterWhere(['price' => $this->price]);


        return $dataProvider;
    }

}
