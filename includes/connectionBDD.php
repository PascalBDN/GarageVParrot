<?php

// Informations de connexion à la base de données
$host = "localhost"; // Adresse du serveur MySQL
$dbname = "garagevparrot"; // Nom de la base de données
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL

try {
    // Connexion à la base de données
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configuration supplémentaire
    // ...

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}