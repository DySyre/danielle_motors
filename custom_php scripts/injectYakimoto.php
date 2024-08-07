<?php
// Paths to the JSON files
$input_file = '../jsons/babaero si azul 5  sprocketbolt cb125s.json';
$output_file = '../jsons/final.json';

// Read the input JSON file
$json_data = file_get_contents($input_file);

// Decode the input JSON data
$items = json_decode($json_data, true);

// Initialize an array to hold the final data
$final_data = array();

// Check if the output JSON file exists and read its content
if (file_exists($output_file)) {
    $existing_data = file_get_contents($output_file);
    $final_data = json_decode($existing_data, true);

    // If decoding failed, initialize final_data as an empty array
    if (!is_array($final_data)) {
        $final_data = array();
    }
}

// Create an array of existing descriptions for quick lookup
$existing_descriptions = array_column($final_data, 'description');

echo "<table border='1'>
<tr>
    <th>Description</th>
    <th>SRP</th>
    <th>Discounted Price</th>
</tr>";

// Loop through each item and display the required fields
foreach ($items as $item) {
    // Skip the item if the description already exists in the final data
    if (in_array($item['description'], $existing_descriptions)) {
        continue;
    }

    echo "<tr>";
    echo "<td>" . htmlspecialchars($item['description']) . "</td>";
    echo "<td>" . number_format($item['SRP'], 2) . "</td>";
    echo "<td>" . number_format($item['discounted_price'], 2) . "</td>";
    echo "</tr>";

    // Add the filtered item to the final data array
    $final_data[] = array(
        'description' => $item['description'],
        'SRP' => $item['SRP'],
        'discounted_price' => $item['discounted_price']
    );
}

echo "</table>";

// Encode the final data array to JSON
$final_json_data = json_encode($final_data, JSON_PRETTY_PRINT);

// Write the JSON data to the new file
file_put_contents($output_file, $final_json_data);
?>
