# GarageVParrot

    -- Création de la base de données garageVParrot.
    CREATE DATABASE garageVParrot;

    -- Création de la table users.

    CREATE TABLE users (
      id INT(11) NOT NULL,
      username VARCHAR(255) NOT NULL,
      email VARCHAR(255) NULL DEFAULT NULL,
      password VARCHAR(255) NOT NULL,
      role ENUM('admin', 'staff') NOT NULL,
      PRIMARY KEY (id)
    );

    -- Creation de la table des services.
    CREATE TABLE services (
      id INT(11) NOT NULL AUTO_INCREMENT,
      nom VARCHAR(255) NOT NULL,
      description TEXT DEFAULT NULL,
      PRIMARY KEY (id)
    );
GaraVParrot


création d'un administrateur => http://localhost/create_admin.php
