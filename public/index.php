<?php 
session_start();
use App\Autoloader;
use App\core\Router;

include "../Autoloader.php";
Autoloader::register();

$route = new Router();
$route->routes();
?>