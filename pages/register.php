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
            $annees_exp = (int)($_POST['annees_exp'] ?? 0);
            $description = trim($_POST['description'] ?? '');
            $user = new Coach($email,$password, $discipline,$annees_exp, $description);

            //insert à la bd 
            $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password,role) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(['Nom','Prenom',$email, $password, 'coach']);
            $userId = $pdo->lastInsertId();

            //insert into coachs
            $stmt2 = $pdo->prepare("INSERT INTO coaches (id_user, discipline,annees_exp, description) VALUES (?, ?, ?, ?)");
            $stmt2->execute([$userId,$discipline, $annees_exp,$description]);

        } elseif ($role === 'sportif') {
            $user = new Sportif($email, $password);

            //insert à la bd
            $stmt = $pdo->prepare("INSERT INTO users (nom, prenom,email, password,role) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(['Nom', 'Prenom',$email, $password,'sportif']);
            $userId = $pdo->lastInsertId();

            //insert into sportifs
            $stmt2 = $pdo->prepare("INSERT INTO sportifs (id_user) VALUES (?)");
            $stmt2->execute([$userId]);
        }
        $success = "Utilisateur inscrit avec succès !";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1b3f65ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 35px;
            width: 350px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #1b3f65ff;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #aaa;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border: none;
            background: #1b3f65ff;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #032d5aff;
        }

        .error { color: red; font-size: 14px; }
        .success { color: green; font-size: 14px; }

        .link {
            margin-top: 12px;
            font-size: 14px;
        }

        a {
            color: #d2a812;
            text-decoration: none;
        }

        /* select styling */
select {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border-radius: 6px;
    border: 1px solid #aaa;
    background-color: white;
    font-size: 14px;
    cursor: pointer;
}

/* textarea styling */
textarea {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border-radius: 6px;
    border: 1px solid #aaa;
    font-family: Arial, sans-serif;
    resize: vertical;
    min-height: 80px;
}

/* focus effect (input, select, textarea) */
input:focus,
select:focus,
textarea:focus {
    outline: none;
    border-color: #1b3f65ff;
    box-shadow: 0 0 5px rgba(27, 63, 101, 0.5);
}
#coachFields {
    margin-top: 10px;
    text-align: left;
}

    </style>
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
<div class="container">
    <h2>Créer un compte</h2>
    <form method="POST" action=''>
        <input type="email" name="email" placeholder="Adresse mail" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <select name="role" required>
            <option value="">Choisir ton role</option>
            <option value="coach">Coach</option>
            <option value="sportif">Sportif</option>
        </select>
        <div id="coachFields" style="display:none;">
            <input type="text" name="discipline" placeholder='Discipline' required>
            <input type="number" name="annees_exp" placeholder="Annees d'éxperiences" required>
            <textarea name="description" placeholder="Description :"></textarea>
        </div>
        <button type="submit" name="submit">S'inscrire</button>
    </form>
    <p class="link">Vous avez déjà un compte ?  
        <a href="login.php">Connexion</a>
    </p>
</div>
    <script>
        const roleSelect = document.querySelector('select[name="role"]');
        const coachFields =document.getElementById('coachFields');
        roleSelect.addEventListener('change',()=> {
            coachFields.style.display= roleSelect.value==='coach'?'block':'none';
        });
    </script>
</body>
</html>