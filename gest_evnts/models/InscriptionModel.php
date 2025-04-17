<?php
namespace models;

class InscriptionModel {
    private $conn;
    private $table = "inscriptions";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function inscrire($event_id, $participant_id) {
        $query = "INSERT INTO " . $this->table . " (event_id, participant_id, date_inscription)
                  VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$event_id, $participant_id]);
    }

    public function getAll() {
        $query = "SELECT i.*, p.nom, e.titre
                  FROM inscriptions i
                  JOIN participants p ON i.participant_id = p.id
                  JOIN events e ON i.event_id = e.id
                  ORDER BY i.date_inscription DESC";
        return $this->conn->query($query);
    }
}
