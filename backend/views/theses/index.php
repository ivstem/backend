<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WorksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роботи студентів';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="works-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Створити роботу', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Підготувати', ['getbodyall'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Перевірити', ['checkall'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Перевірити+', ['checkall', 'force' => true], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($m){
            if($m->canCheck()){
                return ['class' => 'success'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'npp',
            'subject',
            'author',
            'curator',
            'group',
            // 'doc:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
