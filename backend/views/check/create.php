<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Check */

$this->title = 'Create Check';
$this->params['breadcrumbs'][] = ['label' => 'Checks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
