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
use yii\data\Pagination;


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
        //$products = Product::find()->where(['category_id' => $id])->all();
        $query = Product::find()->where(['category_id' => $id]);//Делаем выборку из базы
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3]);//Для пагинации новый объект
        //указываем количество записей
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();


        $category = Category::findOne($id);
        $this->setMeta('Название магазина | ' . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products','pages','category'));
    }


}