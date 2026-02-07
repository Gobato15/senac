<?php
include_once "configs/database.php";

$banco = new Database();
$bd = $banco->conectar();

if ($bd) {
    $sql = "SELECT * FROM alunos";
    $resultado = $bd->query($sql);
    $resultado ->execute();
    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultado as $aluno) {
        echo "Nome: ".$aluno['nome'] ."<br>";
        echo "Email: ".$aluno['email'] ."<br>";
        echo "Telefone: ".$aluno['telefone'] ."<br>";
        echo "Login: ". $aluno['login'] ."<br>";
        echo "Senha: ".$aluno['senha'] ."<br>";
    }
}else{
    echo "Falha ao conectar banco";
}
