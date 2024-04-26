<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Split Screen Links</title>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }
    .container {
        display: flex;
        height: 100%;
    }
    .link {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        text-decoration: none;
        color: #fff;
        transition: background-color 0.3s ease;
    }
    .link-customer {
        background-color: #3498db; /* Blue color for Customer link */
    }
    .link-business {
        background-color: #ff8c00; /* UVA Orange color for Business link */
    }
    .link:hover {
        opacity: 0.8;
    }
</style>
</head>
<body>
    <div class="container">
        <a href="?user=customer" class="link link-customer">Customer</a>
        <a href="?user=business" class="link link-business">Business</a>
    </div>
</body>
</html>
