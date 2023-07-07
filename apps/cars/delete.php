<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Connexion à la base de données
    require '../../includes/connectionBDD.php';
    // Vérifier si le formulaire a été soumis avec confirmation
    if (isset($_POST['confirm_delete'])) {
        // Récupérer le chemin de l'image associée au véhicule
        $stmt = $db->prepare("SELECT img FROM cars WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $car = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagePath = $car['img'];

        // Supprimer l'image du serveur
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Suppression du véhicule
        $stmt = $db->prepare("DELETE FROM cars WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Redirection vers la liste des véhicules après la suppression
        header("Location: index.php");
        exit();
    }
}
?>


