<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use finfo;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoEditController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $queryParams = $request->getQueryParams();
        $queryParamsPost = $request->getParsedBody();

        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        $new_url = filter_var($queryParamsPost['url']);
        $new_title = filter_var($queryParamsPost['titulo']);

        if($id === false || $new_title === false || $new_url === false){
            $this->addErrorMessage('Invalid data, check and try again');
            return new Response(302, [
                'Location' => '/editar-video'
            ]);
        }

        $video = new Video($new_url, $new_title);
        $video->setId($id);

        // if($_FILES['image']['error'] === UPLOAD_ERR_OK){
        //     $fInfo = new finfo(FILEINFO_MIME_TYPE);
        //     $mimeType = $fInfo->file($_FILES['image']['tmp_name']);
            
        //     if(str_starts_with($mimeType, 'image/')){
        //         $fileTempName = uniqid('upload_') . '_' . basename($_FILES['image']['name']);
        //         move_uploaded_file(
        //             $_FILES['image']['tmp_name'],
        //             __DIR__ . '/../../public/img/uploads/' . $fileTempName
        //         );
        //         $video->setFilePath($fileTempName);
        //     }
        // }

        $files = $request->getUploadedFiles();
        /***
         * @var UploadedFileInterface $uploadImage;
         */
        $uploadImage = $files['image'];
        if($uploadImage->getError() === UPLOAD_ERR_OK){
            $fInfo = new finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadImage->getStream()->getMetadata('uri');
            $mimeType = $fInfo->file($tmpFile);
            
            if(str_starts_with($mimeType, 'image/')){
                $fileTempName = uniqid('upload_') . '_' . pathinfo($uploadImage->getClientFilename(), PATHINFO_BASENAME);
                // move_uploaded_file(
                //     $_FILES['image']['tmp_name'],
                //     __DIR__ . '/../../public/img/uploads/' . $fileTempName
                // );

                $uploadImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $fileTempName);
                $video->setFilePath($fileTempName);
            }
        }

        
        if($this->repository->updateVideo($video) === true){
            $this->addSucessMessage('Video modificado com sucesso.');
            return new Response(302, [
                'Location' => '/'
            ]);
        }else{
            $this->addErrorMessage('Edit failed');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}