<?php
// fleetlog.php
$logFile = "fleetlog.txt";

// Collect POST data
$driver = $_POST['driver'] ?? 'Unknown';
$job = $_POST['job'] ?? 'None';
$destination = $_POST['destination'] ?? 'None';
$location = $_POST['location'] ?? 'Unknown';
$region = $_POST['region'] ?? 'Unknown';

// Build log entry
$entry = date("Y-m-d H:i:s") . " | Driver: $driver | Job: $job | Destination: $destination | Location: $location | Region: $region\n";

// Append to log file
file_put_contents($logFile, $entry, FILE_APPEND);

// Confirmation back to SL
echo "Logged: $entry";
?>
