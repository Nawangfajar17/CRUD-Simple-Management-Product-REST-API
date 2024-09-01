<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'suna';
    private $username = 'root'; // Sesuaikan dengan username MySQL Anda
    private $password = ''; // Sesuaikan dengan password MySQL Anda
    public $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
