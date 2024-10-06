<?php

class pessoaDAO{
    private $connection;

    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=pessoas";
    
        try {
            $this->connection = new PDO($dsn, 'root', '1234');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Falha ao conectar: " . $e->getMessage();
        }
    }

    public function insert(pessoaModel $model)
    {
        $sql = "INSERT INTO pessoas(nome) VALUES (?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $model->nome);
        $stmt->execute();
    }

    public function insertChild($id_pai, $nome_filho) {
        if ($this->childExists($id_pai, $nome_filho)) {
            return false; 
        }

        $sql = "INSERT INTO filho (id_pai, nome_filho) VALUES (?, ?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $id_pai);
        $stmt->bindValue(2, $nome_filho);
        $stmt->execute();
    }


    public function deleteAll (int $id) 
    {

        $sql = "DELETE FROM pessoas WHERE id = ? ";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    public function deleteChild($id_pai, $nome_filho) {
        $sql = "DELETE FROM filho WHERE id_pai = ? AND nome_filho = ?";
        
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $id_pai);
        $stmt->bindValue(2, $nome_filho);
        $stmt->execute();
    }

    public function select() 
    {

        $sql = "SELECT * FROM pessoas ";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'pessoaModel');

    }

    public function selectChild() {
        $sql = "SELECT * FROM filho"; 
        $stmt = $this->connection->prepare($sql); 
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    
    
    public function childExists($id_pai, $nome_filho) {
        $query = "SELECT COUNT(*) FROM filho WHERE id_pai = :id_pai AND nome_filho = :nome_filho";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id_pai', $id_pai);
        $stmt->bindParam(':nome_filho', $nome_filho);
        $stmt->execute();
    
        return $stmt->fetchColumn() > 0;
    }
    
}
?>