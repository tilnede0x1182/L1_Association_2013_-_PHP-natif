<?php
/**
 * Suppression d'un article
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

// Vérifier la connexion admin (seuls les admins peuvent supprimer les articles)
if (!verifieConnection() || !verifieConnectionAdmin()) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

// Récupérer l'ID de l'article
$idpost = isset($_GET['idpost']) ? $_GET['idpost'] : 'inconnu';

$titrePage = "Suppression d'un article";

// Traitement du formulaire
if (!empty($_POST) && isset($_POST['choix'])) {
	if ($_POST['choix'] == 1) {
		supprimerArticle($idpost);
	}

	if (!empty($_SESSION['pageCourante'])) {
		header('Location: ' . $_SESSION['pageCourante']);
	} else {
		header('Location: ' . $serveur . 'src/pages/Accueil/index.php');
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

<?php include __DIR__ . '/../../../../utils/templates/nav.php'; ?>

<div class="lien"><p><a href="<?= $serveur ?>src/pages/Contenu/Projets/Creer.php">Nouveau projet</a></p></div>

<h3 class="texte">Voulez-vous réellement supprimer cet article ?</h3>

<form action="" method="POST" style="display: inline;">
	<input name="choix" value="1" type="hidden">
	<input type="submit" value="Oui">
</form>

<form action="" method="POST" style="display: inline;">
	<input name="choix" value="0" type="hidden">
	<input type="submit" value="Annuler">
</form>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
