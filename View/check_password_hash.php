<?php
require_once './Model/Connexion.php';

$conn = new Connexion();
$db = $conn->getDb();

// Email et mot de passe à tester
$email = 'quentin@gmail.com'; // Remplacez par l'email de l'utilisateur
$password = 'quentin'; // Remplacez par le mot de passe en clair

$stmt = $db->prepare("SELECT * FROM tableuser WHERE email = :email");
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "Utilisateur trouvé :<br>";
    echo "Email : " . htmlspecialchars($user['email']) . "<br>";
    echo "Mot de passe haché dans la BDD : " . htmlspecialchars($user['password']) . "<br>";

    // Vérifiez si le mot de passe correspond
    if (password_verify($password, $user['password'])) {
        echo "<p style='color: green;'>Mot de passe correct !</p>";
    } else {
        echo "<p style='color: red;'>Mot de passe incorrect.</p>";
    }
} else {
    echo "<p style='color: red;'>Aucun utilisateur trouvé avec cet email.</p>";
}
?>
