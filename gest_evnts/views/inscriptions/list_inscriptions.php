<?php 
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controllers/InscriptionController.php';

use controllers\InscriptionController;

$db = (new \Database())->getConnection();
$inscriptionController = new InscriptionController($db);
$inscriptions = $inscriptionController->getAllInscriptions();
?>

<div class="container mt-5">
    <h2 class="mb-4">📝 List of Participants</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Participant Name</th>
                <th>Email</th>
                <th>Event</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($inscriptions && $inscriptions->rowCount() > 0): ?>
                <?php while ($inscription = $inscriptions->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= htmlspecialchars($inscription['inscription_id']) ?></td>
                        <td><?= htmlspecialchars($inscription['participant_name']) ?></td>
                        <td><?= htmlspecialchars($inscription['participant_email']) ?></td>
                        <td><?= htmlspecialchars($inscription['event_title']) ?></td>
                        <td><?= htmlspecialchars($inscription['date_inscription']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No inscriptions found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
