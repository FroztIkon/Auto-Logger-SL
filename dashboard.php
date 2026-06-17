<?php
$logFile = "fleetlog.txt";
$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Timestamp</th><th>Driver</th><th>Action</th><th>Amount</th><th>Cargo</th><th>Current Location</th></tr>";

foreach ($lines as $line) {
    list($timestamp, $driver, $action, $amount, $cargo, $slurl) = explode(" | ", $line);

    echo "<tr>";
    echo "<td>$timestamp</td>";
    echo "<td>" . str_replace("Driver: ", "", $driver) . "</td>";
    echo "<td>" . str_replace("Action: ", "", $action) . "</td>";
    echo "<td>" . str_replace("Amount: ", "", $amount) . "</td>";
    echo "<td>" . str_replace("Cargo: ", "", $cargo) . "</td>";

    $slurlLink = str_replace("SLURL: ", "", $slurl);
    echo "<td><a href='$slurlLink' target='_blank'>Teleport</a></td>";

    echo "</tr>";
}
echo "</table>";
?>
<meta http-equiv="refresh" content="5">
<?php
// dashboard.php
$logFile = "fleetlog.txt";
$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Timestamp</th><th>Driver</th><th>Job</th><th>Destination</th><th>Location</th><th>Region</th></tr>";

foreach ($lines as $line) {
    // Split log line into 6 parts (including Region)
    list($timestamp, $driver, $job, $destination, $location, $region) = explode(" | ", $line);

    echo "<tr>";
    echo "<td>$timestamp</td>";
    echo "<td>" . str_replace("Driver: ", "", $driver) . "</td>";
    echo "<td>" . str_replace("Job: ", "", $job) . "</td>";
    echo "<td>" . str_replace("Destination: ", "", $destination) . "</td>";
    echo "<td>" . str_replace("Location: ", "", $location) . "</td>";
    echo "<td>" . str_replace("Region: ", "", $region) . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
<meta http-equiv="refresh" content="5">
