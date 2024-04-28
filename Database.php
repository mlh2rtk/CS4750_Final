<?php
/**
 * Database Class
 *
 * Contains connection information to query PostgresSQL.
 */


class Database {
    public $dbConnector;

    /**
     * Constructor
     *
     * Connects to PostgresSQL
     */
    public function __construct() {
        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["pass"];
        $port = Config::$db["port"];

        $this->dbConnector = new mysqli($host, $user, $password, $database, $port);

    }
    public function drop_tables_if_exists(){
        // Drop tables with foreign key constraints referencing Menu_items
        $this->dbConnector->query('DROP TABLE IF EXISTS Orders_to_Customers;');

        // Drop tables with foreign key constraints referencing Location_Parent_Company
        $this->dbConnector->query('DROP TABLE IF EXISTS Orders_to_Shops;');
        //$this->dbConnector->query('DROP TABLE IF EXISTS Shop_Owner;');

        // Drop tables with foreign key constraints referencing Location
        $this->dbConnector->query('DROP TABLE IF EXISTS Orders;');

        // Drop Customer table
        //$this->dbConnector->query('DROP TABLE IF EXISTS Customer;');
    }





    public function make_tables(){
        $res = $this->dbConnector->query('create sequence if not exists userrating_seq;');
        $res = $this->dbConnector->query(  'CREATE TABLE IF NOT EXISTS `Customer`(first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, username VARCHAR(50) NOT NULL, pass VARCHAR(500) NOT NULL, email VARCHAR(50) NOT NULL, phone VARCHAR(10), PRIMARY KEY(username));');
        $res = $this->dbConnector->query(  "CREATE TABLE IF NOT EXISTS `Location`(location_id INT AUTO_INCREMENT, state CHAR(2) NOT NULL , zip_code INT NOT NULL CHECK ( zip_code between 0 and 99999) ,street_address VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, PRIMARY KEY(location_id));");
        /// Repeated 3
        $res = $this->dbConnector->query(  "CREATE TABLE IF NOT EXISTS `Shop_Owner` (shop_username VARCHAR(50) NOT NULL, location_id INT, password VARCHAR(500) NOT NULL, PRIMARY KEY(shop_username), FOREIGN KEY (location_id) REFERENCES Location(location_id));");
        $res = $this->dbConnector->query(  "CREATE TABLE IF NOT EXISTS `Time_of_operation`( shop_username VARCHAR(50) NOT NULL, dayOfWeek VARCHAR(10) NOT NULL, startTime TIME, endTime TIME, PRIMARY KEY(shop_username, dayOfWeek), FOREIGN KEY (shop_username) REFERENCES Shop_Owner(shop_username));");
        $res = $this->dbConnector->query(  "CREATE TABLE IF NOT EXISTS Location_Parent_Company (
            parent_name VARCHAR(50),
            location_id INT,
            PRIMARY KEY (parent_name, location_id),
            FOREIGN KEY (location_id) REFERENCES Location(location_id));
            ");
        $res = $this->dbConnector->query( 'CREATE TABLE IF NOT EXISTS `Menu_items`(drink_id INT AUTO_INCREMENT, drink_name VARCHAR(50) NOT NULL, price FLOAT(2) NOT NULL, description VARCHAR(255) NOT NULL, parent_name VARCHAR(50), PRIMARY KEY(drink_id),
        FOREIGN KEY (parent_name) REFERENCES Location_Parent_Company(parent_name));
        ');
        $res = $this->dbConnector->query(  'CREATE TABLE IF NOT EXISTS `Reviews`(c_username VARCHAR(50) NOT NULL, shop_username VARCHAR(50) NOT NULL, review_text VARCHAR(255), rating INT CHECK (rating between 0 and 5), PRIMARY KEY(c_username, shop_username), FOREIGN KEY(c_username) REFERENCES Customer(username), FOREIGN KEY(shop_username) REFERENCES Shop_Owner(shop_username));');
        $res = $this->dbConnector->query(  'CREATE TABLE IF NOT EXISTS `Order`(order_id INT AUTO_INCREMENT NOT NULL, drink_id INT, FOREIGN KEY (drink_id) REFERENCES Menu_items(drink_id), PRIMARY KEY(order_id))');
        $res = $this->dbConnector->query(  'CREATE TABLE IF NOT EXISTS `Orders_to_Customers`(order_id INT, c_username VARCHAR(50), PRIMARY KEY (c_username, order_id), FOREIGN KEY (order_id) REFERENCES `Order`(order_id), FOREIGN KEY (c_username) REFERENCES Customer(username));');
        $res = $this->dbConnector->query( 'CREATE TABLE IF NOT EXISTS `Orders_to_Shops`(order_id INT, shop_username VARCHAR(50), FOREIGN KEY (order_id) REFERENCES `Order`(order_id), FOREIGN KEY (shop_username) REFERENCES Shop_Owner(shop_username));');

    }
    /**
     * Query
     *
     * Makes a query to posgres and returns an array of the results.
     * The query must include placeholders for each of the additional
     * parameters provided.
     */
    /*public function query($query, ...$params) {
        $res = pg_query_params($this->dbConnector, $query, $params);

        if ($res === false) {
            echo pg_last_error($this->dbConnector);
            return false;
        }

        return pg_fetch_all($res);
    }
}
*/
}
