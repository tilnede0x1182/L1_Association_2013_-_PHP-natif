<?php
/**
 * Suppression d'un projet
 */
require_once __DIR__ . '/../../includes/init.php';

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "Accueil/Accueil%20%281%29.php");
	exit;
}

// Récupérer l'ID du projet
$idprojet = isset($_GET['idprojet']) ? $_GET['idprojet'] : 'inconnu';

$titrePage = "Suppression d'un projet";

// Traitement du formulaire
if (!empty($_POST) && isset($_POST['choix'])) {
	if ($_POST['choix'] == 1) {
		supprimerProjet($idprojet);
	}

	if (!empty($_SESSION['pageCourante'])) {
		header('Location: ' . $_SESSION['pageCourante']);
	} else {
		header('Location: ' . $serveur . 'Contenu/Projets/NouveauProjet.php');
	}
	exit;
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

<div class="lien"><p><a href="<?= $serveur ?>Contenu/Projets/CreationNouveauProjet.php">Nouveau projet</a></p></div>

<h3>Voulez-vous réellement supprimer ce projet ?</h3>

<form action="" method="POST" style="display: inline;">
	<input name="choix" value="1" type="hidden">
	<input type="submit" value="Oui">
</form>

<form action="" method="POST" style="display: inline;">
	<input name="choix" value="0" type="hidden">
	<input type="submit" value="Annuler">
</form>

<?php include __DIR__ . '/../../templates/footer.php'; ?>
