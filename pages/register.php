<?php
session_start();
require_once '../config/database.php';
require_once '../classes/Coach.php';
require_once '../classes/Sportif.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($role)) {
        $errors[] = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email est invalide.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Cet email est déjà utilisé.";
        }
    }

    if (empty($errors)) {
        if ($role === 'coach') {
            $discipline = trim($_POST['discipline'] ?? '');
            $annees_exp = (int)($_POST['annees_exp'] ?? 0);
            $description = trim($_POST['description'] ?? '');

            // Créer un objet Coach
            $user = new Coach($nom, $prenom, $email, $password, $discipline, $annees_exp, $description);
            $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $password, 'coach']);
            $userId = $pdo->lastInsertId();
            $stmt2 = $pdo->prepare("INSERT INTO coaches (id_user, discipline, annees_exp, description) VALUES (?, ?, ?, ?)");
            $stmt2->execute([$userId, $discipline, $annees_exp, $description]);

        } elseif ($role === 'sportif') {
            $user = new Sportif($nom, $prenom, $email, $password);
            $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $password, 'sportif']);
            $userId = $pdo->lastInsertId();
            $stmt2 = $pdo->prepare("INSERT INTO sportifs (id_user) VALUES (?)");
            $stmt2->execute([$userId]);
        }

        $success = "Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        * { 
            margin:0; 
            padding:0; 
            box-sizing:border-box; 
            font-family:Arial,sans-serif; 
        }
        body { 
            background:#1b3f65ff; 
            display:flex; 
            justify-content:center; 
            align-items:center; 
            height:100vh; 
        }
        .container { 
            background:white; 
            padding:35px; 
            width:360px; 
            border-radius:8px; 
            box-shadow:0 0 15px rgba(0,0,0,0.15); 
            text-align:center; 
        }
        h2 { 
            margin-bottom:20px; 
            color:#1b3f65ff; 
        }
        input, select, textarea { 
            width:100%; 
            padding:12px; 
            margin:8px 0; 
            border-radius:6px; 
            border:1px solid #aaa; 
        }
        button { 
            width:100%; 
            padding:12px; 
            margin-top:12px; 
            border:none; 
            background:#1b3f65ff; 
            color:white; 
            font-size:16px; 
            border-radius:6px; 
            cursor:pointer; 
        }
        button:hover { 
            background:#032d5aff; 
        }
        .error { 
            color:red; 
            font-size:14px; 
            margin-bottom:10px; 
        }
        .success { 
            color:green; 
            font-size:14px; 
            margin-bottom:10px; 
        }
        .link { 
            margin-top:12px; 
            font-size:14px; 
        }
        a { 
            text-decoration:none; 
            color:#d2a812; 
        }
        #coachFields { 
            text-align:left; 
            display:none; 
            margin-top:10px; 
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Créer un compte</h2>

    <?php if ($errors): ?>
        <ul class="error">
            <?php foreach($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <select name="role" required>
            <option value="">Choisir votre rôle</option>
            <option value="coach">Coach</option>
            <option value="sportif">Sportif</option>
        </select>

        <div id="coachFields">
            <input type="text" name="discipline" placeholder="Discipline">
            <input type="number" name="annees_exp" placeholder="Années d'expérience">
            <textarea name="description" placeholder="Description"></textarea>
        </div>

        <button type="submit">S'inscrire</button>
    </form>

    <p class="link">Vous avez déjà un compte ? <a href="login.php">Connexion</a></p>
</div>

<script>
    const roleSelect = document.querySelector('select[name="role"]');
    const coachFields = document.getElementById('coachFields');

    roleSelect.addEventListener('change', () => {
        coachFields.style.display = roleSelect.value === 'coach' ? 'block' : 'none';
    });
</script>
</body>
</html>