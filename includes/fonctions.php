<?php
/**
 * Fonctions utilitaires centralisées
 */

// ==============================================================================
// Fonctions de dates
// ==============================================================================

/**
 * Convertit une date au format JJMMAAAA en JJ/MM/AAAA
 * @param string $date Date au format JJMMAAAA
 * @return string Date formatée ou "Date non renseignée"
 */
function convertDate($date) {
	if ($date != 0) {
		$jour = substr($date, 0, 2);
		$mois = substr($date, 2, 2);
		$annee = substr($date, 4, 4);
		return $jour . '/' . $mois . '/' . $annee;
	}
	return "Date non renseignée";
}

/**
 * Convertit une chaîne de chiffres en entier
 * @param string $chaine Chaîne de chiffres
 * @return int Valeur numérique
 */
function convertChiffre($chaine) {
	return intval($chaine);
}

/**
 * Calcule l'ancienneté depuis une date d'inscription
 * @param string $dateInscription Date au format JJMMAAAA
 * @return string Ancienneté formatée
 */
function CalcAnciennete($dateInscription) {
	$jourActuel = date("d");
	$moisActuel = date("m");
	$anneeActuelle = date("Y");
	$dateActuelle = $jourActuel . $moisActuel . $anneeActuelle;

	if ($dateInscription == 0) return "Non renseignée";
	if ($dateActuelle == $dateInscription) return "Inscrit aujourd'hui.";

	$diffAnnees = convertChiffre(substr($dateActuelle, 4, 4)) - convertChiffre(substr($dateInscription, 4, 4));
	$diffMois = convertChiffre(substr($dateActuelle, 2, 2)) - convertChiffre(substr($dateInscription, 2, 2));
	$diffJours = convertChiffre(substr($dateActuelle, 0, 2)) - convertChiffre(substr($dateInscription, 0, 2));

	if ($diffAnnees > 0) {
		return ($diffAnnees == 1) ? "1 an" : $diffAnnees . " ans";
	} else if ($diffMois > 0) {
		return $diffMois . " mois";
	} else if ($diffJours > 0) {
		return ($diffJours == 1) ? "Inscrit hier" : $diffJours . " jours";
	}
	return "";
}

/**
 * Calcule l'ancienneté avec formulation "Il y a..."
 * @param string $date Date au format JJMMAAAA
 * @return string Ancienneté formatée
 */
function CalcAnciennete2($date) {
	$jourActuel = date("d");
	$moisActuel = date("m");
	$anneeActuelle = date("Y");
	$dateActuelle = $jourActuel . $moisActuel . $anneeActuelle;

	if ($date == 0) return "Non renseignée";
	if ($dateActuelle == $date) return "Aujourd'hui";

	$diffAnnees = convertChiffre(substr($dateActuelle, 4, 4)) - convertChiffre(substr($date, 4, 4));
	$diffMois = convertChiffre(substr($dateActuelle, 2, 2)) - convertChiffre(substr($date, 2, 2));
	$diffJours = convertChiffre(substr($dateActuelle, 0, 2)) - convertChiffre(substr($date, 0, 2));

	if ($diffAnnees > 0) {
		return ($diffAnnees == 1) ? "Il y a 1 an" : "Il y a " . $diffAnnees . " ans";
	} else if ($diffMois > 0) {
		return "Il y a " . $diffMois . " mois";
	} else if ($diffJours > 0) {
		return ($diffJours == 1) ? "Hier" : "Il y a " . $diffJours . " jours";
	}
	return "";
}

// ==============================================================================
// Fonctions de vérification de connexion
// ==============================================================================

/**
 * Vérifie si l'utilisateur est connecté
 * @return bool True si connecté, false sinon
 */
function verifieConnection() {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'SELECT id, motdepasse FROM asso WHERE id="' . $_SESSION['id'] . '"';
	$resultat = mysqli_query($connexion, $requete);
	$ligne = mysqli_fetch_array($resultat);

	if ($ligne == false) return false;
	if ($ligne['id'] != $_SESSION['id']) return false;
	if ($ligne['motdepasse'] != $_SESSION['motdepasse']) return false;

	return true;
}

/**
 * Vérifie si l'utilisateur est un membre avec privilèges (admin/président/secrétaire)
 * @return bool True si membre privilégié, false sinon
 */
function verifieConnectionMembre() {
	$connexion = getConnexion();
	if (!$connexion) return false;

	$requete = 'SELECT id, motdepasse, competence FROM asso WHERE id="' . $_SESSION['id'] . '"';
	$resultat = mysqli_query($connexion, $requete);
	$ligne = mysqli_fetch_array($resultat);

	if ($ligne == false) return false;
	if ($ligne['id'] != $_SESSION['id']) return false;
	if ($ligne['motdepasse'] != $_SESSION['motdepasse']) return false;

	$competencesAutorisees = array("President", "Secretaire", "Administrateur");
	if (!in_array($ligne['competence'], $competencesAutorisees)) return false;

	return true;
}

// ==============================================================================
// Fonctions de détection et formatage
// ==============================================================================

/**
 * Détecte les balises [pseudo="xxx"] et les transforme en liens vers le profil
 * @param string $texte Texte contenant des balises pseudo
 * @return string Texte avec liens HTML
 */
function detectlId($texte) {
	global $serveur;
	$resultat = "";
	$longueur = strlen($texte);

	for ($index = 0; $index < $longueur; $index++) {
		$fragment = substr($texte, $index, 14);

		if ($fragment == '[pseudo=&quot;') {
			$decalage = 14;
			$position = $index + 13;
			$pseudo = "";
			$fin = "";

			while (($fin != '&quot;]') && ($position < ($longueur - 1))) {
				$position++;
				$decalage++;
				if (substr($texte, $position, 1) != '&') {
					$pseudo .= substr($texte, $position, 1);
				}
				$fin = substr($texte, $position, 7);
			}

			$connexion = getConnexion();
			if ($connexion) {
				$requete = 'SELECT id FROM asso WHERE id="' . $pseudo . '"';
				$res = mysqli_query($connexion, $requete);
				$ligne = mysqli_fetch_array($res);

				if ($ligne == false) {
					$resultat .= $pseudo;
				} else {
					$resultat .= '<a href="' . $serveur . 'Membres/Voir.php?idmembre=' . $pseudo . '">' . $pseudo . '</a>';
				}
			}
			$index += $decalage + 5;
		} else {
			$resultat .= substr($texte, $index, 1);
		}
	}

	return $resultat;
}

// ==============================================================================
// Fonctions d'affichage
// ==============================================================================

/**
 * Génère le lien CSS et le script de thème
 * @return string HTML du lien CSS et script
 */
function includeStylesheet() {
	global $serveur;
	$html = '    <link rel="stylesheet" href="' . $serveur . 'Ressources/CSS/style.css">' . "\n";

	if (!empty($_SESSION['style']) && $_SESSION['style'] == 2) {
		$html .= '    <script>document.addEventListener("DOMContentLoaded", function() { document.body.classList.add("theme2"); });</script>' . "\n";
	}

	return $html;
}

/**
 * Génère le script HTML5 shiv pour IE
 * @return string Script HTML5 shiv
 */
function html5Shiv() {
	return '<script>(function(){if(!/*@cc_on!@*/0)return;var e = "abbr,article,aside,audio,bb,canvas,datagrid,datalist,details,dialog,eventsource,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video".split(\',\');for(var i=0;i<e.length;i++){document.createElement(e[i])}})()</script>';
}
?>
