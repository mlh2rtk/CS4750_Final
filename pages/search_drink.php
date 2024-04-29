<?php
include('../Database.php');
include('../Config.php');

// Retrieve the search term from the AJAX request
$businessSearch = $_GET['q'];

// Perform the search query
$db = new Database();
$sql = "SELECT drink_id, drink_name, price, description, parent_name FROM menu_items WHERE drink_name LIKE ?";
$stmt = $db->dbConnector->prepare($sql);
$businessSearch = "%" . $businessSearch . "%";
$stmt->bind_param("s", $businessSearch);
$stmt->execute();
$result = $stmt->get_result();

// Output the search results
while ($row = $result->fetch_assoc()) {
    echo "<form method='post' action=''>";
    echo "Drink: " . $row['drink_name'] . ",   Price: " . $row['price'] . ",   Description: " . $row['description'] . ",   Shop: " . $row['parent_name']. "<br>";
    echo "<input type='hidden' name='drinkName' value='{$row['drink_name']}'>";
    echo "<input type='hidden' name='price' value='{$row['price']}'>";
    echo "<input type='hidden' name='description' value='{$row['description']}'>";
    echo "<input type='hidden' name='parentName' value='{$row['parent_name']}'>";
    echo "<input type='hidden' name='drinkId' value='{$row['drink_id']}'>";
    echo "<div><input type='button' name='addCart' value='Add to cart?'></div>";
    echo "</form>";
}

