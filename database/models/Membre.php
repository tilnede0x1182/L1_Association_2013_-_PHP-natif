<?php
/**
 * Model Membre - Gestion des membres dans la base de données
 */

/**
 * Récupère un membre par son identifiant
 * @param string $id Identifiant du membre
 * @return array|false Données du membre ou false
 */
function getMembre($id) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'SELECT * FROM asso WHERE id="' . mysqli_real_escape_string($connexion, $id) . '"';
	$resultat = mysqli_query($connexion, $requete);
	return mysqli_fetch_array($resultat);
}

/**
 * Récupère tous les membres avec tri
 * @param string $classement Champ de tri
 * @param string $ordre ASC ou DESC
 * @return array Liste des membres
 */
function getAllMembres($classement = 'id', $ordre = 'ASC') {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$champsValides = array('id', 'competence', 'datedinscription', 'datedederniereconnection', 'nombredeprojets', 'datedudernierpost');
	if (!in_array($classement, $champsValides)) $classement = 'id';
	if ($ordre != 'DESC') $ordre = 'ASC';

	$requete = "SELECT * FROM asso ORDER BY " . $classement . " " . $ordre;
	$resultat = mysqli_query($connexion, $requete);

	$membres = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$membres[] = $ligne;
	}
	return $membres;
}

/**
 * Vérifie si un membre existe
 * @param string $id Identifiant du membre
 * @return bool
 */
function membreExiste($id) {
	return (bool) getMembre($id);
}

/**
 * Met à jour la date de dernière connexion
 * @param string $id Identifiant du membre
 * @return bool
 */
function updateDerniereConnexion($id) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$date = date('dmY');
	$requete = 'UPDATE asso SET datedederniereconnection="' . $date . '" WHERE id="' . mysqli_real_escape_string($connexion, $id) . '"';
	return mysqli_query($connexion, $requete);
}

/**
 * Crée un nouveau membre
 * @param array $donnees Données du membre
 * @return bool
 */
function creerMembre($donnees) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'INSERT INTO asso (id, motdepasse, Nom, Prenom, mail, Pays, CodePostal, DateNaissance, datedinscription, competence, nombredeprojets, datedudernierprojet, datedederniereconnection) VALUES ("' .
		mysqli_real_escape_string($connexion, $donnees['id']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['motdepasse']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['Nom']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['Prenom']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['mail']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['Pays']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['CodePostal']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['DateNaissance']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['datedinscription']) . '", "' .
		'Membre", 0, 0, 0)';

	return mysqli_query($connexion, $requete);
}

/**
 * Supprime un membre et ses contenus associés
 * @param string $id Identifiant du membre
 * @return bool
 */
function supprimerMembre($id) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$idEchappe = mysqli_real_escape_string($connexion, $id);

	// Supprimer les projets du membre
	mysqli_query($connexion, 'DELETE FROM projets WHERE id="' . $idEchappe . '"');
	mysqli_query($connexion, 'DELETE FROM dataprojets WHERE idmembre="' . $idEchappe . '"');

	// Supprimer les posts du membre
	mysqli_query($connexion, 'DELETE FROM posts WHERE id="' . $idEchappe . '"');
	mysqli_query($connexion, 'DELETE FROM dataposts WHERE idmembre="' . $idEchappe . '"');

	// Supprimer le membre
	return mysqli_query($connexion, 'DELETE FROM asso WHERE id="' . $idEchappe . '"');
}

/**
 * Supprime un membre avec vérification du mot de passe
 * @param string $id Identifiant du membre
 * @param string $motdepasse Mot de passe hashé
 * @return bool
 */
function supprimerMembreAvecVerification($id, $motdepasse) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$idEchappe = mysqli_real_escape_string($connexion, $id);
	$mdpEchappe = mysqli_real_escape_string($connexion, $motdepasse);

	// Supprimer le membre (avec vérification mot de passe)
	mysqli_query($connexion, 'DELETE FROM asso WHERE id="' . $idEchappe . '" AND motdepasse="' . $mdpEchappe . '"');

	// Supprimer les projets du membre
	mysqli_query($connexion, 'DELETE FROM projets WHERE id="' . $idEchappe . '"');
	mysqli_query($connexion, 'DELETE FROM dataprojets WHERE idmembre="' . $idEchappe . '"');

	// Supprimer les posts du membre
	mysqli_query($connexion, 'DELETE FROM dataposts WHERE idmembre="' . $idEchappe . '"');

	return true;
}

/**
 * Met à jour une information du membre
 * @param string $id Identifiant du membre
 * @param string $champ Champ à modifier
 * @param string $valeur Nouvelle valeur
 * @return bool
 */
function updateMembre($id, $champ, $valeur) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$champsValides = array('Nom', 'Prenom', 'id', 'mail', 'Pays', 'CodePostal', 'DateNaissance', 'motdepasse');
	if (!in_array($champ, $champsValides)) return false;

	$requete = 'UPDATE asso SET ' . $champ . '="' . mysqli_real_escape_string($connexion, $valeur) . '" WHERE id="' . mysqli_real_escape_string($connexion, $id) . '"';
	return mysqli_query($connexion, $requete);
}

/**
 * Récupère un membre par son ID (alias de getMembre)
 * @param string $id Identifiant du membre
 * @return array|false Données du membre ou false
 */
function getMembreById($id) {
	return getMembre($id);
}

/**
 * Connecte un membre (met à jour date connexion et statut)
 * @param string $id Identifiant du membre
 * @param string $motdepasse Mot de passe hashé
 * @return bool
 */
function connecterMembre($id, $motdepasse) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$date = date('dmY');
	$idEchappe = mysqli_real_escape_string($connexion, $id);
	$mdpEchappe = mysqli_real_escape_string($connexion, $motdepasse);

	$sql = 'UPDATE asso SET datedederniereconnection="' . $date . '", Connecte="1" WHERE id="' . $idEchappe . '" AND motdepasse="' . $mdpEchappe . '"';
	return mysqli_query($connexion, $sql);
}

/**
 * Déconnecte un membre
 * @param string $id Identifiant du membre
 * @param string $motdepasse Mot de passe hashé
 * @return bool
 */
function deconnecterMembre($id, $motdepasse) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$idEchappe = mysqli_real_escape_string($connexion, $id);
	$mdpEchappe = mysqli_real_escape_string($connexion, $motdepasse);

	$sql = 'UPDATE asso SET Connecte="0" WHERE id="' . $idEchappe . '" AND motdepasse="' . $mdpEchappe . '"';
	return mysqli_query($connexion, $sql);
}

/**
 * Génère un mot de passe aléatoire
 * @param int $longueur Longueur en mots de 2 caractères
 * @return string Mot de passe généré
 */
function genererMotDePasseAleatoire($longueur = 3) {
	$consonnes = 'bcdfghjklmnpqrstvwxz';
	$voyelles = 'aeiou';
	$motdepasse = '';

	for ($index = 0; $index < $longueur; $index++) {
		$motdepasse .= $consonnes[rand(0, strlen($consonnes) - 1)];
		$motdepasse .= $voyelles[rand(0, strlen($voyelles) - 1)];
	}

	return $motdepasse;
}

/**
 * Inscrit un nouveau membre
 * @param array $donnees Données du formulaire
 * @return bool true si succès, false si erreur
 */
function inscrireMembre($donnees) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	// Vérifier si l'identifiant existe déjà
	if (membreExiste($donnees['id'])) {
		return false;
	}

	$motdepasse = $donnees['motdepasse'];
	$datedinscription = date('dmY');

	// Formater la date de naissance
	$dateNaissance = -11;
	if (!empty($donnees['d1']) && !empty($donnees['d2']) && !empty($donnees['d3'])) {
		$jour = str_pad($donnees['d1'], 2, '0', STR_PAD_LEFT);
		$mois = str_pad($donnees['d2'], 2, '0', STR_PAD_LEFT);
		$dateNaissance = $jour . $mois . $donnees['d3'];
	}

	$sql = 'INSERT INTO asso (competence, Nom, Prenom, CodePostal, Pays, DateNaissance, mail, id, motdepasse, datedinscription, datedederniereconnection, datedudernierpost) VALUES ("Membre", "' .
		mysqli_real_escape_string($connexion, $donnees['nom']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['prenom']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['adresse']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['pays']) . '", "' .
		$dateNaissance . '", "' .
		mysqli_real_escape_string($connexion, $donnees['mail']) . '", "' .
		mysqli_real_escape_string($connexion, $donnees['id']) . '", "' .
		md5($motdepasse) . '", "' .
		$datedinscription . '", "-11", "-11")';

	if (mysqli_query($connexion, $sql)) {
		return true;
	}
	return false;
}
?>
