<?php
require_once './Model/Connexion.php';

$conn = new Connexion();
$db = $conn->getDb();

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

$email = 'quentin@gmail.com'; // Changez pour tester un autre email
$password = 'quentin'; // Changez pour tester un autre mot de passe

echo "<h2>Test de connexion pour l'utilisateur : $email</h2>";

$stmt = $db->prepare("SELECT * FROM tableuser WHERE email = :email");
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "Utilisateur trouvé :<br>";
    echo "Email : " . htmlspecialchars($user['email']) . "<br>";
    echo "Mot de passe haché : " . htmlspecialchars($user['password']) . "<br>";

    if (password_verify($password, $user['password'])) {
        echo "<p style='color: green;'>Connexion réussie : le mot de passe correspond.</p>";
    } else {
        echo "<p style='color: red;'>Connexion échouée : le mot de passe ne correspond pas.</p>";
    }
} else {
    echo "<p style='color: red;'>Aucun utilisateur trouvé avec cet email.</p>";
}
?>
