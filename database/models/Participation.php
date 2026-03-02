<?php
/**
 * Model Participation - Gestion des participations aux projets
 */

/**
 * Récupère les participants acceptés d'un projet
 * @param int $idprojet ID du projet
 * @return array Liste des participants (idmembre)
 */
function getParticipants($idprojet) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT idmembre FROM participations WHERE idprojet="' .
		mysqli_real_escape_string($connexion, $idprojet) . '" AND statut="accepte"';
	$resultat = mysqli_query($connexion, $requete);

	$participants = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$participants[] = $ligne['idmembre'];
	}
	return $participants;
}

/**
 * Récupère les demandes de participation en attente pour un projet
 * @param int $idprojet ID du projet
 * @return array Liste des demandes
 */
function getDemandesParticipation($idprojet) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT * FROM participations WHERE idprojet="' .
		mysqli_real_escape_string($connexion, $idprojet) . '" AND statut="en_attente"';
	$resultat = mysqli_query($connexion, $requete);

	$demandes = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$demandes[] = $ligne;
	}
	return $demandes;
}

/**
 * Récupère toutes les demandes en attente pour les projets d'un membre
 * @param string $idmembre ID du créateur des projets
 * @return array Liste des demandes avec infos projet
 */
function getDemandesParticipationPourCreateur($idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return array();

	$requete = 'SELECT p.*, pr.Objet as titre_projet, pr.id as createur_projet
		FROM participations p
		INNER JOIN projets pr ON p.idprojet = pr.idprojet
		WHERE pr.id="' . mysqli_real_escape_string($connexion, $idmembre) . '"
		AND p.statut="en_attente"
		ORDER BY p.date_demande DESC';
	$resultat = mysqli_query($connexion, $requete);

	$demandes = array();
	while ($ligne = mysqli_fetch_array($resultat)) {
		$demandes[] = $ligne;
	}
	return $demandes;
}

/**
 * Vérifie si un membre est participant d'un projet
 * @param int $idprojet ID du projet
 * @param string $idmembre ID du membre
 * @return bool
 */
function estParticipant($idprojet, $idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'SELECT id FROM participations WHERE idprojet="' .
		mysqli_real_escape_string($connexion, $idprojet) . '" AND idmembre="' .
		mysqli_real_escape_string($connexion, $idmembre) . '" AND statut="accepte"';
	$resultat = mysqli_query($connexion, $requete);

	return mysqli_num_rows($resultat) > 0;
}

/**
 * Vérifie si un membre a déjà une demande en attente pour un projet
 * @param int $idprojet ID du projet
 * @param string $idmembre ID du membre
 * @return bool
 */
function aDemandeEnAttente($idprojet, $idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'SELECT id FROM participations WHERE idprojet="' .
		mysqli_real_escape_string($connexion, $idprojet) . '" AND idmembre="' .
		mysqli_real_escape_string($connexion, $idmembre) . '" AND statut="en_attente"';
	$resultat = mysqli_query($connexion, $requete);

	return mysqli_num_rows($resultat) > 0;
}

/**
 * Crée une demande de participation
 * @param int $idprojet ID du projet
 * @param string $idmembre ID du membre demandeur
 * @return bool
 */
function demanderParticipation($idprojet, $idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$date = date('d/m/Y');

	$requete = 'INSERT INTO participations (idprojet, idmembre, statut, date_demande) VALUES ("' .
		mysqli_real_escape_string($connexion, $idprojet) . '", "' .
		mysqli_real_escape_string($connexion, $idmembre) . '", "en_attente", "' .
		$date . '")';

	return mysqli_query($connexion, $requete);
}

/**
 * Accepte une demande de participation
 * @param int $idprojet ID du projet
 * @param string $idmembre ID du membre
 * @return bool
 */
function accepterParticipation($idprojet, $idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'UPDATE participations SET statut="accepte" WHERE idprojet="' .
		mysqli_real_escape_string($connexion, $idprojet) . '" AND idmembre="' .
		mysqli_real_escape_string($connexion, $idmembre) . '"';

	return mysqli_query($connexion, $requete);
}

/**
 * Refuse une demande de participation
 * @param int $idprojet ID du projet
 * @param string $idmembre ID du membre
 * @return bool
 */
function refuserParticipation($idprojet, $idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'UPDATE participations SET statut="refuse" WHERE idprojet="' .
		mysqli_real_escape_string($connexion, $idprojet) . '" AND idmembre="' .
		mysqli_real_escape_string($connexion, $idmembre) . '"';

	return mysqli_query($connexion, $requete);
}

/**
 * Retire un participant d'un projet (supprime sa participation)
 * @param int $idprojet ID du projet
 * @param string $idmembre ID du membre à retirer
 * @return bool
 */
function retirerParticipant($idprojet, $idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'DELETE FROM participations WHERE idprojet="' .
		mysqli_real_escape_string($connexion, $idprojet) . '" AND idmembre="' .
		mysqli_real_escape_string($connexion, $idmembre) . '"';

	return mysqli_query($connexion, $requete);
}

/**
 * Ajoute directement un participant (sans passer par demande)
 * Utilisé par le seed et pour le créateur du projet
 * @param int $idprojet ID du projet
 * @param string $idmembre ID du membre
 * @return bool
 */
function ajouterParticipant($idprojet, $idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$date = date('d/m/Y');

	$requete = 'INSERT INTO participations (idprojet, idmembre, statut, date_demande) VALUES ("' .
		mysqli_real_escape_string($connexion, $idprojet) . '", "' .
		mysqli_real_escape_string($connexion, $idmembre) . '", "accepte", "' .
		$date . '") ON DUPLICATE KEY UPDATE statut="accepte"';

	return mysqli_query($connexion, $requete);
}

/**
 * Compte le nombre de demandes en attente pour les projets d'un membre
 * @param string $idmembre ID du créateur des projets
 * @return int
 */
function countDemandesEnAttente($idmembre) {
	$connexion = getConnexion();
	if (!$connexion) return 0;

	$requete = 'SELECT COUNT(*) as nb FROM participations p
		INNER JOIN projets pr ON p.idprojet = pr.idprojet
		WHERE pr.id="' . mysqli_real_escape_string($connexion, $idmembre) . '"
		AND p.statut="en_attente"';
	$resultat = mysqli_query($connexion, $requete);
	$ligne = mysqli_fetch_array($resultat);

	return intval($ligne['nb']);
}
?>
