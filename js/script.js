document.addEventListener('DOMContentLoaded', function() {
    fetchListEntries();

    function fetchListEntries() {
        fetch('/include/ajax-handler.php') // Ensure this path is correct
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
