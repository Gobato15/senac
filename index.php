<?php
include_once "objetos/AlunoController.php";

//Login
session_start();
if (!isset($_SESSION["aluno"])){
    header("location: login.php");
    exit();
}

$controller = new AlunoController();
$alunos = $controller->index();
global $alunos;
$a = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (isset($_POST["pesquisar"])){
    $a = $controller->pesquisaAluno($_POST["pesquisar"]);
    }
}
if($_SERVER["REQUEST_METHOD"] === "GET"){
    if(isset($_GET["excluir"])){
        $a = $controller->excluirAluno($_GET["excluir"]);
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senac Rio Claro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Senac Rio Claro</h1>
        <div class="user-info">
            <span><strong>Usuário Logado:</strong> <?=$_SESSION['aluno']->nome ?></span>
            <a href="logout.php" class="btn btn-logout">Sair</a>
        </div>
    </header>

    <div class="card">
        <div class="section-header">
            <h2>Gestão de Alunos</h2>
            <a href="cadastro.php" class="btn btn-primary">Cadastrar Aluno</a>
        </div>

        <div class="search-section">
            <h3>Pesquisar Aluno</h3>
            <form method="POST" action="index.php" class="form-group">
                <label for="pesquisar">RA:</label>
                <input type="number" id="pesquisar" name="pesquisar" placeholder="Digite o RA do aluno..." required>
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>

        <?php if($a) :?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>RA</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$a->ra; ?></td>
                        <td><?=$a->nome; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="section-header">
            <h2>Alunos Cadastrados</h2>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>RA</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($alunos) :?>
                    <?php foreach($alunos as $aluno) :?>
                    <tr>
                        <td><a href="ver-aluno.php?ra=<?= $aluno->ra;?>"><strong><?= $aluno->ra; ?></strong></a></td>
                        <td><?=$aluno->nome; ?></td>
                        <td><?=$aluno->email; ?></td>
                        <td>
                            <div class="actions">
                                <a href="ver-aluno.php?ra=<?= $aluno->ra ?>" class="action-view">Visualizar</a>
                                <a href="atualizar.php?alterar=<?= $aluno->ra ?>" class="action-edit">Alterar</a>
                                <a href="index.php?excluir=<?= $aluno->ra ?>" class="action-delete" onclick="return confirm('Deseja realmente excluir este aluno?')">Excluir</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">Nenhum aluno cadastrado.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>


