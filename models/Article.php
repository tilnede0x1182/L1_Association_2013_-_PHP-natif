<?php
/**
 * Model Article (Post) - Gestion des articles dans la base de données
 */

/**
 * Récupère un article par son ID
 * @param int $idpost ID de l'article
 * @return array|false Données de l'article ou false
 */
function getArticle($idpost) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'SELECT * FROM posts WHERE idpost="' . mysqli_real_escape_string($connexion, $idpost) . '"';
	$resultat = mysqli_query($connexion, $requete);
	return mysqli_fetch_array($resultat);
}

/**
 * Récupère les derniers articles
 * @param int $limite Nombre d'articles à récupérer
 * @return array Liste des articles
 */
function getDerniersArticles($limite = 5) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT * FROM posts ORDER BY date DESC, heure DESC LIMIT ' . intval($limite);
	$resultat = mysqli_query($connexion, $requete);

	$articles = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$articles[] = $ligne;
	}
	return $articles;
}

/**
 * Récupère tous les articles avec pagination
 * @param int $limite Nombre max d'articles
 * @return array Liste des articles
 */
function getAllArticles($limite = 199) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT * FROM posts ORDER BY date DESC, heure DESC LIMIT ' . intval($limite);
	$resultat = mysqli_query($connexion, $requete);

	$articles = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$articles[] = $ligne;
	}
	return $articles;
}

/**
 * Récupère les articles d'un membre
 * @param string $idmembre ID du membre
 * @return array Liste des articles
 */
function getArticlesByMembre($idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT * FROM posts WHERE id="' . mysqli_real_escape_string($connexion, $idmembre) . '" ORDER BY date DESC, heure DESC';
	$resultat = mysqli_query($connexion, $requete);

	$articles = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$articles[] = $ligne;
	}
	return $articles;
}

/**
 * Récupère les modifications d'un article
 * @param int $idpost ID de l'article
 * @param int $limite Nombre max de modifications
 * @return array Liste des modifications
 */
function getModificationsArticle($idpost, $limite = 0) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT idmembre, date FROM dataposts WHERE idpost="' . mysqli_real_escape_string($connexion, $idpost) . '" ORDER BY date DESC, heure DESC';
	if ($limite > 0) $requete .= ' LIMIT ' . intval($limite);
	$resultat = mysqli_query($connexion, $requete);

	$modifications = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$modifications[] = $ligne;
	}
	return $modifications;
}

/**
 * Compte le nombre de modifications d'un article
 * @param int $idpost ID de l'article
 * @return int Nombre de modifications
 */
function countModificationsArticle($idpost) {
	$connexion = getConnexion();
	if (!$connexion) return 0;

	$requete = 'SELECT COUNT(*) as nb FROM dataposts WHERE idpost="' . mysqli_real_escape_string($connexion, $idpost) . '"';
	$resultat = mysqli_query($connexion, $requete);
	$ligne = mysqli_fetch_array($resultat);
	return intval($ligne['nb']);
}

/**
 * Crée un nouvel article
 * @param string $idmembre ID du membre auteur
 * @param string $objet Titre de l'article
 * @param string $contenu Contenu de l'article
 * @return bool
 */
function creerArticle($idmembre, $objet, $contenu) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$date = date('dmY');
	$heure = date('His');

	$requete = 'INSERT INTO posts (id, Objet, Post, date, heure) VALUES ("' .
		mysqli_real_escape_string($connexion, $idmembre) . '", "' .
		mysqli_real_escape_string($connexion, $objet) . '", "' .
		mysqli_real_escape_string($connexion, $contenu) . '", "' .
		$date . '", "' . $heure . '")';

	return mysqli_query($connexion, $requete);
}

/**
 * Modifie un article
 * @param int $idpost ID de l'article
 * @param string $objet Nouveau titre
 * @param string $contenu Nouveau contenu
 * @param string $idmembre ID du membre qui modifie
 * @return bool
 */
function modifierArticle($idpost, $objet, $contenu, $idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$date = date('dmY');
	$heure = date('His');

	// Mettre à jour l'article
	$requete = 'UPDATE posts SET Objet="' . mysqli_real_escape_string($connexion, $objet) . '", Post="' . mysqli_real_escape_string($connexion, $contenu) . '" WHERE idpost="' . mysqli_real_escape_string($connexion, $idpost) . '"';
	$resultat = mysqli_query($connexion, $requete);

	// Enregistrer la modification
	if ($resultat) {
		$requete2 = 'INSERT INTO dataposts (idpost, idmembre, date, heure) VALUES ("' .
			mysqli_real_escape_string($connexion, $idpost) . '", "' .
			mysqli_real_escape_string($connexion, $idmembre) . '", "' .
			$date . '", "' . $heure . '")';
		mysqli_query($connexion, $requete2);
	}

	return $resultat;
}

/**
 * Supprime un article
 * @param int $idpost ID de l'article
 * @return bool
 */
function supprimerArticle($idpost) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$idpostEchappe = mysqli_real_escape_string($connexion, $idpost);

	// Supprimer les modifications associées
	mysqli_query($connexion, 'DELETE FROM dataposts WHERE idpost="' . $idpostEchappe . '"');

	// Supprimer l'article
	return mysqli_query($connexion, 'DELETE FROM posts WHERE idpost="' . $idpostEchappe . '"');
}
?>
