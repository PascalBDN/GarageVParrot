<?php
include_once('includes/connectionBDD.php');

$sql = "SELECT id, nom, description FROM services";
$stmt = $db->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Output data of each row
    $cardsPerRow = [
        'lg' => 4, // Grand écran : 3 cartes par ligne
        'md' => 6, // Moyen écran : 2 cartes par ligne
        'sm' => 12 // Petit écran : 1 carte par ligne
    ];

    echo '<div class="container">';
    echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="col col-12 col-md-6 col-lg-4">';
        echo '<div class="card mb-3">';
        echo '<div class="card-body">';
        echo '<h4 class="card-title">' . $row["nom"] . '</h4>';
        echo '<hr>';
        echo '<p class="card-text">' . $row["description"] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo "No services available";
}
?>




