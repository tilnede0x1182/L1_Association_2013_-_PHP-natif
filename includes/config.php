<?php
/**
 * Configuration globale du projet
 */

// Désactiver l'affichage des erreurs deprecated
ini_set('display_errors', 'off');

// URL du serveur
$serveur = "http://localhost/association/";

// Chemin racine du projet
if (!defined('RACINE_PROJET')) {
	define('RACINE_PROJET', '/home/tilnede0x1182/code/tilnede0x1182/Personnel/2025/Entrainement/projet_fac/Web_et_Reseau/Sites_Gestion_Utilisateurs/Gestion_Membres_Association/L1_Association_2013_-_PHP-natif/');
}

// Configuration base de données
$db_server = "localhost";
$db_user = "tilnede0x1182";
$db_password = "tilnede0x1182";
$db_name = "association1";

/**
 * Connexion à la base de données
 * @return mysqli|false La connexion ou false en cas d'erreur
 */
function getConnexion() {
	global $db_server, $db_user, $db_password, $db_name;
	$connexion = mysqli_connect($db_server, $db_user, $db_password, $db_name);
	if (!$connexion) {
		echo "Pas de connexion au serveur";
		return false;
	}
	return $connexion;
}
?>
