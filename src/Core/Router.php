<?php

namespace App\Core;

class Router
{
  private $routes = [];
  private $method;
  private $route;
  private $controllerAction;

  public function __construct($method, $route) 
  {
    $this->method = $method;
    $this->route = $route;
  }

  public function add($controllerAction)
  {
    $this->routes[] = [
      'method' => $this->method,
      'route' => $this->route,
      'controllerAction' => $controllerAction
    ];
  }

  private function isApiRoute(): bool
  {
    if(substr($this->route, 0, 7) == '/public') {
      $this->route = substr($this->route, 7);
      return true;
    }
    return false;
  }

  public function dispatch()
  {
    $isApiRoute = $this->isApiRoute();
    if($isApiRoute) {
      $path = explode('/', $this->route);
      if($this->method === 'POST') {
        $controllerFile = ucfirst($path[1]) . 'Controller.php';
        $controllerName = ucfirst($path[1]) . 'Controller';
        $controllerMethod = $path[2];
        $controllerPath = realpath(__DIR__ . '/../Controllers/' . $controllerFile);
        
        if(file_exists($controllerPath)) {
          require_once $controllerPath;
          
          $controllerClass = "Api\\Controllers\\$controllerName";
          //$controller = new $controllerName();
          // $controller->$controllerMethod();
        }
        // require_once __DIR__ . '/../Controllers/' . $controllerFile;
        // $controller = new $controllerName();
        // $controller->$path[2];
      }

      
      // $controllerName = $path[]
    }
    // echo $this->route;
    // foreach ($this->routes as $route) {
    //   $matches = [];
    //   if ($method === $route['method'] && preg_match($this->convertToRegex($route['route']), $uri . $matches)) {
    //     $controllerAction = explode('@', $route['controllerAction']);
    //     $controllerName = $controllerAction[0];
    //     $methodName = $controllerAction[1];

    //     $controllerClass = "App\\Controllers\\$controllerName";
    //     if (class_exists($controllerClass) && method_exists($controllerClass, $methodName)) {
    //       $controller = new $controllerClass();
    //       unset($matches[0]);
    //       return call_user_func_array([$controller, $methodName], array_values($matches));
    //     } else {
    //       header("HTTP/1.1 404 Not Found");
    //       echo "Controller or Method Not Found";
    //       return;
    //     }
    //   }
    // }

    // header("HTTP/1.1 404 Not Found");
    // echo "Route Not Found";
  }

  private function convertToRegex($route)
  {
    return "/^" . preg_replace('/\{[a-zA-Z_]+\}/', '([a-zA-Z0-9_\-]+)', $route) . "$/";
  }
}