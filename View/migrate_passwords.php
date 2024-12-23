<?php
require_once './Model/Connexion.php';

$conn = new Connexion();
$db = $conn->getDb();

// Récupérer tous les utilisateurs
$users = $db->query("SELECT id, password FROM tableuser")->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    $oldHash = $user['password'];

    // Vérifiez si c'est un hash SHA1 (40 caractères)
    if (strlen($oldHash) === 40) {
        // Recréer un hash BCRYPT basé sur le SHA1 existant
        $newHash = password_hash($oldHash, PASSWORD_BCRYPT);

        // Mettre à jour la base de données
        $stmt = $db->prepare("UPDATE tableuser SET password = :newHash WHERE id = :id");
        $stmt->bindValue(':newHash', $newHash, PDO::PARAM_STR);
        $stmt->bindValue(':id', $user['id'], PDO::PARAM_INT);
        $stmt->execute();

        echo "Mot de passe mis à jour pour l'utilisateur ID : {$user['id']}<br>";
    } else {
        echo "Aucun changement nécessaire pour l'utilisateur ID : {$user['id']}<br>";
    }
}
?>
