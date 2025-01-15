<?php 
class dbconfig {
    private $host = "localhost";  // servidor do banco de dados
    private $username = "root";   // usuário do banco
    private $password = "";       // senha do banco
    private $database = "user-registration"; // nome do seu banco de dados
    private $conn;

    public function __construct(){
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->database",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}


?>