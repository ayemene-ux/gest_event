<?php
require_once __DIR__ . '/../layout/header.php';  
require_once __DIR__ . '/../../config/Database.php'; 
require_once __DIR__ . '/../../models/EventModel.php';
require_once __DIR__ . '/../../controllers/EventController.php';

use controllers\EventController;
use models\EventModel;

$db = (new \Database())->getConnection();
$eventController = new EventController($db);
$events = $eventController->getAllEvents();
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php elseif (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h2 class="fw-bold">📅 Event List</h2>
    <a href="create_event.php" class="btn btn-success">➕ Add New Event</a>
</div>

<div class="table-responsive">
    <table class="table table-hover shadow-sm bg-white rounded">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Actions</th> 
                    </tr>
                </thead>

        <tbody>
            <?php if ($events && $events->rowCount() > 0): ?>
                <?php while ($event = $events->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?= $event['id'] ?></td>
                        <td><?= htmlspecialchars($event['titre']) ?></td>
                        <td><?= htmlspecialchars($event['date_evenement']) ?></td>
                        <td><?= htmlspecialchars($event['description']) ?></td>
                        <td>
                    <div class="d-flex gap-2">
                        <a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                        <a href="delete_event.php?id=<?= $event['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?')">🗑️ Delete</a>
                    </div>
                </td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center text-muted">No events found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
