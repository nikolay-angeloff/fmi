<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Position;
use app\models\Group;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ElectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Добавяне на кандидати';
$this->params['breadcrumbs'][] = $this->title;
$this->params['electionId'] = $model->id;
?>
<div class="election-index">	

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
        		
            'first_name',
            'last_name',
            'email:email',
        	[
        		'attribute' => 'position0.title',
        		'value' => 'position0.title',
        		'filter' => Html::activeDropDownList($searchModel, 'position', ArrayHelper::map(Position::find()->asArray()->all(), 'id', 'title'),['class'=>'form-control','prompt' => 'Select Position']),
        	],
            [
        		'attribute' => 'group0.title',
        		'value' => 'group0.title',
        		'filter' => Html::activeDropDownList($searchModel, 'group', ArrayHelper::map(Group::find()->asArray()->all(), 'id', 'title'),['class'=>'form-control','prompt' => 'Select Group	']),
        	],
            'unique_id',

        	[
        		'class' => 'yii\grid\ActionColumn',
			    'template' => '{add}',
			    'buttons' => [
			          'add' => function ($url, $model, $id) {
			               return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, ['title' => Yii::t('app', 'Add Candidate')]);
			          },
				],
				'urlCreator' => function ($action, $model, $key, $index) {
					if ($action === 'add') {
						$url = Url::to(['/admin/election/add-candidate', 'userId' => $model->id, 'electionId' => $this->params['electionId']]);
						return $url;
					}	
				}
        	],
    	]	
    ]); ?>

</div>
