<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\Position;
use app\models\Group;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Election */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Elections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="election-view">

    <h1><?= Html::encode($model->name) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'start_date',
            'end_date',
            [     		
		    	'attribute' => 'is_active', 
            	'value' => $model->is_active == 1 ? 'Yes' : 'No'
		    ],
        ],
    ]) ?>
    
    <h2>Кандидати</h2>
    
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
			    'template' => '{delete}',
			    'buttons' => [
			          'delete' => function ($url, $model, $id) {
			               return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => Yii::t('app', 'Remove Candidate')]);
			          },
				],
				'urlCreator' => function ($action, $model, $key, $index) {
					if ($action === 'delete') {
						$url = Url::to(['/admin/election/remove-candidate', 'userId' => $model->id, 'electionId' => $this->title]);
						return $url;
					}	
				}
        	],
    	]	
    ]); ?>
    
    <p>
        <?= Html::a('Добави кандидати', ['add-candidate-list', 'electionId' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
