// Path to the AJAX-HANDLER file
$ajaxFilePath = '/plugin.php?plugin=naughty-nice-list/include/&file=ajax-handler.php&nopage=1';

document.addEventListener('DOMContentLoaded', function() {
    fetchListEntries();

    function fetchListEntries() {
        fetch($ajaxFilePath) // Ensure this path is correct
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error fetching list entries:', data.error);
                    return;
                }
                updateGrid('naughty_list', data.naughty);
                updateGrid('nice_list', data.nice);
            })
            .catch(error => console.error('Fetch error:', error));
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
