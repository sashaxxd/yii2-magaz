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

        $category = Category::findOne($id);
         if(empty($category))
         {
             throw new \yii\web\HttpException(404, 'Нет такой страницы');
         }

        //Debug($id);
        //$products = Product::find()->where(['category_id' => $id])->all();
        $query = Product::find()->where(['category_id' => $id]);//Делаем выборку из базы
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);//Для пагинации новый объект
        //указываем количество записей
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();



        $this->setMeta('Название магазина | ' . $products->name, $products->keywords, $products->description);
        return $this->render('view', compact('products','pages','category'));
    }


}