<?php
namespace controllers;

use PDO;

class InscriptionController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllInscriptions() {
        $query = "
            SELECT
                i.id AS inscription_id,
                p.nom AS participant_name,
                p.email AS participant_email,
                e.titre AS event_title,
                i.date_inscription
            FROM inscriptions i
            JOIN participants p ON i.participant_id = p.id
            JOIN events e ON i.event_id = e.id
            ORDER BY i.date_inscription DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
