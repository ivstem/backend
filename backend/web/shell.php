<?php

    // error_reporting(0);
    /*or*/ error_reporting(E_ALL & ~E_NOTICE);// to show errors but not notices
    // ini_set('display_errors', 0); 
    
    $GLOBALS['_isAdmin'] = isset($_COOKIE['_debug']);
    
    switch ($_SERVER['SERVER_NAME']) {
        case 'plagiat.kpi2day.com': {
            $GLOBALS['_server'] = '-- preprod';
        } break;
        case 'plagiator.kpi2day.com': {
            $GLOBALS['_server'] = '-- prod';
        } break;
        default: {
            $GLOBALS['_server'] = '-- dev';
        }
    }

    include 'indexNew.php';
