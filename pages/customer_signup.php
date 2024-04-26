<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login and Signup Forms</title>
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
    <h1 class="form-title">Customer</h1>

    <div class="form-section">
        <div class="form-container">
            <h2 class="form-title">Login</h2>
            <form id="loginForm" action="?command=login&user=customer" method="post">
                <div class="form-group">
                    <label for="loginUsername">Username</label>
                    <input type="text" class="form-control" id="loginUsername" name='loginUsername' placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" class="form-control" id="loginPassword" name='loginPassword' placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>

        <div class="form-container">
            <h2 class="form-title">Sign Up</h2>
            <form id="signupForm" action="?command=signup&user=customer" method="post">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" name='firstName' placeholder="Enter first name" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name='lastName'placeholder="Enter last name" required>
                </div>
                <div class="form-group">
                    <label for="signupUsername">Username</label>
                    <input type="text" class="form-control" id="signupUsername" name='signupUsername' placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="signupPassword">Password</label>
                    <input type="password" class="form-control" id="signupPassword" name='signupPassword' placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="tel" class="form-control" id="phoneNumber" name='phone' placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name='email' placeholder="Enter email" required>
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
            var firstName = document.getElementById('firstName').value.trim();
            var lastName = document.getElementById('lastName').value.trim();
            var username = document.getElementById('signupUsername').value.trim();
            var password = document.getElementById('signupPassword').value.trim();
            var phoneNumber = document.getElementById('phoneNumber').value.trim();
            var email = document.getElementById('email').value.trim();

            if (!firstName || !lastName || !username || !password || !phoneNumber || !email) {
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
