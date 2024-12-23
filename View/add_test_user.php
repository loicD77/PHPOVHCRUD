<?php
require_once './Model/Connexion.php';
require_once './Model/UserManager.php';
require_once './Model/User.php';

$conn = new Connexion();
$db = $conn->getDb();

$userManager = new UserManager($db);

$email = 'test_user@gmail.com';
$password = 'test123';
$hashedPassword = sha1($password);

$newUser = new User([
    'email' => $email,
    'password' => $hashedPassword,
    'firstName' => 'Test',
    'lastName' => 'User',
    'address' => '123 Test Street',
    'postalCode' => '12345',
    'city' => 'Test City',
    'role' => 'user'
]);

$userManager->create($newUser);

echo "Utilisateur ajouté avec succès : $email<br>";
echo "Mot de passe en clair : $password<br>";
echo "Mot de passe haché (sha1) : $hashedPassword<br>";
?>
