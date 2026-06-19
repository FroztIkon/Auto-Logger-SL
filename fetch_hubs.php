<?php
// Define target source and destination file
$url = 'https://sl-gtfo.com/hub.php';
$output_file = 'hub_data.json';

// 1. Fetch the remote HTML content using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) PHP-Scraper');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$html = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Ensure the request was successful
if ($http_code !== 200 || !$html) {
    die("Error: Unable to fetch data from the server (HTTP Code: $http_code).");
}

// 2. Load the HTML into DOMDocument
$dom = new DOMDocument();
// Suppress HTML5 structural warnings common on web pages
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($dom);

// Target all table rows inside the main content table
$rows = $xpath->query('//table//tr');

$parsed_hubs = [];

foreach ($rows as $row) {
    $cells = $row->getElementsByTagName('td');
    
    // Skip empty rows or header rows that don't match the expected layout
    if ($cells->length < 3) {
        continue;
    }
    
    // Extract textual data safely from columns
    $area     = trim($cells->item(0)->nodeValue ?? '');
    $region   = trim($cells->item(1)->nodeValue ?? '');
    $hub_name = trim($cells->item(2)->nodeValue ?? '');

    // Skip the literal table header text if it gets selected
    if (strtolower($area) === 'area' && strtolower($hub_name) === 'hub name') {
        continue;
    }

    // Map columns dynamically into an associative array
    $parsed_hubs[] = [
        'area'     => $area,
        'region'   => $region,
        'hub_name' => $hub_name
    ];
}

// 3. Encode to JSON format and completely overwrite the file
$json_flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
$json_data  = json_encode($parsed_hubs, $json_flags);

if (file_put_contents($output_file, $json_data)) {
    echo "Success: Parsed " . count($parsed_hubs) . " hubs and saved them to $output_file.";
} else {
    echo "Error: Failed to write data to $output_file. Check server directory permissions.";
}
?>
