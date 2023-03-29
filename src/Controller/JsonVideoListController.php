<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonVideoListController implements RequestHandlerInterface
{

    public function __construct(private VideoRepository $repository)
    {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = array_map(function(Video $video): array {
            return [
                'url' => $video->url,
                'title' => $video->title,
                'file_path' => "/img/uploads/" . $video->getFilePath(),
            ];
        },$this->repository->allVideos());

        return new Response(200, [
            'Content-Type' => 'application/json'
        ], json_encode($videoList));
    }
}