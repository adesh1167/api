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
$response = [];

$access_codes = [
    'sporty0924880au2' => [
        'country' => 'Ghana',
        'bookie' => 'SportyBet',
    ],
    'sporty09248o301c' => [
        'country' => 'Ghana',
        'bookie' => 'SportyBet',
    ],
    'bet9ja101624ua2f0' => [
        'country' => 'Nigeria',
        'bookie' => 'Bet9ja',
    ]
];

if(isset($access_code) && !empty($access_code)){
    if(isset($access_codes[strtolower($access_code)])){
        $response['status'] = 'valid';
        $response['data'] = $access_codes[$access_code];
        $response['message'] = 'Access Code Valid. Redirecting';
    } else{
        $response['status'] = 'invalid';
        $response['error'] = 'Access Code Invalid';
    }
} else{
        $response['status'] = 'empty';
        $response['error'] = 'Enter a valid Access Code';
    
}

exit(json_encode($response));
