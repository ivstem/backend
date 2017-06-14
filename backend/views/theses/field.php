<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Works */

$this->title = 'Field: ' . $field. ' - id:' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $field;
?>
<div class="works-update">

    <h1><?= Html::encode($this->title) ?></h1>

     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            "$field:ntext",
            // 'body:ntext',
        ],
    ]) ?>

</div>
