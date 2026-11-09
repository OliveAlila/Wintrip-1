<?php
declare(strict_types=1);
require __DIR__ . '/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Allow: POST'); http_response_code(405); echo json_encode(['error' => 'Method not allowed']); exit; }
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) $input = $_POST;
$name = trim((string)($input['name'] ?? ''));
$email = trim((string)($input['email'] ?? ''));
$nationality = trim((string)($input['nationality'] ?? ''));
$tripType = trim((string)($input['trip_type'] ?? ''));
$travellers = trim((string)($input['travellers'] ?? ''));
$destination = trim((string)($input['destination'] ?? ''));
$travelFrom = trim((string)($input['travel_from'] ?? ''));
$travelTo = trim((string)($input['travel_to'] ?? ''));
$message = trim((string)($input['message'] ?? ''));
if ($name === '' || strlen($name) > 160) { http_response_code(422); echo json_encode(['error' => 'Please enter your name.']); exit; }
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) { http_response_code(422); echo json_encode(['error' => 'Please enter a valid email address.']); exit; }
if ($nationality === '' || strlen($nationality) > 100) { http_response_code(422); echo json_encode(['error' => 'Please enter your nationality.']); exit; }
if (strlen($tripType) > 40 || strlen($travellers) > 40) { http_response_code(422); echo json_encode(['error' => 'Please check your trip type and traveller details.']); exit; }
if ($message === '' || strlen($message) > 10000) { http_response_code(422); echo json_encode(['error' => 'Please tell us a little about your trip.']); exit; }
$validateDate = static function (string $value, string $label): ?string {
    if ($value === '') return null;
    $date = DateTime::createFromFormat('Y-m-d', $value);
    if (!$date || $date->format('Y-m-d') !== $value) { http_response_code(422); echo json_encode(['error' => 'Please provide a valid ' . $label . ' date.']); exit; }
    return $value;
};
$fromValue = $validateDate($travelFrom, 'travel-from');
$toValue = $validateDate($travelTo, 'travel-to');
if ($fromValue !== null && $toValue !== null && $toValue < $fromValue) { http_response_code(422); echo json_encode(['error' => 'Travel-to date cannot be earlier than travel-from date.']); exit; }
$stmt = $pdo->prepare("INSERT INTO enquiries (name,email,nationality,trip_type,destination,travel_from,travel_to,travellers,message,status,created_at) VALUES (:name,:email,:nationality,:trip_type,:destination,:travel_from,:travel_to,:travellers,:message,'new',NOW())");
$stmt->execute(['name'=>$name,'email'=>$email,'nationality'=>$nationality,'trip_type'=>$tripType !== '' ? $tripType : null,'destination'=>$destination !== '' ? $destination : null,'travel_from'=>$fromValue,'travel_to'=>$toValue,'travellers'=>$travellers !== '' ? $travellers : null,'message'=>$message]);
echo json_encode(['ok'=>true,'message'=>'Thank you. Your enquiry has been received. Our team will be in touch.']);
