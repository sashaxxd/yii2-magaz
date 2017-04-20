<?php
/**
 * User: noutsasha
 * Date: 19.04.2017
 * Time: 21:14
 */

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;


class CategoryController extends AppController
{
    public  function actionIndex()
    {
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('Название магазина');
        //Debug($hits);
        return $this->render('index', compact('hits'));
    }

    public  function actionView($id)
    {
        $id = Yii::$app->request->get('id');
        //Debug($id);
        $products = Product::find()->where(['category_id' => $id])->all();
        $category = Category::findOne($id);
        $this->setMeta('Название магазина | ' . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products','category'));
    }
    

}