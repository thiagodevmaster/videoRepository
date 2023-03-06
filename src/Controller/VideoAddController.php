<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class VideoAddController implements Controller
{
    public function __construct(private VideoRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
            $titulo = filter_input(INPUT_POST, 'titulo');

            if ($url === false || $titulo === false){
                header("Location: /?sucesso=0");
                exit();
            }

            if($this->repository->addVideo(new Video($url, $titulo)) === true){
                header("Location: /?sucesso=1");
            }else{
                header("Location: /?sucesso=0");
            }
        }
    }
}