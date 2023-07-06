<?php
// Connectez-vous à la base de données
$db = new PDO('mysql:host=localhost;dbname=garagevparrot', 'root', '');

// Vérifiez si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les valeurs du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    // Effectuez les validations nécessaires sur les valeurs reçues
    
    // Hash du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insérez le nouvel administrateur dans la base de données
    $query = $db->prepare('INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)');
    $query->execute([$username, $hashedPassword, $email, 'admin']);
    
    // Redirigez l'utilisateur vers la page de liste des utilisateurs
    header('Location: index.php');
    exit();
}
?>

<?php 
include ('includes/head.php');
?>

    <div class="container">
        <h1>Créer un nouvel administrateur</h1>
    
        <form method="POST" action="create_admin.php">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
        
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
        
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        
            <button type="submit" class="btn btn-primary">Créer administrateur</button>
        </form>
    </div>
</body>

</html>