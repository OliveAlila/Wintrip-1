<?php
declare(strict_types=1);
require __DIR__ . '/db.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { header('Allow: GET'); http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit; }
try {
 $rows=$pdo->query('SELECT reviewer_name AS name,review_text AS text,trip_label AS trip FROM blog_testimonials ORDER BY sort_order,id LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);
 echo json_encode(['testimonials'=>$rows],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
} catch(Throwable $e) {
 error_log('Wintrip testimonials API: '.$e->getMessage());
 http_response_code(500); echo json_encode(['error'=>'Testimonials could not be loaded.']);
}
