<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewJsonVideoController implements RequestHandlerInterface
{

    public function __construct(private VideoRepository $repository)
    {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        //$request = file_get_contents('php://input');
        $request = $request->getBody()->getContents();

        $videoData = json_decode($request, true);
        $video = new Video($videoData['url'], $videoData['title']);
        $this->repository->addVideo($video);

        return new Response(401);
    }
}