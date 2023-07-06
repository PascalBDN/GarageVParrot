<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo '<script>alert("Vous devez être connecté pour accéder à cette page.");</script>';
    echo '<script>window.location.href = "../../admin/index.php";</script>';
    exit;
}
include '../../includes/connectionBDD.php';
include('../../includes/head.php');
?>

<style>
    .service {
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
    }

    .service h2 {
        margin: 0;
        color: #333;
        font-size: 18px;
    }

    .service p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }

    .service a {
        margin-right: 10px;
        color: #666;
        text-decoration: none;
    }

    .service a:hover {
        color: #333;
    }
</style>

<?php
$sql = "SELECT id, nom, description FROM services";
$result = $db->query($sql);

if ($result->rowCount() > 0) {
    while ($row = $result->fetch()) {
        echo "<div class='service'>";
        echo "<h2>" . $row["nom"] . "</h2>";
        echo "<p>" . $row["description"] . "</p>";
        echo "<a href='edit_service.php?id=" . $row["id"] . "'>Edit</a>";
        echo "<a href='delete_service.php?id=" . $row["id"] . "'>Delete</a>";
        echo "</div>";
    }
} else {
    echo "No services available";
}
?>

<a href="add_service.php">Ajouter un nouveau service</a>



