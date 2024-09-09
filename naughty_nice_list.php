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
        const naughtyListData = <?php echo json_encode(getListEntries('naughty')); ?>;
        const niceListData = <?php echo json_encode(getListEntries('nice')); ?>;

        new gridjs.Grid({
            columns: ["Name", "Date"],
            data: naughtyListData.map(item => [item.name, new Date(item.timestamp).toLocaleString()]),
            pagination: true,
            sort: true
        }).render(document.getElementById("naughty_list"));

        new gridjs.Grid({
            columns: ["Name", "Date"],
            data: niceListData.map(item => [item.name, new Date(item.timestamp).toLocaleString()]),
            pagination: true,
            sort: true
        }).render(document.getElementById("nice_list"));
    </script>
<?php } else { ?>
    <p>Please configure the plugin. <a href="<?php echo $setupUrl; ?>">Go to setup</a></p>
<?php } ?>
