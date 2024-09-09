<?php
// Ensure no PHP errors are displayed as HTML
ini_set('display_errors', 0); // Turn off error reporting
header('Content-Type: application/json');

// Fetch the naughty and nice lists from the settings
$data = convertAndGetSettings('naughty-nice-list');

// Check if data is available and properly formatted
if ($data && isset($data['naughty']) && isset($data['nice'])) {
    $response = [
        'naughty' => array_slice($data['naughty'], 0, 5), // Limit to last 5
        'nice' => array_slice($data['nice'], 0, 5) // Limit to last 5
    ];
    echo json_encode($response);
} else {
    // Return an empty JSON response in case of an issue
    echo json_encode(['error' => 'Unable to retrieve lists']);
}
?>
