    <link rel="stylesheet" href="plugin.php?plugin=naughty_nice_list/css&file=style.css&nopage=1"/>
    <script src="plugin.php?plugin=naughty_nice_list/js&file=script.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <div class="container">
        <h1>Naughty Nice List Settings</h1>
        
        <!-- Tabs for navigation -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="nnl-general-settings-tab" data-toggle="tab" href="#nnl-general-settings" role="tab" aria-controls="nnl-general-settings" aria-selected="true">General Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="nnl-display-settings-tab" data-toggle="tab" href="#nnl-display-settings" role="tab" aria-controls="nnl-display-settings" aria-selected="false">Display Settings</a>
            </li>
        </ul>
        
        <div class="tab-content mt-2">
            <!-- General Settings Tab -->
            <div class="tab-pane fade show active" id="nnl-general-settings" role="tabpanel" aria-labelledby="nnl-general-settings-tab">
                <form id="nnl-settings-form">
                    <div class="form-group">
                        <label for="nnl_website_url">Website URL:</label>
                        <input type="text" class="form-control" id="nnl_website_url" name="nnl_website_url">
                    </div>
                    <div class="form-group">
                        <label for="nnl_poll_interval">Polling Interval:</label>
                        <select class="form-control" id="nnl_poll_interval" name="nnl_poll_interval">
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nnl_num_names">Number of Names to Display:</label>
                        <input type="number" class="form-control" id="nnl_num_names" name="nnl_num_names" min="1" max="10">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                    <div id="message" class="mt-2"></div>
                </form>
            </div>

            <!-- Display Settings Tab -->
            <div class="tab-pane fade" id="nnl-display-settings" role="tabpanel" aria-labelledby="nnl-display-settings-tab">
                <h2>Display Settings</h2>
                <p>Here you can configure how the lists are displayed. (Additional settings can be added here.)</p>
                <!-- Add additional fields for display settings if needed -->
            </div>
        </div>
    </div>

    <!-- JavaScript to handle form submission and populate options -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Populate polling interval options
        const intervals = [5, 15, 25, 35, 45, 60, 120, 180];
        const selectElement = document.getElementById('nnl_poll_interval');
        intervals.forEach(interval => {
            const option = document.createElement('option');
            option.value = interval;
            option.textContent = `${interval} seconds`;
            selectElement.appendChild(option);
        });

        // Load existing settings
        fetch('plugins/naughty_nice_list/settings.json')
            .then(response => response.json())
            .then(settings => {
                document.getElementById('nnl_website_url').value = settings.website_url || '';
                document.getElementById('nnl_poll_interval').value = settings.poll_interval || 30;
                document.getElementById('nnl_num_names').value = settings.num_names || 5;
            });

        // Handle form submission
        document.getElementById('nnl-settings-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const settings = {
                website_url: formData.get('nnl_website_url'),
                poll_interval: formData.get('nnl_poll_interval'),
                num_names: formData.get('nnl_num_names')
            };

            fetch('plugins/naughty_nice_list/save_settings.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(settings)
            })
            .then(response => response.text())
            .then(message => {
                document.getElementById('message').textContent = message;
            });
        });
    });
</script>
