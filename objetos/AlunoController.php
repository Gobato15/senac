<?php

include_once "configs/database.php";
include_once "aluno.php";

class AlunoController{
    private $bd;
    private$aluno;

    public function __construct(){
        $banco =new Database();
        $this->bd=$banco->conectar();
        $this->aluno=new Aluno($this->bd);
    }
    public function index(){
        return $this->aluno->lerTodos();

    }
    public function pesquisaAluno($ra){
        return $this->aluno->pesquisaAluno($ra);
    }
    public function cadastrarAluno($dados){

        $this->aluno->nome = $dados['nome'];
        $this->aluno->email = $dados['email'];
        $this->aluno->telefone = $dados['telefone'];
        $this->aluno->senha = $dados['senha'];
        $this->aluno->login = $dados['login'];

        if($this->aluno->cadastrar()){
            header("location: index.php");
            exit();
        }

    }
    public function excluirAluno($ra){
        $this->aluno->ra = $ra;

        if($this->aluno->excluir()){
            header("location:index.php");
        }
    }

    public function atualizarAluno($dados){
        $this->aluno->ra = $dados["ra"];
        $this->aluno->nome = $dados["nome"];
        $this->aluno->email = $dados["email"];
        $this->aluno->senha = $dados["senha"];
        $this->aluno->telefone = $dados["telefone"];
        $this->aluno->login = $dados["login"];

        if($this->aluno->atualizar()){
            header("location:index.php");
        }
    }

    public function localizarAluno($ra){
        return $this->aluno->buscaAluno($ra);
    }


}
