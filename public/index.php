<?php

use Alura\Mvc\Controller\Error404Controller;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

require_once __DIR__ . '/../vendor/autoload.php';
session_start();
session_regenerate_id();

$routes = require_once __DIR__ . '/../config/routes.php';
/**
 * @var ContainerInterface $dependencyContainer;
 */
$dependencyContainer = require_once __DIR__ . '/../config/dependency.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$isLoginRoute = $pathInfo === '/login';
if(!array_key_exists('Logged', $_SESSION) && !$isLoginRoute){
    header('Location: /login');
    return;
}

$key = "$httpMethod|$pathInfo";

if($pathInfo === '/login' and $httpMethod === 'POST'){
    $controllerClass = $routes["$httpMethod|$pathInfo"];
    $controller = $dependencyContainer->get($controllerClass);
}else if (array_key_exists($key, $routes)){
    $controllerClass = $routes["$httpMethod|$pathInfo"];
    $controller = $dependencyContainer->get($controllerClass);
}else{
    $controller = new Error404Controller();
}

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();

/**
 * @var RequestHandleInteface $controller
 **/
$response = $controller->handle($request);

http_response_code($response->getStatusCode());
// Emit headers iteratively:
     foreach ($response->getHeaders() as $name => $values) {
             foreach ($values as $value) {
                 header(sprintf('%s: %s', $name, $value), false);
             }
         }

echo $response->getBody();
