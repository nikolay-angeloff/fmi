<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\Position;
use app\models\Group;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
