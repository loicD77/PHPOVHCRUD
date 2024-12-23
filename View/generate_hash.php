<?php
// Script pour générer un mot de passe haché
$password = 'wx'; // Remplacez par le mot de passe en clair
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

echo "Mot de passe en clair : " . $password . "<br>";
echo "Mot de passe haché : " . $hashedPassword . "<br>";
?>
