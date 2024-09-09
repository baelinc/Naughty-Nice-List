<?php
// Ensure this is loaded within the FPP context
if (!defined('FPP_PATH')) {
    exit;
}

// Debug: Output path to check
error_log('Current directory: ' . __DIR__); // This will log the current directory to your server's error log

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate and save settings
if (isset($data['website_url']) && isset($data['poll_interval']) && isset($data['num_names'])) {
    // Sanitize and validate inputs
    $website_url = filter_var(trim($data['website_url']), FILTER_VALIDATE_URL);
    $poll_interval = intval($data['poll_interval']);
    $num_names = intval($data['num_names']);
    
    // Ensure valid values
    if ($website_url === false || $poll_interval <= 0 || $num_names < 1) {
        echo 'Invalid settings data.';
        exit;
    }
    
    $settings = [
        'website_url' => $website_url,
        'poll_interval' => $poll_interval,
        'num_names' => $num_names
    ];

    // Attempt to write settings to file
    $result = file_put_contents('/api/configfile/plugin.settings.json', json_encode($settings));
    
    if ($result === false) {
        echo 'Failed to save settings.';
    } else {
        echo 'Settings saved successfully.';
    }
} else {
    echo 'Invalid settings data.';
}
