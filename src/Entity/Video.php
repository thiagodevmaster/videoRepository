<?php

namespace Alura\Mvc\Entity;

use http\Exception;

class Video
{
    public readonly string $url;
    public readonly string $title;
    public readonly int $id;
    private ?string $filePath = null;

    public function __construct(string $url, string $title)
    {
        $this->setUrl($url);
        $this->title = $title;
    }

    private function setUrl(string $url)
    {
        if(filter_var($url, FILTER_VALIDATE_URL) === false){
            throw new \InvalidArgumentException();
        }else{
            $this->url = $url;
        }
    }

    public function setId(int $id):void
    {
        $this->id = $id;
    }

    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }
}