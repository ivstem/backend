<?php

$isProd = $_SERVER['SERVER_NAME'] == 'plagiat.kpi2day.com';//'nails.kpi2day.com'

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname='.($isProd? 'mysql.hostinger.com.ua': 'c9'),
    'username' => $isProd? 'user.hostinger': 'slaawwa',
    'password' => $isProd? 'pass.hostinger': '',
    'charset' => 'utf8',
];
