<?php
$file = 'hub_data.json';

// Check if the data file exists
if (!file_exists($file)) {
    die("Error: Data file ($file) not found. Please run your fetch script first.");
}

// Read and decode the JSON data
$json_raw = file_get_contents($file);
$hubs = json_decode($json_raw, true);

if (empty($hubs)) {
    die("Error: No data found in the JSON file.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GTFO Hubs List</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; max-width: 900px; margin: 30px auto; padding: 0 15px; color: #333; }
        h2 { border-bottom: 2px solid #eaeaea; padding-bottom: 10px; }
        .search-box { width: 100%; padding: 12px; margin: 15px 0; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #555; font-weight: 600; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; }
        tr:hover { background-color: #f1f3f5; }
        .no-results { display: none; text-align: center; padding: 20px; color: #777; font-style: italic; }
    </style>
</head>
<body>

    <h2>GTFO Hubs Directory</h2>
    
    <!-- Instant Search Bar -->
    <input type="text" id="searchInput" class="search-box" placeholder="Type to search by Area, Region, or Hub Name...">

    <table id="hubsTable">
        <thead>
            <tr>
                <th>Area</th>
                <th>Region</th>
                <th>Hub Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hubs as $hub): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($hub['area']); ?></strong></td>
                    <td><?php echo htmlspecialchars($hub['region']); ?></td>
                    <td><?php echo htmlspecialchars($hub['hub_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="noResults" class="no-results">No matching hubs found.</div>

    <!-- JavaScript for instant, zero-lag filtering -->
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#hubsTable tbody tr');
            let hasResults = false;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                    hasResults = true;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('noResults').style.display = hasResults ? 'none' : 'block';
        });
    </script>

</body>
</html>
