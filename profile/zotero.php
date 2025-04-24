<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zotero Group Library</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            margin-right: 5px;
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #2980b9;
        }
    </style>
</head><body>
<?php
// Replace with your Zotero group ID
$groupID = "5548551";  // Example: 1234567
$apiKey = "Pd7D3VRUsyLdJF89dweWFWRj";    // Replace with your Zotero API Key
// $limit = 10000;                 // Number of items to fetch
// $itemsPerPage = 10;         // Number of items per page
// $page = isset($_GET['page']) ? intval($_GET['page']) : 1;  // Get the current page number, default to 1
// $start = ($page - 1) * $itemsPerPage;
// Zotero API URL for groups
$url = "https://api.zotero.org/groups/{$groupID}/items?format=bib&style=apa&limit=10&key={$apiKey}";

// Fetch data from Zotero API
$response = file_get_contents($url);

// Check if the response is valid
if ($response === FALSE) {
    die("Error fetching Zotero data.");
}

// Decode JSON response
$items = json_decode($response, true);
echo $response;
// Display the Zotero group library
// echo "<h2>My Zotero Group Library</h2>";
// // echo "<ul>";
// echo "<table><ol>";

// foreach ($items as $item) {
//     if (!empty($item['data']['title']) && $item['data']['itemType'] !== 'attachment') {
//         $title = htmlspecialchars($item['data']['title']);
//         $url = htmlspecialchars($item['links']['alternate']['href'])."//reader//";
//         $itemType = htmlspecialchars($item['data']['itemType']);
//         $date = htmlspecialchars($item['data']['date']);
//         $author = htmlspecialchars($item['data']['creators'][0]['lastName']);
//         echo "<tr><td>{$itemType}</td><td>{$date}</td><td>{$author}</td><td><li><a href='{$url}' target='_blank'>{$title}</a></li></td></tr>";
//     }
// }
// echo "</ol></table>";
// echo "<div class='pagination'>";

// // Check if there is a previous page
// if ($page > 1) {
//     echo "<a href='?page=" . ($page - 1) . "'>&laquo; Previous</a> ";
// }

// // Display current page and next page link
// echo "Page {$page} ";

// echo "<a href='?page=" . ($page + 1) . "'>Next &raquo;</a>";

// echo "</div>";
?>
</body>
</html>
