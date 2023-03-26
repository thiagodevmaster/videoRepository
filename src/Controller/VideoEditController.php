<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use finfo;

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

        if($_FILES['image']['error'] === UPLOAD_ERR_OK){
            $fInfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $fInfo->file($_FILES['image']['tmp_name']);
            
            if(str_starts_with($mimeType, 'image/')){
                $fileTempName = uniqid('upload_') . '_' . basename($_FILES['image']['name']);
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $fileTempName
                );
                $video->setFilePath($fileTempName);
            }
        }
        
        if($this->repository->updateVideo($video) === true){
            header("Location: /?sucesso=1");
        }else{
            header("Location: /?sucesso=0");
        }
    }
}