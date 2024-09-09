$(document).ready(function() {
    var nnl_poll_interval = typeof nnl_poll_interval !== 'undefined' ? nnl_poll_interval : 30;

    function refreshLists() {
        $.ajax({
            url: '/plugin.php?plugin=naughty-nice-list&file=api/get-lists.php&nopage=1',
            method: 'GET',
            success: function(data) {
                let parsedData = JSON.parse(data);
                updateGrid('naughty_list', parsedData.naughty);
                updateGrid('nice_list', parsedData.nice);
            }
        });
    }

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
