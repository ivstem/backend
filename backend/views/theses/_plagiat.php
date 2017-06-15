<?php

use yii\helpers\Html;
$empty = 0;
?>

<div class="plagiat-view">
    
    <h3>Результати перевірок:</h3>

    <div class="list-group">
        <? foreach ($plagiat as $p) { ?>
            <? 
                $pp = $p->info('full+');
                $model_ = $pp[$model->id == $pp['id1']? '_id2': '_id1'];
                $class_ =  $pp['average'] > 0.5
                    ? 'list-group-item-danger'
                    : ($pp['average'] > 0.1
                        ? 'list-group-item-warning'
                        : '');
            ?>
            <? if ($pp['percent']) {?>
                <a href="/backend/theses/<?=$model_->id?>" class="list-group-item <?=$class_?>">
                    <span class="badge"><?= $pp['percent'] ?>%</span>
                    <h4 class="list-group-item-heading">
                        <strong><?=$model_->id?></strong>)
                        <?= $model_->subject?>
                    </h4>
                    <p class="list-group-item-text">
                        Шингл 1: <strong><?= $pp['per'][0] ?></strong>%
                    </p>
                    <p class="list-group-item-text">
                        Шингл 2: <strong><?= $pp['per'][1] ?></strong>%
                    </p>
                    <p class="list-group-item-text">
                        Шингл 3: <strong><?= $pp['per'][2] ?></strong>%
                    </p>
                    <p class="list-group-item-text">
                        Шингл 4: <strong><?= $pp['per'][3] ?></strong>%
                    </p>
                </a>
            <? } else {
                $empty+=1;
            } ?>
        <? } ?>
        <li class="list-group-item disabled">
            <span class="badge"><?=$empty?></span>
            <h4 class="list-group-item-heading">Робіт з 0%:</h4>
        </li>
    </div>

</div>
