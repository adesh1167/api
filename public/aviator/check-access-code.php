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

$access_code = $_GET['access-code'];
$response = [
    'access-code' => $access_code,
    'access-code-from-input' => $data['access-code']
];

$access_codes = [
    'sporty0924880au2',
    'sporty09248o301c',
];

if(isset($access_code) && !empty($access_code)){
    if(in_array(strtolower($access_code), $access_codes)){
        $response['status'] = 'valid';
        $response['message'] = 'Access Code Valid. Server overload, try again';
    } else{
        $response['status'] = 'invalid';
        $response['error'] = 'Access Code Invalid';
    }
} else{
        $response['status'] = 'empty';
        $response['error'] = 'Enter a valid Access Code';
    
}

exit(json_encode($response));
