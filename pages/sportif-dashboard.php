<?php
session_start();
require_once '../config/database.php';
require_once '../classes/Seance.php';
require_once '../classes/Reservation.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
} elseif ($_SESSION['user']['role'] !== 'sportif') {
    header('Location: accee-refuse.php');
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM sportifs WHERE id_user = ?");
$stmt->execute([$_SESSION['user']['id']]);
$sportif = $stmt->fetch();
if (!$sportif) die("Erreur : Sportif introuvable.");
$sportifId = $sportif['id'];

$success = '';
$error = '';

if (isset($_GET['reserver'])) {
    $id_seance = (int)$_GET['reserver'];
    $reservation = new Reservation($pdo, $id_seance, $sportifId);
    if ($reservation->creer()) {
        $success = "Séance réservée et en attente de validation par le coach";
    } else {
        $error = "Séance non disponible ou déjà réservée";
    }
}

$seances = Seance::seancesDisponibles($pdo);
$reservations = Reservation::reservationsSportif($pdo, $sportifId);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Sportif</title>
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
            table{
                width:100%;
                border-collapse:collapse;
                margin-top:20px;
            }
            th,td{
                padding:10px;
                border:1px solid #ccc;
                text-align:center;
            }
            th{
                background:#1b3f65ff;
                color:white;
            }
            a.button{
                background:#1b3f65ff;
                color:white;
                padding:6px 12px;
                border-radius:4px;
                text-decoration:none;
            }
            a.button:hover{
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

        <h2>Dashboard Sportif</h2>
        <?php if($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
        <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

        <h3>Séances disponibles</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Durée</th>
                <th>Discipline</th>
                <th>Action</th>
            </tr>
            <?php foreach($seances as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['date']) ?></td>
                <td><?= htmlspecialchars($s['heure']) ?></td>
                <td><?= htmlspecialchars($s['duree']) ?> min</td>
                <td><?= htmlspecialchars($s['discipline']) ?></td>
                <td><a href="?reserver=<?= $s['id'] ?>" class="button" style="background:#d2a812;">Réserver</a></td>
            </tr>
        <?php endforeach; ?>
        </table>
        <h3>Mes réservations acceptées</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Durée</th>
                <th>Discipline</th>
            </tr>
            <?php foreach($reservations as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['date']) ?></td>
                <td><?= htmlspecialchars($r['heure']) ?></td>
                <td><?= htmlspecialchars($r['duree']) ?> min</td>
                <td><?= htmlspecialchars($r['discipline']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
    </body>
</html>
