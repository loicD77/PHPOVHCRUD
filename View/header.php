<header>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <h1>TP Authentification et Sécurité</h1>
    <nav>
        <a href="index.php">Accueil</a>
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="index.php?ctrl=user&action=login">Connexion</a>
            <a href="index.php?ctrl=user&action=create">Créer un compte</a>
        <?php else: ?>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="index.php?ctrl=user&action=listUser">Gestion des utilisateurs</a>
                <a href="index.php?ctrl=user&action=addUser">Ajouter un utilisateur</a>
            <?php endif; ?>
            <a href="index.php?ctrl=user&action=logout">Déconnexion</a>
        <?php endif; ?>
    </nav>

    <!-- Section affichant le prénom et le rôle -->
    <?php if (isset($_SESSION['user'])): ?>
        <div class="user-info">
            <?= htmlspecialchars($_SESSION['user']['firstName']) ?> (<?= htmlspecialchars($_SESSION['user']['role']) ?>)
        </div>
    <?php endif; ?>
</header>
