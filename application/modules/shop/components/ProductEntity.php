<?php

namespace app\modules\shop\components;

use app\modules\shop\models\OrderItem;

class ProductEntity extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->model = $this->orderItem->product;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return !empty($this->orderItem->custom_name) || $this->model === null
            ? $this->orderItem->custom_name
            : $this->model->name;
    }
}
