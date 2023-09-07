<?php
include_once('conexao/db.php');

$db = new Database();

class Usuario
{
    private $conn;
    private $table_name = "cadas";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function create($postValues)
    {
        $nome = $postValues['nome'];
        $apelido = $postValues['apelido'];
        $nasc = $postValues['nasc'];
        $email = $postValues['email'];
        $senha = $postValues['senha'];

        $query = "INSERT INT " . $this->table_name . "(nome, apelido, nasc, email, senha) VALUES (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $apelido);
        $stmt->bindParam(3, $nasc);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $senha);

        $rows = $this->read();
        if ($stmt->execute()) {
            print "<script>alert('cadastro OK!');</script>";
            print "<script>location.href='?action=read';</script>";
            return true;
        } else {
            return false;
        }
    }
//função para ler os registro do bancos de dados
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
//função para atualizar os dados do banco 
    public function update($postValues)
    {
        $id = $postValues['id'];
        $nome = $postValues['nome'];
        $apelido = $postValues['apelido'];
        $nasc = $postValues['nasc'];
        $email = $postValues['email'];
        $senha = $postValues['senha'];

        if (empty($id) || empty($nome) || empty($apelido) || empty($nasc) || empty($email) || empty($senha)); {
            return false;
        }


        $query = "UPDATE " . $this->table_name . " SET nome = ?, apelido = ?,email = ? ,nasc = ? , senha = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $apelido);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $nasc);
        $stmt->bindParam(5, $senha);
        $stmt->bindParam(6, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table_name . "WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //função para deletar o regsitro do banco de dados
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(1, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    
    public function cadastrar($nome,$apelido,$nasc,$email,$senha,$confsenha)
    {
        if($senha === $confsenha){
            $emailExistente = $this->verificarEmailExistente($email);
            if($emailExistente){
                print "<script>alert('Email já cadastrado')</script>";
                return false;
            }
            $SenhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            $query = "INSERT INTO cadas (nome, apelido,email , nasc, senha) VALUES (? , ?, ? ,?,?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(1,$nome);
            $stmt->bindValue(2,$apelido);
            $stmt->bindValue(3,$email);
            $stmt->bindValue(4,$nasc);
            $stmt->bindValue(5,$SenhaCriptografada);

            $result = $stmt->execute();
            return $result;
        }else{
            return false;
        }
    }

    private function verificarEmailExistente($email)
    {
        $query = "SELECT COUNT(*) FROM cadas WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$email);
        $stmt->execute();
        return $stmt->fetchcolumn() > 0;
    }

    public function logar($email,$senha)
    {
        $query = "SELECT * FROM cadas WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':email',$email);
        $stmt->execute();

        if($stmt->rowCount() == 1){
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            IF(PASSWORD_VERIFY($senha,$usuario['senha'])){
                return true;
            }
        }
        return false;
    }
    }
