<?php 
namespace models;
use \PDO;
use \PDOException;
require_once __DIR__ . '/../config/Database.php';

class EventModel {
    private $conn;
    private $table = "events";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($titre, $date_evenement, $description) {
        $query = "INSERT INTO " . $this->table . " (titre, date_evenement, description) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$titre, $date_evenement, $description]);
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date_evenement DESC";
        return $this->conn->query($query);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  
    }

    public function update($id, $titre, $date_evenement, $description) {
        $query = "UPDATE " . $this->table . " SET titre = ?, date_evenement = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$titre, $date_evenement, $description, $id]);
    }


    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
