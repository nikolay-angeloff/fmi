<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Election */

$this->title = 'Update Election: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Elections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="election-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
