<?php

$isProd = $_SERVER['SERVER_NAME'] == 'plagiat.kpi2day.com';//'nails.kpi2day.com'

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname='.($isProd? 'u473033786_plagi': 'c9'),
    'username' => $isProd? 'u473033786_plagi': 'slaawwa',
    'password' => $isProd? 'S8iOTBvfi7hY9jddA5': '',
    'charset' => 'utf8',
];
