<?php
/**
 * Inscription nouveau membre
 */
require_once __DIR__ . '/../includes/init.php';

$titrePage = "Association - Inscription (nouveau membre)";
$erreur = "";
$succes = false;
$motdepasseGenere = "";

/**
 * Vérifie la validité de la date
 * @return bool
 */
function verifierDate() {
	if (!empty($_POST['d1']) && !empty($_POST['d2']) && !empty($_POST['d3'])) {
		$jour = $_POST['d1'];
		$mois = $_POST['d2'];
		$annee = $_POST['d3'];

		if (!is_numeric($jour) || !is_numeric($mois) || !is_numeric($annee)) {
			return false;
		}

		if ($jour > 31 || $jour < 1 || $mois < 1 || $mois > 12) {
			return false;
		}

		// Mois de 30 jours
		if (in_array($mois, array(4, 6, 9, 11)) && $jour > 30) {
			return false;
		}

		// Février
		if ($mois == 2 && $jour > 29) {
			return false;
		}
	} elseif (!empty($_POST['d1']) || !empty($_POST['d2']) || !empty($_POST['d3'])) {
		// Date partiellement remplie
		return false;
	}

	return true;
}

// Traitement du formulaire
if (!empty($_POST)) {
	// Vérifier la source
	if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== $serveur . "Auth/Inscription.php") {
		$erreur = "Le formulaire est soumis depuis une source externe !";
	} elseif (empty($_POST["nom"]) || empty($_POST["prenom"]) || empty($_POST["id"]) || empty($_POST["mail"]) || empty($_POST["adresse"]) || empty($_POST["pays"])) {
		$erreur = "Veuillez compléter tous les champs munis d'une étoile (*).";
	} elseif (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["id"]) || !preg_match('/^[éèòùàça-zA-Z0-9-_ ]+$/', $_POST["nom"]) || !preg_match('/^[éèòùàça-zA-Z0-9-_ ]+$/', $_POST["prenom"]) || !preg_match('/^[éèòùàça-zA-Z0-9-_ ]+$/', $_POST["adresse"]) || !preg_match('/^[éèòùàça-zA-Z0-9-_ ]+$/', $_POST["pays"])) {
		$erreur = "L'un des champs entrés contient des caractères spéciaux non autorisés.";
	} elseif (!is_numeric($_POST["adresse"])) {
		$erreur = "Le code postal doit être composé de chiffres.";
	} elseif (!verifierDate()) {
		$erreur = "La date n'est pas valide.";
	} elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
		$erreur = "L'adresse e-mail est incorrecte.";
	} elseif (membreExiste($_POST['id'])) {
		$erreur = "Trouvez un autre nom d'utilisateur (identifiant). Celui-ci est déjà utilisé.";
	} else {
		// Inscription
		$motdepasseGenere = inscrireMembre($_POST);
		if ($motdepasseGenere) {
			$succes = true;
		} else {
			$erreur = "Erreur lors de l'inscription.";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title><?= $titrePage ?></title>
	<?= includeStylesheet() ?>
</head>
<body>

<?php include __DIR__ . '/../templates/nav.php'; ?>

<?php if ($succes): ?>
<p>Tout est correct.</p>
<p>Voici votre mot de passe : <strong><?= $motdepasseGenere ?></strong>.</p>
<p>Il servira à confirmer votre inscription.<br><br>
Veuillez entrer ce mot de passe lors de vos prochaines connexions.<br><br>
Cependant, vous pourrez changer ce mot de passe dès votre première connexion.</p>
<p><br><a href="<?= $serveur ?>Accueil/index.php">Revenir à la page d'accueil</a></p>

<?php else: ?>

<?php if ($erreur): ?>
<h4 class="erreur"><?= $erreur ?></h4>
<?php endif; ?>

<?php if (empty($_POST)): ?>
<h2>Inscription nouveau membre :</h2>
<?php endif; ?>

<p>Veuillez compléter le formulaire ci-dessous et remplir tous les champs obligatoires (*) :</p>
<form action="<?= $serveur ?>Auth/Inscription.php" method="POST">
	Nom : <input type="text" name="nom" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">(*)<br>
	Prénom : <input type="text" name="prenom" value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>">(*)<br>
	e-mail : <input type="email" name="mail" value="<?= isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '' ?>">(*)<br>
	Pays : <input type="text" name="pays" value="<?= isset($_POST['pays']) ? htmlspecialchars($_POST['pays']) : '' ?>">
	Adresse (Code postal) : <input type="text" name="adresse" value="<?= isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : '' ?>">(*)<br>
	Date de naissance : <input type="text" name="d1" size="2" value="<?= isset($_POST['d1']) ? htmlspecialchars($_POST['d1']) : '' ?>">/<input type="text" name="d2" size="2" value="<?= isset($_POST['d2']) ? htmlspecialchars($_POST['d2']) : '' ?>">/<input type="text" name="d3" size="4" value="<?= isset($_POST['d3']) ? htmlspecialchars($_POST['d3']) : '' ?>"> (JJ/MM/AAAA)<br>
	Identifiant : <input type="text" name="id" value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>">(*)<br>
	<input type="submit" value="S'inscrire">
</form>

<p><a href="<?= $serveur ?>Accueil/index.php">Retour à la page d'accueil</a></p>
<?php endif; ?>

<?php include __DIR__ . '/../templates/footer.php'; ?>
