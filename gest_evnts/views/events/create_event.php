<?php
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/EventModel.php';
require_once __DIR__ . '/../../controllers/EventController.php';

use controllers\EventController;
use models\EventModel;

$db = (new \Database())->getConnection();
$eventController = new EventController($db);

$message = '';
$alertClass = '';
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $date = trim($_POST['date_evenement'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!empty($titre) && !empty($date)) {
        $success = $eventController->createEvent($titre, $date, $description);

        if ($success) {
            $_SESSION['success'] = "✅ Événement créé avec succès.";
            header("Location: /gestion_evenements/views//events/list_events.php");
            exit();
        } else {
            $message = "❌ Une erreur s'est produite lors de la création.";
            $alertClass = 'alert-danger';
        }
    } else {
        $message = "⚠️ Le titre et la date sont obligatoires.";
        $alertClass = 'alert-warning';
    }
}
?>

<div class="container mt-4">
    <h2 class="mb-4">➕ Ajouter un Nouvel Événement</h2>

    <?php if (!empty($message)): ?>
        <div class="alert <?= $alertClass ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="shadow p-4 bg-light rounded">
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date_evenement" class="form-label">Date</label>
            <input type="date" name="date_evenement" id="date_evenement" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optionnel)</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">✅ Enregistrer</button>
        <a href="list_events.php" class="btn btn-secondary">↩️ Retour</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
