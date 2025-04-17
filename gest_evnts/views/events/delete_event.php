<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controllers/EventController.php';

use controllers\EventController;

$db = (new \Database())->getConnection();
$controller = new EventController($db);

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['error'] = "Event ID is missing.";
    header("Location: list_events.php");
    exit;
}

$event = $controller->getEventById($id);

if (!$event) {
    $_SESSION['error'] = "Event not found.";
    header("Location: list_events.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->deleteEvent($id);
    if ($result === true) {
        $_SESSION['success'] = "✅ Event successfully deleted.";
    } else {
        $_SESSION['error'] = $result;
    }
    header("Location: list_events.php");
    exit;
}
?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h4>⚠️ Delete Event</h4>
        </div>
        <div class="card-body">
            <p>Are you sure you want to delete the event <strong><?= htmlspecialchars($event['titre']) ?></strong> scheduled for <strong><?= htmlspecialchars($event['date_evenement']) ?></strong>?</p>

            <form method="post">
                <a href="list_events.php" class="btn btn-secondary">↩️ Cancel</a>
                <button type="submit" class="btn btn-danger">🗑️ Delete</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
