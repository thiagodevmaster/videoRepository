<?php

use Alura\Mvc\Controller\{Controller, Error404Controller};
use Alura\Mvc\Repository\{UserRepository, VideoRepository};
use Alura\Mvc\Infraestructure\Persistence\ConnectionFactory;

require_once __DIR__ . '/../vendor/autoload.php';
session_start();
session_regenerate_id();

$pdo = ConnectionFactory::createConnection();
$videoRepository = new VideoRepository($pdo);
$userRepository = new UserRepository($pdo);

$routes = require_once __DIR__ . '/../config/routes.php';
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
    $controller = new $controllerClass($userRepository);
}else if (array_key_exists($key, $routes)){
    $controllerClass = $routes["$httpMethod|$pathInfo"];
    $controller = new $controllerClass($videoRepository);
}else{
    $controller = new Error404Controller();
}
/**
 * @var Controller $controller
 **/
$controller->processaRequisicao();
