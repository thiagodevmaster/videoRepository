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

class VideoAddController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        
        $queryParams = $request->getParsedBody();
        $url = filter_var($queryParams['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($queryParams['titulo']);

        if ($url === false || $titulo === false){
            $this->addErrorMessage('Incorrect data, check and try again.');
            return new Response(302, [
                'Location' => '/novo-video'
            ]);
        }

        $video = new Video($url, $titulo);
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

        if($this->repository->addVideo($video) === true){
            $this->addSucessMessage('Add Success!');
            return new Response(302, [
                'Location' => '/'
            ]);
        }else{
            $this->addErrorMessage('include failed');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
        
    }
}