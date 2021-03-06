<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CheckSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роботи перевірки';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(
    "$('.btn-edit').on('click', function() { 
        localStorage.edit = $(this).data('id');
        location.href = '/';
    });",
    View::POS_READY,
    'my-button-handler'
);
?>
<div class="check-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?/* Html::a('Створити роботи перевірки', ['/'], ['class' => 'btn btn-success'])*/ ?>
        <a class="btn btn-success" href="/">Створити роботи перевірки</a>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'doc',
                'format' => 'raw',
                'value' => function($m) {
                    return $m->getFirstWord();
                },
            ],
            [
                'attribute' => 'body',
                'format' => 'raw',
                'value' => function($m) {
                    return $m->getFirstWord($m->body);
                },
            ],
            'created:datetime',
            [
                'label' => 'Дії',
                'format' => 'raw',
                'value' => function($m) {
                    return "<button class='btn btn-default btn-edit' data-id='{$m->id}'>Клієнт</button>";
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
