<?php

class pessoaModel
{
    public $id, $nome, $id_pai, $nome_filho;

    public $rows;

    public $children;

    public function create()
    {
        include_once 'dao/pessoaDAO.php';

        $dao = new pessoaDAO();
        $dao->insert($this);
    }

    public function getAllPessoas()
    {
        include_once 'dao/pessoaDAO.php';

        $dao = new pessoaDAO();

        $this->rows = $dao->select();
    }

    public function getChildren()
    {
        include_once 'dao/pessoaDAO.php';
        $dao = new pessoaDAO();
        $this->children = $dao->selectChild(); 
    }

    public function childExists($id_pai, $nome_filho) {
        include_once 'dao/pessoaDAO.php';
        $dao = new pessoaDAO();
        $dao->childExists($id_pai, $nome_filho);
    }

    public function delete(int $id)
    {
        include_once 'dao/pessoaDAO.php';

        $dao = new pessoaDAO();
        $dao->deleteAll($id);
    }

    public function deleteChild($id_pai, $nome_filho)
    {
        include_once 'dao/pessoaDAO.php';

        $dao = new pessoaDAO();
        $dao->deleteChild($id_pai, $nome_filho);
    }

    public function addChild($id_pai, $nome_filho)
    {
        include_once 'dao/pessoaDAO.php';

        $dao = new pessoaDAO();
        $dao->insertChild($id_pai, $nome_filho);
    }

}
