<?php 
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controllers/EventController.php';

use controllers\EventController;

$db = (new \Database())->getConnection();
$controller = new EventController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $titre = $_POST['titre'] ?? '';
    $date_evenement = $_POST['date_evenement'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($id && $titre && $date_evenement) {
        $success = $controller->updateEvent($id, $titre, $date_evenement, $description);
        if ($success) {
            $_SESSION['success'] = "✅ Event updated successfully.";
            header("Location: list_events.php");
            exit;
        } else {
            $error = "❌ Failed to update event.";
        }
    } else {
        $error = "❗ Please fill in all required fields.";
    }

    $event = [
        'id' => $id,
        'titre' => $titre,
        'date_evenement' => $date_evenement,
        'description' => $description
    ];
}
?>

<div class="container mt-5">
    <h2 class="mb-4">✏️ Edit Event</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($event['id']) ?>">

        <div class="mb-3">
            <label for="titre" class="form-label">Title</label>
            <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($event['titre']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="date_evenement" class="form-label">Event Date</label>
            <input type="date" class="form-control" id="date_evenement" name="date_evenement" value="<?= htmlspecialchars($event['date_evenement']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($event['description']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">✅ Update Event</button>
        <a href="list_events.php" class="btn btn-secondary">↩️ Cancel</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
