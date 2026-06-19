<?php
// File: koneksi/database.php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = ""; // Kosongkan jika menggunakan Laragon/XAMPP bawaan
    private $db_name = "db_pbo_latihan_trpl1a_naelladwiarti (1)";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            // Mengatur error mode PDO ke Exception untuk mempermudah debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Koneksi database gagal: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>