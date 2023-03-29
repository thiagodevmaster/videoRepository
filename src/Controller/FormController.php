<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FormController implements RequestHandlerInterface
{

    public function __construct(private VideoRepository $repository, private Engine $template)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        if(!empty($queryParams)){
            $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        }
       
        $video = [
            'url'=>'',
            'title'=>''
        ];
        if($id !== null || !empty($id)){
            $video = $this->repository->find($id);
        }

        return new Response(200, [], $this->template->render('formulario', [
            'video' => $video,
            'id' => $id
        ]));

    }
}