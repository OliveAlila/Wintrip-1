<?php
declare(strict_types=1);
require __DIR__ . '/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST'); http_response_code(405); echo json_encode(['error' => 'Method not allowed']); exit;
}
$input = json_decode(file_get_contents('php://input'), true);
$email = strtolower(trim((string)($input['email'] ?? $_POST['email'] ?? '')));
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) {
    http_response_code(422); echo json_encode(['error' => 'Please enter a valid email address.']); exit;
}
$stmt = $pdo->prepare('INSERT IGNORE INTO newsletter_subscribers (email,created_at) VALUES (:email,NOW())');
$stmt->execute(['email' => $email]);
if ($stmt->rowCount() === 0) {
    echo json_encode(['ok'=>true,'already_subscribed'=>true,'message'=>'You are already subscribed. Thanks for staying connected!']);
} else {
    echo json_encode(['ok'=>true,'already_subscribed'=>false,'message'=>'Thanks for subscribing! You are on the Wintrip travel list.']);
}
