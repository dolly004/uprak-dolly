<?php
class Database {
    private $host = "localhost";
    private $db_name = "uprak_dolly";
    private $username = "root";
    private $password = "";
    private $conn;

    public function koneksi() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function ambil_data($query) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifikasi($query) {
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }
}
?>
