DROP DATABASE IF EXISTS association1;
CREATE DATABASE association1;
USE association1;

CREATE TABLE asso (
    id VARCHAR(100) PRIMARY KEY,
    motdepasse VARCHAR(255) NOT NULL,
    Nom VARCHAR(100),
    Prenom VARCHAR(100),
    mail VARCHAR(255),
    Pays VARCHAR(100),
    CodePostal VARCHAR(20),
    DateNaissance VARCHAR(20),
    competence VARCHAR(50) DEFAULT 'Membre',
    datedinscription VARCHAR(20),
    datedederniereconnection VARCHAR(20),
    datedudernierpost VARCHAR(20),
    Connecte INT DEFAULT 0,
    nombredeposts INT DEFAULT 0,
    nombredeprojets INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE posts (
    idpost INT AUTO_INCREMENT PRIMARY KEY,
    Post TEXT,
    Objet VARCHAR(255),
    date VARCHAR(20),
    heure VARCHAR(20),
    id VARCHAR(100),
    FOREIGN KEY (id) REFERENCES asso(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE projets (
    idprojet INT AUTO_INCREMENT PRIMARY KEY,
    Objet VARCHAR(255),
    Texte TEXT,
    date VARCHAR(20),
    heure VARCHAR(20),
    id VARCHAR(100),
    FOREIGN KEY (id) REFERENCES asso(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE dataposts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idpost INT,
    idmembre VARCHAR(100),
    date VARCHAR(20),
    heure VARCHAR(20),
    FOREIGN KEY (idpost) REFERENCES posts(idpost) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE dataprojets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idprojet INT,
    idmembre VARCHAR(100),
    date VARCHAR(20),
    heure VARCHAR(20),
    FOREIGN KEY (idprojet) REFERENCES projets(idprojet) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
