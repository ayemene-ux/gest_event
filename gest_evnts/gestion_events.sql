CREATE DATABASE gestion_evenements;
USE gestion_evenements;

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    date_evenement DATE,
    description TEXT
);

CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    email VARCHAR(255)
);

CREATE TABLE inscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    participant_id INT,
    date_inscription DATETIME,
    FOREIGN KEY (event_id) REFERENCES events(id),
    FOREIGN KEY (participant_id) REFERENCES participants(id)
);
