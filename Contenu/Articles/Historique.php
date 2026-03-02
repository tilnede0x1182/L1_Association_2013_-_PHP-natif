<?php
/**
 * Liste des auteurs d'un article
 */
require_once __DIR__ . '/../../includes/init.php';

// Gestion de la page précédente
$pagePrecedente = "";
if (!empty($_SESSION['pageCourante']) && strpos($_SESSION['pageCourante'], "Historique") === false) {
	$pagePrecedente = $_SESSION['pageCourante'];
}

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "Accueil/index.php");
	exit;
}

// Vérifier les droits admin
$estAdmin = verifieConnectionMembre();
if (!$estAdmin) {
	header("Location: " . $serveur . "Accueil/index.php");
	exit;
}

// Récupérer l'ID de l'article
$idpost = isset($_GET['idpost']) ? $_GET['idpost'] : '';
$_SESSION['pageCourante'] = $serveur . "Contenu/Articles/Historique.php?idpost=" . $idpost;

// Récupérer les modifications
$modifications = getModificationsArticle($idpost);

$titrePage = "Liste des auteurs d'un article";
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

<table border="1">
	<tr>
		<th>Liste des auteurs de l'article</th>
		<th>Date de modification</th>
	</tr>
<?php if (empty($modifications)): ?>
	<tr>
		<td colspan="2">Aucune modification depuis la publication de l'article</td>
	</tr>
<?php else: ?>
	<?php foreach ($modifications as $modif): ?>
	<tr>
		<td><a href="<?= $serveur ?>Membres/Voir.php?idmembre=<?= $modif['idmembre'] ?>"><?= htmlspecialchars($modif['idmembre']) ?></a></td>
		<td><?= convertDate($modif['date']) ?></td>
	</tr>
	<?php endforeach; ?>
<?php endif; ?>
</table>

<p>
<?php if ($pagePrecedente): ?>
	<a href="<?= $pagePrecedente ?>">Retour</a><br>
<?php else: ?>
	<a href="<?= $serveur ?>Accueil/index.php">Retour à la page d'accueil</a>
<?php endif; ?>
</p>

<?php include __DIR__ . '/../../templates/footer.php'; ?>
