<?php 
session_start();
require_once('../models/Crud.php');

$db = new Crud();

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

if (isset($_GET['slug']) && !empty($_GET['slug'])) {
    if ($db->selectArticle($_GET['slug'])) {
        $article = $db->selectArticle($_GET['slug']);
    } else {
        header("Location: http://localhost/hardtec-blogweb");
    }
} else {
    header("Location: http://localhost/hardtec-blogweb");
}

if (isset($_GET['submit'])) {
    $slug = str_replace(' ', '-', lcfirst($_GET['titulo']));

    $dados = array(
        "titulo" => $_GET['titulo'],
        "categoria" => $_GET['categoria'],
        "conteudo" => $_GET['conteudo'],
        "slug" => $slug
    );
    
    if ($db->editArticle($dados)) {
        header("Location: http://localhost/hardtec-blogweb/index.php");
    }
}

?>
<!DOCTYPE html>

<html lang="pt-BR">
    <head>
        <!-- Title -->
        <title>Adicionar Post - HARDTEC</title>

        <!-- Meta TAGS -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="hardtech">
        <meta name="keywords" content="hardtech">

        <!-- CSS -->
        <link rel="stylesheet" href="../assets/css/slidershow.css">
        <link rel="stylesheet" href="../assets/css/main.css">
        <link href='https://cdn.jsdelivr.net/npm/froala-editor@3.0.6/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700|Roboto:400,700|Source+Sans+Pro:400,400i,600i&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php require_once('../views/header.php')?>
        <script src="../assets/js/salve.js"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
        <main class="addpost-main container">
            <section class="addpost-content">
                <div class="form">
                    <div class="addpost">
                        <div class="title">
                            <h2>Editar postagem</h2>
                        </div>
                        <form action="#">
                            <div class="row">
                                <div class="col">
                                    <label for="titulo">Título</label>
                                    <input type="text" name="titulo" id="titulo" placeholder="Digite o título da postagem" value="<?php echo $article->titulo; ?>">
                                </div>
                                <div class="col">
                                    <label for="categoria">Categoria</label>
                                    <select name="categoria" id="categoria">
                                    <?php foreach ($db->selectCategorys() as $category): ?>
                                        <option value="<?php echo $category->id_categoria; ?>"><?php echo $category->nome; ?></option>
                                    <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="conteudo">Conteúdo</label>
                                    <textarea name="conteudo" id="conteudo" cols="200" rows="25"><?php echo $article->conteudo; ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <input type="submit" value="Enviar" name="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    <?php require_once('../views/footer.php'); ?>