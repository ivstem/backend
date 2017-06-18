<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tex. сайт</title>
</head>
<body>
    <?php
        if ($GLOBALS['_isAdmin']) { ?>
            <nav>
                <a href="?cmd=home">HOME</a>
                <a href="?cmd=ls">LS</a>
                <a href="?cmd=up">UP</a>
                <a href="?cmd=down">Down</a>
                <a href="?cmd=down-all">Down all</a>
                <a href="?cmd=history">HISTORY</a>
                <a href="?cmd=logout">Logout</a>
            </nav>
            <?php
            $refresh = true;
            $_GET['cmd'] = isset($_GET['cmd'])? $_GET['cmd']: 'home';
            switch ($_GET['cmd']) {
                case 'history': {
                    $cmd = 'php ../yii migrate/history all '.$GLOBALS['_server'];
                    $content = "CMD: `$cmd`<br>".exec($cmd);
                    // location($content);
                    // header("Location: http://www.example.com/");
                    // header('Location: '.$_SERVER['PHP_SELF']);
                    // header('Location: '.$_SERVER['REQUEST_URI']);
                    // $content .= '<br>';
                    // var_dump($_SERVER);
                    // $content = $_SERVER['REQUEST_URI']."&mess=$content";
                } break;
                case 'down': {
                    // $content = exec('echo "yes" | \../yii migrate/down');
                    $cmd = 'echo "yes" | php ../yii migrate/down '.$GLOBALS['_server'];
                    $content = "CMD: `$cmd`<br>".exec($cmd);
                } break;
                case 'down-all': {
                    $cmd = 'echo "yes" | php ../yii migrate/down all '.$GLOBALS['_server'];
                    $content = "CMD: `$cmd`<br>".exec($cmd);
                } break;
                case 'up': {
                    $cmd = 'echo "yes" | php ../yii migrate/up '.$GLOBALS['_server'];
                    $content = "CMD: `$cmd`<br>".exec($cmd);
                } break;
                case 'ls': {
                    $cmd = 'ls -l';
                    $content = "CMD: `$cmd`<br>".system($cmd);
                } break;
                case 'logout': {
                    unset($_COOKIE['_debug']);
                    setcookie('_debug', null, -1, '/');
                    header('Location: '.$_SERVER['PHP_SELF']);
                    exit();
                } break;
                case 'home':
                default: {
                    // var_dump(shell_exec('cd .. && pwd'));
                    // var_dump(shell_exec('cd .. && ls -l && pwd'));
                    // var_dump(exec('echo "yes" | php ../yii migrate/down all'));
                    // var_dump(shell_exec('ls -l'));
                    $content = isset($_GET['mess'])? $_GET['mess']: $_SERVER['SERVER_NAME'];
                    $refresh = false;
                }
            }
            if ($refresh) {
                header('Location: '.$_SERVER['PHP_SELF']."?mess=$content");
                exit();
            }
            ?>
            <pre><?=$content?></pre>
            <?php
            
        } else {?>
        
            <input name="value" id="value">
            <button id="btn">GO!</button>
            <script>
                'use strict';
                (() => {
                    let site = {
                        el: {
                            btn     : document.getElementById('btn'),
                            value   : document.getElementById('value'),
                        },
                        createCookie: (name, value, days) => {
                            var expires = '';
                            if (days) {
                                var date = new Date();
                                date.setTime(date.getTime()+(days*24*60*60*1000));
                                expires = `; expires=${date.toGMTString()}`;
                            }
                            document.cookie = `${name}=${value}${expires}; path=/`;
                        },
                        setHandlers: () => {
                            
                            document.addEventListener('keydown', function(e) {
                                if (e.keyCode === 13) {
                                    site.el.btn.click();
                                }
                            }, false);
                            
                            site.el.btn.onclick = function() {
                                site.createCookie( site.el.value.value, 1, 7 );
                                location.reload();
                            }
                        },
                        init: () => {
                            site.setHandlers();
                        },
                    };
                    site.init();
                })();
            </script>
        <?php }
    ?>
</body>
</html>
