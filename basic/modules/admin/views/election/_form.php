<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Election */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="election-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::classname(), [
	    'dateFormat' => 'yyyy-MM-dd', 'options'=>['style'=>'width:250px;', 'class'=>'form-control']
	]) ?>

    <?= $form->field($model, 'end_date')->widget(\yii\jui\DatePicker::classname(), [
	    'dateFormat' => 'yyyy-MM-dd', 'options'=>['style'=>'width:250px;', 'class'=>'form-control']
	]) ?>

    <?= $form->field($model, 'is_active')->checkBox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
