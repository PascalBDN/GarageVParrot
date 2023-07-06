# GarageVParrot

    -- Création de la base de données garageVParrot.
    CREATE DATABASE garageVParrot;

    -- Creation de la table des services.
    CREATE TABLE services (
      id INT(11) NOT NULL AUTO_INCREMENT,
      nom VARCHAR(255) NOT NULL,
      description TEXT DEFAULT NULL,
      PRIMARY KEY (id)
    );
GaraVParrot


création d'un administrateur => http://localhost/create_admin.php
