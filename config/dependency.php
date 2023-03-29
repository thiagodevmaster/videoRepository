<?php

use Alura\Mvc\Infraestructure\Persistence\ConnectionFactory;
use DI\ContainerBuilder;
use League\Plates\Engine;
use Psr\Container\ContainerInterface;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function(): PDO{
        $connection = ConnectionFactory::createConnection();
        return $connection;
    },
    Engine::class => function(){
        $templatesPath = __DIR__ . '/../view';
        return new Engine($templatesPath);
    }
]);

/**
 * @var ContainerInterface $container;
 */
$container = $builder->build();

return $container;