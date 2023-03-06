<?php

use Alura\Mvc\Controller\FormController;
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
];