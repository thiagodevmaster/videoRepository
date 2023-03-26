<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class RemoveCoverController implements Controller
{
    public function __construct(private VideoRepository $repository)
    {
        
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if($id === false){
            header('Location: /?sucesso=0');
            return;
        }

        if($this->repository->removeCover($id) === false){
            header('Location: /?sucesso=0');
            return;
        }
        
        header('Location: /?sucesso=1');
    }
}