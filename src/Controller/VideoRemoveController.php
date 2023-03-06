<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;


class VideoRemoveController implements Controller
{
    public function __construct(private VideoRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if($this->repository->removeVideo($id) === true){
            header("Location: /?sucesso=1");
        }else {
            header("Location: /?sucesso=0");
        }
    }
}