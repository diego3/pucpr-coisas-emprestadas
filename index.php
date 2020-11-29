<?php
//echo phpinfo();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ("vendor/autoload.php");

use App\Application;

$app = new Application([
    "router" => require "routes.php"
]);
$app->start();

