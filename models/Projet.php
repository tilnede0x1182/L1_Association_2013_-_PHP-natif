<?php
/**
 * Model Projet - Gestion des projets dans la base de données
 */

/**
 * Récupère un projet par son ID
 * @param int $idprojet ID du projet
 * @return array|false Données du projet ou false
 */
function getProjet($idprojet) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'SELECT * FROM projets WHERE idprojet="' . mysqli_real_escape_string($connexion, $idprojet) . '"';
	$resultat = mysqli_query($connexion, $requete);
	return mysqli_fetch_array($resultat);
}

/**
 * Récupère les derniers projets
 * @param int $limite Nombre de projets à récupérer
 * @return array Liste des projets
 */
function getDerniersProjets($limite = 15) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT * FROM projets ORDER BY date DESC, heure DESC LIMIT ' . intval($limite);
	$resultat = mysqli_query($connexion, $requete);

	$projets = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$projets[] = $ligne;
	}
	return $projets;
}

/**
 * Récupère les projets d'un membre
 * @param string $idmembre ID du membre
 * @return array Liste des projets
 */
function getProjetsByMembre($idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT * FROM projets WHERE id="' . mysqli_real_escape_string($connexion, $idmembre) . '" ORDER BY date DESC, heure DESC';
	$resultat = mysqli_query($connexion, $requete);

	$projets = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$projets[] = $ligne;
	}
	return $projets;
}

/**
 * Récupère les modifications d'un projet
 * @param int $idprojet ID du projet
 * @param int $limite Nombre max de modifications
 * @return array Liste des modifications
 */
function getModificationsProjet($idprojet, $limite = 0) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT idmembre, date FROM dataprojets WHERE idprojet="' . mysqli_real_escape_string($connexion, $idprojet) . '" ORDER BY date DESC';
	if ($limite > 0) $requete .= ' LIMIT ' . intval($limite);
	$resultat = mysqli_query($connexion, $requete);

	$modifications = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$modifications[] = $ligne;
	}
	return $modifications;
}

/**
 * Compte le nombre de modifications d'un projet
 * @param int $idprojet ID du projet
 * @return int Nombre de modifications
 */
function countModificationsProjet($idprojet) {
	$connexion = getConnexion();
	if (!$connexion) return 0;

	$requete = 'SELECT COUNT(*) as nb FROM dataprojets WHERE idprojet="' . mysqli_real_escape_string($connexion, $idprojet) . '"';
	$resultat = mysqli_query($connexion, $requete);
	$ligne = mysqli_fetch_array($resultat);
	return intval($ligne['nb']);
}

/**
 * Crée un nouveau projet
 * @param string $idmembre ID du membre auteur
 * @param string $objet Titre du projet
 * @param string $contenu Contenu du projet
 * @return bool
 */
function creerProjet($idmembre, $objet, $contenu) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$date = date('dmY');
	$heure = date('His');

	$requete = 'INSERT INTO projets (id, Objet, Texte, date, heure) VALUES ("' .
		mysqli_real_escape_string($connexion, $idmembre) . '", "' .
		mysqli_real_escape_string($connexion, $objet) . '", "' .
		mysqli_real_escape_string($connexion, $contenu) . '", "' .
		$date . '", "' . $heure . '")';

	$resultat = mysqli_query($connexion, $requete);

	// Mettre à jour le compteur de projets du membre
	if ($resultat) {
		mysqli_query($connexion, 'UPDATE asso SET nombredeprojets = nombredeprojets + 1, datedudernierprojet = "' . $date . '" WHERE id="' . mysqli_real_escape_string($connexion, $idmembre) . '"');
	}

	return $resultat;
}

/**
 * Modifie un projet
 * @param int $idprojet ID du projet
 * @param string $objet Nouveau titre
 * @param string $contenu Nouveau contenu
 * @param string $idmembre ID du membre qui modifie
 * @return bool
 */
function modifierProjet($idprojet, $objet, $contenu, $idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$date = date('dmY');
	$heure = date('His');

	// Mettre à jour le projet
	$requete = 'UPDATE projets SET Objet="' . mysqli_real_escape_string($connexion, $objet) . '", Texte="' . mysqli_real_escape_string($connexion, $contenu) . '" WHERE idprojet="' . mysqli_real_escape_string($connexion, $idprojet) . '"';
	$resultat = mysqli_query($connexion, $requete);

	// Enregistrer la modification
	if ($resultat) {
		$requete2 = 'INSERT INTO dataprojets (idprojet, idmembre, date, heure) VALUES ("' .
			mysqli_real_escape_string($connexion, $idprojet) . '", "' .
			mysqli_real_escape_string($connexion, $idmembre) . '", "' .
			$date . '", "' . $heure . '")';
		mysqli_query($connexion, $requete2);
	}

	return $resultat;
}

/**
 * Supprime un projet
 * @param int $idprojet ID du projet
 * @return bool
 */
function supprimerProjet($idprojet) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	// Récupérer l'auteur du projet pour décrémenter son compteur
	$projet = getProjet($idprojet);
	if ($projet) {
		mysqli_query($connexion, 'UPDATE asso SET nombredeprojets = nombredeprojets - 1 WHERE id="' . mysqli_real_escape_string($connexion, $projet['id']) . '"');
	}

	$idprojetEchappe = mysqli_real_escape_string($connexion, $idprojet);

	// Supprimer les modifications associées
	mysqli_query($connexion, 'DELETE FROM dataprojets WHERE idprojet="' . $idprojetEchappe . '"');

	// Supprimer le projet
	return mysqli_query($connexion, 'DELETE FROM projets WHERE idprojet="' . $idprojetEchappe . '"');
}
?>
