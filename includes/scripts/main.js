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

            // Initialiser le slider d'images
            $('.slider').slick({
                dots: true,
                arrows: true,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                adaptiveHeight: true
            });
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
});


 // Configurer les barres de plage avec fourchettes (intervalle)
 $('#prixRange').ionRangeSlider({
    type: 'double',
    min: <?php echo $minMaxValues['min_prix']; ?>,
    max: <?php echo $minMaxValues['max_prix']; ?>,
    from: <?php echo $minMaxValues['min_prix']; ?>,
    to: <?php echo $minMaxValues['max_prix']; ?>,
    step: 1000,
    grid: true,
    grid_num: 10,
    postfix: ' €'
});

$('#kilometrageRange').ionRangeSlider({
    type: 'double',
    min: <?php echo $minMaxValues['min_kilometrage']; ?>,
    max: <?php echo $minMaxValues['max_kilometrage']; ?>,
    from: <?php echo $minMaxValues['min_kilometrage']; ?>,
    to: <?php echo $minMaxValues['max_kilometrage']; ?>,
    step: 1000,
    grid: true,
    grid_num: 10,
    postfix: ' km'
});

$('#anneeRange').ionRangeSlider({
    type: 'double',
    min: <?php echo $minMaxValues['min_annee']; ?>,
    max: <?php echo $minMaxValues['max_annee']; ?>,
    from: <?php echo $minMaxValues['min_annee']; ?>,
    to: <?php echo $minMaxValues['max_annee']; ?>,
    step: 1,
    grid: true,
    grid_num: 10
});

// Écouteur d'événement pour le changement des barres de plage
$('#prixRange, #kilometrageRange, #anneeRange').on('change', function () {
    filterCars();
});

// Fonction de filtrage des voitures
function filterCars() {
    var prixRange = $('#prixRange').val().split(';');
    var prixMin = parseFloat(prixRange[0]);
    var prixMax = parseFloat(prixRange[1]);

    var kilometrageRange = $('#kilometrageRange').val().split(';');
    var kilometrageMin = parseFloat(kilometrageRange[0]);
    var kilometrageMax = parseFloat(kilometrageRange[1]);

    var anneeRange = $('#anneeRange').val().split(';');
    var anneeMin = parseInt(anneeRange[0]);
    var anneeMax = parseInt(anneeRange[1]);

    // Filtrer les voitures en fonction des valeurs des barres de plage
    var filteredCars = <?php echo json_encode($cars); ?>.filter(function (car) {
        return car.prix >= prixMin &&
            car.prix <= prixMax &&
            car.kilometrage >= kilometrageMin &&
            car.kilometrage <= kilometrageMax &&
            car.annee >= anneeMin &&
            car.annee <= anneeMax;
    });

    // Mettre à jour la liste des voitures filtrées
    var carListHtml = '';
        filteredCars.forEach(function (car) {
            carListHtml += '<div class="col-sm-6 col-md-4 mt-4 mt-4">';
            carListHtml += '<div class="card">';
            <?php
            $imagePaths = explode(',', $car['img']);
            $imgPath = trim($imagePaths[0]);
            ?>
            carListHtml += '<img src="images/cars/<?php echo $imgPath; ?>" class="card-img-top rounded-3" alt="Voiture d\'occasion" style="height: 200px">';
            carListHtml += '<h5 class="card-title">' + car.modele + '</h5>';
            carListHtml += '<p class="card-text">Prix : ' + car.prix + '€</p>';
            carListHtml += '<p>Année de mise en circulation : ' + car.annee + '</p>';
            carListHtml += '<p>Kilométrage : ' + car.kilometrage + ' km</p>';
            carListHtml += '<a href="#" class="btn btn-primary open-modal" data-bs-toggle="modal" data-bs-target="#carModal" data-id="' + car.id + '">Lire la suite...</a>';
            carListHtml += '</div></div></div>';
        });


    $('#carList').html(carListHtml);
}
});