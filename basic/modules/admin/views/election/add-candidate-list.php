<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ElectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Потребители';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="election-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Election', ['view'], ['class' => 'btn btn-success']) ?>
    </p>

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

</div>
