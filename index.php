<?php
require 'config.php'; // pulls in $pdo

// Load hub data JSON
$hubDataRaw = json_decode(file_get_contents('hub_data.json'), true);
$hubLookup = [];
foreach ($hubDataRaw as $entry) {
    $hubLookup[$entry['region']] = $entry['hub_name'];
}

// Top 10 Drivers
$sqlDrivers = "SELECT driver, COUNT(*) AS trips 
               FROM fleet_events 
               GROUP BY driver 
               ORDER BY trips DESC 
               LIMIT 10";
$drivers = $pdo->query($sqlDrivers)->fetchAll(PDO::FETCH_ASSOC);

// Top 10 Cargo
$sqlCargo = "SELECT cargo, COUNT(*) AS loads 
             FROM fleet_events 
             GROUP BY cargo 
             ORDER BY loads DESC 
             LIMIT 10";
$cargo = $pdo->query($sqlCargo)->fetchAll(PDO::FETCH_ASSOC);

// Top 10 Regions (to be mapped to hubs)
$sqlRegions = "SELECT 
    SUBSTRING_INDEX(SUBSTRING_INDEX(slurl, '/', 5), '/', -1) AS region,
    COUNT(*) AS visits
FROM fleet_events
GROUP BY region
ORDER BY visits DESC
LIMIT 10";
$regions = $pdo->query($sqlRegions)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Fleet Dashboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 20px;
        color: #333;
    }
    h2 {
        margin-top: 0;
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 5px;
    }
    .dashboard {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        padding: 20px;
        flex: 1;
        min-width: 300px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: #3498db;
        color: #fff;
    }
</style>
</head>
<body>
<h1>Fleet Dashboard</h1>
<div class="dashboard">

    <!-- Top Drivers -->
    <div class="card">
        <h2>Top 10 Drivers</h2>
        <table>
            <tr><th>Driver</th><th>Trips</th></tr>
            <?php foreach ($drivers as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['driver']) ?></td>
                    <td><?= $row['trips'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Top Cargo -->
    <div class="card">
        <h2>Top 10 Cargo</h2>
        <table>
            <tr><th>Cargo</th><th>Loads</th></tr>
            <?php foreach ($cargo as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['cargo']) ?></td>
                    <td><?= $row['loads'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Top Hubs -->
    <div class="card">
        <h2>Top 10 Hubs</h2>
        <table>
            <tr><th>Hub</th><th>Visits</th></tr>
            <?php foreach ($regions as $row): 
                $region = $row['region'];
                $hubName = $hubLookup[$region] ?? $region;
            ?>
                <tr>
                    <td><?= htmlspecialchars($hubName) ?></td>
                    <td><?= $row['visits'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>
</body>
</html>
