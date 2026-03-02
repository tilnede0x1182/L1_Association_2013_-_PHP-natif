<?php
/**
 * Page de connexion membre
 */
require_once __DIR__ . '/../includes/init.php';

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
				header('Location: ' . $serveur . 'Accueil/index.php');
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

<?php include __DIR__ . '/../templates/nav.php'; ?>

<?php if ($erreur): ?>
<h4 class="erreur"><?= $erreur ?></h4>
<?php endif; ?>

<?php if ($afficherFormulaire): ?>
<h3>Entrez votre identifiant et votre mot de passe.</h3>

<div class="Accès membres">
	<p>Accès membres :</p>

	<form action="Connexion.php" method="POST">
		<label for="id">Identifiant :</label>
		<input type="text" name="id" id="id"><br>
		<label for="motdepasse">Mot de passe :</label>
		<input type="password" name="motdepasse" id="motdepasse"><br>
		<input type="submit" value="Se connecter"><br>
		<a href="<?= $serveur ?>Auth/Inscription.php">S'inscrire</a>
	</form>
</div>

<?php if (!empty($_SESSION['pageCourante'])): ?>
<p><a href="<?= $_SESSION['pageCourante'] ?>">Retour</a></p>
<?php endif; ?>

<p><a href="<?= $serveur ?>Accueil/index.php">Aller à la page d'accueil</a></p>
<?php endif; ?>

<?php include __DIR__ . '/../templates/footer.php'; ?>
