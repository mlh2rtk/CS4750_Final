<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
spl_autoload_register(function ($classname) {
    include "$classname.php";
});
$siteConstructor = new SiteManager();
$siteConstructor->run();
