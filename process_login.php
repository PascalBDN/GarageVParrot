<?php
session_start();
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garagevparrot";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification des erreurs de connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Vérification si les champs sont renseignés
if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['name'])) {
    die("Veuillez fournir l'e-mail, le mot de passe et le nom.");
}

// Échapper les valeurs des champs pour éviter les injections SQL
$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($_POST['password']);
$name = $conn->real_escape_string($_POST['name']);

// Requête pour récupérer l'utilisateur correspondant à l'e-mail fourni
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

// Vérification si l'utilisateur existe
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Vérification du mot de passe
    if (password_verify($password, $row['password'])) {
        // Mot de passe correct, connexion réussie
        $_SESSION['role'] = $row['role'];
        $_SESSION['name'] = $name; // Stocker le nom dans la session

        // Redirection vers la page appropriée en fonction du rôle de l'utilisateur
        if ($row['role'] == 'admin') {
            header("Location: apps/cars/create_car.php");
            exit();
        } elseif ($row['role'] == 'staff') {
            header("Location: staff.php");
            exit();
        }
    } else {
        // Mot de passe incorrect
        echo "Mot de passe incorrect.";
    }
} else {
    // Aucun utilisateur trouvé avec cet e-mail
    echo "Aucun utilisateur trouvé avec cet e-mail : " . $email;
}

// Fermeture de la connexion à la base de données
$conn->close();
?>