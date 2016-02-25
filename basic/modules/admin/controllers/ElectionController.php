<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Election;
use app\models\UserSearch;
use app\models\Candidate;
use app\models\Group;
use app\models\Voter;
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
       				'only' => ['index', 'view', 'create', 'update', 'delete', 
       						'add-candidate-list', 'add-candidate', 'remove-candidate',
       						'add-group-list', 'add-group', 'remove-group'],
       				'rules' => [
       						[
       								'allow' => true,
       								'actions' => ['index', 'view', 'create', 'update', 'delete', 
       										'add-candidate-list', 'add-candidate', 'remove-candidate', 
       										'add-group-list', 'add-group', 'remove-group'],
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
    	
    	$groupDataProvider = new ActiveDataProvider([
    			'query' => $model->getGroups(),
    	]);
    	
        return $this->render('view', [
            'model' => $model, 
        	'searchModel' => $searchModel,
        	'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
        	'groupDataProvider' => $groupDataProvider,
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
    	return $this->redirect(['view', 'id' => $electionId]);
    }
    
    /**
     * List of possible candidates.
     * @param integer $electionId
     * @return mixed
     */
    public function actionAddCandidateList($electionId) {
    	$model = $this->findModel($electionId);
    	$searchModel = new UserSearch();
    	
    	$users = $model->users;
    	
    	foreach ($users as $user) {
    		$userIds[] = $user->id;
    	}
    	
    	$searchModel->addCandidateFlag = true;
    	$searchModel->ids = $userIds;
    	
        return $this->render('add-candidate-list', [
            'model' => $model, 
        	'searchModel' => $searchModel,
        	'electionId' => $electionId,
        	'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
        ]);
    }
    
    /**
     * Adds a candidate.
     * @param integer $userId
     * @param integer $electionId
     * @return mixed
     */
    public function actionAddCandidate($userId, $electionId) {
    	$candidate = new Candidate();
    	$candidate->election_id = $electionId;
    	$candidate->user_id = $userId;
    	$candidate->save();
    	return $this->redirect(['add-candidate-list', 'electionId' => $electionId]);
    }
    
    /**
     * Removes a group.
     * @param integer $groupId
     * @param integer $electionId
     * @return mixed
     */
    public function actionRemoveGroup($groupId, $electionId) {
    	Voter::findOne(['group_id' => $groupId, 'election_id' => $electionId])->delete();
    	return $this->redirect(['view', 'id' => $electionId]);
    }
    
    /**
     * List of possible voters groups.
     * @param integer $electionId
     * @return mixed
     */
    public function actionAddGroupList($electionId) {
    	$model = $this->findModel($electionId);

    	$groups = $model->groups;
    	 
    	foreach ($groups as $group) {
    		$groupIds[] = $group->id;
    	}
    	
    	$dataProvider = new ActiveDataProvider([
    			'query' => Group::find()->where(['not in', 'id', $groupIds]),
    	]);
    	
    	return $this->render('add-group-list', [
    			'model' => $model,
    			'dataProvider' => $dataProvider,
    	]);
    }
    
    /**
     * Adds a group.
     * @param integer $groupId
     * @param integer $electionId
     * @return mixed
     */
    public function actionAddGroup($groupId, $electionId) {
    	$voter = new Voter();
    	$voter->election_id = $electionId;
    	$voter->group_id = $groupId;
    	$voter->save();
    	return $this->redirect(['add-group-list', 'electionId' => $electionId]);
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
