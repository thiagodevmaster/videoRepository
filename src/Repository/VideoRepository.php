<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

class VideoRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function addVideo(Video $video): bool
    {
        $sql = 'INSERT INTO videos (url, title) VALUES (?, ?);';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $video->url);
        $statement->bindValue(2, $video->title);

        return $statement->execute();
    }

    public function removeVideo(int $id): bool
    {
        $query = 'DELETE FROM videos WHERE id=?;';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(1, $id);

        return $statement->execute();
    }

    public function updateVideo(Video $video): bool
    {
        $sql = 'UPDATE videos SET url=:url, title=:title WHERE id=:id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':url', $video->url);
        $statement->bindValue(':title', $video->title);
        $statement->bindValue(':id', $video->id, PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * @return Video[]
     */
    public function allVideos(): array
    {
        $list_Videos = $this->pdo->query("SELECT * FROM videos;")
            ->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function (array $videoData) {
            $video = new Video($videoData['url'], $videoData['title']);
            $video->setId($videoData['id']);
            return $video;
            }, $list_Videos
        );
    }

    public function find(int $id): Video
    {
        $statement = $this->pdo->prepare("SELECT * FROM videos WHERE id = ?;");
        $statement->bindValue(1, $id, PDO::PARAM_INT);
        $statement->execute();
        $videoData = $statement->fetch(\PDO::FETCH_ASSOC);
        $video = new Video($videoData['url'], $videoData['title']);

        return $video;
    }
}