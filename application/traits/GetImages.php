<?php

namespace app\traits;

use app\modules\image\models\Image;

/**
 * Trait to create relation of images width object
 * Class GetImages
 * @package app\traits
 */
trait GetImages
{
    public function getImages()
    {
        /**
         * @var $object \app\models\BaseObject
         * @var $model \app\properties\HasProperties | \yii\db\ActiveRecord
         * @return \yii\db\ActiveQueryInterface
         */
        $model = $this;
        $object = $model->object;
        return $model->hasMany(Image::className(), ['object_model_id' => 'id'])->andWhere(
            ['object_id' => $object->id]
        )
            ->addOrderBy(
                [
                    'sort_order' => SORT_ASC,
                    'id' => SORT_ASC
                ]
            );
    }

    public  function getVal(){
        $model = $this;

        //$val = $model->name;  //   '1551-481 (Белый, 75C)'

        $strName= $model->name;
        preg_match( '!\(([^\)]+)\)!', $strName, $match );
        $arrName = explode(', ', $match[1] );
        $name = str_replace(['(', ','], ['', ''], $arrName);

        return $name[0];

    }


    public function getCartImage()
    {
        /**
         * @var $object \app\models\BaseObject
         * @var $model \app\properties\HasProperties | \yii\db\ActiveRecord
         * @return \yii\db\ActiveQueryInterface
         */
        $model = $this;
        $object = $model->object;

        $strName= $model->name;
        preg_match( '!\(([^\)]+)\)!', $strName, $match );
        $arrName = explode(', ', $match[0]);
        $color= str_replace(['(', ','], ['', ''], $arrName);

        $titles = Image::find()
            ->where(['object_model_id'  => $model->parent_id])
            ->asArray()
            ->all();

        $arrTitles = [];
        foreach ($titles as $title){
            $arrTitles[] = $title['image_title'];
        }

        if(array_search($color[0], $arrTitles)){
            return $model->hasMany(Image::className(), ['object_model_id' => 'parent_id'])
                ->andWhere([
                    'object_id' => $object->id,
                    'image_title' => $color[0]
                ])
                ->addOrderBy([
                    'sort_order' => SORT_ASC,
                    'id' => SORT_ASC
                ]);
        }else{
            return $model->hasMany(Image::className(), ['object_model_id' => 'parent_id'])
                ->andWhere([
                    'object_id' => $object->id,
                    //'image_title' => $color
                ])
                ->addOrderBy([
                    'sort_order' => SORT_ASC,
                    'id' => SORT_ASC
                ]);
        }

    }

}