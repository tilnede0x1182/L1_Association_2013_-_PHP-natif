<?php
/**
 * Création d'un nouveau projet
 */
require_once __DIR__ . '/../../includes/init.php';

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "Accueil/Accueil%20%281%29.php");
	exit;
}

$titrePage = "Création d'un nouveau projet";
$message = "";
$erreur = "";

// Traitement du formulaire
if (!empty($_POST['sujet']) && !empty($_POST['contenu'])) {
	$objet = htmlspecialchars($_POST['sujet']);
	$texte = htmlspecialchars($_POST['contenu']);

	if (creerProjet($_SESSION['id'], $objet, $texte)) {
		header('Location: ' . $serveur . 'Contenu/Projets/NouveauProjet.php');
		exit;
	} else {
		$erreur = "Erreur lors de la création du projet.";
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

<?php include __DIR__ . '/../../templates/nav.php'; ?>

<?php if ($erreur): ?>
<h4 class="erreur"><?= $erreur ?></h4>
<?php endif; ?>

<form action="<?= $serveur ?>Contenu/Projets/CreationNouveauProjet.php" method="POST">
	<label>Objet : <input type="text" name="sujet" autofocus></label><br>
	<label><p>Texte :</p><textarea rows="25" cols="82" name="contenu"></textarea></label><br>
	<input type="submit" value="Créer">
</form>

<?php if (!empty($_SESSION['pageCourante'])): ?>
<a href="<?= $_SESSION['pageCourante'] ?>">Annuler</a>
<?php endif; ?>

<?php include __DIR__ . '/../../templates/footer.php'; ?>
