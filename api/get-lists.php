<?php
// Turn off error display but log errors
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/your/error_log.log'); // Set this to your actual log file path

header('Content-Type: application/json');

// Fetch the naughty and nice lists from the settings
$data = convertAndGetSettings('naughty-nice-list');

// Check if data is available and properly formatted
if ($data && isset($data['naughty']) && isset($data['nice'])) {
    // Prepare the response data
    $response = [
        'naughty' => array_slice($data['naughty'], 0, 5), // Limit to last 5
        'nice' => array_slice($data['nice'], 0, 5) // Limit to last 5
    ];
    echo json_encode($response);
} else {
    // Return an error JSON response
    echo json_encode(['error' => 'Unable to retrieve lists']);
}
?>
