<?php
// Ensure this is loaded within the FPP context
if (!defined('FPP_PATH')) {
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate and save settings
if (isset($data['website_url']) && isset($data['poll_interval']) && isset($data['num_names'])) {
    $settings = [
        'website_url' => trim($data['website_url']),
        'poll_interval' => intval($data['poll_interval']),
        'num_names' => intval($data['num_names'])
    ];
    file_put_contents('plugins/naughty_nice_list/settings.json', json_encode($settings));
    echo 'Settings saved successfully.';
} else {
    echo 'Invalid settings data.';
}
