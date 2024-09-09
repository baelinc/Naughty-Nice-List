$(document).ready(function() {
    var nnl_poll_interval = typeof nnl_poll_interval !== 'undefined' ? nnl_poll_interval : 30;

    function refreshLists() {
        $.ajax({
    url: '/plugin.php?plugin=naughty-nice-list&file=api/get-lists.php&nopage=1', // Update with your PHP script URL
    method: 'GET',
    dataType: 'json', // Expect JSON response
    success: function(data) {
        if (data.error) {
            console.error('Error:', data.error);
        } else {
            // Handle valid data
            console.log('Naughty List:', data.naughty);
            console.log('Nice List:', data.nice);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error('AJAX Error:', textStatus, errorThrown);
    }
});

    function updateGrid(elementId, listData) {
        const gridInstance = gridjs.Grid({
            columns: ["Name", "Date"],
            data: listData.map(item => [item.name, new Date(item.timestamp).toLocaleString()])
        });
        gridInstance.render(document.getElementById(elementId));
    }

    setInterval(refreshLists, nnl_poll_interval * 1000);
    refreshLists();
});
