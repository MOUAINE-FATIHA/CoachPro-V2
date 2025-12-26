<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accès refusé</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 40px;
            max-width: 800px;
        }

        .image {
            flex: 1;
        }

        .image img {
            max-width: 100%;
            height: auto;
        }

        .text {
            flex: 1;
            padding-left: 30px;
        }

        .text h1 {
            font-size: 80px;
            color: black;
            margin: 0;
        }

        .text h2 {
            margin-top: 10px;
            color: #333;
            font-size: 28px;
        }

        .text p {
            margin: 10px 0 20px;
            color: #666;
            font-size: 16px;
        }

        .text a {
            display: inline-block;
            padding: 12px 20px;
            background: #1b3f65ff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 15px;
            transition: 0.2s;
        }

        .text a:hover {
            background: #032d5aff;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                text-align: center;
            }
            .text {
                padding-left: 0;
                padding-top: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="image">
            <img src="../403.png" alt="non autorisée">
        </div>
        <div class="text">
            <h1>404</h1>
            <h2>Cette page est introuvable</h2>
            <p>La page que vous cherchez n'existe pas ou a été déplacée.</p>
            <a href="../public/index.php">Retour au Dashboard</a>
        </div>
    </div>
</body>
</html>