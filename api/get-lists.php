<?php
// This endpoint returns the naughty and nice lists in JSON format
header('Content-Type: application/json');
$data = convertAndGetSettings('naughty-nice-list');

$response = [
    'naughty' => array_slice($data['naughty'], 0, 5), // Limit to last 5
    'nice' => array_slice($data['nice'], 0, 5) // Limit to last 5
];

echo json_encode($response);
?>
