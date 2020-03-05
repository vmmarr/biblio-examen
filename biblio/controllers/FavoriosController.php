<?php

namespace app\controllers;

use app\models\favoritosSearch;
use app\models\Usuarios;
use Yii;

class FavoriosController extends \yii\web\Controller
{
    public function actionIndex($id = null)
    {
        $searchModel = new favoritosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($id === null) {
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('error', 'Debe estar logueado.');
                return $this->redirect('site/login');
            } else {
                $model = Yii::$app->user->identity;
            }
        } else {
            
        }
    
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}