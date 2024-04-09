<?php
/**
 * Configuration information
 * CS4640 Spring 2024
 *
 * Contains connection information for the local Docker
 * PostgresSQL database.  When uploading your code to the
 * CS4640 server, you can replace this file with another
 * configuration containing connection information found
 * on our course Canvas site.
 */


class Config {
    public static $db = [
        "host" => "localhost",
        "port" => 5432,
        "user" => "mlh2rtk_a",
        "pass" => "Spring2024",
        "database" => "mlh2rtk_a"
    ];
}
