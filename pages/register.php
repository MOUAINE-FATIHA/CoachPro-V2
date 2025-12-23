<?php
require_once '../config/database.php';
require_once '../classes/Coach.php';
require_once '../classes/Sportif.php';
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] ==='POST'){
    $role = $_POST['role'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password) || empty($role)) {
        $errors[] = "les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "l'email est incorrect.";
    }

    if (empty($errors)) {
        if ($role ==='coach') {
            $discipline = trim($_POST['discipline'] ?? '');

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <?php if ($errors): ?>
        <ul style="color:red;"><?php foreach ($errors as $err): ?>
            <li><?= $err ?></li><?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?= $success ?></p>
    <?php endif; ?>
    
    <form method="post" action="">
        <label for="email">Email : </label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password :</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label>Rôle:
        <select name="role" required>
            <option value="">Choisir</option>
            <option value="coach">Coach</option>
            <option value="sportif">Sportif</option>
        </select>
        </label>
        <br>

    <div id="coachFields" style="display:none;">
        <label>Discipline : <input type="text" name="discipline"></label>
        <br>
        <label>Années d'expérience : <input type="number" name="annees_exp"></label>
        <br>
        <label>Description : <textarea name="description"></textarea></label>
        <br>
    </div>
    <button type="submit">S'inscrire</button>
    </from>
    <script>
        const roleSelect = document.querySelector('select[name="role"]');
        const coachFields =document.getElementById('coachFields');
        roleSelect.addEventListner('change',()=> {
            coachFields.style.display= roleSelect.value==='coach'?'block':'none';
        });
    </script>
</body>
</html>