<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private UserRepository $repository)
    {      
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getParsedBody();

        $email = filter_var($queryParams['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($queryParams['password']);

        $user = $this->repository->findByEmail($email);
        $correctPassword = password_verify($password, $user['password']);

        if($correctPassword){
            $_SESSION['Logged'] = true;
            $this->addSucessMessage("Login realizado com sucesso");
            return new Response(302, [
                'Location' => '/'
            ]);
        }else{
            // enviar um mensagem para /login
            $this->addErrorMessage('Usuário ou senha inválido.');
            return new Response(302, [
                'Location' => '/login'
            ]);
        }
    }
}