<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;

class FormController extends ViewController implements Controller
{
    public function __construct(private VideoRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $video = [
            'url'=>'',
            'title'=>''
        ];
        if($id !== null){
            $video = $this->repository->find($id);
        }

        $this->renderHTML('formulario', [
            'video' => $video
        ]);

    }
}