<?php
// Code de connexion à la base de données
include('includes/connectionBDD.php');

if (isset($_GET['id'])) {
    $carId = $_GET['id'];

    try {
        // Connexion à la base de données via PDO
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

        // Requête SQL pour récupérer les détails du véhicule en fonction de son ID
        $sql = "SELECT * FROM cars WHERE id = :carId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':carId', $carId);
        $stmt->execute();
        $carDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        // Afficher les détails du véhicule
        echo '<h5>Modèle : ' . $carDetails['modele'] . '</h5>';
        echo '<p>Prix : ' . $carDetails['prix'] . '€</p>';
        echo '<p>Année de mise en circulation : ' . $carDetails['annee'] . '</p>';
        echo '<p>Kilométrage : ' . $carDetails['kilometrage'] . ' km</p>';

        // Afficher les images du véhicule
        $imagePaths = explode(',', $carDetails['img']);
        foreach ($imagePaths as $imagePath) {
            $imgPath = trim($imagePath);
            echo '<img src="images/cars/' . $imgPath . '" alt="Voiture d\'occasion">';
        }
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>
