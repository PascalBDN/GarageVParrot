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

    -- Création de la table Horaires.
    CREATE TABLE Horaires (
      id INT(11) NOT NULL AUTO_INCREMENT,
      jour ENUM('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche') NOT NULL,
      ouverture_matin TIME NOT NULL,
      fermeture_matin TIME NOT NULL,
      ouverture_apresmidi TIME NOT NULL,
      fermeture_apresmidi TIME NOT NULL,
      PRIMARY KEY (id)
    );

    -- Insertion d'horaires de démarrage pour la table horaires
    INSERT INTO Horaires (jour, ouverture_matin, fermeture_matin, ouverture_apresmidi, fermeture_apresmidi)
    VALUES
      ('Lundi', '09:00:00', '12:00:00', '14:00:00', '18:00:00'),
      ('Mardi', '09:30:00', '12:30:00', '14:00:00', '17:30:00'),
      ('Mercredi', '10:00:00', '13:00:00', '14:30:00', '19:00:00'),
      ('Jeudi', '08:00:00', '12:00:00', '13:30:00', '17:00:00'),
      ('Vendredi', '09:00:00', '12:00:00', '14:00:00', '18:00:00'),
      ('Samedi', '10:30:00', '13:30:00', '15:00:00', '17:30:00'),
      ('Dimanche', '11:00:00', '14:00:00', '15:30:00', '18:30:00');

      CREATE TABLE cars (
          id INT(11) NOT NULL AUTO_INCREMENT,
          img TEXT DEFAULT NULL,
          modele VARCHAR(255) DEFAULT NULL,
          prix DECIMAL(10,2) DEFAULT NULL,
          annee INT(11) DEFAULT NULL,
          energie VARCHAR(50) DEFAULT NULL,
          kilometrage INT(11) DEFAULT NULL,
          description TEXT DEFAULT NULL,
          securite TEXT DEFAULT NULL,
          places TEXT DEFAULT NULL,
          options_list VARCHAR(255) DEFAULT NULL,
          create_at DATETIME DEFAULT NULL,
          PRIMARY KEY (id)
        );



GaraVParrot


création d'un administrateur => http://localhost/create_admin.php
