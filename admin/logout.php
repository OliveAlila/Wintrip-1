<?php
require __DIR__.'/bootstrap.php';if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: index.php');exit;}admin_verify_csrf();$_SESSION=[];if(ini_get('session.use_cookies')){$p=session_get_cookie_params();setcookie(session_name(),'',time()-42000,$p['path'],$p['domain'],$p['secure'],$p['httponly']);}session_destroy();header('Location: index.php');exit;
