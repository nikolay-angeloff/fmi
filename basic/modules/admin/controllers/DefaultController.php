<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\LoginForm;

class DefaultController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['login', 'logout', 'index'],
				'rules' => [
						[
							'allow' => true,
							'actions' => ['login'],
							'roles' => ['?'],
						],
						[
							'allow' => true,
							'actions' => ['index', 'logout'],
							'roles' => ['@'],
						],
				],
			],
		];
	}
	
	public function beforeAction($action)
	{
	    $this->layout = 'admin'; 
	    return parent::beforeAction($action);
	}
	
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionLogin()
    {
    	if (!\Yii::$app->user->isGuest) {
    		return $this->goHome();
    	}
    
    	$model = new LoginForm();
    	if ($model->load(Yii::$app->request->post()) && $model->login()) {
    		return $this->goBack();
    	}
    	return $this->render('login', [
    			'model' => $model,
    	]);
    }
    
    public function actionLogout()
    {
    	Yii::$app->user->logout();
    
    	return Yii::$app->getResponse()->redirect('index');
    }
}
