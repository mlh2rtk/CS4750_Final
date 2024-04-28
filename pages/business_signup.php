<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Login and Signup Forms</title>
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
            max-width: 400px;
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
        .form-section {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
            max-width: 800px;
            margin-top: 20px;
        }
        .form-section > .form-container {
            margin: 0 10px;
        }
    </style>
</head>
<body>

<!-- Inside the <body> tag of login.php -->
<?php
// Check if an error message exists in the URL query string
if(isset($_GET['error']) && $_GET['error'] === 'incorrect_credentials') {
    // Display an alert to the user indicating incorrect password
    echo '<script>alert("Incorrect credentials. Please try again.");</script>';
}
?>

<h1 class="form-title">Business</h1>

<div class="form-section">
    <div class="form-container">
        <h2 class="form-title">Login</h2>
        <form id="loginForm" action="?command=check_login&user=business" method="post">
            <div class="form-group">
                <label for="loginUsername">Username</label>
                <input type="text" class="form-control" id="loginUsername" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" class="form-control" id="loginPassword" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <div class="form-container">
        <h2 class="form-title">Sign Up</h2>
        <form id="signupForm" action="?command=signup&user=business" method="post">
            <div class="form-group">
                <label for="signupUsername">Username</label>
                <input type="text" class="form-control" id="signupUsername" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="signupPassword">Password</label>
                <input type="password" class="form-control" id="signupPassword" placeholder="Enter password" required>
            </div>
            <div class="form-group">
                <label for="companyName">Company Name</label>
                <input type="text" class="form-control" id="companyName" placeholder="Enter company name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" placeholder="Enter street address" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" placeholder="Enter city" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="state">State</label>
                    <input type="text" class="form-control" id="state" placeholder="Enter state" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="zipCode">Zip</label>
                    <input type="text" class="form-control" id="zipCode" placeholder="Zip code" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        var username = document.getElementById('loginUsername').value.trim();
        var password = document.getElementById('loginPassword').value.trim();

        if (!username || !password) {
            alert('Please fill out all fields in the login form.');
            event.preventDefault();
        }
    });

    document.getElementById('signupForm').addEventListener('submit', function(event) {
        var username = document.getElementById('signupUsername').value.trim();
        var password = document.getElementById('signupPassword').value.trim();
        var confirmPassword = document.getElementById('confirmPassword').value.trim();
        var companyName = document.getElementById('companyName').value.trim();
        var address = document.getElementById('address').value.trim();
        var city = document.getElementById('city').value.trim();
        var state = document.getElementById('state').value.trim();
        var zipCode = document.getElementById('zipCode').value.trim();

        if (!username || !password || !confirmPassword || !companyName || !address || !city || !state || !zipCode) {
            alert('Please fill out all fields in the signup form.');
            event.preventDefault();
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
