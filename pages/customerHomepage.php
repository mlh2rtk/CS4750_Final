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
    </style>
</head>
<body>

<!-- Navigation bar -->
<div class="navbar">
    <a href="#" class="active" onclick="toggleSection('profile')">Profile</a>
    <a href="#" onclick="toggleSection('searchDrink')">Search Drink</a>
    <a href="#" onclick="toggleSection('searchCompany')">Search Company</a>
</div>

<div class="form-container" id="profile">
    <h2 class="form-title">Profile</h2>
    <!-- Profile content goes here -->
</div>

<div class="form-container" id="searchDrink">
    <h2 class="form-title">Search Drink</h2>
    <div class="search-bar-container">
        <div class="search-bar">
            <input type="text" placeholder="Search Drink...">
        </div>
        <button type="button">Search</button>
    </div>
    <!-- Search drink content goes here -->
</div>

<div class="form-container" id="searchCompany">
    <h2 class="form-title">Search Company</h2>
    <div class="search-bar-container">
        <div class="search-bar">
            <input type="text" placeholder="Search Company...">
        </div>
        <button type="button">Search</button>
    </div>
    <!-- Search company content goes here -->
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
</script>

</body>
</html>
