<?php
declare(strict_types=1);
require __DIR__ . '/db.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET'); http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']); exit;
}
try {
    $rows = $pdo->query('SELECT image_key, image_url, alt_text FROM site_images')->fetchAll(PDO::FETCH_ASSOC);
    $images = [];
    foreach ($rows as $row) {
        $images[$row['image_key']] = [
            'url' => trim((string)$row['image_url']),
            'alt' => (string)($row['alt_text'] ?? '')
        ];
    }
    echo json_encode(['images' => $images], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    error_log('Wintrip site images API: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Homepage image settings could not be loaded.', 'images' => []]);
}
