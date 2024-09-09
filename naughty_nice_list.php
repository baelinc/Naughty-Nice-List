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
