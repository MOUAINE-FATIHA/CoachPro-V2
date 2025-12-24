<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
    exit;
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<h2>Bienvenue</h2>
<p>Email : <?= $user['email']; ?></p>
<p>Rôle : <?= $user['role']; ?></p>

<?php if ($user['role'] === 'coach'): ?>
    <p>Dashboard Coach</p>
<?php else: ?>
    <p>Dashboard Sportif</p>
<?php endif; ?>
<a href="login.php">Déconnexion</a>

</body>
</html>
