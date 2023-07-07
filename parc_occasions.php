<?php
// Inclure l'en-tête
include('includes/head.php');
include('includes/navbar.php');
?>

<body>

    <!-- Modal -->
    <div class="modal fade" id="carModal" tabindex="-1" role="dialog" aria-labelledby="carModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carModalLabel">Détails du véhicule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Les détails du véhicule seront insérés ici -->
                </div>
            </div>
        </div>
    </div>

    <?php
    // Code de connexion à la base de données
    include('includes/connectionBDD.php');

    try {
      
        // Requête SQL pour récupérer les valeurs minimales et maximales de la table "cars"
        $sql = "SELECT MIN(prix) AS min_prix, MAX(prix) AS max_prix, MIN(kilometrage) AS min_kilometrage, MAX(kilometrage) AS max_kilometrage, MIN(annee) AS min_annee, MAX(annee) AS max_annee FROM cars";
        $stmt = $db->query($sql);
        $minMaxValues = $stmt->fetch(PDO::FETCH_ASSOC);

        // Requête SQL pour récupérer tous les enregistrements de la table "cars"
        $sqlCars = "SELECT * FROM cars";
        $stmtCars = $db->query($sqlCars);
        $cars = $stmtCars->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
    ?>

    <div class="container">
        

            <!-- Liste des voitures -->
            <div id="carList" class="col-12 row mt-4">
    <?php
    // Pagination variables
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $itemsPerPage = 12;
    $startIndex = ($currentPage - 1) * $itemsPerPage;
    $totalItems = count($cars);
    $totalPages = ceil($totalItems / $itemsPerPage);

    // Get a subset of cars based on the pagination variables
    $pagedCars = array_slice($cars, $startIndex, $itemsPerPage);

    foreach ($pagedCars as $car) :
    ?>
    <div class="col-sm-6 col-md-4 mt-4 mt-4">
        <div class="card">
        <?php
$imagePaths = explode(',', $car['img']);
$imgPath = trim($imagePaths[0]);
?>
<img src="images/cars/<?php echo $imgPath; ?>" class="card-img-top rounded-3" alt="Voiture d'occasion"
                style="height: 200px">
            <div class="card-body">
                <h5 class="card-title"><?php echo $car['modele']; ?></h5>
                <p class="card-text">Prix : <?php echo $car['prix']; ?>€</p>
                <p>Année de mise en circulation : <?php echo $car['annee']; ?></p>
                <p>Kilométrage : <?php echo $car['kilometrage']; ?> km</p>
                <a href="#" class="btn btn-sm btn-primary open-modal" data-bs-toggle="modal"
                    data-bs-target="#carModal" data-id="<?php echo $car['id']; ?>">Détails
                </a>
                <a href="contact.php?subject=Contact%20-%20<?php echo $car['modele']; ?>%20(<?php echo $car['annee']; ?>)"
                    class="btn btn-sm btn-primary" data-id="<?php echo $car['modele']; ?>">Contactez Nous</a>

            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center mt-4">
        <?php if ($currentPage > 1) : ?>
        <li class="page-item">
            <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Précédent</a>
        </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages) : ?>
        <li class="page-item">
            <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Suivant</a>
        </li>
        <?php endif; ?>
    </ul>
</nav>

        </div>
    </div>

    

    <?php
// Inclure le pied de page
include('footer.php');
?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JavaScript and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ion.rangeSlider JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

    <script>
        $(document).ready(function () {
            // Écouteur d'événement pour le clic sur le lien "Lire la suite"
            $('.open-modal').click(function (e) {
                e.preventDefault();

                // Récupérer l'identifiant du véhicule à partir de l'attribut data-id
                var carId = $(this).data('id');

                // Requête AJAX pour récupérer les détails du véhicule
                $.ajax({
                    url: 'get_car_details.php', // Chemin vers le script PHP qui récupère les détails du véhicule
                    type: 'GET',
                    data: {
                        id: carId
                    },
                    success: function (response) {
                        // Insérer les détails du véhicule dans la fenêtre modale
                        $('.modal-body').html(response);
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

           
    </script>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- Bootstrap JavaScript and Popper.js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- ion.rangeSlider CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css" />
<!-- ion.rangeSlider JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>


</body>

</html>



