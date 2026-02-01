<?php
/**
 * Wedding AI - Database Connection
 * Professional Portfolio Pattern: PDO Singleton-like approach
 */

class Database {
    private $host = "localhost";
    private $db_name = "wedding"; // Nome que deste à DB
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // DSN (Data Source Name) com charset definido para evitar problemas de acentos
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Configura o PDO para lançar exceções em caso de erro (melhor para debug)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Define o modo de busca padrão para Array Associativo
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $exception) {
            // Em produção, não mostramos o erro detalhado, mas para o teu dev é essencial
            error_log("Connection error: " . $exception->getMessage());
            die(json_encode(["error" => "Falha na conexão com o servidor."]));
        }

        return $this->conn;
    }
}
?>