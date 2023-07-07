<?php
// Établir la connexion à la base de données MySQL
require '../../includes/connectionBDD.php';

// Vérifier que les champs sont bien complétés
$erreurs = []; // Tableau pour stocker les erreurs de validation

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs soumises dans le formulaire
    $modele = $_POST['modele'];
    $prix = $_POST['prix'];
    $annee = $_POST['annee'];
    $energie = $_POST['energie'];
    $kilometrage = $_POST['kilometrage'];
    $description = $_POST['description'];

    $images = $_FILES['img'];

    // Validation des champs obligatoires
    if (empty($modele)) {
        $erreurs[] = 'Modèle obligatoire';
    }

    if (empty($prix)) {
        $erreurs[] = 'Prix obligatoire';
    }

    if (empty($annee)) {
        $erreurs[] = 'Année obligatoire';
    }

    if (empty($kilometrage)) {
        $erreurs[] = 'Kilométrage obligatoire';
    }

    if (empty($description)) {
        $erreurs[] = 'Description obligatoire';
    }

    // Si aucune erreur de validation n'est détectée
    if (empty($erreurs)) {
        try {
            $imgPaths = []; // Tableau pour stocker les chemins des images

            // Déplacer les fichiers téléchargés vers le dossier des images
            foreach ($images['tmp_name'] as $index => $tmpName) {
                // Obtenir l'extension du fichier
                $extension = pathinfo($images['name'][$index], PATHINFO_EXTENSION);

                // Générer un nom de fichier unique avec le nom d'origine et un identifiant unique
                $uniqueName = pathinfo($images['name'][$index], PATHINFO_FILENAME) . '_' . uniqid('', true) . '.' . $extension;

                // Chemin complet de l'image avec le nouveau nom de fichier
                $imgPath = '../../assets/images/cars/' . $uniqueName;

                // Déplacer le fichier téléchargé vers le dossier des images
                move_uploaded_file($tmpName, $imgPath);

                // Ajouter le chemin de l'image au tableau
                $imgPaths[] = $imgPath;
            }

            // Récupérer les options sélectionnées
            $securite = isset($_POST['securite']) ? $_POST['securite'] : [];
            $places = isset($_POST['places']) ? $_POST['places'] : [];

            // Préparer et exécuter la requête d'insertion des données dans la table "cars"
            $stmt = $db->prepare("INSERT INTO cars (img, modele, prix, annee, energie, kilometrage, description, securite, places) 
                VALUES (:img, :modele, :prix, :annee, :energie, :kilometrage, :description, :securite, :places)");
            $stmt->bindValue(':img', implode(',', $imgPaths));
            $stmt->bindValue(':modele', $modele);
            $stmt->bindValue(':prix', $prix);
            $stmt->bindValue(':annee', $annee);
            $stmt->bindValue(':energie', $energie);
            $stmt->bindValue(':kilometrage', $kilometrage);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':securite', implode(',', $securite)); // Convertir le tableau en une chaîne de caractères séparée par des virgules
            $stmt->bindValue(':places', implode(',', $places)); // Convertir le tableau en une chaîne de caractères séparée par des virgules

            $stmt->execute();
        } catch (PDOException $e) {
            // Gérer l'erreur d'exécution de la requête
            $erreurs[] = 'Erreur lors de l\'ajout du véhicule : ' . $e->getMessage();
        }
        // Rediriger vers la page d'accueil après l'ajout du véhicule
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="app.css">
    <title>Ajouter un véhicule</title>
</head>

<body>
    <h3>Ajouter un véhicule</h3>
    <p>
        <a href="index.php" class="btn btn-secondary">Liste des véhicules</a>
    </p>

    <form method="post" enctype="multipart/form-data">
        <?php if (!empty($erreurs)) : ?>
            <!-- Afficher les erreurs de validation s'il y en a -->
            <div class="alert alert-danger">
                <?php foreach ($erreurs as $erreur) : ?>
                    <p><?php echo $erreur; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Images</label><br>
            <input type="file" name="img[]" multiple>
        </div>
        <div class="mb-3">
            <label class="form-label">Modèle</label><br>
            <input type="text" class="form-control" name="modele">
        </div>
        <div class="mb-3">
            <label class="form-label">Prix</label><br>
            <input type="number" class="form-control" name="prix">
        </div>
        <div class="mb-3">
            <label class="form-label">Année</label><br>
            <input type="number" class="form-control" name="annee">
        </div>
        <div class="mb-3">
            <label class="form-label">Énergie</label><br>
            <select class="form-select" name="energie">
                <option value="essence">Essence</option>
                <option value="diesel">Diesel</option>
                <option value="electrique">Électrique</option>
                <option value="hybride">Hybride</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kilométrage</label><br>
            <input type="number" class="form-control" name="kilometrage">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label><br>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Sécurité</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="securite[]" value="ABS">
                <label class="form-check-label">ABS</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="securite[]" value="Airbags">
                <label class="form-check-label">Airbags</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="securite[]" value="Antidémarrage">
                <label class="form-check-label">Antidémarrage</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre de places</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="places[]" value="2">
                <label class="form-check-label">2 places</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="places[]" value="4">
                <label class="form-check-label">4 places</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="places[]" value="5">
                <label class="form-check-label">5 places</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter le véhicule</button>
    </form>
</body>

</html>
