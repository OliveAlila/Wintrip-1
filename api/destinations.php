<?php
declare(strict_types=1);
require __DIR__ . '/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET'); http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']); exit;
}
$requested = trim((string)($_GET['destination'] ?? $_GET['slug'] ?? ''));
if ($requested !== '') {
    $stmt = $pdo->prepare('SELECT name, slug, country, region, description, region_description, image_url, best_time, visitor_guidance, highlights FROM destinations WHERE is_active = 1 AND (slug = :slug OR name = :name) LIMIT 1');
    $stmt->execute(['slug' => $requested, 'name' => $requested]);
    $destination = $stmt->fetch();
    if (!$destination) { http_response_code(404); echo json_encode(['error' => 'Destination not found']); exit; }
    if (is_string($destination['highlights'])) {
        $destination['highlights'] = json_decode($destination['highlights'], true) ?: [];
    }
    echo json_encode(['destination' => $destination], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}
$stmt = $pdo->query('SELECT name, slug, country, region, description, region_description, image_url, best_time, visitor_guidance, highlights FROM destinations WHERE is_active = 1 ORDER BY sort_order, name');
$items = $stmt->fetchAll();
foreach ($items as &$item) {
    if (is_string($item['highlights'])) $item['highlights'] = json_decode($item['highlights'], true) ?: [];
}
unset($item);
echo json_encode(['destinations' => $items], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
