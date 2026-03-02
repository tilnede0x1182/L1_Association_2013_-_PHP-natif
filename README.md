# Association des Anciens de Paris 7

Ce projet est une application web destinée à être utilisée par une association (fictive) d'anciens élèves de l'univeristé Paris 7. Le projet a été fait dans le cadre d'un projet de groupe (initialemnt à 2) lors de mon curcus à l'université et constitue un simple exercice de code. Ce n'est pas un réel site web destiné à une association existante. Je l'ai refactoré afin qu'il soit terminé et modernisé un peu au niveau visuel. En effet, initialemnt, le css était presque inexistant (html presque pur). Ce site web permet aux membres de créer un compte, de consulter les profils des autres membres et de rester en contact avec leur communauté. Les utilisateurs peuvent publier des articles et proposer des projets collaboratifs. Un système de participation permet de rejoindre les projets des autres membres après validation du créateur. Les administrateurs disposent de droits de modération pour gérer le contenu et les utilisateurs.

## Fonctionnalités

- **Inscription et connexion** : Création d un compte membre avec validation des informations et authentification sécurisée.
- **Gestion du profil** : Modification des informations personnelles (nom, prénom, courriel, mot de passe).
- **Publication d articles** : Rédaction, modification et consultation d articles visibles par tous les membres.
- **Création de projets** : Proposition de projets collaboratifs avec description, dates et participants.
- **Demande de participation** : Les membres peuvent demander à rejoindre un projet existant.
- **Gestion des participants** : Le créateur d un projet peut accepter ou refuser les demandes de participation.
- **Retrait de participants** : Exclusion d un membre d un projet par son créateur.
- **Liste des membres** : Consultation de l annuaire des anciens élèves inscrits.
- **Modération** : Les administrateurs peuvent gérer le contenu et les utilisateurs du site.
- **Thèmes visuels** : Choix entre deux thèmes de couleur (orange et vert).
- **Page de contact** : Formulaire permettant de contacter l équipe du site.

## Technologies

- PHP 8.1
- MySQL 8.0
- HTML5 / CSS3
- Apache

## Installation

### WAMP (Windows)

1. Placer le projet dans `C:\wamp64\www\association\`
2. Démarrer WAMP et accéder à phpMyAdmin
3. Exécuter le fichier `database/creation_db.sql`
4. Lancer le seed :
   ```
   php database/seed.php
   ```
5. Accéder au site : http://localhost/association/

### XAMPP (Windows / macOS)

1. Placer le projet dans `C:\xampp\htdocs\association\` (Windows) ou `/Applications/XAMPP/htdocs/association/` (macOS)
2. Démarrer Apache et MySQL depuis le panneau XAMPP
3. Exécuter le fichier `database/creation_db.sql` via phpMyAdmin
4. Lancer le seed :
   ```
   php database/seed.php
   ```
5. Accéder au site : http://localhost/association/

### LAMP (Linux)

1. Placer le projet dans `/var/www/html/association/`
2. Créer la base de données :
   ```
   sudo mysql < database/creation_db.sql
   ```
3. Lancer le seed :
   ```
   php database/seed.php
   ```
4. Accéder au site : http://localhost/association/

## Identifiants de test

Les identifiants générés par le seed sont disponibles dans `database/users.txt`.
