<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoListController extends ViewController implements Controller
{

    public function __construct(private VideoRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $video_list = $this->repository->allVideos();
        $this->renderHTML('video-list', [
            'video_list' => $video_list
        ]);
    }
}