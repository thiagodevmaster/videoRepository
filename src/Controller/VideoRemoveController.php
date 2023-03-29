<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoRemoveController implements RequestHandlerInterface
{

    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $query = $request->getQueryParams();
        $id = filter_var($query['id'], FILTER_VALIDATE_INT);

        if($id === null || $id === false){
            $this->addErrorMessage('Video não encontrado.');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        if($this->repository->removeVideo($id) === true){
            $this->addSucessMessage('Video Removido com sucesso.');
            return new Response(302, [
                'Location' => '/'
            ]);
        }else {
            $this->addErrorMessage('Remove failed');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}