<?php
include('../Database.php');
include('../Config.php');

// Retrieve the search term from the AJAX request
$businessSearch = $_GET['q'];

// Perform the search query
$db = new Database();
$sql = "SELECT * FROM Location_Parent_Company NATURAL JOIN Location WHERE parent_name LIKE ?";
$stmt = $db->dbConnector->prepare($sql);
$businessSearch = "%" . $businessSearch . "%";
$stmt->bind_param("s", $businessSearch);
$stmt->execute();
$result = $stmt->get_result();

// Output the search results
while ($row = $result->fetch_assoc()) {
    echo "Business Name: " . $row['parent_name'] . ",   Address: " . $row['street_address'] .","." ".$row['city']." ".$row['state']." ".$row['zip_code']. "<br>";
    echo "<div><form method='get'><button type='submit'>Visit Company</button>
    <input type=hidden id='parent_loc' name='parent_loc' value='".$row['parent_name']."'>"."<input type=hidden name='user' value='customer'></form></div>";
}
