<?php
session_start();
spl_autoload_register(function ($classname) {
    include "$classname.php";
});
$siteConstructor = new SiteManager();
$siteConstructor->run();
?>