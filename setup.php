<?php
include 'pluginUpdate.php'; // Include your update functions if necessary

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and save settings
    $clientId = $_POST['client_id'] ?? '';
    $clientSecret = $_POST['client_secret'] ?? '';

    // Save to settings file or database
    $settings = [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
    ];

    file_put_contents('settings.json', json_encode($settings));

    echo "<p>Settings saved successfully.</p>";
}

// Load current settings if available
$currentSettings = [];
if (file_exists('settings.json')) {
    $currentSettings = json_decode(file_get_contents('settings.json'), true);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Setup Naughty Nice List Plugin</title>
    <link rel="stylesheet" href="/path/to/your/style.css">
</head>
<body>
    <h1>Setup Naughty Nice List Plugin</h1>
    <form method="post" action="">
        <label for="client_id">Client ID:</label>
        <input type="text" id="client_id" name="client_id" value="<?php echo htmlspecialchars($currentSettings['client_id'] ?? ''); ?>" required>
        <br>
        <label for="client_secret">Client Secret:</label>
        <input type="text" id="client_secret" name="client_secret" value="<?php echo htmlspecialchars($currentSettings['client_secret'] ?? ''); ?>" required>
        <br>
        <input type="submit" value="Save Settings">
    </form>
</body>
</html>
