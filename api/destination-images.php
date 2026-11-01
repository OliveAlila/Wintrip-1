<?php
declare(strict_types=1);
require __DIR__ . '/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { header('Allow: GET'); http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit; }
$slug=trim((string)($_GET['slug']??''));
if($slug===''){http_response_code(400);echo json_encode(['error'=>'Destination slug is required']);exit;}
$stmt=$pdo->prepare('SELECT id,image_url,name FROM destinations WHERE slug=? AND is_active=1 LIMIT 1');
$stmt->execute([$slug]);$destination=$stmt->fetch();
if(!$destination){http_response_code(404);echo json_encode(['error'=>'Destination not found']);exit;}
$images=[['image_url'=>$destination['image_url'],'alt_text'=>$destination['name'],'sort_order'=>0]];
$q=$pdo->prepare('SELECT image_url,alt_text,sort_order FROM destination_images WHERE destination_id=? ORDER BY sort_order,id LIMIT 9');
$q->execute([$destination['id']]);
foreach($q->fetchAll() as $image){$images[]=$image;}
echo json_encode(['images'=>$images],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
