<?php
declare(strict_types=1);
require __DIR__ . '/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { header('Allow: GET'); http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit; }
try {
 $rows=$pdo->query('SELECT image_key,image_url,alt_text FROM site_images')->fetchAll();
 $images=[];
 foreach($rows as $row){$images[$row['image_key']]=['url'=>$row['image_url'],'alt'=>$row['alt_text']??''];}
 echo json_encode(['images'=>$images],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
} catch(Throwable $e) {
 error_log('Wintrip site images: '.$e->getMessage());
 echo json_encode(['images'=>[]]);
}
