<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "product_move".
 *
 * @property string $id
 * @property int $product_id
 * @property int $warehouse_id
 * @property double $quantity
 * @property double $product_parent_id
 * @property string $time
 * @property int $row_id
 */
class ProductMove extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_move';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'warehouse_id', 'row_id'], 'integer'],
            [['quantity'], 'required'],
            [['quantity', 'total', 'product_parent_id'], 'number'],
            [['time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'warehouse_id' => 'Склад',
            'total' => 'Общее кол-во',
            'quantity' => 'Кол-во',
            'product_parent_id' => 'Родитель',
            'time' => 'Дата',
            'row_id' => 'Row ID',
        ];
    }

    public function getName()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

}
