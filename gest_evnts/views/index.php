<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/EventModel.php';
require_once __DIR__ . '/../controllers/EventController.php';

use controllers\EventController;
use models\EventModel;

$db = (new \Database())->getConnection();
$eventController = new EventController($db);
$events = $eventController->getAllEvents();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
</head>

<body>

    <div class="container">
        

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="list-group">
                    <a href="events/list_events.php" class="list-group-item list-group-item-action bg-primary rounded-3 mb-3">Liste des Événements</a>
                    <a href="participants/register_participant.php" class="list-group-item list-group-item-action bg-info rounded-3 mb-3">Inscription d'un Participant</a>
                    <a href="inscriptions/list_inscriptions.php" class="list-group-item list-group-item-action bg-success rounded-3 mb-3">Liste des Inscriptions</a>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
