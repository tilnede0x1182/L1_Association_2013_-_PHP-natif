<?php
/**
 * Fichier d'initialisation - à inclure au début de chaque page
 *
 * Usage: include 'includes/init.php'; (depuis la racine)
 * Ou: include __DIR__ . '/../includes/init.php'; (depuis un sous-dossier)
 */

// Démarrer la session si pas déjà fait
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// Valeurs par défaut de session
if (empty($_SESSION['id'])) $_SESSION['id'] = 80;
if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse'] = 80;
if (empty($_SESSION['style'])) $_SESSION['style'] = 1;

// Inclure la configuration
require_once __DIR__ . '/config.php';

// Inclure les fonctions utilitaires
require_once __DIR__ . '/fonctions.php';

// Inclure les models
require_once __DIR__ . '/../models/Membre.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Projet.php';
?>
