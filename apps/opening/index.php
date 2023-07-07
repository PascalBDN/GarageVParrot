<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garagevparrot";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM Horaires");
    $stmt->execute();
    $horaires = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<?php
include ('../../includes/head.php');
?>

<div class="container mt-4">
    <h3 class="">Horaires du garage</h3>





    <table class="table">
        <?php foreach ($horaires as $horaire): ?>
        <tr>
            <td><?php echo $horaire['jour']; ?></td>
            <td>
                <?php if ($horaire['ouverture_matin'] != '00:00:00' && $horaire['fermeture_matin'] != '00:00:00'): ?>
                    <span class="badge badge-success">🟢</span>
                <?php else: ?>
                    <span class="badge badge-danger">🔴</span>
                <?php endif; ?>
                <?php echo substr($horaire['ouverture_matin'], 0, 5); ?> 
                - 
                <?php echo substr($horaire['fermeture_matin'], 0, 5); ?>
            </td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td>
                <?php if ($horaire['ouverture_apresmidi'] != '00:00:00' && $horaire['fermeture_apresmidi'] != '00:00:00'): ?>
                    <span class="badge badge-success">🟢</span>
                <?php else: ?>
                    <span class="badge badge-danger">🔴</span>
                <?php endif; ?>
                <?php echo substr($horaire['ouverture_apresmidi'], 0, 5); ?> 
                - 
                <?php echo substr($horaire['fermeture_apresmidi'], 0, 5); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>


