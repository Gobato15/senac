<?php
include_once("objetos/AlunoController.php");
//Proteger a Pagina
session_start();
if (!isset($_SESSION["aluno"])){
    header("location: login.php");
    exit();
}
$controller = new AlunoController();

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ra'])){
    $a = $controller->localizarAluno($_GET['ra']);
}

//var_dump($a);

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aluno: <?= $a->nome ?></title>
</head>
<body>
<a href="index.php">Voltar</a>
<h1>#<?= $a->ra ?> - <?= $a->nome ?></h1>
<p><strong>E-mail:</strong><?=$a->email ?></p>
<p><strong>Telefone:</strong><?=$a->telefone ?></p>
<p><strong>Login:</strong><?=$a->login ?></p>
<!--Duplicar as Linhas CTRL+D-->
<!--Mostrar imagem na Tabela-->
<?php if($a->imagem ==""):?>
        <td><img style="width: 20%;"src="imagem/image-fail.jpg"></td>
        <?php else : ?>

            <td><img style="width: 20%" src="uploads/<?=$a->imagem;?>"</td>
        <?php endif; ?>

</body>
</html>
