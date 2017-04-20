<?php
/**
 * User: noutsasha
 * Date: 20.04.2017
 * Time: 18:35
 */

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController
{
    public  function actionView($id)
    {
        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);//Ленивая загрузка
        if(empty($product))
        {
            throw new \yii\web\HttpException(404, 'Нет такой страницы');
        }
       // $product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one();//Жадная загрузка
        $hits = Product::find()->where(['hit' => '1'])->limit(4)->all();
        $this->setMeta('Название магазина | ' . $category->name, $category->keywords, $category->description);
       return $this->render('view', compact('product', 'hits'));
    }

}