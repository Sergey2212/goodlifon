<?php

namespace app\web\theme\module\widgets\varieties;

use app\modules\shop\models\Product;
use app\models\ObjectPropertyGroup;
use app\models\Property;
use app\models\PropertyGroup;
use app\models\PropertyStaticValues;
use devgroup\TagDependencyHelper\ActiveRecordHelper;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class PropertiesWidget
 * @property ActiveRecord $model
 * @property ActiveForm $form
 * @property Object $object
 * @property array $objectPropertyGroups
 * @property array $propertyGroupsToAdd
 * @property string $viewFile
 * @package app\properties
 */
class VarietiesWidget extends Widget
{
    private $objectPropertyGroups = [];
    public $form;
    public $model;
    public $viewFile = 'varieties-widget';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $cacheKey = 'PropertiesWidget: ' . get_class($this->model) . ':' . $this->model->id;
        $data = Yii::$app->cache->get($cacheKey);
        if ($data === false) {
            $this->objectPropertyGroups = ObjectPropertyGroup::getForModel($this->model);




            Yii::$app->cache->set(
                $cacheKey,
                [
                    'objectPropertyGroups' => $this->objectPropertyGroups,
                ],
                86400,
                new TagDependency(
                    [
                        'tags' => [
                            ActiveRecordHelper::getCommonTag(get_class($this->model)),
                            ActiveRecordHelper::getCommonTag(PropertyGroup::className()),
                            ActiveRecordHelper::getCommonTag(Property::className()),
                        ],
                    ]
                )
            );
        } else {
            $this->objectPropertyGroups = $data['objectPropertyGroups'];
        }
        return $this->render(
            $this->viewFile,
            [
                'model' => $this->model,
                'object_property_groups' => $this->objectPropertyGroups,
            ]
        );
    }


    public function nameStaticValues($valueID, $property_id){
        $valuesNames = PropertyStaticValues::find()
            ->where (['id' => $valueID, 'property_id' => $property_id])
            ->all();
        return $valuesNames;
    }

}

