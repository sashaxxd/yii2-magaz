<?php
/**
 * User: noutsasha
 * Date: 16.04.2017
 * Time: 18:45
 */

namespace app\models;


use yii\db\ActiveRecord;

class Category extends  ActiveRecord
{
    public static function tableName()//Указываем связь с таблицей в БД
    {
        return 'category';
    }

    public  function getProducts()
    {
        //Cвязь категорий с продукутами 1. указываем класс продуктов 2. Указываем связь
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

}