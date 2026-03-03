<?php
/**
 * Inscription nouveau membre
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

$titrePage = "Association - Inscription (nouveau membre)";
$erreur = "";
$succes = false;

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

		// Fevrier
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
	if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== $serveur . "src/pages/Auth/Inscription.php") {
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
	} elseif (empty($_POST['motdepasse'])) {
		$erreur = "Veuillez entrer un mot de passe.";
	} elseif (empty($_POST['motdepasse_confirm'])) {
		$erreur = "Veuillez confirmer votre mot de passe.";
	} elseif ($_POST['motdepasse'] !== $_POST['motdepasse_confirm']) {
		$erreur = "Les mots de passe ne correspondent pas.";
	} else {
		// Inscription
		if (inscrireMembre($_POST)) {
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

<?php include __DIR__ . '/../../../utils/templates/nav.php'; ?>

<?php if ($succes): ?>
<div class="texte">
	<p>Inscription réussie !</p>
	<p>Vous pouvez maintenant vous connecter avec votre identifiant et votre mot de passe.</p>
	<div class="lien lien-mb"><a href="<?= $serveur ?>src/pages/Auth/Connexion.php">Se connecter</a></div>
	<div class="lien"><a href="<?= $serveur ?>src/pages/Accueil/index.php">Revenir à la page d'accueil</a></div>
</div>

<?php else: ?>

<?php if ($erreur): ?>
<h4 class="erreur"><?= $erreur ?></h4>
<?php endif; ?>

<?php if (empty($_POST)): ?>
<h2 class="texte">Inscription nouveau membre :</h2>
<?php endif; ?>

<p class="texte">Veuillez compléter le formulaire ci-dessous et remplir tous les champs obligatoires (*) :</p>
<form class="texte" action="<?= $serveur ?>src/pages/Auth/Inscription.php" method="POST">
	<table class="table-formulaire">
		<colgroup>
			<col class="col-label">
			<col>
		</colgroup>
		<tr>
			<td class="td-label"><span class="form-label">Nom</span></td>
			<td class="td-input"><input type="text" name="nom" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>"> <span class="champ-obligatoire">(*)</span></td>
		</tr>
		<tr>
			<td class="td-label"><span class="form-label">Prénom</span></td>
			<td class="td-input"><input type="text" name="prenom" value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>"> <span class="champ-obligatoire">(*)</span></td>
		</tr>
		<tr>
			<td class="td-label"><span class="form-label">E-mail</span></td>
			<td class="td-input"><input type="email" name="mail" value="<?= isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '' ?>"> <span class="champ-obligatoire">(*)</span></td>
		</tr>
		<tr>
			<td class="td-label"><span class="form-label">Pays</span></td>
			<td class="td-input"><input type="text" name="pays" value="<?= isset($_POST['pays']) ? htmlspecialchars($_POST['pays']) : '' ?>"></td>
		</tr>
		<tr>
			<td class="td-label"><span class="form-label">Code postal</span></td>
			<td class="td-input"><input type="text" name="adresse" value="<?= isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : '' ?>"> <span class="champ-obligatoire">(*)</span></td>
		</tr>
		<tr>
			<td class="td-label"><span class="form-label">Date de naissance</span></td>
			<td class="td-input"><span class="cadre-date"><input type="text" name="d1" id="d1" size="2" maxlength="2" class="input-date-court" value="<?= isset($_POST['d1']) ? htmlspecialchars($_POST['d1']) : '' ?>" onkeyup="if(this.value.length==2)document.getElementById('d2').focus();">&nbsp;/&nbsp;<input type="text" name="d2" id="d2" size="2" maxlength="2" class="input-date-court" value="<?= isset($_POST['d2']) ? htmlspecialchars($_POST['d2']) : '' ?>" onkeyup="if(this.value.length==2)document.getElementById('d3').focus();">&nbsp;/&nbsp;<input type="text" name="d3" id="d3" size="4" maxlength="4" class="input-date-annee" value="<?= isset($_POST['d3']) ? htmlspecialchars($_POST['d3']) : '' ?>"></span> <span class="format-indication">(JJ/MM/AAAA)</span></td>
		</tr>
		<tr>
			<td class="td-label"><span class="form-label">Identifiant</span></td>
			<td class="td-input"><input type="text" name="id" value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>"> <span class="champ-obligatoire">(*)</span></td>
		</tr>
		<tr>
			<td class="td-label"><span class="form-label">Mot de passe</span></td>
			<td class="td-input"><input type="password" name="motdepasse"> <span class="champ-obligatoire">(*)</span></td>
		</tr>
		<tr>
			<td class="td-label"><span class="form-label">Confirmer le mot de passe</span></td>
			<td class="td-input"><input type="password" name="motdepasse_confirm"> <span class="champ-obligatoire">(*)</span></td>
		</tr>
		<tr>
			<td class="td-vide"></td>
			<td class="td-submit"><input type="submit" value="S'inscrire"></td>
		</tr>
	</table>
</form>

<div class="texte"><div class="lien"><a href="<?= $serveur ?>src/pages/Accueil/index.php">Retour à la page d'accueil</a></div></div>
<?php endif; ?>

<?php include __DIR__ . '/../../../utils/templates/footer.php'; ?>
