<?php

include_once "configs/database.php";
include_once "aluno.php";

class AlunoController{
    private $bd;
    private $aluno;
    private $img_name;

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
    public function cadastrarAluno($dados,$arquivo){
        $temArquivo = isset($arquivo['name']['fileToUpload'])
        && $arquivo['name']['fileToUpload']!==""
        && isset($arquivo['error']['fileToUpload'])
        && $arquivo['error']['fileToUpload'] === UPLOAD_ERR_OK;

        if($temArquivo && !$this->upload($arquivo)){
            return false;
        }

        if(!$temArquivo){
            $this->img_name =null;
        }

        $this->aluno->nome = $dados['nome'];
        $this->aluno->email = $dados['email'];
        $this->aluno->telefone = $dados['telefone'];
        $this->aluno->senha = $dados['senha'];
        $this->aluno->login = $dados['login'];
        $this->aluno->img = $this->img_name;

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
    public function upload($arquivo)
    {

        $target_dir = "uploads/";
        $uploadOk = 1;
        $target_file = $target_dir . $arquivo["name"]['fileToUpload'];
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $random_name = uniqid('img_', true) . '.' . pathinfo($arquivo['name']['fileToUpload'], PATHINFO_EXTENSION);
        $this->img_name = $random_name;
        $upload_file = $target_dir . $random_name;

        $check = getimagesize($arquivo['tmp_name']['fileToUpload']);

        if ($check !== false) {
            //echo "Imagem selecionada - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            // echo "O arquivo selecionado não é uma imagem.<br>";
            $uploadOk = 0;
        }

        // Verifica se o arquivo já existe na pasta
        if (file_exists($upload_file)) {
            // echo "O arquivo já existe no servidor.<br>";
            $uploadOk = 0;
        }

        // Verifica o tamanho do arquivo - Limite de 5MB
        if ($arquivo['size']['fileToUpload'] > 5000000) {
            // echo "Arquivo muito grande!<br>";
            $uploadOk = 0;
            echo "imagem muito grande";
            die();
        }
        // Permite apenas determinados tipos de arquivo - jpg, png, jpeg e gif
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            //  echo "São aceitas somente imagens JPG, JPEG, PNG e GIF.";
            $uploadOk = 0;
        }

        // Verificação de erros. Se $uploadOk=0 ocorreu algum erro
        if ($uploadOk == 0) {
            //  echo "Erro: não foi possível fazer upload.";
            return false;
            // Se não ocorreu problemas, tenta fazer upload
        } else {
            if (move_uploaded_file($arquivo['tmp_name']['fileToUpload'], $upload_file)) {
                //     echo "Arquivo ". basename( $arquivo['full_path']['fileToUpload']) . " enviado.";
                return true;
            } else {
                //     echo "Erro ao enviar a imagem.";
                return false;
            }
        }

        return false;
    }


}
