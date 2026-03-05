<?php
/**
 * Configuration globale du projet
 */

// ==============================================================================
// Chargement du .env
// ==============================================================================

/**
 *	Charge les variables d'environnement depuis un fichier .env
 *
 *	@param string $path Chemin vers le fichier .env
 */
function load_env_file($path) {
	if (!file_exists($path)) {
		return;
	}
	$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line) {
		$line = trim($line);
		if ($line === '' || $line[0] === '#') {
			continue;
		}
		$pos = strpos($line, '=');
		if ($pos === false) {
			continue;
		}
		$key = trim(substr($line, 0, $pos));
		$value = trim(substr($line, $pos + 1));
		$_ENV[$key] = $value;
		putenv("$key=$value");
	}
}

// Charger le .env depuis la racine du projet
load_env_file(dirname(dirname(__DIR__)) . '/.env');

// ==============================================================================
// Configuration
// ==============================================================================

// Désactiver l'affichage des erreurs deprecated
ini_set('display_errors', 'off');

// URL du serveur
$serveur = "http://localhost/association/";

// Chemin racine du projet
if (!defined('RACINE_PROJET')) {
	define('RACINE_PROJET', '/home/tilnede0x1182/code/tilnede0x1182/Personnel/2025/Entrainement/projet_fac/Web_et_Reseau/Sites_Gestion_Utilisateurs/Gestion_Membres_Association/L1_Association_2013_-_PHP-natif/');
}

// Configuration base de données (depuis .env)
$db_server = $_ENV['DB_HOST'] ?? 'localhost';
$db_user = $_ENV['DB_USER'] ?? '';
$db_password = $_ENV['DB_PASSWORD'] ?? '';
$db_name = $_ENV['DB_NAME'] ?? '';

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
