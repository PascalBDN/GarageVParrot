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
    form {
        margin-top: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $sql = "INSERT INTO services (nom, description) VALUES (?, ?)";
    $stmt= $db->prepare($sql);
    $stmt->execute([$nom, $description]);

    header("Location: index.php");
    exit();
}
?>

<form action="add_service.php" method="post">
    <label for="nom">Nom du service :</label>
    <input type="text" name="nom"><br>
    <label for="description">Description :</label>
    <textarea name="description"></textarea><br>
    <input type="submit" value="Ajouter">
</form>
