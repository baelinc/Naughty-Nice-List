<?php
// Ensure no PHP errors are displayed as HTML
ini_set('display_errors', 0); // Turn off error reporting
header('Content-Type: application/json');

// Path to the JSON file
$jsonFilePath = '/path/to/your/naughty-nice-list.json';

// Check if the file exists
if (file_exists($jsonFilePath)) {
    $data = json_decode(file_get_contents($jsonFilePath), true);

    if ($data && isset($data['naughty']) && isset($data['nice'])) {
        $response = [
            'naughty' => array_slice($data['naughty'], 0, 5), // Limit to last 5
            'nice' => array_slice($data['nice'], 0, 5) // Limit to last 5
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Data format error']);
    }
} else {
    echo json_encode(['error' => 'JSON file not found']);
}
?>
