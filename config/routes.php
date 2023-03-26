<?php

use Alura\Mvc\Controller\FormController;
use Alura\Mvc\Controller\JsonVideoListController;
use Alura\Mvc\Controller\LoginController;
use Alura\Mvc\Controller\LoginFormController;
use Alura\Mvc\Controller\LogoutController;
use Alura\Mvc\Controller\NewJsonVideoController;
use Alura\Mvc\Controller\RemoveCoverController;
use Alura\Mvc\Controller\VideoAddController;
use Alura\Mvc\Controller\VideoEditController;
use Alura\Mvc\Controller\VideoListController;
use Alura\Mvc\Controller\VideoRemoveController;

return [
    'GET|/' => VideoListController::class,
    'GET|/novo-video' => FormController::class,
    'POST|/novo-video' => VideoAddController::class,
    'GET|/editar-video' => FormController::class,
    'POST|/editar-video' => VideoEditController::class,
    'GET|/excluir-video' => VideoRemoveController::class,
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginController::class,
    'GET|/logout' => LogoutController::class,
    'GET|/remover-capa' => RemoveCoverController::class,
    'GET|/videos-json' => JsonVideoListController::class,
    'POST|/videos' => NewJsonVideoController::class,
];