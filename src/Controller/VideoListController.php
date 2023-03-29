<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoListController implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $repository, private Engine $template)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $video_list = $this->repository->allVideos();
        return new Response(200, [], $this->template->render('video-list', [
            'video_list' => $video_list
        ]));
    }
}