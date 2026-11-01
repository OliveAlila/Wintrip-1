<?php
declare(strict_types=1);
require __DIR__ . '/db.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { header('Allow: GET'); http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit; }
try {
    $row=$pdo->query('SELECT title_html, body_html FROM testimonials WHERE id=1')->fetch(PDO::FETCH_ASSOC);
    if (!$row) { http_response_code(404); echo json_encode(['error'=>'No saved testimonial']); exit; }
    echo json_encode($row, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    error_log('Wintrip testimonials API: '.$e->getMessage());
    http_response_code(500); echo json_encode(['error'=>'Testimonial content could not be loaded.']);
}
