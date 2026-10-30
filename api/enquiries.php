<?php
declare(strict_types=1);
require __DIR__ . '/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST'); http_response_code(405); echo json_encode(['error' => 'Method not allowed']); exit;
}
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) $input = $_POST;
$name = trim((string)($input['name'] ?? ''));
$email = trim((string)($input['email'] ?? ''));
$destination = trim((string)($input['destination'] ?? ''));
$travelDate = trim((string)($input['travel_date'] ?? $input['date'] ?? ''));
$message = trim((string)($input['message'] ?? ''));
if ($name === '' || strlen($name) > 160) { http_response_code(422); echo json_encode(['error' => 'Please enter your name.']); exit; }
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) { http_response_code(422); echo json_encode(['error' => 'Please enter a valid email address.']); exit; }
if ($message === '' || strlen($message) > 10000) { http_response_code(422); echo json_encode(['error' => 'Please tell us a little about your trip.']); exit; }
$dateValue = null;
if ($travelDate !== '') {
    $date = DateTime::createFromFormat('Y-m-d', $travelDate);
    if (!$date || $date->format('Y-m-d') !== $travelDate) { http_response_code(422); echo json_encode(['error' => 'Please provide a valid travel date.']); exit; }
    $dateValue = $travelDate;
}
$stmt = $pdo->prepare('INSERT INTO enquiries (name,email,destination,travel_date,message,status,created_at) VALUES (:name,:email,:destination,:travel_date,:message,\'new\',NOW())');
$stmt->execute(['name'=>$name,'email'=>$email,'destination'=>$destination !== '' ? $destination : null,'travel_date'=>$dateValue,'message'=>$message]);
echo json_encode(['ok'=>true,'message'=>'Thank you. Your enquiry has been received. Our team will be in touch.']);
