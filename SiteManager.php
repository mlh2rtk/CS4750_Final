<?php
class SiteManager{
    public $db;
    public function __construct(){
        $this->db = new Database();
        $this->db->make_tables();
        $this->db = $this->db->dbConnector;
    }
    public function run() {
        $user = isset($_GET['user']) ?  $_GET['user'] : 'welcome';
        switch ($user) {
            case 'customer':
                $this->handle_customer();
                break;
            case 'business':
                $this->handle_business();
            default:
                $this->welcome();

        }
    }
    function handle_customer(){
        $command = isset($_GET['command']) ?  $_GET['command'] : 'home';
        switch ($command){
            case 'signup':

                break;
            case 'login':

                break;
        }
    }
    function handle_business(){
        $command = isset($_GET['command']) ?  $_GET['command'] : 'home';
        switch ($command){
            case 'signup':

                break;
            case 'login':

                break;
        }
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
    
    function customer_submit(){

    }
    function customer_signup(){
        include('pages/customer_signup');
    }
    function business_submit(){

    }
    function welcome(){
        include('pages/welcome.php');
    }
    function business_signup(){
        include('pages/business_signup.php');
    }
    function signup(){
        include('pages/signup.php');
    }
}
