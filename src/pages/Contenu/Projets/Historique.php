<?php
/**
 * Liste des auteurs d'un projet
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

// Gestion de la page précédente
$pagePrecedente = "";
if (!empty($_SESSION['pageCourante']) && strpos($_SESSION['pageCourante'], "Historique") === false) {
	$pagePrecedente = $_SESSION['pageCourante'];
}

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

// Récupérer l'ID du projet
$idprojet = isset($_GET['idprojet']) ? $_GET['idprojet'] : '';
$_SESSION['pageCourante'] = $serveur . "src/pages/Contenu/Projets/Historique.php?idprojet=" . $idprojet;

// Récupérer le projet
$projet = getProjet($idprojet);

// Vérifier les droits
$estAdmin = verifieConnectionAdmin();
$estProprietaire = ($projet && $projet['id'] == $_SESSION['id']);

$titrePage = "Liste des auteurs d'un projet";
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

<?php if ($estProprietaire || $estAdmin): ?>
	<?php $modifications = getModificationsProjet($idprojet); ?>

	<table border="1">
		<tr>
			<th>Liste des auteurs du projet</th>
			<th>Date de modification</th>
		</tr>
	<?php if (empty($modifications)): ?>
		<tr>
			<td colspan="2">Aucune modification depuis la publication du projet</td>
		</tr>
	<?php else: ?>
		<?php foreach ($modifications as $modif): ?>
		<tr>
			<td><a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $modif['idmembre'] ?>"><?= htmlspecialchars($modif['idmembre']) ?></a></td>
			<td><?= convertDate($modif['date']) ?></td>
		</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</table>

	<p>
	<?php if ($pagePrecedente): ?>
		<a href="<?= $pagePrecedente ?>">Retour</a><br>
	<?php else: ?>
		<a href="<?= $serveur ?>src/pages/Accueil/index.php">Retour à la page d'accueil</a>
	<?php endif; ?>
	</p>

<?php else: ?>
	<p>Vous n'avez pas accès à cette page.</p>
	<p><a href="<?= $serveur ?>src/pages/Accueil/index.php">Retour à la page d'accueil</a></p>
<?php endif; ?>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
