<?php

namespace app\components;


use yii\base\Widget;
use app\models\Category;
use Yii;

class MenuWidget extends Widget //Свой виджет должен наследовать виджет Yii
{
    public  $tpl;
    public  $data; // Тут будет массив данных из таблицы категории
    public  $tree; // Тут будет вложенность категорий в катоегорию дерево
    public  $menuHtml;// Тут будет шаблон


    public  function  init()
    {
        parent::init();
        if($this->tpl === null)
        {
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';//Добавляем расширение файла(канкатенируем и прибавляем)

    }

    public  function  run()
    {
        // get cache возвращаем из кэша
        $menu = Yii::$app->cache->get('menu');

        if($menu) return $menu;


        $this->data = Category::find()->indexBy('id')->asArray()->all();// indexBy() функция для совпадения id c номерами массивов
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        //set cache формируем меню и записываем в кэш
        Yii::$app->cache->set('menu', $this->menuHtml, 60); //кэшируем на 1 минуту в папке runtime храниться кэш
        return $this->menuHtml;
    }
    protected function getTree(){
        $tree = [];
        foreach ($this->data as $id=>&$node) {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    protected function getMenuHtml($tree){
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category);
        }
        return $str;
    }

    protected function catToTemplate($category){
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }

}