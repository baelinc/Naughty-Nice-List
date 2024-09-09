<?php
// Ensure this is loaded within the FPP context
if (!defined('FPP_PATH')) {
    exit;
}

// Define a function to create an empty config
function emptyConfig() {
    return [
        'website_url' => '',
        'poll_interval' => 30, // Default to 30 seconds
        'num_names' => 5 // Default to showing 5 names
    ];
}

// Function to read the settings from the JSON file
function getSettings($filename) {
    global $settings;

    $cfgFile = $settings['configDirectory'] . "/plugin.fpp-" . $filename . ".json";
    if (file_exists($cfgFile)) {
        $jsonData = file_get_contents($cfgFile);
        return json_decode($jsonData, true);
    }

    // If the file doesn't exist, return empty config
    return emptyConfig();
}

// Function to write the settings to the JSON file
function writeToJsonFile($filename, $data) {
    global $settings;

    $cfgFile = $settings['configDirectory'] . "/plugin.fpp-" . $filename . ".json";
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($cfgFile, $json_data);
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate and save settings
if (isset($data['website_url']) && isset($data['poll_interval']) && isset($data['num_names'])) {
    // Sanitize and prepare the settings
    $settingsData = [
        'website_url' => trim($data['website_url']),
        'poll_interval' => intval($data['poll_interval']),
        'num_names' => intval($data['num_names'])
    ];

    // Write the settings to the JSON file
    writeToJsonFile('naughty_nice_list', $settingsData);

    echo 'Settings saved successfully.';
} else {
    echo 'Invalid settings data.';
}
?>
