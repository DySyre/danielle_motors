<?php
// Path to the JSON file
$output_file = '../jsons/final.json';

// Check if the JSON file exists
if (!file_exists($output_file)) {
    die('JSON file not found.');
}

// Read the JSON file
$json_data = file_get_contents($output_file);

// Decode the JSON data
$items = json_decode($json_data, true);

// Check if the JSON data was properly decoded
if (!is_array($items)) {
    die('Error decoding JSON data.');
}

echo "<table border='1'>
<tr>
    <th>#</th>
    <th>Description</th>
    <th>SRP</th>
    <th>Discounted Price</th>
</tr>";

// Initialize row number
$row_number = 1;

// Loop through each item and display the required fields
foreach ($items as $item) {
    echo "<tr>";
    echo "<td>" . $row_number . "</td>";
    echo "<td>" . htmlspecialchars($item['description']) . "</td>";
    echo "<td>" . number_format($item['SRP'], 2) . "</td>";
    echo "<td>" . number_format($item['discounted_price'], 2) . "</td>";
    echo "</tr>";
    
    // Increment row number
    $row_number++;
}

echo "</table>";
?>
