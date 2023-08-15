<?php


namespace app\web\theme\module\widgets\ExpandableSearch;
use app\modules\shop\models\Category;
use yii\helpers\Url;
use yii\base\Widget;

class ExpandableSearchWidget extends Widget
{
    //Выборка категорий каталога из базы данных
    protected $data;
    //Массив категорий каталога в виде дерева
    protected $tree;

    public $autocomplete = true;
    public $useFontAwesome = true;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->data = Category::find()
            ->select(['id', 'name'])
            ->where(['parent_id' => 1])
            ->asArray()
            ->all();
        $this->makeTree();
        return $this->render(
            'expandable-search',
            [
                'tree' => $this->tree,
                'autocomplete' => $this->autocomplete,
                'useFontAwesome' => $this->useFontAwesome,
            ]
        );
    }

    /**
     * Функция принимает на вход линейный массив элеменов
     *  и возвращает массив в виде дерева
     */
    protected function makeTree() {
        if (empty($this->data)) {
            return;
        }
        foreach ($this->data as $category) {
            $this->tree[] = ['label' => $category['name'],

                'url' => Url::toRoute(
                    [
                        '@category',
                        // 'category_group_id' => $category->category_group_id,
                        'last_category_id' => $category['id'],
                    ]
                )
          ];
        }
}

}