<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur ou de staff
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff')) {
    echo '<script>alert("Vous devez être connecté en tant qu\'administrateur ou staff pour accéder à cette page.");</script>';
    echo '<script>window.location.href = "../../admin/index.php";</script>';
    exit;
}

// Inclure le fichier de connexion à la base de données
include '../../includes/connectionBDD.php';

$stmt = $db->prepare("SELECT * FROM cars ORDER BY id DESC");
$stmt->execute();

$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Tableau des véhicules</title>
</head>

<body>
    
    <h3>Tableau des véhicules</h3>

    <a href="create_car.php" class="btn btn-success">Ajouter un nouveau véhicule</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Images</th>
                <th scope="col">Modèle</th>
                <th scope="col">Prix</th>
                <th scope="col">Année</th>
                <th scope="col">Énergie</th>
                <th scope="col">Kilométrage</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($cars as $key => $car) : ?>
    <tr>
        <th scope="row"><?php echo ++$key; ?></th>
        <td>
            <?php
            // Chemins d'images séparés
            $imagePaths = explode(',', $car['img']);

            foreach ($imagePaths as $imagePath) {
                // Supprimez les éventuels espaces autour du chemin de l'image
                $imagePath = trim($imagePath);

                // Chemin de base des images
                $basePath = '';

                // Chemin complet de l'image
                $absoluteImagePath = $basePath . $imagePath;

                // Afficher l'image
                echo '<img src="' . $absoluteImagePath . '" alt="Voiture d\'occasion" style="width: 80px;">';
            }
            ?>
        </td>
        <td><?php echo $car['modele']; ?></td>
        <td><?php echo $car['prix']; ?></td>
        <td><?php echo $car['annee']; ?></td>
        <td><?php echo $car['energie']; ?></td>
        <td><?php echo $car['kilometrage']; ?></td>
        <td><?php echo $car['description']; ?></td>

        <td>
            <!-- Actions -->
            <div class="btn-group" role="group" aria-label="Actions">
                        <a href="update.php?id=<?php echo $car['id'] ?>" type="button" class="btn btn-sm btn-outline-primary rounded">Modification</a>
                        <form action="delete.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $car['id'] ?>">
    <button type="submit" name="confirm_delete" class="btn btn-sm btn-outline-danger ms-2 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">Supprimer</button>
</form>

                    </div>
        </td>
    </tr>
<?php endforeach; ?>


        </tbody>
    </table>
</body>

</html>
