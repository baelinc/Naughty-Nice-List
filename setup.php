<?php
// Ensure no PHP errors are displayed as HTML
ini_set('display_errors', 0); // Turn off error reporting
header('Content-Type: text/html');

// Include necessary functions and settings
include $settings['pluginDirectory'] . "/fpp-naughty-nice-list/pluginUpdate.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data and save settings
    $client_id = $_POST['client_id'] ?? '';
    $client_secret = $_POST['client_secret'] ?? '';

    // Validate and save the settings
    if (!empty($client_id) && !empty($client_secret)) {
        $settings = [
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ];
        savePluginSettings('naughty-nice-list', $settings);
        $message = "Settings saved successfully!";
    } else {
        $message = "Please fill in all fields.";
    }
}

// Retrieve existing settings
$existingSettings = convertAndGetSettings('naughty-nice-list');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Plugin Setup</title>
    <link rel="stylesheet" href="/plugin.php?plugin=naughty-nice-list&file=css/setup.css&nopage=1">
</head>
<body>
    <h1>Setup Naughty or Nice List Plugin</h1>
    <?php if (isset($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="client_id">Client ID:</label>
        <input type="text" id="client_id" name="client_id" value="<?php echo htmlspecialchars($existingSettings['client_id'] ?? ''); ?>">
        <br><br>
        <label for="client_secret">Client Secret:</label>
        <input type="text" id="client_secret" name="client_secret" value="<?php echo htmlspecialchars($existingSettings['client_secret'] ?? ''); ?>">
        <br><br>
        <input type="submit" value="Save Settings">
    </form>
</body>
</html>
