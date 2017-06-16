<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Check */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Роботи перевірки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Перетворити в роботу', ['tothese', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Перевести?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'doc:ntext',
            'body:ntext',
            'created:datetime',
        ],
    ]) ?>

</div>
