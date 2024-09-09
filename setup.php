<?php
// setup.php
include $settings['pluginDirectory'] . "/fpp-naughty-nice-list/pluginUpdate.php";

$pluginName = 'naughty-nice-list';
$pluginJson = convertAndGetSettings($pluginName);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission here
    $clientId = $_POST['client_id'] ?? '';
    $clientSecret = $_POST['client_secret'] ?? '';

    // Save settings
    savePluginSettings($pluginName, [
        'client_id' => $clientId,
        'client_secret' => $clientSecret
    ]);

    echo '<p>Settings saved successfully!</p>';
}
?>

<form method="post">
    <label for="client_id">Client ID:</label>
    <input type="text" id="client_id" name="client_id" value="<?php echo htmlspecialchars($pluginJson['client_id'] ?? '', ENT_QUOTES); ?>" required>
    <br>
    <label for="client_secret">Client Secret:</label>
    <input type="text" id="client_secret" name="client_secret" value="<?php echo htmlspecialchars($pluginJson['client_secret'] ?? '', ENT_QUOTES); ?>" required>
    <br>
    <input type="submit" value="Save Settings">
</form>
