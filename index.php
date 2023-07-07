<?php
require_once 'includes/connectionBDD.php';
include 'includes/head.php';
include 'includes/navbar.php';

?>

// Récupérer les avis approuvés de la base de données
$query = "SELECT * FROM avis_clients WHERE (approved = 1 AND (note = 4 OR note = 5)) ORDER BY id DESC";
$result = $db->query($query);
$reviews = $result->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les photos aléatoires de la base de données cars
$query = "SELECT img FROM cars ORDER BY RAND() LIMIT 5";
$result = $db->query($query);
$carImages = $result->fetchAll(PDO::FETCH_COLUMN);

// Mélanger les avis
shuffle($reviews);

?>
<div class="container mt-4">
    <h1>Bienvenue au garage V. Parrot !</h1>

    <p>Le garage V. parrot est plus qu'un simple garage automobile - c'est une passion pour les véhicules et un dévouement à fournir un service de qualité supérieure à nos clients. Situé à Brennilis, nous avons bâti notre réputation en offrant des services de réparation et d'entretien automobile de haute qualité depuis 1982.</p>

    <p>Notre équipe de techniciens qualifiés et expérimentés est dotée des outils et des connaissances les plus récents pour traiter une large gamme de problèmes automobiles, qu'il s'agisse de réparations majeures ou d'un simple entretien préventif. Nous travaillons sur tous les types de véhicules, des voitures classiques aux modèles modernes.</p>
    <?php
    include('services.php');
    ?>
    <p>Chez V. Parrot, nous sommes fiers de notre travail et nous nous engageons à garantir que chaque véhicule qui entre dans notre garage est traité avec le plus grand soin et la plus grande attention. Nos techniciens sont toujours prêts à expliquer clairement les réparations nécessaires et à fournir des estimations précises.</p>

    <p>De plus, nous proposons une gamme de véhicules d'occasion de qualité, minutieusement sélectionnés et révisés par nos soins pour garantir à nos clients une expérience d'achat de voiture sans stress.</p>

    <p>Naviguez sur notre site pour découvrir plus sur nos services, notre équipe, et comment nous pouvons vous aider à maintenir votre véhicule en excellent état. N'hésitez pas à nous contacter pour toute question ou pour prendre un rendez-vous.</p>

    <p>Nous avons hâte de vous accueillir au garage !</p>
</div>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="reviewsCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php foreach ($reviews as $index => $review) : ?>
                                <li data-target="#reviewsCarousel" data-slide-to="<?= $index ?>" class="<?= $index == 0 ? 'active' : '' ?>"></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php foreach ($reviews as $index => $review) : ?>
                                <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($review['nom']) ?></h5>
                                            <p class="card-text"><?= htmlspecialchars($review['commentaire']) ?></p>
                                            <p class="card-text">
                                                <small class="text-muted"><?= str_repeat('★', $review['note']) ?></small>
                                            </p>
                                        </div>
                                        
                                    </div>
                                    <a href="comments.php">Voir tous les commentaires</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev mt-4" href="#reviewsCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#reviewsCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div id="carCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($carImages as $index => $image) : ?>
                        <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                            <img src="apps/cars/<?= $image ?>" class="d-block w-100 rounded" alt="Car Image">
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#carCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>
<script src="srcipts/main.js"></script>
<?php
// Inclure le pied de page
include('footer.php');
?>


