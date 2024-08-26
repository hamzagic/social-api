<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;
use App\Controllers\SubjectController;
use App\Controllers\GenreController;

$connection = new Connection();
$connection->connect();

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
  '/subject/create' => [SubjectController::class, 'create'],
  '/subject/find-one' => [SubjectController::class, 'findById'],
  '/subject/find-name' => [SubjectController::class, 'findByName'],
  '/genre/create' => [GenreController::class, 'create'],
];

if(isApiRoute($path)) {
  $route = substr($path, 7);
} else {
  echo "Invalid URL";
}

function isApiRoute($path): bool
{
  if(substr($path, 0, 7) == '/public') {
    return true;
  }
  return false;
}

function route($routes, $route, $connection)
{
  if(array_key_exists($route, $routes)) {
    $controller = $routes[$route];
    $method = $routes[$route][1];
    
    if(class_exists($controller[0]) && method_exists($controller[0], $method)) {
      $controller_instance = new $controller[0]($connection);
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = file_get_contents('php://input');
        $controller_instance->$method($data);
      }
      if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller_instance->$method();
      }
    } else {
      echo "Invalid class";
    }
  } else {
    http_response_code(404);
    echo "Route not found";
  }
}

route($routes, $route, $connection);



