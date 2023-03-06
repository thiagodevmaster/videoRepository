<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class VideoEditController implements Controller
{
    public function __construct(private VideoRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $new_url = $_POST['url'];
        $new_title = $_POST['titulo'];

        if($id === false || $new_title === false || $new_url === false){
            header('Location: /?sucesso=0');
            exit();
        }

        $video = new Video($new_url, $new_title);
        $video->setId($id);

        if($this->repository->updateVideo($video) === true){
            header("Location: /?sucesso=1");
        }else{
            header("Location: /?sucesso=0");
        }
    }
}