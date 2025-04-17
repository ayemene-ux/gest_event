<?php namespace controllers;

require_once __DIR__ . '/../models/EventModel.php';
require_once __DIR__ . '/../config/Database.php';

use PDO;
use models\EventModel;

class EventController {
    private $eventModel;
    public function __construct($db) {
        $this->eventModel = new EventModel($db);
    }

    public function createEvent($titre, $date_evenement, $description) {
        if (empty($titre) || empty($date_evenement)) {
            return "Title and event date are required.";
        }

        if (!strtotime($date_evenement)) {
            return "Invalid date format.";
        }

        return $this->eventModel->create($titre, $date_evenement, $description);
    }

    public function getAllEvents() {
        return $this->eventModel->getAll();
    }

    
    public function getEventById($id) {
        return $this->eventModel->getById($id);  
    }

    public function updateEvent($id, $titre, $date_evenement, $description) {
        if (empty($id) || empty($titre) || empty($date_evenement)) {
            return "Event ID, title, and date are required.";
        }

        if (!strtotime($date_evenement)) {
            return "Invalid date format.";
        }

       
        return $this->eventModel->update($id, $titre, $date_evenement, $description);
    }

 
    public function deleteEvent($id) {
        if (empty($id)) {
            return "Event ID is required.";
        }

        $result = $this->eventModel->delete($id);
        if ($result) {
            return true;  
        } else {
            return "❌ An error occurred while deleting the event.";
        }
    }


}
