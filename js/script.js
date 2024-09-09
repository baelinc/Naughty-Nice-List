jQuery(document).ready(function($) {
    const pollInterval = parseInt(nnl_poll_interval) * 1000;
    const numNames = parseInt(nnl_num_names);
    const websiteUrl = nnl_website_url;

    function fetchLists() {
        $.ajax({
            url: websiteUrl,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Initialize empty lists
                const naughtyList = [];
                const niceList = [];

                // Process the data
                data.forEach(item => {
                    if (item.listtype === 'naughty') {
                        naughtyList.push(`${item.firstname} ${item.lastinitial}`);
                    } else if (item.listtype === 'nice') {
                        niceList.push(`${item.firstname} ${item.lastinitial}`);
                    }
                });

                // Clear existing lists
                $('#nnl-naughty-list').empty();
                $('#nnl-nice-list').empty();

                // Add names to Naughty List
                naughtyList.slice(0, numNames).forEach(name => {
                    $('#nnl-naughty-list').append(`<li>${name}</li>`);
                });

                // Add names to Nice List
                niceList.slice(0, numNames).forEach(name => {
                    $('#nnl-nice-list').append(`<li>${name}</li>`);
                });
            },
            error: function() {
                $('#nnl-naughty-list').html('<li>Error loading list</li>');
                $('#nnl-nice-list').html('<li>Error loading list</li>');
            }
        });
    }

    fetchLists(); // Initial fetch
    setInterval(fetchLists, pollInterval); // Poll at intervals
});
