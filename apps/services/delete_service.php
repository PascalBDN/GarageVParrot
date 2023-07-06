<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo '<script>alert("Vous devez être connecté pour accéder à cette page.");</script>';
    echo '<script>window.location.href = "../../admin/index.php";</script>';
    exit;
}
include '../../includes/connectionBDD.php';


$id = $_GET['id'];

$sql = "DELETE FROM services WHERE id = ?";
$stmt= $db->prepare($sql);
$stmt->execute([$id]);

header("Location: index.php");
exit();