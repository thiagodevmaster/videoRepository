<?php 
$this->layout('layout');
/**@var \Alura\Mvc\Entity\Video[] $video_list*/
?>
<ul class="videos__container" alt="videos alura">
    <?php foreach ($video_list as $video):?>
        <?php if(str_starts_with($video->url, 'http')):?>
            <li class="videos__item">
                <?php if($video->getFilePath() !== null):  ?>
                    <a href="<?= $video->url; ?>">
                        <img src="/img/uploads/<?= $video->getFilePath();?>" alt="tumbnail" style="width: 100%; height: 100%">
                    </a>
                <?php else: ?>
                    <iframe width="100%" height="72%" src="<?= $video->url;?>"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    <?php endif; ?>
                    <div class="descricao-video">
                        <img src="img/logo.png" alt="logo canal alura">
                        <h3><?= $video->title;?></h3>
                        <div class="acoes-video">
                            <a href="/editar-video?id=<?= $video->id;?>">Editar</a>
                            <?php if($video->getFilePath() !== null):?>
                                <a href="/remover-capa?id=<?= $video->id;?>">Remover Capa</a>
                            <?php endif; ?>
                            <a href="/excluir-video?id=<?= $video->id;?>">Excluir</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
    <?php endforeach;?>
</ul>
