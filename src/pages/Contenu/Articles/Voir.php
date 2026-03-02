<?php
/**
 * Affichage d'un article
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

// Gestion de la page précédente
$pagePrecedente = "";
if (!empty($_SESSION['pageCourante']) && strpos($_SESSION['pageCourante'], "Voir") === false) {
	$pagePrecedente = $_SESSION['pageCourante'];
}

// Récupérer l'ID de l'article
$idpost = isset($_GET['idpost']) ? $_GET['idpost'] : 'inconnu';
$_SESSION['pageCourante'] = $serveur . "src/pages/Contenu/Articles/Voir.php?idpost=" . $idpost;

// Récupérer l'article
$article = getArticle($idpost);
if (!$article) {
	die("Article non trouvé");
}

// Vérifier les droits
$estAdmin = verifieConnectionAdmin();

// Récupérer les modifications
$modifs = getModificationsArticle($idpost, 1);
$dateModif = !empty($modifs)
	? "<br>Dernière modification :<br><a href=\"" . $serveur . "src/pages/Membres/Voir.php?idmembre=" . $modifs[0]['idmembre'] . "\">" . $modifs[0]['idmembre'] . "</a> (" . convertDate($modifs[0]['date']) . ")<br>"
	: "";

$titrePage = "Article de " . $article['id'];
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

<?php if ($estAdmin): ?>
<table border="1">
	<tr>
		<th>Auteurs et dates de modification</th>
		<th>Contenu de l'article</th>
		<th>Modifications</th>
	</tr>
	<tr>
		<td>
			<?= $dateModif ?>
			<br>Publication :<br>
			<a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $article['id'] ?>"><?= htmlspecialchars($article['id']) ?></a>
			(<?= convertDate($article['date']) ?>)
			<?php if (!empty($modifs)): ?>
				<br><br><a href="<?= $serveur ?>src/pages/Contenu/Articles/Historique.php?idpost=<?= $idpost ?>">Afficher la liste</a>
			<?php endif; ?>
		</td>
		<td>
			<?php if (!empty($article['Objet'])): ?>
				<h4><?= htmlspecialchars($article['Objet']) ?> :</h4>
			<?php endif; ?>
			<?= nl2br(detectlId($article['Post'])) ?>
		</td>
		<td>
			<a href="<?= $serveur ?>src/pages/Contenu/Articles/Editer.php?idarticle=<?= $idpost ?>">modifier</a>
			<br><br><br>
			<a href="<?= $serveur ?>src/pages/Contenu/Articles/Supprimer.php?idpost=<?= $idpost ?>">supprimer</a>
		</td>
	</tr>
</table>

<?php else: ?>
<table border="1">
	<tr>
		<th>Auteur</th>
		<th>Contenu de l'article</th>
		<th>Date de publication</th>
	</tr>
	<tr>
		<td><a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $article['id'] ?>"><?= htmlspecialchars($article['id']) ?></a></td>
		<td>
			<?php if (!empty($article['Objet'])): ?>
				<h4><?= htmlspecialchars($article['Objet']) ?> :</h4>
			<?php endif; ?>
			<?= nl2br(detectlId($article['Post'])) ?>
		</td>
		<td><?= convertDate($article['date']) ?></td>
	</tr>
</table>
<?php endif; ?>

<?php if ($pagePrecedente): ?>
<div class="lien"><a href="<?= $pagePrecedente ?>">Retour</a></div>
<?php endif; ?>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
