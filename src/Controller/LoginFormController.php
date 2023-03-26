<?php

namespace Alura\Mvc\Controller;

class LoginFormController extends ViewController implements Controller
{
    public function processaRequisicao(): void
    {

        if(array_key_exists('Logged', $_SESSION) && $_SESSION['Logged'] === true){
            header('Location: /');
            return;
        }
        $this->renderHTML('login-form');
    }
}