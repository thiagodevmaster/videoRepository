<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\User;
use Exception;
use PDO;

class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function addUser(User $user): bool
    {
        $sql = 'INSERT INTO users (email, password) VALUES (?, ?);';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user->getEmail());
        $statement->bindValue(1, $user->getPassword());
        
        return $statement->execute();
    }

    public function findByEmail(string $email)
    {
        try{
            $sql = "SELECT * FROM users WHERE email=?;";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $email);
            $statement->execute();    
        }catch(Exception $e){
            echo "ERRO: " . $e->getMessage();
            exit();
        }

        $userData = $statement->fetch(PDO::FETCH_ASSOC);
        return $userData;
    }


}