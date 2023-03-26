<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use finfo;

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

            $video = new Video($url, $titulo);
            if($_FILES['image']['error'] === UPLOAD_ERR_OK){
                $fInfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $fInfo->file($_FILES['image']['tmp_name']);
                
                if(str_starts_with($mimeType, 'image/')){
                    $fileTempName = uniqid('upload_') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
                    move_uploaded_file(
                        $_FILES['image']['tmp_name'],
                        __DIR__ . '/../../public/img/uploads/' . $fileTempName
                    );
                    $video->setFilePath($fileTempName);
                }
            }

            if($this->repository->addVideo($video) === true){
                header("Location: /?sucesso=1");
            }else{
                header("Location: /?sucesso=0");
            }
        }
    }
}