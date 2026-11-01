<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) {
 $secure=(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off');
 session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$secure,'httponly'=>true,'samesite'=>'Lax']);
 session_start();
}
function admin_db(): PDO {
 static $pdo=null; if($pdo instanceof PDO)return $pdo;
 $file=dirname(__DIR__).'/api/config.php';
 if(!is_file($file))throw new RuntimeException('Database configuration is missing. Configure api/config.php first.');
 $c=require $file;
 $pdo=new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4',$c['host'],$c['database']),$c['username'],$c['password'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
 return $pdo;
}
function admin_csrf(): string { if(empty($_SESSION['admin_csrf']))$_SESSION['admin_csrf']=bin2hex(random_bytes(32)); return $_SESSION['admin_csrf']; }
function admin_verify_csrf(): void { if(!hash_equals($_SESSION['admin_csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('Your session expired. Refresh the page and try again.');} }
function admin_require_login(): void { if(empty($_SESSION['admin_id'])){header('Location: index.php');exit;} }
function admin_h($v): string {return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function admin_redirect(string $message=''): void { if($message!=='')$_SESSION['admin_flash']=$message;header('Location: dashboard.php');exit; }
