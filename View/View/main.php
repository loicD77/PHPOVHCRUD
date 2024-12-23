<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <title>TP Authentification et Sécurité</title>
</head>
<body>
    <header>
        <h1>TP Authentification et Sécurité</h1>
        <nav>
            <a href="index.php?ctrl=user&action=login">Connexion</a> |
            <a href="index.php">Accueil</a> |
            <a href="index.php?ctrl=userManager&action=listUser">Gestion des utilisateurs</a>
        </nav>
    </header>
    <main>
        <?php
        // Charger dynamiquement le contenu de la page
        if (isset($page)) {
            require "./View/{$page}.php";
        } else {
            echo "<p>Page introuvable</p>";
        }
        ?>
    </main>
    <?php include './View/footer.php'; ?>
</body>
</html>
