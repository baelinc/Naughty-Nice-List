<?php
// Ensure this is loaded within the FPP context
if (!defined('FPP_PATH')) {
    exit;
}

// Load plugin-specific scripts and styles
?>
<link rel="stylesheet" href="plugins/naughty_nice_list/css/style.css"/>
<script src="plugins/naughty_nice_list/js/script.js"></script>

<div class="container">
    <h1>Naughty Nice List Settings</h1>
    
    <!-- Tabs for navigation -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="nnl-general-settings-tab" data-bs-toggle="tab" href="#nnl-general-settings" role="tab" aria-controls="nnl-general-settings" aria-selected="true">General Settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="nnl-display-settings-tab" data-bs-toggle="tab" href="#nnl-display-settings" role="tab" aria-controls="nnl-display-settings" aria-selected="false">Display Settings</a>
        </li>
    </ul>
    
    <div class="tab-content mt-2">
        <!-- General Settings Tab -->
        <div class="tab-pane fade show active" id="nnl-general-settings" role="tabpanel" aria-labelledby="nnl-general-settings-tab">
            <form method="post" action="">
                <?php
                // Handle form submission
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Validate and save settings
                    $website_url = isset($_POST['nnl_website_url']) ? trim($_POST['nnl_website_url']) : '';
                    $poll_interval = isset($_POST['nnl_poll_interval']) ? intval($_POST['nnl_poll_interval']) : 30;
                    $num_names = isset($_POST['nnl_num_names']) ? intval($_POST['nnl_num_names']) : 5;

                    // Save settings to a file or database
                    // Example code to save settings to a file
                    $settings = [
                        'website_url' => $website_url,
                        'poll_interval' => $poll_interval,
                        'num_names' => $num_names,
                    ];
                    file_put_contents('plugins/naughty_nice_list/settings.json', json_encode($settings));

                    echo '<div class="alert alert-success">Settings saved successfully.</div>';
                }
                
                // Load existing settings
                $settings = json_decode(file_get_contents('plugins/naughty_nice_list/settings.json'), true);
                ?>
                
                <div class="form-group">
                    <label for="nnl_website_url">Website URL:</label>
                    <input type="text" class="form-control" id="nnl_website_url" name="nnl_website_url" value="<?php echo esc_attr($settings['website_url'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="nnl_poll_interval">Polling Interval:</label>
                    <select class="form-control" id="nnl_poll_interval" name="nnl_poll_interval">
                        <?php
                        $intervals = [5, 15, 25, 35, 45, 60, 120, 180];
                        foreach ($intervals as $interval) {
                            echo '<option value="' . $interval . '"' . selected($interval, $settings['poll_interval'] ?? 30, false) . '>' . $interval . ' seconds</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nnl_num_names">Number of Names to Display:</label>
                    <input type="number" class="form-control" id="nnl_num_names" name="nnl_num_names" value="<?php echo esc_attr($settings['num_names'] ?? 5); ?>" min="1" max="10">
                </div>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>

        <!-- Display Settings Tab -->
        <div class="tab-pane fade" id="nnl-display-settings" role="tabpanel" aria-labelledby="nnl-display-settings-tab">
            <h2>Display Settings</h2>
            <p>Here you can configure how the lists are displayed. (Additional settings can be added here.)</p>
            <!-- Add additional fields for display settings if needed -->
        </div>
    </div>
</div>
