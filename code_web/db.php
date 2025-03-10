<?php
$host = 'localhost'; // Adresse du serveur MySQL
$dbname = 'smarttech_db'; // Nom de la base de données
$username = 'amy'; // Nom d'utilisateur MySQL
$password = 'passer'; // Mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
