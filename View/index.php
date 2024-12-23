<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion de la classe Connexion
require_once './Model/Connexion.php';

session_start();

// Connexion à la base de données
$conn = new Connexion();
$db = $conn->getDb();

if ($db) {
    echo "Connexion réussie à la base de données.";
} else {
    die("Échec de la connexion à la base de données."); // Stopper le script si la connexion échoue
}

// Charger le contrôleur et l'action
$ctrl = $_GET['ctrl'] ?? 'user'; // Contrôleur par défaut : 'user'
$action = $_GET['action'] ?? 'home'; // Action par défaut : 'home'

$controllerFile = "./Controller/{$ctrl}Controller.php";
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = "{$ctrl}Controller";

    // Vérifier que la classe existe
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass($db);

        // Vérifier que la méthode existe dans le contrôleur
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            echo "Erreur : L'action '{$action}' n'existe pas dans le contrôleur '{$ctrl}'.";
        }
    } else {
        echo "Erreur : Le contrôleur '{$controllerClass}' n'existe pas.";
    }
} else {
    echo "Erreur : Le fichier du contrôleur '{$ctrl}Controller.php' est introuvable.";
}
?>
