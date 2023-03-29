<?php

namespace Alura\Mvc\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginFormController implements RequestHandlerInterface
{
    public function __construct(private Engine $templates)
    {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        if(array_key_exists('Logged', $_SESSION) && $_SESSION['Logged'] === true){
            return new Response(302, [
                'Location' => '/'
            ]);
        }
        
        return new Response(200, [], $this->templates->render('login-form'));
    }
}