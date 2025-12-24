<?php
session_start();
require_once '../config/database.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $errors[] = "les champs sont obligatoires";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "l'émail est incorrect";
    }

    if (empty($errors)) {
        //recherche sur user
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $user['password'] === $password) {
            //session
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'email' => $user['email'],
                'role'  => $user['role']
            ];
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = "Email ou mot de passe incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
    }

body {
    background: #1b3f65ff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background: white;
    padding: 35px;
    width: 360px;
    border-radius: 8px;
    box-shadow: 0px 0px 15px rgba(0,0,0,0.15);
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #1b3f65ff;
}

input, select, textarea {
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

.error {
    color: red;
    margin-bottom: 10px;
    font-size: 14px;
}

.success {
    color: green;
    margin-bottom: 10px;
    font-size: 14px;
}

.link {
    margin-top: 12px;
    font-size: 14px;
}

a {
    text-decoration: none;
    color: #d2a812;
}
#coachFields {
    text-align: left;
}
</style>
</head>

<body>

<h2>Connexion</h2>

<?php if ($errors): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $err): ?>
            <li><?= $err ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<div class="container">
    <h2>Connexion</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="submit">Se connecter</button>
    </form>
    <p class="link">Vous n'avez pas de compte ?  
        <a href="register.php">Créer un compte</a>
    </p>
</div>
</div>
</body>
</html>