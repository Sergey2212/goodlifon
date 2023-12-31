<?php

namespace app\modules\installer\models;

use Yii;

class FinalStep extends \yii\base\Model
{
    public $serverName = 'localhost';
    public $serverPort = 80;
    public $cacheClass = 'yii\caching\FileCache';
    public $useMemcached = false;
    public $keyPrefix = 'dp2';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'serverName',
                    'serverPort',
                    'cacheClass',
                    'keyPrefix',
                ],
                'filter',
                'filter' => 'trim',
            ],
            [
                [
                    'serverName',
                    'cacheClass',
                ],
                'required',
            ],
            [
                [
                    'useMemcached',
                ],
                'filter',
                'filter' => 'boolval',
            ],
            [
                [
                    'useMemcached',
                ],
                'boolean'
            ],
            [
                [
                    'cacheClass',
                ],
                \app\validators\ClassnameValidator::className(),
            ],
        ];
    }
}