<?php

switch ($_SERVER['SERVER_NAME']) {
    case 'sub1.site.com': {
        $dbName = 'sub1DBname';
        $dbUser = 'sub1DBuser';
        $dbPass = 'sub1DBpass';
    } break;
    case 'sub2.site.com': {
        $dbName = 'sub2DBname';
        $dbUser = 'sub2DBuser';
        $dbPass = 'sub2DBpass';
    } break;
    default: {
        $dbName = 'devDBname';
        $dbUser = 'devDBuser';
        $dbPass = 'devDBpass';
    }
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname='.$dbname,
    'username' => $dbUser,
    'password' => $dbPass,
    'charset' => 'utf8',
];
