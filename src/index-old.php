<?php
require 'vendor/autoload.php';
require 'Database/Connection.php';
require 'Controllers/SubjectController.php';
require 'Core/Router.php';

use App\Database\Connection;
use App\Core\Router;

$connection = new Connection();
$connection->connect();

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Router($method, $path);
$router->dispatch();


