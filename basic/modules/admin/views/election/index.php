<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ElectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Elections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="election-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Election', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'start_date',
            'end_date',
            [     		
		    	'attribute' => 'is_active', 
            	'value' => function ($data) {
	                return $data->is_active == 1 ? 'Yes' : 'No'; 
	            },
		    ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
