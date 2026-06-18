<?php
require 'config.php'; // pulls in $pdo

$sql = "SELECT timestamp, driver, action, amount, cargo, slurl 
        FROM fleet_events ORDER BY timestamp DESC";
$stmt = $pdo->query($sql);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Timestamp</th><th>Driver</th><th>Action</th><th>Amount</th><th>Cargo</th><th>Current Location</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
    echo "<td>" . htmlspecialchars($row['driver']) . "</td>";
    echo "<td>" . htmlspecialchars($row['action']) . "</td>";
    echo "<td>" . htmlspecialchars($row['amount']) . "</td>";
    echo "<td>" . htmlspecialchars($row['cargo']) . "</td>";
    echo "<td><a href='" . htmlspecialchars($row['slurl']) . "' target='_blank'>Teleport</a></td>";
    echo "</tr>";
}
echo "</table>";
?>
<meta http-equiv="refresh" content="5">
