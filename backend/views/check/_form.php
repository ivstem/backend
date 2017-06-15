<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Check */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="check-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc')->textarea(['rows' => 6]) ?>

    <?/* $form->field($model, 'body')->textarea(['rows' => 6])*/ ?>

    <?/* $form->field($model, 'created')->textInput() */?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
