<?php
// Define the settings file path
$settingsFile = __DIR__ . '/settings.json';

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate and save settings
if (isset($data['website_url']) && isset($data['poll_interval']) && isset($data['num_names'])) {
    $settings = [
        'website_url' => trim($data['website_url']),
        'poll_interval' => intval($data['poll_interval']),
        'num_names' => intval($data['num_names'])
    ];

    // Save the settings to the settings.json file
    if (file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT))) {
        echo 'Settings saved successfully.';
    } else {
        echo 'Error saving settings.';
    }
} else {
    echo 'Invalid settings data.';
}
?>
