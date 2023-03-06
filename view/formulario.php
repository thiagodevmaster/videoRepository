<?php
require_once __DIR__ . '/inicio-html.php';
/**
 * @var $id;
 * @var \Alura\Mvc\Entity\Video $video;
 */
?>

    <main class="container">

        <form class="container__formulario"
              action=""
              method="post">
            <h2 class="formulario__titulo"><?= $id !== null ? 'Editar Vídeo' : 'Inserir Vídeo'; ?> </h2>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="url">Link embed</label>
                <input name="url"
                       value="<?= $id !== null ? $video->url : null;?>"
                       class="campo__escrita"
                       required
                       placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g"
                       id='url'
                />
            </div>


            <div class="formulario__campo">
                <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
                <input name="titulo"
                       value="<?= $id !== null ? $video->title : null; ?>"
                       class="campo__escrita"
                       required
                       placeholder="Neste campo, dê o nome do vídeo"
                       id='titulo'
                />
            </div>

            <input class="formulario__botao" type="submit" value="Enviar"/>
        </form>

    </main>
<?php
require_once __DIR__ . "/fim-html.php";