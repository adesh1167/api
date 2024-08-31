<?php
// Set CORS headers to allow requests from any origin (for development only, restrict in production)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests for CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

// Read JSON input from request body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate JSON input
if (json_last_error() !== JSON_ERROR_NONE || !isset($data['expoPushToken']) || !isset($data['message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON or missing fields']);
    exit;
}

// Extract data
$expoPushToken = $data['expoPushToken'];
$message = $data['message'];
$title = $data['title'];
$payload = $data['data'];

// Endpoint for Expo push notifications
$expoUrl = 'https://exp.host/--/api/v2/push/send';

// Prepare payload
$payload = [
    'to' => $expoPushToken,
    'sound' => 'default',
    'title' => $title,
    'body' => $message,
    'data' => $payload ? $payload : [],
];

// Initialize cURL
$ch = curl_init($expoUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

// Execute request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close cURL
curl_close($ch);

// Check response
if ($httpCode == 200) {
    echo json_encode(['status' => 'success', 'response' => json_decode($response, true)]);
} else {
    http_response_code($httpCode);
    echo json_encode(['status' => 'error', 'response' => json_decode($response, true)]);
}
?>
