<?php
/**
	Script de seed pour la base de données association1.
	Génère des utilisateurs, posts et projets réalistes.

	Usage :
		php seed.php
*/

// ==============================================================================
// Données
// ==============================================================================

$PRENOMS = [
	"Jean", "Pierre", "Marie", "Sophie", "Lucas", "Emma", "Louis", "Lea", "Hugo", "Chloe",
	"Antoine", "Camille", "Maxime", "Julie", "Thomas", "Manon", "Nicolas", "Laura", "Alexandre", "Sarah",
	"Romain", "Oceane", "Julien", "Mathilde", "Florian", "Pauline", "Quentin", "Marine", "Baptiste", "Anais",
	"Victor", "Clemence", "Theo", "Margot", "Nathan", "Ines", "Gabriel", "Jade", "Raphael", "Lola",
	"Adam", "Charlotte", "Leo", "Alice", "Arthur", "Juliette", "Ethan", "Louise", "Noah", "Anna",
	"Liam", "Eva", "Jules", "Clara", "Enzo", "Celia", "Mael", "Zoe", "Aaron", "Elsa",
	"Tom", "Rose", "Paul", "Victoire", "Axel", "Lucie", "Eden", "Agathe", "Nolan", "Ambre",
	"Gabin", "Lena", "Mathis", "Noemie", "Simon", "Capucine", "Timothe", "Elise", "Oscar", "Gabrielle",
	"Samuel", "Apolline", "Martin", "Adele", "Esteban", "Jeanne", "Ruben", "Helene", "Sacha", "Margaux",
	"Louis", "Constance", "Thibault", "Diane", "Corentin", "Salome", "Dylan", "Anaelle", "Bastien", "Romane"
];

$NOMS = [
	"Martin", "Bernard", "Dubois", "Thomas", "Robert", "Richard", "Petit", "Durand", "Leroy", "Moreau",
	"Simon", "Laurent", "Lefebvre", "Michel", "Garcia", "David", "Bertrand", "Roux", "Vincent", "Fournier",
	"Morel", "Girard", "Andre", "Lefevre", "Mercier", "Dupont", "Lambert", "Bonnet", "Francois", "Martinez",
	"Legrand", "Garnier", "Faure", "Rousseau", "Blanc", "Guerin", "Muller", "Henry", "Roussel", "Nicolas",
	"Perrin", "Robin", "Aubert", "Lemaire", "Renaud", "Dumas", "Lacroix", "Fontaine", "Chevalier", "Clement",
	"Gauthier", "Boyer", "Gautier", "Roche", "Roy", "Noel", "Meyer", "Lucas", "Meunier", "Jean",
	"Perez", "Marchand", "Dufour", "Blanchard", "Marie", "Barbier", "Brun", "Picard", "Caron", "Masson",
	"Lemoine", "Giraud", "Sanchez", "Nguyen", "Ferrand", "Lopez", "Fabre", "Leroux", "Colin", "Arnaud",
	"Vidal", "Renard", "Dupuis", "Brunet", "Schmitt", "Lecomte", "Fernandez", "Pierre", "Benoit", "Carpentier",
	"Fleury", "Rodriguez", "Boucher", "Jacquet", "Adam", "Paris", "Poirier", "Marty", "Rolland", "Riviere"
];

$PAYS = ["France", "Belgique", "Suisse", "Canada", "Luxembourg"];

$TITRES_POSTS = [
	"Retour d'experience sur", "Comment j'ai appris", "Les bases de", "Tutoriel complet sur",
	"Astuces pour maitriser", "Introduction a", "Guide pratique de", "Mon avis sur",
	"Pourquoi j'utilise", "Decouverte de", "Mes conseils pour", "Analyse de",
	"Reunion annuelle des anciens", "Nouveau partenariat", "Conference sur l'innovation",
	"Atelier networking du mois", "Bilan de l'annee", "Invitation au gala annuel",
	"Offre d'emploi partenaire", "Formation continue disponible"
];

$SUJETS_POSTS = [
	"le framework Laravel", "React et ses hooks", "la gestion de bases de donnees", "le deploiement Docker",
	"l'API REST", "la securite web", "le responsive design", "Git et GitHub", "les tests unitaires",
	"l'architecture MVC", "les design patterns", "l'optimisation SQL", "le cloud AWS", "Kubernetes",
	"l'integration continue", "le machine learning", "Python pour debutants", "JavaScript moderne"
];

$CONTENUS_POSTS = [
	"Ceci est un excellent sujet qui merite d'etre approfondi.",
	"J'ai beaucoup appris en travaillant sur ce projet.",
	"Les retours de la communaute ont ete tres constructifs.",
	"Cette approche m'a permis de gagner en productivite.",
	"Je recommande vivement cette methode a tous les debutants.",
	"L'implementation s'est revelee plus complexe que prevu.",
	"Les resultats obtenus depassent mes attentes initiales.",
	"Ce tutoriel m'a ete d'une grande aide pour comprendre les concepts.",
	"La documentation officielle est tres bien faite.",
	"N'hesitez pas a poser vos questions en commentaire.",
	"Nous avons le plaisir de vous annoncer la tenue de notre prochaine reunion.",
	"Suite aux echanges avec nos partenaires, nous sommes heureux de cette collaboration.",
	"Une conference exceptionnelle aura lieu le mois prochain.",
	"L'atelier du mois a rencontre un vif succes. Merci a tous les participants.",
	"Voici le bilan de nos activites. Nous remercions tous ceux qui ont contribue."
];

$TITRES_PROJETS = [
	"Site e-commerce", "Application mobile", "Plateforme collaborative", "Tableau de bord analytique",
	"API de gestion", "Systeme de reservation", "Reseau social interne", "Outil de monitoring",
	"Application de chat", "Gestionnaire de taches", "Organisation du forum annuel",
	"Creation d'un annuaire en ligne", "Mise en place d'un mentorat", "Developpement application mobile",
	"Partenariat avec universite", "Creation fonds de soutien", "Organisation hackathon", "Lancement newsletter"
];

$DESCRIPTIONS_PROJETS = [
	"Projet innovant visant a ameliorer l'experience utilisateur.",
	"Solution complete developpee en equipe avec methodologie agile.",
	"Application repondant aux besoins identifies lors de l'analyse.",
	"Systeme robuste et scalable pour une utilisation en production.",
	"Prototype fonctionnel demontrant la faisabilite technique.",
	"Ce projet vise a organiser un evenement majeur pour rassembler tous les anciens.",
	"Nous souhaitons creer un outil permettant aux membres de se retrouver.",
	"Un programme de mentorat pour accompagner les jeunes diplomes.",
	"Developpement d'une application pour faciliter la communication.",
	"Etablir un partenariat durable avec notre universite d'origine.",
	"Creer un fonds pour aider les etudiants en difficulte financiere.",
	"Organiser un hackathon ouvert aux etudiants et anciens."
];

// ==============================================================================
// Fonctions utilitaires
// ==============================================================================

/**
	Génère une date aléatoire au format ddmmyyyy.
	@param jours_passes Nombre de jours dans le passé (max)
	@return string Date au format ddmmyyyy
*/
function genererDate($jours_passes) {
	$timestamp = time() - rand(0, $jours_passes * 24 * 3600);
	return date('dmY', $timestamp);
}

/**
	Génère une date postérieure à une date donnée (format ddmmyyyy).
	@param dateBase Date de base au format ddmmyyyy
	@return string Date postérieure au format ddmmyyyy
*/
function genererDateApres($dateBase) {
	$jour = substr($dateBase, 0, 2);
	$mois = substr($dateBase, 2, 2);
	$annee = substr($dateBase, 4, 4);
	$timestampBase = mktime(0, 0, 0, $mois, $jour, $annee);
	$maintenant = time();
	$ecart = $maintenant - $timestampBase;
	if ($ecart <= 0) return date('dmY');
	$timestampModif = $timestampBase + rand(1, $ecart);
	return date('dmY', $timestampModif);
}

// 10 ans en jours
$DIX_ANS = 3650;

// Taille des batchs pour INSERT multiples
$BATCH_SIZE = 100;

/**
	Génère une heure aléatoire au format HHmmss.
	@return string Heure au format HHmmss
*/
function genererHeure() {
	return sprintf('%02d%02d%02d', rand(8, 22), rand(0, 59), rand(0, 59));
}

/**
	Choisit un élément aléatoire dans un tableau.
	@param tableau Tableau source
	@return mixed Élément choisi
*/
function choisirAleatoire($tableau) {
	return $tableau[array_rand($tableau)];
}

/**
	Exécute un INSERT multiple avec les VALUES accumulés.
	@param connexion Connexion mysqli
	@param sqlBase Début de la requête (INSERT INTO ... VALUES)
	@param values Tableau des VALUES à insérer (passé par référence, vidé après)
*/
function executerBatch($connexion, $sqlBase, &$values) {
	if (empty($values)) return;
	$sql = $sqlBase . implode(',', $values);
	mysqli_query($connexion, $sql);
	$values = [];
}

// ==============================================================================
// Fonctions principales
// ==============================================================================

/**
	Crée les utilisateurs dans la base de données.
	@param connexion Connexion mysqli
	@return array Liste des identifiants créés et données pour users.txt
*/
function creerUtilisateurs($connexion) {
	global $PRENOMS, $NOMS, $PAYS;
	$identifiants = [];
	$usersTxt = "=== ADMINS ===\n";

	global $DIX_ANS;

	// 3 admins
	for ($idx = 1; $idx <= 3; $idx++) {
		$identifiant = 'admin' . sprintf('%02d', $idx);
		$motdepasseClair = 'Admin' . $idx . '23';
		$motdepasse = md5($motdepasseClair);
		$dateInscription = genererDate($DIX_ANS);
		$dateDerniereConnexion = genererDate($DIX_ANS);
		$dateDernierPost = genererDate($DIX_ANS);

		$sql = "INSERT INTO asso (id, motdepasse, Nom, Prenom, mail, Pays, CodePostal, DateNaissance, competence, datedinscription, datedederniereconnection, datedudernierpost, Connecte)
				VALUES ('$identifiant', '$motdepasse', 'Admin', 'Admin$idx', 'admin$idx@association.fr', 'France', '75000', '01011980', 'Administrateur', '$dateInscription', '$dateDerniereConnexion', '$dateDernierPost', 0)";
		mysqli_query($connexion, $sql);

		$identifiants[] = $identifiant;
		$usersTxt .= "$identifiant $motdepasseClair\n";
	}

	$usersTxt .= "\n=== USERS ===\n";

	// 97 membres (100 total avec 3 admins)
	for ($idx = 0; $idx < 97; $idx++) {
		$prenom = $PRENOMS[$idx % count($PRENOMS)];
		$nom = $NOMS[$idx % count($NOMS)];
		$identifiant = 'user_' . strtolower($prenom) . '_' . strtolower($nom) . ($idx + 1);
		$motdepasseClair = 'Password' . ($idx + 1);
		$motdepasse = md5($motdepasseClair);
		$mail = strtolower($prenom) . '.' . strtolower($nom) . ($idx + 1) . '@email.fr';
		$paysChoisi = choisirAleatoire($PAYS);
		$codePostal = sprintf('%05d', rand(10000, 99999));
		$dateNaissance = sprintf('%02d%02d%04d', rand(1, 28), rand(1, 12), rand(1970, 2000));
		$dateInscription = genererDate($DIX_ANS);
		$dateDerniereConnexion = genererDate($DIX_ANS);
		$dateDernierPost = genererDate($DIX_ANS);

		$sql = "INSERT INTO asso (id, motdepasse, Nom, Prenom, mail, Pays, CodePostal, DateNaissance, competence, datedinscription, datedederniereconnection, datedudernierpost, Connecte)
				VALUES ('$identifiant', '$motdepasse', '$nom', '$prenom', '$mail', '$paysChoisi', '$codePostal', '$dateNaissance', 'Membre', '$dateInscription', '$dateDerniereConnexion', '$dateDernierPost', 0)";
		mysqli_query($connexion, $sql);

		$identifiants[] = $identifiant;
		$usersTxt .= "$identifiant $motdepasseClair\n";
	}

	return ['identifiants' => $identifiants, 'usersTxt' => $usersTxt];
}

/**
	Crée les posts dans la base de données.
	@param connexion Connexion mysqli
	@param identifiants Liste des identifiants utilisateurs
*/
function creerPosts($connexion) {
	global $TITRES_POSTS, $SUJETS_POSTS, $CONTENUS_POSTS, $DIX_ANS, $BATCH_SIZE;

	$result = mysqli_query($connexion, "SELECT id FROM asso");
	$identifiants = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$identifiants[] = $row['id'];
	}

	$totalPosts = 0;
	$values = [];
	$sqlBase = "INSERT INTO posts (Post, Objet, date, heure, id) VALUES ";
	$compteurParUtilisateur = [];

	mysqli_begin_transaction($connexion);

	foreach ($identifiants as $identifiant) {
		$nombrePosts = rand(3, 10);
		$compteurParUtilisateur[$identifiant] = $nombrePosts;

		for ($idx = 0; $idx < $nombrePosts; $idx++) {
			$objet = choisirAleatoire($TITRES_POSTS) . " " . choisirAleatoire($SUJETS_POSTS);
			$post = choisirAleatoire($CONTENUS_POSTS);
			$datePost = genererDate($DIX_ANS);
			$heurePost = genererHeure();

			$objet = mysqli_real_escape_string($connexion, $objet);
			$post = mysqli_real_escape_string($connexion, $post);

			$values[] = "('$post', '$objet', '$datePost', '$heurePost', '$identifiant')";
			$totalPosts++;

			if (count($values) >= $BATCH_SIZE) {
				executerBatch($connexion, $sqlBase, $values);
			}
		}
	}

	executerBatch($connexion, $sqlBase, $values);

	foreach ($compteurParUtilisateur as $identifiant => $nombre) {
		mysqli_query($connexion, "UPDATE asso SET nombredeposts = $nombre WHERE id = '$identifiant'");
	}

	mysqli_commit($connexion);
	echo "Posts crees: $totalPosts\n";
}

/**
	Crée les projets dans la base de données.
	@param connexion Connexion mysqli
*/
function creerProjets($connexion) {
	global $TITRES_PROJETS, $DESCRIPTIONS_PROJETS, $DIX_ANS, $BATCH_SIZE;

	$result = mysqli_query($connexion, "SELECT id FROM asso");
	$identifiants = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$identifiants[] = $row['id'];
	}



	$totalProjets = 0;
	$compteurParUtilisateur = [];

	mysqli_begin_transaction($connexion);

	foreach ($identifiants as $identifiant) {
		$nombreProjets = rand(0, 2);
		$compteurParUtilisateur[$identifiant] = $nombreProjets;

		for ($idx = 0; $idx < $nombreProjets; $idx++) {
			$objet = choisirAleatoire($TITRES_PROJETS);
			$texte = choisirAleatoire($DESCRIPTIONS_PROJETS);
			$dateProjet = genererDate($DIX_ANS);
			$heureProjet = genererHeure();

			$objet = mysqli_real_escape_string($connexion, $objet);
			$texte = mysqli_real_escape_string($connexion, $texte);

			$sql = "INSERT INTO projets (Objet, Texte, date, heure, id) VALUES ('$objet', '$texte', '$dateProjet', '$heureProjet', '$identifiant')";
			mysqli_query($connexion, $sql);
			$idprojet = mysqli_insert_id($connexion);
			$totalProjets++;

			}
	}

	foreach ($compteurParUtilisateur as $identifiant => $nombre) {
		mysqli_query($connexion, "UPDATE asso SET nombredeprojets = $nombre WHERE id = '$identifiant'");
	}

	mysqli_commit($connexion);
	echo "Projets crees: $totalProjets\n";
}

/**
	Crée les modifications de posts (dataposts).
	@param connexion Connexion mysqli
*/
function creerDataposts($connexion) {
	global $DIX_ANS, $BATCH_SIZE;
	// Seuls les admins peuvent modifier les articles
	$admins = ['admin01', 'admin02', 'admin03'];

	$result = mysqli_query($connexion, "SELECT idpost, id, date FROM posts");
	$totalModifs = 0;
	$values = [];
	$sqlBase = "INSERT INTO dataposts (idpost, idauteur, idmembre, date, heure) VALUES ";

	mysqli_begin_transaction($connexion);

	while ($row = mysqli_fetch_assoc($result)) {
		$idpost = $row['idpost'];
		$idauteur = $row['id'];
		$datePost = $row['date'];
		$nombreModifs = rand(0, 5);

		for ($idx = 0; $idx < $nombreModifs; $idx++) {
			$modificateur = choisirAleatoire($admins);
			$dateModif = genererDateApres($datePost);
			$heureModif = genererHeure();

			$values[] = "($idpost, '$idauteur', '$modificateur', '$dateModif', '$heureModif')";
			$totalModifs++;

			if (count($values) >= $BATCH_SIZE) {
				executerBatch($connexion, $sqlBase, $values);
			}
		}
	}

	mysqli_commit($connexion);
	echo "Modifications de posts creees: $totalModifs\n";
}

/**
	Crée les participations aux projets.
	Chaque personne ayant modifié un projet est automatiquement participant.
	Le créateur du projet est aussi participant.
	@param connexion Connexion mysqli
*/
function creerParticipations($connexion) {
	global $BATCH_SIZE;

	// Les admins ne participent pas aux projets
	$admins = ["admin01", "admin02", "admin03"];

	// Récupérer tous les membres non-admins
	$result = mysqli_query($connexion, "SELECT id FROM asso WHERE competence != 'Administrateur'");
	$membres = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$membres[] = $row["id"];
	}

	$totalParticipations = 0;
	$values = [];
	$sqlBase = "INSERT INTO participations (idprojet, idmembre, date_acceptation) VALUES ";
	$participantsParProjet = [];

	mysqli_begin_transaction($connexion);

	// Récupérer tous les projets
	$result = mysqli_query($connexion, "SELECT idprojet, id, date FROM projets");
	while ($row = mysqli_fetch_assoc($result)) {
		$idprojet = $row["idprojet"];
		$createur = $row["id"];
		$dateProjet = $row["date"];
		$dateFormatee = substr($dateProjet, 0, 2) . "/" . substr($dateProjet, 2, 2) . "/" . substr($dateProjet, 4, 4);

		$participantsProjet = [];

		// Ajouter le créateur comme participant (sauf si admin)
		if (!in_array($createur, $admins)) {
			$values[] = "($idprojet, \"$createur\", \"$dateFormatee\")";
			$participantsProjet[] = $createur;
			$totalParticipations++;
		}

		// Ajouter 2-30 participants aléatoires
		$nombreParticipants = rand(2, 30);
		$membresDisponibles = array_diff($membres, [$createur]);
		shuffle($membresDisponibles);
		$participantsAleatoires = array_slice($membresDisponibles, 0, min($nombreParticipants, count($membresDisponibles)));

		foreach ($participantsAleatoires as $participant) {
			$dateParticipation = genererDateApres($dateProjet);
			$datePartFormatee = substr($dateParticipation, 0, 2) . "/" . substr($dateParticipation, 2, 2) . "/" . substr($dateParticipation, 4, 4);
			$values[] = "($idprojet, \"$participant\", \"$datePartFormatee\")";
			$participantsProjet[] = $participant;
			$totalParticipations++;

			if (count($values) >= $BATCH_SIZE) {
				executerBatch($connexion, $sqlBase, $values);
			}
		}

		$participantsParProjet[$idprojet] = $participantsProjet;
	}

	executerBatch($connexion, $sqlBase, $values);
	mysqli_commit($connexion);
	echo "Participations creees: $totalParticipations\n";

	return $participantsParProjet;
}

/**
	Crée les modifications de projets (dataprojets).
	Les modifications sont faites par des participants.
	Exception : exactement 2% des projets ont des modifications par des admins.
	@param connexion Connexion mysqli
	@param participantsParProjet Tableau idprojet => [participants]
*/
function creerModificationsProjets($connexion, $participantsParProjet) {
	global $BATCH_SIZE;

	$admins = ['admin01', 'admin02', 'admin03'];
	$totalModifs = 0;
	$values = [];
	$sqlBase = "INSERT INTO dataprojets (idprojet, idmembre, date, heure) VALUES ";

	// Récupérer tous les projets
	$result = mysqli_query($connexion, "SELECT idprojet, date FROM projets");
	$projets = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$projets[] = $row;
	}

	// Calculer exactement 2% des projets pour modifications admin
	$nombreProjetsAdmin = (int) round(count($projets) * 0.02);
	$indicesProjetsAdmin = array_rand($projets, max(1, $nombreProjetsAdmin));
	if (!is_array($indicesProjetsAdmin)) {
		$indicesProjetsAdmin = [$indicesProjetsAdmin];
	}
	$projetsAdmin = [];
	foreach ($indicesProjetsAdmin as $idx) {
		$projetsAdmin[] = $projets[$idx]['idprojet'];
	}

	mysqli_begin_transaction($connexion);

	foreach ($projets as $projet) {
		$idprojet = $projet['idprojet'];
		$dateProjet = $projet['date'];
		$nombreModifs = rand(5, 30);

		// Déterminer qui peut modifier ce projet
		$estProjetAdmin = in_array($idprojet, $projetsAdmin);
		$participants = isset($participantsParProjet[$idprojet]) ? $participantsParProjet[$idprojet] : [];

		for ($idx = 0; $idx < $nombreModifs; $idx++) {
			if ($estProjetAdmin && rand(1, 3) == 1) {
				// 1/3 des modifs par admin sur les projets sélectionnés
				$modificateur = choisirAleatoire($admins);
			} elseif (!empty($participants)) {
				// Modification par un participant
				$modificateur = choisirAleatoire($participants);
			} else {
				// Fallback si pas de participants (ne devrait pas arriver)
				continue;
			}

			$dateModif = genererDateApres($dateProjet);
			$heureModif = genererHeure();
			$values[] = "($idprojet, '$modificateur', '$dateModif', '$heureModif')";
			$totalModifs++;

			if (count($values) >= $BATCH_SIZE) {
				executerBatch($connexion, $sqlBase, $values);
			}
		}
	}

	executerBatch($connexion, $sqlBase, $values);
	mysqli_commit($connexion);
	echo "Modifications de projets creees: $totalModifs (" . count($projetsAdmin) . " projets avec modifs admin)\n";
}

/**
	Crée 50 demandes de participation aléatoires.
	Les admins ne peuvent pas faire de demande.
	@param connexion Connexion mysqli
	@param participantsParProjet Tableau idprojet => [participants] pour éviter les doublons
*/
function creerDemandesParticipation($connexion, $participantsParProjet) {
	// Les admins ne peuvent pas demander
	$admins = ["admin01", "admin02", "admin03"];

	// Récupérer tous les membres non-admins
	$result = mysqli_query($connexion, "SELECT id FROM asso WHERE competence != 'Administrateur'");
	$membres = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$membres[] = $row["id"];
	}

	// Récupérer tous les projets
	$result = mysqli_query($connexion, "SELECT idprojet, date FROM projets");
	$projets = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$projets[] = $row;
	}

	$totalDemandes = 0;
	$values = [];
	$sqlBase = "INSERT INTO demandes_participation (idprojet, idmembre, date_demande) VALUES ";

	mysqli_begin_transaction($connexion);

	// Créer exactement 50 demandes
	while ($totalDemandes < 50) {
		$projet = choisirAleatoire($projets);
		$idprojet = $projet['idprojet'];
		$dateProjet = $projet['date'];

		// Choisir un membre qui n'est pas déjà participant
		$participantsActuels = isset($participantsParProjet[$idprojet]) ? $participantsParProjet[$idprojet] : [];
		$membresDisponibles = array_diff($membres, $participantsActuels);

		if (empty($membresDisponibles)) continue;

		$demandeur = choisirAleatoire($membresDisponibles);

		// Vérifier qu'on n'a pas déjà ajouté cette demande
		$cleUnique = $idprojet . '-' . $demandeur;
		static $demandesAjoutees = [];
		if (in_array($cleUnique, $demandesAjoutees)) continue;
		$demandesAjoutees[] = $cleUnique;

		$dateDemande = genererDateApres($dateProjet);
		$dateFormatee = substr($dateDemande, 0, 2) . "/" . substr($dateDemande, 2, 2) . "/" . substr($dateDemande, 4, 4);

		$values[] = "($idprojet, \"$demandeur\", \"$dateFormatee\")";
		$totalDemandes++;
	}

	if (!empty($values)) {
		$sql = $sqlBase . implode(',', $values);
		mysqli_query($connexion, $sql);
	}

	mysqli_commit($connexion);
	echo "Demandes de participation creees: $totalDemandes\n";
}

// ==============================================================================
// Main
// ==============================================================================

function main() {
	$debut = microtime(true);
	echo "=== Seed association1 ===\n\n";

	$connexion = mysqli_connect('localhost', 'tilnede0x1182', 'tilnede0x1182', 'association1');
	if (!$connexion) {
		die("Erreur de connexion: " . mysqli_connect_error() . "\n");
	}

	mysqli_set_charset($connexion, 'utf8mb4');

	// Nettoyage
	mysqli_query($connexion, "SET FOREIGN_KEY_CHECKS = 0");
	mysqli_query($connexion, "TRUNCATE TABLE participations");
	mysqli_query($connexion, "TRUNCATE TABLE demandes_participation");
	mysqli_query($connexion, "TRUNCATE TABLE dataprojets");
	mysqli_query($connexion, "TRUNCATE TABLE dataposts");
	mysqli_query($connexion, "TRUNCATE TABLE projets");
	mysqli_query($connexion, "TRUNCATE TABLE posts");
	mysqli_query($connexion, "TRUNCATE TABLE asso");
	mysqli_query($connexion, "SET FOREIGN_KEY_CHECKS = 1");

	echo "Tables nettoyees.\n";

	// Création des données
	$resultat = creerUtilisateurs($connexion);
	echo "Utilisateurs crees: " . count($resultat['identifiants']) . "\n";

	creerPosts($connexion);
	creerProjets($connexion);
	creerDataposts($connexion);
	$participantsParProjet = creerParticipations($connexion);
	creerModificationsProjets($connexion, $participantsParProjet);
	creerDemandesParticipation($connexion, $participantsParProjet);

	// Écriture du fichier users.txt
	$cheminUsers = __DIR__ . '/users.txt';
	file_put_contents($cheminUsers, $resultat['usersTxt']);
	echo "\nFichier users.txt cree: $cheminUsers\n";

	mysqli_close($connexion);

	$fin = microtime(true);
	$duree = round($fin - $debut, 2);
	echo "\n=== Seed termine en {$duree}s ===\n";
}

// ==============================================================================
// Lancement du programme
// ==============================================================================

main();
