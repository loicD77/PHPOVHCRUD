<?php
// Inclure la connexion à la base de données
require_once './Model/Connexion.php';
$conn = new Connexion();
$db = $conn->getDb();

// Ajouter un utilisateur de test
$email = 'test@example.com';
$password = 'test123'; // Mot de passe clair
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$stmt = $db->prepare("
    INSERT INTO tableuser (email, password, firstName, lastName, address, postalCode, city, role)
    VALUES (:email, :password, :firstName, :lastName, :address, :postalCode, :city, :role)
");

$stmt->execute([
    ':email' => $email,
    ':password' => $hashedPassword,
    ':firstName' => 'John',
    ':lastName' => 'Doe',
    ':address' => '123 Street Name',
    ':postalCode' => '12345',
    ':city' => 'CityName',
    ':role' => 'user'
]);

echo "Utilisateur de test ajouté avec succès : $email (mot de passe : $password)";
?>
