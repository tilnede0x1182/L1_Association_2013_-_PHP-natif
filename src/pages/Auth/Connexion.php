<?php
/**
 * Page de connexion membre
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

$erreur = "";
$afficherFormulaire = true;

// Traitement du formulaire
if (!empty($_POST)) {
	if (empty($_POST["id"]) || empty($_POST["motdepasse"])) {
		$erreur = "Veuillez compléter tous les champs demandés.";
	} elseif (!preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["id"]) || !preg_match('/^[a-zA-Z0-9-_]+$/', $_POST["motdepasse"])) {
		$erreur = "L'un des champs entrés contient des caractères spéciaux ou accentués.";
	} else {
		$_SESSION['id'] = $_POST['id'];
		$_SESSION['motdepasse'] = md5($_POST['motdepasse']);

		if (verifieConnection()) {
			// Connexion réussie
			connecterMembre($_SESSION['id'], $_SESSION['motdepasse']);
			$afficherFormulaire = false;

			if (!empty($_SESSION['pageCourante'])) {
				header('Location: ' . $_SESSION['pageCourante']);
			} else {
				header('Location: ' . $serveur . 'src/pages/Accueil/index.php');
			}
			exit;
		} else {
			$erreur = "Identifiant ou mot de passe incorrect(s).";
		}
	}
}

$titrePage = "Connexion membre";
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

<?php if ($erreur): ?>
<h4 class="erreur"><?= $erreur ?></h4>
<?php endif; ?>

<?php if ($afficherFormulaire): ?>
<div class="texte">
	<h3>Entrez votre identifiant et votre mot de passe.</h3>
	<p>Accès membres :</p>
	<form action="Connexion.php" method="POST">
		<label for="id">Identifiant :</label>
		<input type="text" name="id" id="id"><br>
		<label for="motdepasse">Mot de passe :</label>
		<input type="password" name="motdepasse" id="motdepasse"><br>
		<input type="submit" value="Se connecter"><br>
		<div class="lien"><a href="<?= $serveur ?>src/pages/Auth/Inscription.php">S'inscrire</a></div>
	</form>
	<?php if (!empty($_SESSION['pageCourante'])): ?>
	<div class="lien"><a href="<?= $_SESSION['pageCourante'] ?>">Retour</a></div>
	<?php endif; ?>
	<div class="lien"><a href="<?= $serveur ?>src/pages/Accueil/index.php">Aller à la page d'accueil</a></div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/../../../utils/templates/footer.php'; ?>
