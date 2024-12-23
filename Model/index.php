<?php
require_once 'Model/Connexion.php';
require_once 'Model/User.php';
require_once 'Model/UserManager.php';

$conn = new Connexion();
$db = $conn->getDb();
$userManager = new UserManager($db);

$action = $_GET['action'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        // Création d'un utilisateur
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'address' => $_POST['address'],
            'postalCode' => $_POST['postalCode'],
            'city' => $_POST['city']
        ];
        $user = new User($data);
        $userManager->create($user);
        echo "Utilisateur créé avec succès !";
    } elseif (isset($_POST['update'])) {
        // Modification d'un utilisateur
        $data = [
            'id' => intval($_POST['userId']),
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'address' => $_POST['address'],
            'postalCode' => $_POST['postalCode'],
            'city' => $_POST['city']
        ];
        $user = new User($data);
        $userManager->update($user);
        echo "Utilisateur modifié avec succès !";
    }
}

if ($action === 'delete') {
    // Suppression d'un utilisateur
    $id = intval($_GET['id']);
    $userManager->delete($id);
    echo "Utilisateur supprimé avec succès !";
}

// Récupérer tous les utilisateurs pour l'affichage
$users = $userManager->findAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    <title>Gestion des utilisateurs</title>
</head>
<body>
    <h1>Gestion des utilisateurs</h1>

    <!-- Formulaire de création d'utilisateur -->
    <h2>Créer un utilisateur</h2>
    <form action="index.php" method="POST">
        <input type="hidden" name="create" value="1">
        <label>Email :</label><br/>
        <input type="email" name="email" required/><br>
        <label>Mot de passe :</label><br/>
        <input type="password" name="password" required/><br>
        <label>Prénom :</label><br/>
        <input type="text" name="firstName" required/><br>
        <label>Nom :</label><br/>
        <input type="text" name="lastName" required/><br>
        <label>Adresse :</label><br/>
        <input type="text" name="address" required/><br>
        <label>Code Postal :</label><br/>
        <input type="text" name="postalCode" required/><br>
        <label>Ville :</label><br/>
        <input type="text" name="city" required/><br>
        <button type="submit">Créer</button>
    </form>

    <!-- Formulaire de modification d'utilisateur -->
    <h2>Modifier un utilisateur</h2>
    <form action="index.php" method="POST">
        <input type="hidden" name="update" value="1">
        <label>ID de l'utilisateur à modifier :</label><br/>
        <input type="number" name="userId" required/><br>
        <label>Email :</label><br/>
        <input type="email" name="email" required/><br>
        <label>Mot de passe :</label><br/>
        <input type="password" name="password" required/><br>
        <label>Prénom :</label><br/>
        <input type="text" name="firstName" required/><br>
        <label>Nom :</label><br/>
        <input type="text" name="lastName" required/><br>
        <label>Adresse :</label><br/>
        <input type="text" name="address" required/><br>
        <label>Code Postal :</label><br/>
        <input type="text" name="postalCode" required/><br>
        <label>Ville :</label><br/>
        <input type="text" name="city" required/><br>
        <button type="submit">Modifier</button>
    </form>

    <!-- Liste des utilisateurs -->
    <h2>Liste des utilisateurs</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Code Postal</th>
            <th>Ville</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['firstName']) ?></td>
                <td><?= htmlspecialchars($user['lastName']) ?></td>
                <td><?= htmlspecialchars($user['address']) ?></td>
                <td><?= htmlspecialchars($user['postalCode']) ?></td>
                <td><?= htmlspecialchars($user['city']) ?></td>
                <td>
                    <a href="index.php?action=delete&id=<?= $user['id'] ?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
