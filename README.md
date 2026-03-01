# L1 - Association

## Description
Le site web est une plateforme PHP/MySQL développée « from scratch » pour une association (fictive) d’anciens étudiants.
Les membres peuvent s’inscrire, se connecter et gérer leurs informations personnelles en toute sécurité.
Ils ont la possibilité de publier, modifier et supprimer des articles ainsi que des projets, avec historique des modifications.
Une interface simple permet de naviguer entre les listes de membres, d’articles et de projets, et d’afficher des détails sur chaque élément.
Deux thèmes CSS offrent un choix de style, et le code intègre des fonctions utilitaires pour la gestion des dates et de l’affichage.

## Technologies et versions
- **PHP** 5.5.x (extensions `mysql_*`, sessions, SNMP non utilisée ici)
- **MySQL** 5.6 (base `association1`, tables `asso`, `posts`, `projets`, `dataposts`, `dataprojets`)
- **HTML5**
- **CSS3** (deux thèmes : `style1.css`, `style2.css`)
- **JavaScript** minimal — shiv HTML5 pour anciennes versions d’IE
- **MD5** pour hachage de mot de passe

## Fonctionnalités implémentées
1. **Inscription**
   - Formulaire de création de compte (nom, prénom, mail, pays, code postal, date de naissance)
   - Génération d’un mot de passe aléatoire
   - Vérification de validité des champs (regex, date, e-mail)
2. **Connexion / Déconnexion**
   - Authentification via `$_SESSION['id']` + `$_SESSION['motdepasse']` MD5
   - Mise à jour de la date de dernière connexion
3. **Gestion des membres**
   - Liste triable des membres (compétence, identifiant, date d’inscription, etc.)
   - Page de profil détaillée : compétence, projets, posts, ancienneté, statut “connecté”
   - Modification des informations personnelles : nom, prénom, identifiant, e-mail, code postal, pays, date de naissance, mot de passe
   - Suppression de compte (cascade : supprime projets et posts associés)
4. **Articles (“Posts”)**
   - Création, édition, suppression de posts
   - Stockage des modifications dans `dataposts` (auteurs, dates)
   - Affichage des 5 derniers posts sur la page d’accueil
   - Liste complète paginée jusqu’à 199 articles
   - Vue détaillée d’un article unique
   - Liste des auteurs ayant modifié un article
5. **Projets**
   - Création, édition, suppression de projets
   - Stockage des modifications dans `dataprojets`
   - Affichage des 15 derniers projets sur la page “Nouveau Projet”
   - Liste complète des projets pour chaque membre
6. **Navigation & présentation**
   - Menu principal adaptatif selon connexion et rôle
   - Choix de deux thèmes CSS (“Coucher de soleil” / “Rosée du matin”)
   - Pages “À propos” et “Contact” statiques
   - Favicon, logo et images de header
7. **Utilitaires**
   - Fonctions partagées (`ConversionDate`, `detectlId`, `CalcAnciennete`)
   - Générateur de mot de passe aléatoire
   - Inclusions dynamiques de CSS et scripts de compatibilité HTML5

## Fonctionnalités administrateur
Les administrateurs (membres avec compétence = 1) disposent de droits étendus :
- **Gestion des articles** : visualisation de l'historique des modifications de tous les articles, accès à la liste complète des auteurs ayant modifié un article
- **Gestion des projets** : visualisation des modifications de tous les projets (pas uniquement les siens), accès à la liste complète des auteurs via "Afficher la liste"
- **Gestion des membres** : accès à la liste complète des membres avec informations détaillées
- **Modération** : possibilité de voir les dates de dernière modification sur tous les contenus

