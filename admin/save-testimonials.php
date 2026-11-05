<?php
declare(strict_types=1);
require __DIR__.'/bootstrap.php';admin_require_login();
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: dashboard.php#testimonial-editor');exit;}
try{
 admin_verify_csrf();
 $names=$_POST['reviewer_name']??[];$reviews=$_POST['review_text']??[];$trips=$_POST['trip_label']??[];$ids=$_POST['id']??[];
 if(!is_array($names)||!is_array($reviews)||!is_array($trips)||!is_array($ids))throw new RuntimeException('Invalid testimonial data.');
 $count=count($names);
 if($count>5)throw new RuntimeException('You can save a maximum of 5 testimonials.');
 if(count($reviews)!==$count||count($trips)!==$count||count($ids)!==$count)throw new RuntimeException('Please complete each testimonial row.');
 $pdo=admin_db();$pdo->beginTransaction();$pdo->exec('DELETE FROM blog_testimonials');
 $stmt=$pdo->prepare('INSERT INTO blog_testimonials (reviewer_name,review_text,trip_label,sort_order) VALUES (?,?,?,?)');
 for($i=0;$i<$count;$i++){
  $name=trim((string)$names[$i]);$review=trim((string)$reviews[$i]);$trip=trim((string)$trips[$i]);
  if($name===''||$review==='')throw new RuntimeException('Every testimonial needs a customer name and review text.');
  if(mb_strlen($name)>100||mb_strlen($review)>1200||mb_strlen($trip)>160)throw new RuntimeException('One or more testimonial fields exceed the allowed length.');
  $stmt->execute([$name,$review,$trip,$i+1]);
 }
 $pdo->commit();$_SESSION['admin_flash']='Testimonials saved successfully.';
}catch(Throwable $e){
 if(isset($pdo)&&$pdo instanceof PDO&&$pdo->inTransaction())$pdo->rollBack();
 error_log('Wintrip testimonial save: '.$e->getMessage());
 $_SESSION['admin_flash']=$e instanceof RuntimeException?$e->getMessage():'Could not save testimonials. Check that database/testimonials.sql has been imported.';
}
header('Location: dashboard.php#testimonial-editor');exit;
