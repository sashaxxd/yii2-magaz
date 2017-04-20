<?php
/**
 * User: noutsasha
 * Date: 16.04.2017
 * Time: 18:53
 */

namespace app\models;


use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function tableName()//Указываем связь с таблицей в БД
    {
        return 'product';
    }

    public  function getCategory()
    {
        //Cвязь продуктов с категорией 1. указываем класс категории 2. Указываем связь
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

}