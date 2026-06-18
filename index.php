<?php
require 'config.php'; // pulls in $pdo

// Top 10 Drivers
$sqlDrivers = "SELECT driver, COUNT(*) AS trips 
               FROM fleet_events 
               GROUP BY driver 
               ORDER BY trips DESC 
               LIMIT 10";
$drivers = $pdo->query($sqlDrivers)->fetchAll(PDO::FETCH_ASSOC);

// Top 10 Regions (extract region from SLURL)
$sqlRegions = "SELECT 
                  SUBSTRING_INDEX(SUBSTRING_INDEX(slurl, '/', 5), '/', -1) AS region,
                  COUNT(*) AS visits
               FROM fleet_events
               GROUP BY region
               ORDER BY visits DESC
               LIMIT 10";
$regions = $pdo->query($sqlRegions)->fetchAll(PDO::FETCH_ASSOC);

// Top 10 Cargo Types
$sqlCargo = "SELECT cargo, COUNT(*) AS moves 
             FROM fleet_events 
             GROUP BY cargo 
             ORDER BY moves DESC 
             LIMIT 10";
$cargo = $pdo->query($sqlCargo)->fetchAll(PDO::FETCH_ASSOC);
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
    h1 {
        text-align: center;
        color: #2c3e50;
    }
    h2 {
        margin-top: 0;
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 5px;
    }
    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }
    .card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    th {
        background: #3498db;
        color: #fff;
    }
    tr:nth-child(even) {
        background: #f9f9f9;
    }
    tr:hover {
        background: #eaf2f8;
    }
</style>
</head>
<body>

<h1>Fleet Leaderboard</h1>
<div class="dashboard">
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

    <div class="card">
        <h2>Top 10 Regions</h2>
        <table>
            <tr><th>Region</th><th>Visits</th></tr>
            <?php foreach ($regions as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['region']) ?></td>
                    <td><?= $row['visits'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="card">
        <h2>Top 10 Cargo</h2>
        <table>
            <tr><th>Cargo</th><th>Moves</th></tr>
            <?php foreach ($cargo as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['cargo']) ?></td>
                    <td><?= $row['moves'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

</body>
</html>
