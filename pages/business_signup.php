<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Business Signup</h5>
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter username">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" placeholder="Enter state">
                            </div>
                            <div class="form-group">
                                <label for="zipcode">Zipcode</label>
                                <input type="text" class="form-control" id="zipcode" placeholder="Enter zipcode">
                            </div>
                            <div class="form-group">
                                <label for="streetAddress">Street Address</label>
                                <input type="text" class="form-control" id="streetAddress" placeholder="Enter street address">
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" placeholder="Enter city">
                            </div>
                            <div class="form-group">
                                <label for="hoursOfOperation">Hours of Operation</label>
                                <div class="row">
                                    <div class="col">
                                        <label for="monday">Monday</label>
                                        <input type="text" class="form-control" id="monday" placeholder="Enter hours for Monday">
                                    </div>
                                    <div class="col">
                                        <label for="tuesday">Tuesday</label>
                                        <input type="text" class="form-control" id="tuesday" placeholder="Enter hours for Tuesday">
                                    </div>
                                    <div class="col">
                                        <label for="wednesday">Wednesday</label>
                                        <input type="text" class="form-control" id="wednesday" placeholder="Enter hours for Wednesday">
                                    </div>
                                    <div class="col">
                                        <label for="thursday">Thursday</label>
                                        <input type="text" class="form-control" id="thursday" placeholder="Enter hours for Thursday">
                                    </div>
                                    <div class="col">
                                        <label for="friday">Friday</label>
                                        <input type="text" class="form-control" id="friday" placeholder="Enter hours for Friday">
                                    </div>
                                    <div class="col">
                                        <label for="saturday">Saturday</label>
                                        <input type="text" class="form-control" id="saturday" placeholder="Enter hours for Saturday">
                                    </div>
                                    <div class="col">
                                        <label for="sunday">Sunday</label>
                                        <input type="text" class="form-control" id="sunday" placeholder="Enter hours for Sunday">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>