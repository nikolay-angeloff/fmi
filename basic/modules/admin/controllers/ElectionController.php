<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Election;
use app\models\UserSearch;
use app\models\Candidate;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ElectionController implements the CRUD actions for Election model.
 */
class ElectionController extends Controller
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
     * Lists all Election models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
	    		'query' => Election::find(),
	    ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Election model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	$searchModel = new UserSearch();
    	$searchModel->isCandidateList = true;
    	
    	$searchModel->candidatesQuery = $model->getUsers();
    	$searchModel->electionId = $id;
    	
        return $this->render('view', [
            'model' => $model, 
        	'searchModel' => $searchModel,
        	'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
        	'electionId' => $id,
        ]);
    }

    /**
     * Creates a new Election model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Election();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Election model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Election model.
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
     * Removes a candidate.
     * @param integer $userId
     * @param integer $electionId
     * @return mixed
     */
    public function actionRemoveCandidate($userId, $electionId) {
    	Candidate::findOne(['user_id' => $userId, 'election_id' => $electionId]	)->delete();
    	return $this->redirect(['view', 'id' => $model->id]);
    }
    
    /**
     * List of possible candidates.
     * @param integer $electionId
     * @return mixed
     */
    public function actionAddCandidateList($electionId) {
    	$model = $this->findModel($electionId);
    	$searchModel = new UserSearch();
    	
        return $this->render('view', [
            'model' => $model, 
        	'searchModel' => $searchModel,
        	'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
        ]);
    }

    /**
     * Finds the Election model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Election the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Election::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
   	
}
