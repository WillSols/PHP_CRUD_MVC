<?php

class pessoaController {
    public static function index(){
        include 'model/pessoaModel.php';

        $model = new pessoaModel();
        $model->getAllPessoas();

        include 'views/pessoaView.php';
    }

    public static function indexChildren() {
        include 'model/pessoaModel.php';
    
        $model = new pessoaModel();
        $children = $model->getChildren();
        
        include 'views/pessoaView.php'; 
    }
    
    
    public static function create(){
        include 'model/pessoaModel.php';
        include_once 'DAO/pessoaDAO.php';
    
        $model = new pessoaModel();
        if (isset($_POST['nome'])) {
            $model->nome = $_POST['nome'];
        } else {
            echo "Nome não foi enviado!";
            return;
        }
    
        $dao = new pessoaDAO();
        $dao->insert($model);
    
        header("Location: /pessoa/index");
    }

    public static function createChild() { 
        include 'model/pessoaModel.php';
        include_once 'DAO/pessoaDAO.php';
        
        if (isset($_POST['id_pai']) && isset($_POST['nome_filho'])) {
            $id_pai = $_POST['id_pai']; 
            $nome_filho = $_POST['nome_filho'];
    
            $dao = new pessoaDAO(); 
            $model = new pessoaModel();
    
            if ($dao->childExists($id_pai, $nome_filho)) {
                echo "<script>alert('Filho já adicionado!');</script>";
                echo "<script>setTimeout(() => { window.location.href = '/pessoa/index'; }, 100);</script>";
                exit(); 
            } else {
                $dao->insertChild($id_pai, $nome_filho);
            }
        } else {
            echo "ID do pai ou nome do filho não foram enviados!";
            return;
        }
    
        header("Location: /pessoa/index");
        exit(); 
    }
    
    

    public static function deleteAll() {
        include 'model/pessoaModel.php';
        
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            $model = new pessoaModel();
            $model->delete($id); 
        }

        header("Location: /pessoa/index");
    }

    public static function deleteChild() {
        include 'model/pessoaModel.php';
    
        if (isset($_POST['id_pai']) && isset($_POST['nome_filho'])) {
            $id_pai = $_POST['id_pai'];
            $nome_filho = $_POST['nome_filho'];
    
            $model = new pessoaModel();
            $model->deleteChild($id_pai, $nome_filho); 
        } else {
            echo "ID do pai ou nome do filho não foram enviados!";
            return;
        }
    
        header("Location: /pessoa/index");
    }
}

?>