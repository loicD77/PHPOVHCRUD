<?php
require_once './Model/Connexion.php';

$conn = new Connexion();
$db = $conn->getDb();

// Récupère tous les utilisateurs
$users = $db->query("SELECT id, password FROM tableuser")->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    $oldHash = $user['password'];

    // Si le mot de passe est un hash SHA1 (longueur 40), on le ré-hache avec bcrypt
    if (strlen($oldHash) === 40) {
        $newHash = password_hash($oldHash, PASSWORD_BCRYPT);
        $stmt = $db->prepare("UPDATE tableuser SET password = :newHash WHERE id = :id");
        $stmt->bindValue(':newHash', $newHash, PDO::PARAM_STR);
        $stmt->bindValue(':id', $user['id'], PDO::PARAM_INT);
        $stmt->execute();

        echo "Mise à jour du mot de passe pour l'utilisateur ID : " . $user['id'] . "<br>";
    }
}
echo "Mise à jour terminée.";
