<?php

use Alura\Mvc\Infraestructure\Persistence\ConnectionFactory;

require_once "vendor/autoload.php";

$pdo = ConnectionFactory::createConnection();

$email = $argv[1];
$password = $argv[2];
$hash = password_hash($password, PASSWORD_ARGON2ID);

$sql = "INSERT INTO users (email, password) VALUES (?, ?);";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $email);
$statement->bindValue(2, $hash);
$statement->execute();