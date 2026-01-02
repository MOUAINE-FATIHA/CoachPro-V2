<?php
session_start();
require_once '../config/database.php';
require_once '../classes/Seance.php';
require_once '../classes/Reservation.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
} elseif ($_SESSION['user']['role'] !== 'coach') {
    header('Location: accee-refuse.php');
    exit;
}
$coachId = $_SESSION['user']['id'];
$success = '';
$error = '';

if (isset($_POST['ajouter'])) {
    $date = $_POST['date'] ?? '';
    $heure = $_POST['heure'] ?? '';
    $duree = (int)($_POST['duree'] ?? 0);

    if ($date && $heure && $duree > 0) {
        $seance = new Seance($pdo, $coachId, $date, $heure, $duree);
        if ($seance->creer()) {
            $success = "Séance ajoutée avec succès";
        } else { $error = "Erreur lors de l'ajout"; }
    } else { $error = "Tous les champs sont obligatoires"; }
}

if (isset($_GET['supprimer'])) {
    $id = (int)$_GET['supprimer'];
    $seance = new Seance($pdo, $coachId, '', '', 0);
    $seance->supprimer($id);
    $success = "Séance supprimée";
}

if (isset($_GET['reservation_id'], $_GET['action'])) {
    $resId = (int)$_GET['reservation_id'];
    $action = $_GET['action'];
    if ($action === 'accept') {
        Reservation::updateStatut($pdo, $resId, 'accepted');
        $success = "Réservation acceptée";
    } elseif ($action === 'refuse') {
        Reservation::updateStatut($pdo, $resId, 'refused');
        $success = "Réservation refusée";
    }
}

$seances = Seance::seancesCoach($pdo, $coachId);
$reservations = Reservation::reservationsCoach($pdo, $coachId);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Coach</title>
        <style>
            body { 
                font-family: Arial,sans-serif; 
                background:#1b3f65ff; 
                color:#333; 
                margin:0; 
                padding:0;
            }
            .container { 
                max-width:900px; 
                margin:30px auto; 
                background:white; 
                padding:20px; 
                border-radius:8px;
            }
            h2{
                text-align:center;
                color:#1b3f65ff;
            }
            table {
                width:100%; 
                border-collapse:collapse; 
                margin-top:20px;
            }
            th, td {
                padding:10px;
                border:1px solid #ccc;
                text-align:center;
            }
            th {
                background:#1b3f65ff;
                color:white;
            }
            a.button {
                background:#1b3f65ff;
                color:white;
                padding:6px 12px;
                border-radius:4px;
                text-decoration:none;
            }
            a.button:hover{
                background:#032d5aff;
            }
            button{
                padding:6px 12px;
                border:none;
                background:#1b3f65ff;
                color:white;
                border-radius:4px;
                cursor:pointer;
            }
            button:hover{
                background:#032d5aff;
            }
            .success{
                color:green;
                text-align:center;
            }
            .error{
                color:red;
                text-align:center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div style="text-align:right;margin-bottom:10px;">
            <a href="logout.php" style="background:#d2a812;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;">Déconnexion</a>
        </div>

        <h2>Dashboard Coach</h2>
        <?php if($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
        <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

        <h3>Ajouter une séance</h3>
            <form method="POST">
                <input type="date" name="date" required>
                <input type="time" name="heure" required>
                <input type="number" name="duree" placeholder="Durée" required>
                <button name="ajouter">Ajouter</button>
            </form>
        <h3>Mes séances</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Durée</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            <?php foreach($seances as $s): ?>
            <tr>
                <td><?= $s['date'] ?></td>
                <td><?= $s['heure'] ?></td>
                <td><?= $s['duree'] ?></td>
                <td><?= $s['statut'] ?></td>
                <td><a href="?supprimer=<?= $s['id'] ?>" style="background:#d2a812;color:white;padding:6px 12px;border-radius:4px;text-decoration:none;">Supprimer</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h3>Réservations en attente</h3>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Durée</th>
                    <th>Sportif</th>
                    <th>Action</th>
                </tr>
                <?php foreach($reservations as $r): ?>
                <tr>
                    <td><?= $r['date'] ?></td>
                    <td><?= $r['heure'] ?></td>
                    <td><?= $r['duree'] ?></td>
                    <td><?= $r['nom'].' '.$r['prenom'] ?></td>
                    <td>
                    <a href="?reservation_id=<?= $r['id'] ?>&action=accept" class="button" style="background:green;">Accepter</a>
                    <a href="?reservation_id=<?= $r['id'] ?>&action=refuse" class="button" style="background:red;">Refuser</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html>
