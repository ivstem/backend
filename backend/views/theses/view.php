<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Works */

$this->title = "ID: {$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'Роботи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="works-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Підтвертіть видалення?',
                'method' => 'post',
            ],
        ]) ?>
        <? $canCheck = $model->canCheck()? '+': '-' ?>
        <?= Html::a("Оновити текст перевірки ($canCheck)", ['getbody', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Перевірити', ['checkbyid', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Перевірити+', ['checkbyid', 'id' => $model->id, 'force' => true], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'npp',
            'subject',
            'group',
            'author',
            'curator',
            [
                'attribute' => 'doc',
                'format' => 'raw',
                'value' => function($m) {
                    return "<a href='/backend/theses/field?id={$m->id}&field=doc' class='btn btn-default'>Документ</a>";
                },
            ],
            [
                'attribute' => 'body',
                'format' => 'raw',
                'value' => function($m) {
                    return "<a href='/backend/theses/field?id={$m->id}&field=body' class='btn btn-default'>Підготовлений текст</a>";
                },
            ],
        ],
    ]) ?>
    
    <?= $this->render('_plagiat', [
        'model' => $model,
        'plagiat' => $plagiat,
    ]) ?>

</div>
