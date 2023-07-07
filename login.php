<?php include ('includes/head.php'); ?>


<body>
    <div class="container">
        <h2>Connexion</h2>
        <form action="process_login.php" method="post"><div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            
            <button type="submit" class="btn btn-primary mt-2">Se connecter</button>
        </form>
    </div>
</body>
</html>
