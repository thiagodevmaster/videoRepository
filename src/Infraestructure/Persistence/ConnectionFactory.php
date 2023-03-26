<?php

namespace Alura\Mvc\Infraestructure\Persistence;

use PDO;
use PDOException;

class ConnectionFactory
{
    public static function createConnection(){

        try{
            $dir_path = __DIR__ . '/../../../banco.sqlite';
            $pdo = new PDO("sqlite:$dir_path");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $error){
            echo "ERROR => " . $error->getMessage() . PHP_EOL;
            exit(); 
        }
        return $pdo;
    }
}