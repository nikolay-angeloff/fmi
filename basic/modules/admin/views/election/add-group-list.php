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

$this->title = 'Добавяне на групи избиратели';
$this->params['breadcrumbs'][] = $this->title;
$this->params['electionId'] = $model->id;
?>
<div class="election-index">	

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
        		
            'title',

        	[
        		'class' => 'yii\grid\ActionColumn',
			    'template' => '{add}',
			    'buttons' => [
			          'add' => function ($url, $model, $id) {
			               return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, ['title' => Yii::t('app', 'Add Group')]);
			          },
				],
				'urlCreator' => function ($action, $model, $key, $index) {
					if ($action === 'add') {
						$url = Url::to(['/admin/election/add-group', 'groupId' => $model->id, 'electionId' => $this->params['electionId']]);
						return $url;
					}	
				}
        	],
    	]	
    ]); ?>

</div>
