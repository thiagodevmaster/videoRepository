<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;

class LoginController implements Controller
{

    public function __construct(private UserRepository $repository)
    {      
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $user = $this->repository->findByEmail($email);
        $correctPassword = password_verify($password, $user['password']);

        if($correctPassword){
            $_SESSION['Logged'] = true;
            header('Location: /');
        }else{
            header('Location: /login?success=0');
        }
    }
}