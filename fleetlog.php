<?php
// Database connection settings
require 'config.php'; // pulls in $pdo


// Collect POST data
$driver = $_POST['driver'] ?? 'Unknown';
$action = $_POST['action'] ?? 'None';
$amount = $_POST['amount'] ?? '0';
$cargo  = $_POST['cargo'] ?? 'None';
$slurl  = $_POST['slurl'] ?? 'Unknown';

// Insert into database
$sql = "INSERT INTO fleet_events (timestamp, driver, action, amount, cargo, slurl) 
        VALUES (NOW(), :driver, :action, :amount, :cargo, :slurl)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':driver' => $driver,
    ':action' => $action,
    ':amount' => $amount,
    ':cargo'  => $cargo,
    ':slurl'  => $slurl
]);

echo "Logged successfully.";
?>
<?php
// Database connection settings
require 'config.php'; // pulls in $pdo


// Collect POST data
$driver = $_POST['driver'] ?? 'Unknown';
$action = $_POST['action'] ?? 'None';
$amount = $_POST['amount'] ?? '0';
$cargo  = $_POST['cargo'] ?? 'None';
$slurl  = $_POST['slurl'] ?? 'Unknown';

// Insert into database
$sql = "INSERT INTO fleet_events (timestamp, driver, action, amount, cargo, slurl) 
        VALUES (NOW(), :driver, :action, :amount, :cargo, :slurl)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':driver' => $driver,
    ':action' => $action,
    ':amount' => $amount,
    ':cargo'  => $cargo,
    ':slurl'  => $slurl
]);

echo "Logged successfully.";
?>
