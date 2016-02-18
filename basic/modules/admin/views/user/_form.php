<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Group;
use app\models\Position;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php 
	    $groups = Group::find()->asArray()->all();
	    $groupMap = ArrayHelper::map($groups, 'id', 'title');
	    $positions = Position::find()->asArray()->all();
	    $positionMap = ArrayHelper::map($positions, 'id', 'title');
    	$form = ActiveForm::begin(); 
    ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->dropDownList($positionMap) ?>

    <?= $form->field($model, 'group')->dropDownList($groupMap) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
