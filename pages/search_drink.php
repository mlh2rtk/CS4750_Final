<?php
include('../Database.php');
include('../Config.php');

// Retrieve the search term from the AJAX request
$drinkSearch = $_GET['q'];

// Perform the search query
$db = new Database();
$sql = "SELECT drink_name, price, description, parent_name FROM menu_items WHERE drink_name LIKE ?";
$stmt = $db->dbConnector->prepare($sql);
$drinkSearch = "%" . $drinkSearch . "%";
$stmt->bind_param("s", $drinkSearch);
$stmt->execute();
$result = $stmt->get_result();

// Output the search results
while ($row = $result->fetch_assoc()) {
    echo "Drink: " . $row['drink_name'] . ",   Price: " . $row['price'] . ",   Description: " . $row['description'] . ",   Shop: " . $row['parent_name']. "<br>";
    echo "<div><input type='button' value='Add to cart?'></div>";
}

