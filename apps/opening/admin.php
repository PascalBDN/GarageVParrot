<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garagevparrot";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $conn->prepare("UPDATE Horaires SET ouverture_matin=?, fermeture_matin=?, ouverture_apresmidi=?, fermeture_apresmidi=? WHERE jour=?");
        $stmt->execute([$_POST['ouverture_matin'], $_POST['fermeture_matin'], $_POST['ouverture_apresmidi'], $_POST['fermeture_apresmidi'], $_POST['jour']]);
        echo "Horaires mis à jour avec succès";
    }

    $stmt = $conn->prepare("SELECT * FROM Horaires");
    $stmt->execute();
    $horaires = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
form {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
form div {
    margin-right: 10px;
}
</style>
</head>
<body>

<h2>Gestion des horaires du garage</h2>

<?php foreach ($horaires as $horaire): ?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <div>
        <label for="jour">Jour:</label><br>
        <input type="text" id="jour" name="jour" value="<?php echo $horaire['jour']; ?>" readonly>
    </div>
    <div>
        <label for="ouverture_matin">Ouverture matin:</label><br>
        <input type="time" id="ouverture_matin" name="ouverture_matin" value="<?php echo $horaire['ouverture_matin']; ?>">
    </div>
    <div>
        <label for="fermeture_matin">Fermeture matin:</label><br>
        <input type="time" id="fermeture_matin" name="fermeture_matin" value="<?php echo $horaire['fermeture_matin']; ?>">
    </div>
    <div>
        <label for="ouverture_apresmidi">Ouverture après-midi:</label><br>
        <input type="time" id="ouverture_apresmidi" name="ouverture_apresmidi" value="<?php echo $horaire['ouverture_apresmidi']; ?>">
    </div>
    <div>
        <label for="fermeture_apresmidi">Fermeture après-midi:</label><br>
        <input type="time" id="fermeture_apresmidi" name="fermeture_apresmidi" value="<?php echo $horaire['fermeture_apresmidi']; ?>">
    </div>
    <div>
        <input type="submit" value="Mettre à jour" class="btn btn-primary">
    </div>
</form> 
<?php endforeach; ?>

</body>
</html>

