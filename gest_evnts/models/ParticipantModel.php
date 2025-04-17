<?php
namespace models;

class ParticipantModel {
    private $conn;
    private $table = "participants";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($nom, $email) {
        $query = "INSERT INTO " . $this->table . " (nom, email) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nom, $email]);
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        return $this->conn->query($query);
    }
}
