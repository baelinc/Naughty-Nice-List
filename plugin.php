<?php
include $settings['pluginDirectory'] . "/fpp-naughty-nice-list/pluginUpdate.php";

$pluginName = 'naughty-nice-list';
$pluginJson = convertAndGetSettings($pluginName);

$setupUrl = 'plugin.php?' . http_build_query([
    '_menu' => 'content',
    'plugin' => 'fpp-' . $pluginName,
    'page' => 'setup.php'
]);

function sortByTimestampDesc($a, $b) {
    return $b['timestamp'] > $a['timestamp'];
}

function getListEntries($listType) {
    $data = convertAndGetSettings('naughty-nice-list');
    usort($data[$listType], 'sortByTimestampDesc');
    return array_slice($data[$listType], 0, 5); // Limit to last 5 entries
}
?>
<head>
    <link rel="stylesheet" href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css">
    <link rel="stylesheet" href="/plugin.php?plugin=naughty-nice-list&file=css/style.css&nopage=1">
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <script type="text/javascript" src="/plugin.php?plugin=naughty-nice-list&file=js/script.js&nopage=1"></script>
</head>
<?php if ($pluginJson['client_id'] != '') { ?>
    <div id="naughty_list"></div>
    <div id="nice_list"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchListEntries();

            function fetchListEntries() {
                fetch('/plugin.php?plugin=naughty-nice-list&file=php/ajax-handler.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error('Error fetching list entries:', data.error);
                            return;
                        }

                        updateGrid('naughty_list', data.naughty);
                        updateGrid('nice_list', data.nice);
                    })
                    .catch(error => console.error('Error:', error));
            }

            function updateGrid(elementId, entries) {
                new gridjs.Grid({
                    columns: ["Name", "Date"],
                    data: entries.map(item => [item.name, new Date(item.timestamp).toLocaleString()]),
                    pagination: true,
                    sort: true
                }).render(document.getElementById(elementId));
            }
        });
    </script>
<?php } else { ?>
    <p>Please configure the plugin. <a href="<?php echo $setupUrl; ?>">Go to setup</a></p>
<?php } ?>
