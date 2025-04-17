<?php
namespace controllers;

use PDO;

class ParticipantController {
    private $conn;

    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function registerParticipant($nom, $email, $event_id) {
        $query = "INSERT INTO participants (nom, email) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
    
        if ($stmt->execute([$nom, $email])) {
            $participant_id = $this->conn->lastInsertId();
    
            $query = "INSERT INTO inscriptions (event_id, participant_id, date_inscription) VALUES (?, ?, NOW())";
            $stmt = $this->conn->prepare($query);
    
            if ($stmt->execute([$event_id, $participant_id])) {
                return true; 
            }
        }
    
        return "Failed to register participant."; 
    }
    

    public function getAllParticipants() {
        $query = "SELECT * FROM participants ORDER BY nom ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>
