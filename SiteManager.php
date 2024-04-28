<?php
class SiteManager{
    public $db;
    public $loggedInUser;

    public function __construct(){
        $this->db = new Database();
        $this->db->drop_tables_if_exists();
        $this->db->make_tables();
    }
    public function run() {
        $user = isset($_GET['user']) ?  $_GET['user'] : 'welcome';
        switch ($user) {
            case 'customer':
                $this->handle_customer();
                break;
            case 'business':
                $this->handle_business();
                break;
            default:
                $this->welcome();
                break;

        }
    }

    function handle_customer(){
        $command = isset($_GET['command']) ?  $_GET['command'] : 'home';
        switch ($command){
            case 'signup':
                $this->customer_signup();
                break;
            case 'login':
                $this->customer_login();
                break;
            case 'home':
                $this->split_screen_customer();
                break;
            case 'homepage':
                include("pages/customerHomepage.php");
                break;
        }
    }
    function customer_signup(){
        $statement = $this->db->dbConnector->prepare("INSERT INTO Customer(first_name, last_name, username, pass, email, phone)
                                   VALUES (?, ?, ?, ?, ?, ?);");
        $pass = password_hash($_POST['signupPassword'], PASSWORD_DEFAULT);
        $statement->bind_param('ssssss', $_POST['firstName'], $_POST['lastName'], $_POST['signupUsername'], $pass, $_POST['email'], $_POST['phone']);
        $statement->execute();
        $statement->close();
        $this->loggedInUser = $_POST['signupUsername'];
        header('Location: ?user=customer&command=homepage');

    }
    function customer_login(){
        $statement = $this->db->dbConnector->prepare("SELECT pass FROM Customer WHERE username=? ;");
        $statement->bind_param('s',$_POST['loginUsername']);
        $statement->bind_result($pass);
        $statement->execute();
        $statement->fetch();

        //correct password
        if(password_verify($_POST['loginPassword'], $pass) == true)
        {
            $this->loggedInUser = $_POST['loginUsername'];
            header("Location: ?user=customer&command=homepage");
        }
        else
        {
            header("Location: ?user=customer&error=incorrect_credentials");
        }
    }
    function split_screen_customer(){
        include('pages/customer_signup.php');
    }

    /* the beginning of the handling of business user

    //////////////////////////////////////////////
    //////////////////////////////////////////////
    /////////////////////////////////////////////
    */
    function handle_business(){
        $command = isset($_GET['command']) ?  $_GET['command'] : 'home';
        switch ($command){
            case 'signup':
                $this->business_signup();
                break;
            case 'login':
                $this->business_login();
                break;
            case 'home':
                $this->split_screen_business();
                break;
            case 'homepage':
                include("pages/businessHomepage.php");
                break;
        }
    }

    function business_signup(){

        // Prepare SQL statement to insert data into Location table
        $location_statement = $this->db->dbConnector->prepare("INSERT INTO Location (state, zip_code, street_address, city) VALUES (?, ?, ?, ?)");
        $location_statement->bind_param('siss', $_POST['state'], $_POST['zipCode'], $_POST['address'], $_POST['city']);
        $location_statement->execute();
        $location_id = $location_statement->insert_id; // Get the auto-generated location_id

        // Prepare SQL statement to insert data into Shop_Owner table
        $shop_owner_statement = $this->db->dbConnector->prepare("INSERT INTO Shop_Owner (shop_username, location_id, password) VALUES (?, ?, ?)");
        $pass = password_hash($_POST['signupPassword'], PASSWORD_DEFAULT);
        $shop_owner_statement->bind_param('sis', $_POST['signupUsername'], $location_id, $pass);
        $shop_owner_statement->execute();

        // Prepare SQL statement to insert data into Location_Parent_Company table
        $location_parent_statement = $this->db->dbConnector->prepare("INSERT INTO Location_Parent_Company (parent_name, location_id) VALUES (?, ?)");
        $location_parent_statement->bind_param('si', $_POST['companyName'], $location_id);
        $location_parent_statement->execute();

        // Close prepared statements
        $location_statement->close();
        $shop_owner_statement->close();
        $location_parent_statement->close();

        $this->loggedInUser = $_POST['signupUsername'];
        header('Location: ?user=business&command=homepage');

    }
    function business_login(){
        $statement = $this->db->dbConnector->prepare("SELECT password FROM Shop_Owner WHERE shop_username=? ;");
        $statement->bind_param('s',$_POST['loginUsername']);
        $statement->bind_result($pass);
        $statement->execute();
        $statement->fetch();

        //correct password
        if(password_verify($_POST['loginPassword'], $pass))
        {
            $_SESSION['loggedInUser'] = $_POST['loginUsername'];
            //$this->loggedInUser = $_POST['loginUsername'];
            header("Location: ?user=business&command=homepage");
        }
        else
        {
            header("Location: ?user=business&error=incorrect_credentials");
        }
    }

    function split_screen_business(){
        include('pages/business_signup.php');
    }
    /**
     * Write Review
     *
     * Adds a review for a shop from a customer.
     *
     * @param string $customerUsername The username of the customer leaving the review.
     * @param string $shopUsername The username of the shop being reviewed.
     * @param string $reviewText The text of the review.
     * @param int $rating The rating given by the customer (between 0 and 5).
     * @return bool True if the review was successfully added, false otherwise.
     */
    public function writeReview($customerUsername, $shopUsername, $reviewText, $rating) {
        $stmt = $this->dbConnector->prepare("INSERT INTO Reviews (c_username, shop_username, review_text, rating) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $customerUsername, $shopUsername, $reviewText, $rating);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Search Drink
     *
     * Searches for a drink by its name.
     *
     * @param string $drinkName The name of the drink to search for.
     * @return array|null An array of drink details if found, null otherwise.
     */
    public function searchDrink($drinkName) {
        $stmt = $this->dbConnector->prepare("SELECT * FROM Menu_items WHERE drink_name = ?");
        $stmt->bind_param("s", $drinkName);
        $stmt->execute();
        $result = $stmt->get_result();
        $drink = $result->fetch_assoc();
        $stmt->close();
        return $drink;
    }
    function welcome(){
        include('pages/welcome.php');
    }
}
