<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RemoveCoverController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository)
    {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if($id === false){
            $this->addErrorMessage("Invalid Cover");
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        if($this->repository->removeCover($id) === false){
            $this->addErrorMessage('Removal failed');
            header('Location: /');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
        
        $this->addSucessMessage('skin successfully removed');
        return new Response(302, [
            'Location' => '/'
        ]);
    }
}