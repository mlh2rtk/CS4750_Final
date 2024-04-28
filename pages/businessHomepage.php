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
            display: none; /* Initially hide */
        }
        .form-title {
            text-align: center;
            margin-bottom: 20px;
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
        .navbar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .navbar a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
            cursor: pointer;
        }
        .navbar a.active {
            font-weight: bold;
        }
        .menu-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: none; /* Initially hide */
            width: 66%; /* 66% of screen width */
        }
        .menu-table {
            width: 100%;
            border-collapse: collapse;
        }
        .menu-table th,
        .menu-table td {
            padding: 8px;
            text-align: left;
        }
        .new-item-form {
            margin-top: 20px; /* Adjust the margin-top value as needed */
        }
        .menu-table th:first-child,
        .menu-table td:first-child {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        .menu-table th:last-child,
        .menu-table td:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        #reviews {
            display: none; /* Initially hidden */
            width: 66%; /* 66% of screen width */
            margin-top: 20px; /* Add margin to separate from other sections */
        }
        .review-table {
            width: 100%; /* Ensure the table takes up the full width */
            table-layout: auto; /* Allow the table to adjust column widths automatically */
        }
        .review-table th,
        .review-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            white-space: nowrap; /* Prevent line wrapping */
            overflow: hidden; /* Hide overflow content */
            text-overflow: ellipsis; /* Show ellipsis for overflow content */
        }
        .smaller-text {
            font-size: smaller; /* Adjust as needed */
        }
        .bigger-text {
            font-size: larger; /* Adjust as needed */
        }
    </style>
</head>
<body>

<!-- Navigation bar -->
<div class="navbar">
    <a href="#" class="active" onclick="toggleSection('about')">About</a>
    <a href="#" onclick="toggleSection('menu')">Menu</a>
    <a href="#" onclick="toggleSection('reviews')">Reviews</a>
</div>

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
<div class="form-container" id="about">
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

<div class="menu-container" id="menu">
    <h2 class="form-title">Menu</h2>
    <table class="menu-table">
        <!-- Table header -->
        <thead>
        <tr>
            <th class="menu-header">Drink Name</th>
            <th class="menu-header">Price</th>
            <th class="menu-header">Description</th>
        </tr>
        </thead>
        <!-- Table body -->
        <tbody>
        <?php
        // Query and display the menu items for the shop's parent company
        $sql = "SELECT drink_id, drink_name, price, description FROM Menu_items WHERE parent_name IN (SELECT parent_name FROM Location_Parent_Company WHERE location_id IN (SELECT location_id FROM Shop_Owner WHERE shop_username = ?))";
        $stmt = $this->db->dbConnector->prepare($sql);
        $stmt->bind_param("s", $this->loggedInUser);
        $stmt->execute();
        $stmt->bind_result($drink_id, $drink_name, $price, $description);
        while ($stmt->fetch()) {
            echo "<tr>";
            echo "<td>$drink_name</td>";
            echo "<td>$price</td>";
            echo "<td>$description</td>";
            echo "</tr>";
        }
        $stmt->close();
        ?>
        </tbody>
    </table>
    <div class="new-item-form">
        <!-- Form for inputting new menu items -->
        <form method="post" action="">
            <h3>Add/Edit Menu Item</h3>
            <label for="newDrinkName">Drink Name:</label>
            <input type="text" id="newDrinkName" name="newDrinkName" required><br>
            <label for="newPrice">Price:</label>
            <input type="number" id="newPrice" name="newPrice" step="0.01" required><br>
            <label for="newDescription">Description:</label>
            <input type="text" id="newDescription" name="newDescription"><br>
            <button type="submit" name="addMenuItem">Add Item</button>
        </form>
    </div>
</div>

<div id="reviews">
    <h2>Reviews</h2>
    <table class="review-table">
        <thead>
        <tr>
            <th class="smaller-text">Customer</th>
            <th>Rating</th>
            <th class="bigger-text">Review</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Query the database to retrieve reviews for the shop_username
        $sql = "SELECT c_username, rating, review_text FROM Reviews WHERE shop_username = ?";
        $stmt = $this->db->dbConnector->prepare($sql);
        $stmt->bind_param("s", $this->loggedInUser);
        $stmt->execute();
        $stmt->bind_result($c_username, $rating, $review_text);
        while ($stmt->fetch()) {
            echo "<tr>";
            echo "<td class='smaller-text'>$c_username</td>";
            echo "<td>$rating</td>";
            echo "<td class='bigger-text'>$review_text</td>";
            echo "</tr>";
        }
        $stmt->close();
        ?>
        </tbody>
    </table>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        toggleSection('about'); // Automatically toggle into the "About" section on page load

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

    function toggleSection(sectionId) {
        const sections = document.querySelectorAll('.form-container, .menu-container, #reviews');
        const navbarLinks = document.querySelectorAll('.navbar a');
        sections.forEach(function(section) {
            if (section.id === sectionId) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
        navbarLinks.forEach(function(link) {
            if (link.getAttribute('onclick').includes(sectionId)) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }
</script>

</body>
</html>