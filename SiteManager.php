<?php
class SiteManager{
    public $db;
    public function __construct(){
        $this->db = new Database();
    }
    public function run() {

        $command = isset($_GET['command']) ? $_GET['command'] : 'welcome';

        switch ($command) {
            case 'customer_signup':
                $this->customer_signup();
                break;
            case 'business_signup':
                $this->business_signup();
                break;
            case 'signup':
                $this->signup();
                break;
            case 'business_submit':
                $this->business_submit();
            case 'customer_submit':
                $this->customer_submit();
            default:
                $this->welcome();

        }
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
?>