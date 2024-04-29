<?php
include('../Database.php');
include('../Config.php');

$db = new Database();
$c_username = $_POST['c_username'];
$shopUsername = $_POST['shopUsername'];
$reviewText = $_POST['reviewText'];
$rating = $_POST['rating'];
$sql = "INSERT INTO reviews (c_username, shop_username, review_text, rating) VALUES (?, ?, ?, ?)";
$stmt = $db->dbConnector->prepare($sql);
$stmt->bind_param("ssss", $c_username, $shopUsername, $reviewText, $rating);
$stmt->execute();
$stmt->close();