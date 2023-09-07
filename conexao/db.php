<?php
class Database
{
    private $host = "localhost";
    private $db_name = "form";
    private $user_name = "root";
    private $senha = "";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->user_name, $this->senha);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "ERRO na conexão: " . $e->getMessage();
        }
        return $this->conn;
    }
}
