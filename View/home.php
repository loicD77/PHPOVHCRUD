<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Vérification de session
if (!isset($_SESSION['user'])) {
    echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
    exit;
}
?>

<link href="css/style.css" rel="stylesheet" type="text/css">

<h2>Bienvenue, <?= htmlspecialchars($_SESSION['user']['firstName'] ?? 'Cher utilisateur'); ?></h2>

<p>
    Vous êtes connecté en tant que 
    <strong><?= htmlspecialchars($_SESSION['user']['role'] ?? 'Visiteur'); ?></strong>.
</p>

<?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <div class="admin-actions">
        <p>En tant qu'administrateur, vous pouvez :</p>
        <ul>
            <li><a href="index.php?ctrl=user&action=listUser">Gérer les utilisateurs</a></li>
            <li><a href="index.php?ctrl=user&action=addUser">Ajouter un nouvel utilisateur</a></li>
        </ul>
    </div>
<?php else: ?>
    <p>Merci de vous être connecté. Utilisez la navigation pour explorer vos fonctionnalités.</p>
<?php endif; ?>
