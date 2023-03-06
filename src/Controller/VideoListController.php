<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoListController implements Controller
{

    public function __construct(private VideoRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $video_list = $this->repository->allVideos();
        require_once __DIR__ . "/../../view/video-list.php";
    }
}