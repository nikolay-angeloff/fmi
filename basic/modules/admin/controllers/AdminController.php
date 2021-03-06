<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
{
	public function beforeAction($action)
	{
		$this->layout = 'admin';
		return parent::beforeAction($action);
	}
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        	'access' => [
        			'class' => AccessControl::className(),
       				'only' => ['index', 'view', 'create', 'update', 'delete'],
       				'rules' => [
       						[
       								'allow' => true,
       								'actions' => ['index', 'view', 'create', 'update', 'delete'],
       								'roles' => ['@'],
       						],
       				],
        	],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Admin::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	public function actionCreate()
    {
        $model = new Admin();
		$model->update = false;
		if ($model->load(Yii::$app->request->post())) {
        	$model->password = md5($model->password);
        	$model->repeatpassword = md5($model->repeatpassword);
        	if($model->save()) {
            	return $this->redirect(['view', 'id' => $model->id]);
        	}
        	else {
        		return $this->render('update', [
        				'model' => $model,
        		]);
        	}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
	public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->update = true;
        $prevPassword = $model->password;
		$model->password = null;
        
        if ($model->load(Yii::$app->request->post())) {
        	if(!$model->password) {
	        	$model->password = md5($model->password);
	        	$model->repeatpassword = md5($model->repeatpassword);
        	}
        	else {
        		$model->password = $prevPassword;
        		$model->repeatpassword = $prevPassword;
        	}
        	if($model->save()) {
            	return $this->redirect(['view', 'id' => $model->id]);
        	}
        	else {
        		return $this->render('update', [
        				'model' => $model,
        		]);
        	}
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
