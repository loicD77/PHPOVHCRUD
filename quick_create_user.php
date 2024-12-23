<?php
// Inclure la connexion à la base de données
require_once './Model/Connexion.php';

$conn = new Connexion();
$db = $conn->getDb();

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

// Informations de l'utilisateur à créer
$email = 'test_user@gmail.com'; // Remplacez par l'email que vous voulez tester
$password = 'test123'; // Remplacez par le mot de passe en clair
$firstName = 'Test';
$lastName = 'User';
$address = '123 Test Street';
$postalCode = '12345';
$city = 'Test City';
$role = 'admin'; // 'admin' ou 'user'

// Hacher le mot de passe
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insertion dans la base de données
try {
    $stmt = $db->prepare("
        INSERT INTO tableuser (email, password, firstName, lastName, address, postalCode, city, role)
        VALUES (:email, :password, :firstName, :lastName, :address, :postalCode, :city, :role)
    ");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':postalCode', $postalCode, PDO::PARAM_STR);
    $stmt->bindValue(':city', $city, PDO::PARAM_STR);
    $stmt->bindValue(':role', $role, PDO::PARAM_STR);
    $stmt->execute();

    echo "Utilisateur créé avec succès !<br>";
    echo "Email : $email<br>";
    echo "Mot de passe : $password (haché en base de données)";
} catch (PDOException $e) {
    echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage();
}
?>
