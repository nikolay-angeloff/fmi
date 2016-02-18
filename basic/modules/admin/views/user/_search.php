<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Group;
use app\models\Position;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php 
	    $groups = Group::find()->asArray()->all();
	    $groupMap = ArrayHelper::map($groups, 'id', 'title');
	    $positions = Position::find()->asArray()->all();
	    $positionMap = ArrayHelper::map($positions, 'id', 'title');
	    $form = ActiveForm::begin([
	        'action' => ['index'],
	        'method' => 'get',
	    ]); 
    ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'position') ?>
    
    <?= $form->field($model, 'group') ?>
    
    <?= $form->field($model, 'unique_id') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
