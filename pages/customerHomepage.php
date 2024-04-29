<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Homepage</title>
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
            max-width: 1000px; /* Adjust the max-width as needed */
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
        .search-bar-container {
            display: flex;
            align-items: center;
            max-width: 800px; /* Adjust the max-width as needed */
            margin: 20px auto;
        }
        .search-bar {
            flex: 1;
            margin-right: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
        }
        .search-bar input[type="text"] {
            width: calc(100% - 40px);
            margin-right: 10px;
            padding: 5px;
            border: none;
            outline: none;
        }
        .search-bar button {
            width: 80px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
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

<?php
// Check if add to cart form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCart"])) {
    // Retrieve the form data
    $drinkName = $_POST['drinkName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $parentName = $_POST['parentName'];
    $drinkId = $_POST['drinkId'];
    error_log($drinkId);
    // Update orders table
    $sql = "INSERT INTO orders (drink_id) VALUES (?)";
    $stmt = $this->db->dbConnector->prepare($sql);
    $stmt->bind_param("i", $drinkId);
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();

    // Update orders to customers
    $sql = "INSERT INTO orders_to_customers (order_id, drink_id) VALUES (?, ?)";
    $stmt = $this->db->dbConnector->prepare($sql);
    $stmt->bind_param("ii", $orderId, $drinkId);
    $stmt->execute();
    $stmt->close();
}
?>

<!-- Navigation bar -->
<div class="navbar">
    <a href="#" class="active" onclick="toggleSection('profile')">Profile</a>
    <a href="#" onclick="toggleSection('searchDrink')">Search Drink</a>
    <a href="#" onclick="toggleSection('searchCompany')">Search Company</a>
    <a href="#" onclick="toggleSection('reviews')">Reviews</a>
</div>

<!-- Profile Section -->
<div class="form-container" id="profile">
    <!-- Profile content will be dynamically loaded here via PHP -->
    <!-- Cart -->
    <div id="cart">

    </div>
    <!-- review -->
    <div id="reviews">
        <h2>Your Reviews</h2>
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
            $sql = "SELECT shop_username, rating, review_text FROM reviews WHERE c_username = ?";
            $stmt = $this->db->dbConnector->prepare($sql);
            $stmt->bind_param("s", $_SESSION['loggedInUser']);
            $stmt->execute();
            $stmt->bind_result($shop_username, $rating, $review_text);
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td class='smaller-text'>$shop_username</td>";
                echo "<td>$rating</td>";
                echo "<td class='bigger-text'>$review_text</td>";
                echo "</tr>";
            }
            $stmt->close();
            ?>
            </tbody>
        </table>
        <br><br>
    </div>
</div>

<!-- Search Drink Section -->
<div class="form-container" id="searchDrink">
    <h2 class="form-title">Search Drink</h2>
    <div class="search-bar-container">
        <div class="search-bar">
            <input type="text" id="drinkSearchInput" name="drinkSearchInput" placeholder="Search Drink...">
        </div>
        <button type="button" onclick="searchDrink()">Search</button>
    </div>
    <div id="searchResults"></div> <!-- This div will display search results -->
</div>

<!-- Search Company Section -->
<div class="form-container" id="searchCompany">
    <h2 class="form-title">Search Company</h2>
    <div class="search-bar-container">
        <div class="search-bar">
            <input type="text" id="companySearchInput" placeholder="Search Company...">
        </div>
        <button type="button" onclick="searchCompany()">Search</button>
    </div>
    <div id="searchCompanyResults"></div> <!-- This div will display search results -->
</div>

<!-- Reviews Section -->
<div class="form-container" id="reviews">
    <h2 class="form-title">Write a Review</h2>
    <form id="reviewForm">
        <div class="form-group">
            <label for="shopUsername">Shop Username:</label>
            <input type="text" id="shopUsername" name="shopUsername" placeholder="Enter shop username" required>
        </div>
        <div class="form-group">
            <label for="reviewText">Review Text:</label>
            <textarea id="reviewText" name="reviewText" placeholder="Enter your review" required></textarea>
        </div>
        <div class="form-group">
            <label for="rating">Rating (0-5):</label>
            <input type="number" id="rating" name="rating" min="0" max="5" required>
        </div>
        <input type="hidden" id="c_username" name="c_username" value="<?php echo $_SESSION['loggedInUser']?>">
        <button type="submit">Submit Review</button>
    </form>
</div>

<div>
    <a class="nav-link" href="?">Log out</a>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        toggleSection('profile'); // Initially show the Profile section
    });

    function toggleSection(sectionId) {
        const sections = document.querySelectorAll('.form-container');
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

    // Function to handle drink search
    function searchDrink() {
        const searchTerm = document.getElementById('drinkSearchInput').value.trim();

        // Make AJAX request to search for drinks
        if (searchTerm !== '') {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `pages/search_drink.php?q=${encodeURIComponent(searchTerm)}`, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('searchResults').innerHTML = xhr.responseText;
                } else {
                    console.error('Request failed. Status:', xhr.status);
                }
            };

            xhr.send();
        } else {
            alert('Please enter a search term.');
        }
    }

    // Function to handle company search
    function searchCompany() {
        const searchTerm = document.getElementById('companySearchInput').value.trim();

        // Make AJAX request to search for companies
        if (searchTerm !== '') {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `pages/search_company.php?q=${encodeURIComponent(searchTerm)}`, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('searchCompanyResults').innerHTML = xhr.responseText;
                } else {
                    console.error('Request failed. Status:', xhr.status);
                }
            };

            xhr.send();
        } else {
            alert('Please enter a search term.');
        }
    }

    // Function to handle review submission
    document.getElementById('reviewForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'pages/submit_review.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Review submitted successfully!');
                // Clear form fields after successful submission (optional)
                document.getElementById('shopUsername').value = '';
                document.getElementById('reviewText').value = '';
                document.getElementById('rating').value = '';
            } else {
                alert('Failed to submit review. Please try again.');
            }
        };
        xhr.send(formData);
    });
</script>

</body>
</html>
