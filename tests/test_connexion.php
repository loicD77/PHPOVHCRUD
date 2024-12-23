<?php
require_once 'Model/Connexion.php';

try {
    $connexion = new Connexion();
    $db = $connexion->getDb();
    echo "Connexion réussie à la base de données !";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
