<?php
/**
 * Plugin Name: Naughty Nice List
 * Description: A plugin to display the Naughty and Nice lists with configurable options.
 * Version: 1.0
 * Author: Johnathan Evans
 */

// Enqueue scripts and styles
function nnl_enqueue_scripts() {
    wp_enqueue_script('nnl-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), null, true);
    wp_enqueue_style('nnl-style', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'nnl_enqueue_scripts');

// Add admin menu
function nnl_add_admin_menu() {
    add_options_page(
        'Naughty Nice List Settings',
        'Naughty Nice List',
        'manage_options',
        'naughty_nice_list',
        'nnl_settings_page'
    );
}
add_action('admin_menu', 'nnl_add_admin_menu');

// Settings page
function nnl_settings_page() {
    ?>
    <div class="wrap">
        <h1>Naughty Nice List Settings</h1>
        
        <!-- Include custom CSS and JS -->
        <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>css/custom-settings.css"/>
        <script src="<?php echo plugin_dir_url(__FILE__); ?>js/custom-settings.js"></script>

        <div class="row">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="nnl-general-settings-tab" data-bs-toggle="pill" href="#nnl-general-settings" role="tab" aria-controls="home" aria-selected="true">General Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="nnl-display-settings-tab" data-bs-toggle="pill" href="#nnl-display-settings" role="tab" aria-controls="profile" aria-selected="false">Display Settings</a>
                </li>
            </ul>
            <div class="tab-content mt-2">
                <div class="tab-pane fade show active" id="nnl-general-settings" role="tabpanel" aria-labelledby="nnl-general-settings-tab">
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('nnl_options_group');
                        do_settings_sections('naughty_nice_list');
                        submit_button();
                        ?>
                    </form>
                </div>
                <div class="tab-pane fade" id="nnl-display-settings" role="tabpanel" aria-labelledby="nnl-display-settings-tab">
                    <h2>Display Settings</h2>
                    <p>Here you can configure how the lists are displayed.</p>
                    <!-- Add additional settings fields for display configuration here -->
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Register settings
function nnl_register_settings() {
    register_setting('nnl_options_group', 'nnl_website_url');
    register_setting('nnl_options_group', 'nnl_poll_interval');
    register_setting('nnl_options_group', 'nnl_num_names');

    add_settings_section('nnl_settings_section', 'General Settings', null, 'naughty_nice_list');

    add_settings_field(
        'nnl_website_url',
        'Website URL',
        'nnl_website_url_callback',
        'naughty_nice_list',
        'nnl_settings_section'
    );

    add_settings_field(
        'nnl_poll_interval',
        'Polling Interval',
        'nnl_poll_interval_callback',
        'naughty_nice_list',
        'nnl_settings_section'
    );

    add_settings_field(
        'nnl_num_names',
        'Number of Names to Display',
        'nnl_num_names_callback',
        'naughty_nice_list',
        'nnl_settings_section'
    );
}
add_action('admin_init', 'nnl_register_settings');

function nnl_website_url_callback() {
    $value = get_option('nnl_website_url', '');
    echo '<input type="text" name="nnl_website_url" value="' . esc_attr($value) . '" />';
}

function nnl_poll_interval_callback() {
    $value = get_option('nnl_poll_interval', '30');
    echo '<select name="nnl_poll_interval">
            <option value="5"' . selected($value, '5', false) . '>5 seconds</option>
            <option value="15"' . selected($value, '15', false) . '>15 seconds</option>
            <option value="25"' . selected($value, '25', false) . '>25 seconds</option>
            <option value="35"' . selected($value, '35', false) . '>35 seconds</option>
            <option value="45"' . selected($value, '45', false) . '>45 seconds</option>
            <option value="60"' . selected($value, '60', false) . '>1 minute</option>
            <option value="120"' . selected($value, '120', false) . '>2 minutes</option>
            <option value="180"' . selected($value, '180', false) . '>3 minutes</option>
        </select>';
}

function nnl_num_names_callback() {
    $value = get_option('nnl_num_names', '5');
    echo '<input type="number" name="nnl_num_names" value="' . esc_attr($value) . '" min="1" max="10" />';
}

// Shortcode to display the lists
function nnl_display_lists() {
    ob_start();
    ?>
    <div id="nnl-container">
        <div id="nnl-naughty">
            <h2>Naughty List</h2>
            <ul id="nnl-naughty-list"></ul>
        </div>
        <div id="nnl-nice">
            <h2>Nice List</h2>
            <ul id="nnl-nice-list"></ul>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('naughty_nice_list', 'nnl_display_lists');
