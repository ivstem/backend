<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Плагіатор',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menu = [
        ['label' => 'Головна', 'url' => ['/site/index']]
    ];
    if (Yii::$app->user->isGuest) {
        $menu[] = ['label' => 'Вхід', 'url' => ['/site/login']];
        // ['label' => 'Роботи перевірки', 'url' => ['/check']],
        // ['label' => 'Контакт', 'url' => ['/site/contact']],
    } else {
        $menu[] = ['label' => 'Роботи студентів', 'url' => ['/theses']];
        $menu[] = ['label' => 'Роботи перевірки', 'url' => ['/check']];
        $menu[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Вийти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
        . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menu,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        
        <?php foreach (Yii::$app->session->getAllFlashes() as $key => $flash) { ?>
            <div class="alert alert-<?=$key?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <?=$flash?>
            </div>
        <? } ?>
        
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Плагіатор <?= date('Y') ?></p>

        <p class="pull-right">Розроблено студентом <a href="http://ivstem.kpi.ua" target="_blank">ІВСТЕМ</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
