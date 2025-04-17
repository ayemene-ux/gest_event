<?php 
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controllers/ParticipantController.php';
require_once __DIR__ . '/../../controllers/EventController.php';

use controllers\ParticipantController;
use controllers\EventController;

$db = (new \Database())->getConnection();
$eventController = new EventController($db);
$events = $eventController->getAllEvents();  

$participantController = new ParticipantController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $event_id = $_POST['event_id'];
    
    $result = $participantController->registerParticipant($nom, $email, $event_id);
    if ($result === true) {
        $_SESSION['success'] = "Participant successfully registered!";
        header("Location: /gestion_evenements/views/inscriptions/list_inscriptions.php");
        exit;  
    } else {
        $_SESSION['error'] = $result;
        header("Location: /gestion_evenements/views/index.php");

    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4">📝 Register Participant</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Name</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="event_id" class="form-label">Select Event</label>
            <select class="form-control" id="event_id" name="event_id" required>
                <option value="">-- Select Event --</option>
                <?php if ($events && $events->rowCount() > 0): ?>
                    <?php while ($event = $events->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $event['id'] ?>"><?= htmlspecialchars($event['titre']) ?> - <?= htmlspecialchars($event['date_evenement']) ?></option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="">No events available</option>
                <?php endif; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
        <a class="btn btn-secondary" href="/gestion_evenements/views/index.php">Cancel</a>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
