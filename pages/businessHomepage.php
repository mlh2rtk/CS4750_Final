<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Time of Operation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            margin: 0;
            min-height: 100vh;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            width: 100%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa; /* Light gray background */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }
        .form-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }

        ..form-container {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        .day-operation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 10px; /* Adjust margin as needed */
        }

        .sql-data {
            flex-grow: 1;
        }

        .edit-form {
            flex-shrink: 0;
        }


    </style>
</head>
<body>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editButton"])) {
    // Retrieve form data
    $dayOfWeek = $_POST["dayOfWeek"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];

    // Update the Time_of_Operation table in the database
    $sql = "REPLACE INTO Time_of_operation (shop_username, dayOfWeek, startTime, endTime) VALUES (?, ?, ?, ?)";
    $stmt = $this->db->dbConnector->prepare($sql);
    $stmt->bind_param("ssss", $_SESSION['loggedInUser'], $dayOfWeek, $startTime, $endTime);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editLocationButton"])) {
    // Retrieve the form data
    $streetAddress = $_POST['streetAddress'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    // Perform any necessary validation or database updates here
    // For this example, we'll just display the updated location
    $sql = "REPLACE INTO location (location_id, state, zip_code, street_address, city) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->db->dbConnector->prepare($sql);
    $stmt->bind_param("isiss", $location_id, $state, $zip, $streetAddress, $city);
    $stmt->execute();
    $stmt->close();
}
?>
<!-- Business Time of Operation-->
<div class="form-container">
    <h2 class="form-title">Business Time of Operation</h2>
    <?php
    $shop_username = $_SESSION['loggedInUser']; // Replace with the actual shop username
    $daysOfWeek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

    foreach ($daysOfWeek as $day) {
        // Prepare and execute SQL query to retrieve time of operation for the current day
        $sql = "SELECT startTime, endTime FROM Time_of_operation WHERE shop_username = ? AND dayOfWeek = ?";
        $stmt = $this->db->dbConnector->prepare($sql);
        $stmt->bind_param("ss", $shop_username, $day);
        $stmt->execute();
        $stmt->bind_result($startTime, $endTime);

        // Fetch the result
        $stmt->fetch();
        $stmt->close();

        // Check if a record exists for the current day
        echo "<div class='day-operation'>";
        echo "<div class='sql-data'>";
        echo "<strong>$day:</strong> ";
        if ($startTime !== null && $endTime !== null) {
            // Format the time strings as desired
            $startTimeFormatted = date("h:i A", strtotime("$startTime"));
            $endTimeFormatted = date("h:i A", strtotime("$endTime"));
            echo "$startTimeFormatted - $endTimeFormatted";
        } else {
            echo "Closed";
        }
        $startTime = NULL;
        $endTime = NULL;
        echo "</div>"; // Close sql-data div

        // Display input fields for editing start and end times
        echo "<div class='edit-form' style='display: none;'>";
        echo "<form method='post' action=''>";
        echo "<input type='hidden' name='dayOfWeek' value='$day'>";
        echo "<input type='time' name='startTime'> - ";
        echo "<input type='time' name='endTime'>";
        echo "<button type='submit' name='editButton'>Save</button>";
        echo "</form>";
        echo "</div>"; // Close edit-form div

        // Toggle button to show/hide edit form
        echo "<button class='toggle-edit'>Open</button>";
        echo "</div>"; // Close day-operation div
    }
    ?>
</div>
<!-- Update location -->
<div class="form-container">
    <h2 class="form-title">Business Location</h2>
    <?php
    //$location_id = $_SESSION['locationID'];
    // Prepare and execute SQL query to retrieve address for the current location_id
    $sql = "SELECT state, zip_code, street_address, city FROM location JOIN location_parent_company ON location.location_id=location_parent_company.location_id WHERE parent_name = ?";
    $stmt = $this->db->dbConnector->prepare($sql);
    $stmt->bind_param("i", $_SESSION['loggedInUser']);
    $stmt->execute();
    $stmt->bind_result($state, $zip, $streetAddress, $city);

    // Fetch the result
    $stmt->fetch();
    $stmt->close();
    ?>
    <form method="post" action=''>
        <label for="streetAddress">Street Address:</label><br>
        <input type="text" id="streetAddress" name="streetAddress" value="<?php echo $streetAddress; ?>"><br><br>

        <label for="city">City:</label><br>
        <input type="text" id="city" name="city" value="<?php echo $city; ?>"><br><br>

        <label for="state">State:</label><br>
        <input type="text" id="state" name="state" value="<?php echo $state; ?>"><br><br>

        <label for="zip">ZIP Code:</label><br>
        <input type="text" id="zip" name="zip" value="<?php echo $zip; ?>"><br><br>

        <input type="submit" name="editLocationButton" value="Update">
    </form>
</div>
<!-- Update name of business -->
<div class="form-container">
    <h2 class="form-title">Business Name</h2>
    <form method="post" action=''>
        <label for="businessName">Business Name:</label><br>
        <input type="text" id="businessName" name="businessName" value="<?php echo $_SESSION['loggedInUser']; ?>"><br><br>
        <input type="submit" name="editNameButton" value="Update">
    </form>
</div>
<!-- See reviews -->
<div class="form-container">
    <h2 class="form-title">Reviews</h2>
    <?php
    // Prepare and execute SQL query to retrieve reviews for the current shop
    $sql = "SELECT review_text, rating FROM reviews WHERE shop_username = ?";
    $stmt = $this->db->dbConnector->prepare($sql);
    $stmt->bind_param("i", $_SESSION['loggedInUser']);
    $stmt->execute();
    $stmt->bind_result($review_text, $rating);

    // Fetch the result
    while ($stmt->fetch()){
        echo "<div><div>$review_text</div><div>$rating</div></div>";
    }
    $stmt->close();
    ?>
</div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleButtons = document.querySelectorAll(".toggle-edit");

        toggleButtons.forEach(button => {
            button.addEventListener("click", function() {
                const editForm = this.parentElement.querySelector(".edit-form");
                if (editForm.style.display === "none") {
                    editForm.style.display = "block";
                    this.textContent = "Close";
                } else {
                    editForm.style.display = "none";
                    this.textContent = "Open";
                }
            });
        });
    });
</script>

</html>