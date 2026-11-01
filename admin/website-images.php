<?php
require __DIR__.'/bootstrap.php'; admin_require_login();
function wi_image_url(string $fileField,string $urlField): string {
 $upload=$_FILES[$fileField]??null;
 if($upload && ($upload['error']??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_NO_FILE){
  if(($upload['error']??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_OK) throw new RuntimeException('Image upload failed. Check the file size and try again.');
  if((int)$upload['size']<1||(int)$upload['size']>5*1024*1024) throw new RuntimeException('Images must be 5 MB or smaller.');
  if(!is_uploaded_file($upload['tmp_name'])) throw new RuntimeException('Invalid image upload.');
  $info=@getimagesize($upload['tmp_name']); $mime=$info['mime']??''; $ext=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$mime]??null;
  if(!$ext) throw new RuntimeException('Use a JPG, PNG or WebP image.');
  $dir=dirname(__DIR__).'/uploads/website/'; if(!is_dir($dir)&&!mkdir($dir,0755,true)) throw new RuntimeException('Could not create uploads/website. Check folder permissions.');
  $name=bin2hex(random_bytes(16)).'.'.$ext; if(!move_uploaded_file($upload['tmp_name'],$dir.$name)) throw new RuntimeException('Could not save uploaded image.');
  return 'uploads/website/'.$name;
 }
 $url=trim((string)($_POST[$urlField]??''));
 if($url===''||preg_match('~^(?:javascript|data|file):~i',$url)) throw new RuntimeException('Choose an image file or enter an image URL/path.');
 if(preg_match('~^https?://~i',$url)){if(!filter_var($url,FILTER_VALIDATE_URL))throw new RuntimeException('Enter a valid HTTP/HTTPS image URL.');return $url;}
 if(str_starts_with($url,'/')||str_contains($url,'..')||!preg_match('~^[a-zA-Z0-9._/-]+$~',$url)) throw new RuntimeException('Use a site-relative path such as uploads/website/photo.jpg.');
 return ltrim($url,'/');
}
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: dashboard.php#homepage-images');exit;}
try{
 admin_verify_csrf(); $pdo=admin_db(); $action=$_POST['action']??'';
 if($action==='save_site'){
  $key=trim((string)($_POST['image_key']??''));$label=trim((string)($_POST['label']??''));$url=wi_image_url('image_file','image_url');$alt=trim((string)($_POST['alt_text']??''));
  if(!preg_match('/^[a-z0-9._-]{2,120}$/',$key)||$label==='')throw new RuntimeException('Invalid image section.');
  $s=$pdo->prepare('INSERT INTO site_images(image_key,label,image_url,alt_text) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE label=VALUES(label),image_url=VALUES(image_url),alt_text=VALUES(alt_text)');$s->execute([$key,$label,$url,$alt]);$_SESSION['admin_flash']='Website image saved.';
 } elseif($action==='save_destination_main'){
  $id=(int)($_POST['destination_id']??0);$url=wi_image_url('image_file','image_url');$s=$pdo->prepare('UPDATE destinations SET image_url=? WHERE id=?');$s->execute([$url,$id]);if(!$s->rowCount()){$q=$pdo->prepare('SELECT id FROM destinations WHERE id=?');$q->execute([$id]);if(!$q->fetch())throw new RuntimeException('Destination not found.');}$_SESSION['admin_flash']='Destination main image updated.';
 } elseif($action==='add_destination_image'){
  $id=(int)($_POST['destination_id']??0);$url=wi_image_url('image_file','image_url');$alt=trim((string)($_POST['alt_text']??''));$q=$pdo->prepare('SELECT COUNT(*) FROM destination_images WHERE destination_id=?');$q->execute([$id]);$count=(int)$q->fetchColumn();
  if($count>=9)throw new RuntimeException('This destination already has 10 images including its main image. Remove one before adding another.');
  $s=$pdo->prepare('INSERT INTO destination_images(destination_id,image_url,alt_text,sort_order) VALUES(?,?,?,?)');$s->execute([$id,$url,$alt,$count+1]);$_SESSION['admin_flash']='Destination gallery image added.';
 } elseif($action==='delete_destination_image'){
  $id=(int)($_POST['image_id']??0);$dest=(int)($_POST['destination_id']??0);$s=$pdo->prepare('DELETE FROM destination_images WHERE id=? AND destination_id=?');$s->execute([$id,$dest]);$_SESSION['admin_flash']='Destination gallery image removed.';
 } elseif($action==='move_destination_image'){
  $id=(int)($_POST['image_id']??0);$dest=(int)($_POST['destination_id']??0);$dir=($_POST['direction']??'up')==='down'?'down':'up';$q=$pdo->prepare('SELECT id,destination_id,sort_order FROM destination_images WHERE id=? AND destination_id=?');$q->execute([$id,$dest]);$row=$q->fetch();
  if($row){$op=$dir==='up'?'<':'>';$order=$dir==='up'?'DESC':'ASC';$n=$pdo->prepare("SELECT id,sort_order FROM destination_images WHERE destination_id=? AND sort_order $op ? ORDER BY sort_order $order,id $order LIMIT 1");$n->execute([$dest,$row['sort_order']]);$other=$n->fetch();if($other){$pdo->beginTransaction();$pdo->prepare('UPDATE destination_images SET sort_order=? WHERE id=?')->execute([$other['sort_order'],$row['id']]);$pdo->prepare('UPDATE destination_images SET sort_order=? WHERE id=?')->execute([$row['sort_order'],$other['id']]);$pdo->commit();}}
  $_SESSION['admin_flash']='Destination image order updated.';
 } else throw new RuntimeException('Unknown image-management action.');
} catch(Throwable $e){if(isset($pdo)&&$pdo instanceof PDO&&$pdo->inTransaction())$pdo->rollBack();error_log('Wintrip image manager: '.$e->getMessage());$_SESSION['admin_flash']='Could not save: '.$e->getMessage();}
$action=(string)($_POST['action']??''); $anchor=$action==='save_site'?'#homepage-images':'#destination-images'; $dest=(int)($_POST['destination_id']??0); $query=[]; if($dest)$query['destination_id']=$dest; if($action==='save_site'&&!empty($_POST['image_key']))$query['section']=(string)$_POST['image_key']; header('Location: dashboard.php'.($query?'?'.http_build_query($query):'').$anchor); exit;
