<?php 
include $settings['pluginDirectory'] . "/naughty_nice_list/pluginUpdate.php"; 

// Include common functionality
include_once 'naughty_nice_list.common.php';

// Plugin-specific variables
$pluginName = 'naughty_nice_list';
$pluginJson = convertAndGetSettings($pluginName);

// Setup URL for configuration
$setupUrl = 'plugin.php?' . http_build_query([
    '_menu' => 'content',
    'plugin' => 'fpp-' . $pluginName,
    'page' => 'setup.php'
]);

// Function to get the latest 5 names for display
function getNames($type = 'naughty') {
    global $pluginName;
    $filename = $pluginName . "_list_" . $type . ".json";
    $names = convertAndGetSettings($filename);
    return array_slice($names, 0, 5); // Get the latest 5 names
}

// Function to display the status data
function getStatusData($pj) {
    return [
        [
            "website_url" => $pj['website_url'],
            "poll_interval" => $pj['poll_interval'] . " seconds",
            "num_names" => $pj['num_names'] . " names"
        ]
    ];
}
?>

<head>
    <link rel="stylesheet" href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css">
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <style>
        /* Custom styles for the display */
        .avatar {
            width: 40px;
            min-width: 40px;
            height: 40px;
        }

        .rounded {
            border-radius: .25rem !important;
        }

        .ms-3 {
            margin-left: 1rem !important;
        }
    </style>
</head>

<body>
    <?php if ($pluginJson['website_url'] != '') { ?>

        <!-- Display plugin status using Grid.js -->
        <div id="status"></div>
        <script>
            new gridjs.Grid({
                columns: [
                    { id: 'website_url', name: 'Website URL' },
                    { id: 'poll_interval', name: 'Poll Interval' },
                    { id: 'num_names', name: 'Number of Names' }
                ],
                data: <?php echo json_encode(getStatusData($pluginJson)); ?>,
                style: {
                    table: {
                        border: '3px solid #ccc'
                    },
                    th: {
                        'background-color': 'rgba(0, 0, 0, 0.1)',
                        color: '#000',
                        'border-bottom': '3px solid #ccc',
                        'text-align': 'center'
                    },
                    td: {
                        'text-align': 'center'
                    }
                }
            }).render(document.getElementById("status"));
        </script>

        <!-- Display the latest names from both Naughty and Nice lists -->
        <h3>Naughty List</h3>
        <div id="naughty-list"></div>
        <script>
            new gridjs.Grid({
                columns: [
                    { id: 'name', name: 'Child Name' }
                ],
                data: <?php echo json_encode(getNames('naughty')); ?>,
                style: {
                    table: {
                        border: '3px solid #ccc'
                    },
                    th: {
                        'background-color': 'rgba(255, 0, 0, 0.1)',
                        color: '#000',
                        'border-bottom': '3px solid #ccc',
                        'text-align': 'center'
                    },
                    td: {
                        'text-align': 'center'
                    }
                }
            }).render(document.getElementById("naughty-list"));
        </script>

        <h3>Nice List</h3>
        <div id="nice-list"></div>
        <script>
            new gridjs.Grid({
                columns: [
                    { id: 'name', name: 'Child Name' }
                ],
                data: <?php echo json_encode(getNames('nice')); ?>,
                style: {
                    table: {
                        border: '3px solid #ccc'
                    },
                    th: {
                        'background-color': 'rgba(0, 255, 0, 0.1)',
                        color: '#000',
                        'border-bottom': '3px solid #ccc',
                        'text-align': 'center'
                    },
                    td: {
                        'text-align': 'center'
                    }
                }
            }).render(document.getElementById("nice-list"));
        </script>

    <?php } else { ?>
        <!-- Prompt the user to set up the plugin if no website URL is configured -->
        <p>You need to configure this plugin before you can see the status. Click <a href="<?php echo $setupUrl; ?>">here</a> to configure.</p>
    <?php } ?>
</body>
