<?php
/**
 * Page d'accueil - Affiche les 5 derniers articles
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

$_SESSION['pageCourante'] = $serveur . "src/pages/Accueil/index.php";

// Récupérer les données
$estAdmin = verifieConnectionMembre();
$articles = getDerniersArticles(5);

// Préparer les données pour l'affichage
$articlesAvecModifs = array();
foreach ($articles as $article) {
	$article['modifications'] = getModificationsArticle($article['idpost'], 1);
	$article['nbModifs'] = countModificationsArticle($article['idpost']);
	$articlesAvecModifs[] = $article;
}

$titrePage = "Accueil Association";
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

<?php if ($estAdmin): ?>
<table border="1">
	<tr>
		<th>Auteurs et dates de modification</th>
		<th>Derniers articles</th>
		<th>Modifications</th>
	</tr>
<?php foreach ($articlesAvecModifs as $article): ?>
	<tr>
		<td>
			<?php if (!empty($article['modifications'])): ?>
				Dernière modification :<br>
				<a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $article['modifications'][0]['idmembre'] ?>"><?= $article['modifications'][0]['idmembre'] ?></a>
				(<?= convertDate($article['modifications'][0]['date']) ?>)<br><br>
			<?php endif; ?>
			Publication :<br>
			<a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $article['id'] ?>"><?= $article['id'] ?></a>
			(<?= convertDate($article['date']) ?>)
			<?php if ($article['nbModifs'] > 0): ?>
				<br><br><a href="<?= $serveur ?>src/pages/Contenu/Articles/Historique.php?idpost=<?= $article['idpost'] ?>">Afficher la liste</a>
			<?php endif; ?>
		</td>
		<td>
			<?php if (!empty($article['Objet'])): ?>
				<h4><?= htmlspecialchars($article['Objet']) ?> :</h4>
			<?php endif; ?>
			<p><?= nl2br(detectlId($article['Post'])) ?></p>
		</td>
		<td>
			<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Articles/Editer.php?idarticle=<?= $article['idpost'] ?>">modifier</a></div>
			<br><br><br>
			<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Articles/Supprimer.php?idpost=<?= $article['idpost'] ?>">supprimer</a></div>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php else: ?>
<table border="1">
	<tr>
		<th>Auteur</th>
		<th>Derniers articles</th>
		<th>Date de publication</th>
	</tr>
<?php foreach ($articlesAvecModifs as $article): ?>
	<tr>
		<td><a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $article['id'] ?>"><?= $article['id'] ?></a></td>
		<td>
			<?php if (!empty($article['Objet'])): ?>
				<h4><?= htmlspecialchars($article['Objet']) ?> :</h4>
			<?php endif; ?>
			<?= nl2br(detectlId($article['Post'])) ?>
		</td>
		<td><?= convertDate($article['date']) ?></td>
	</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<a href="<?= $serveur ?>src/pages/Contenu/Articles/Liste.php">Afficher la liste complète</a>

<?php include __DIR__ . '/../../../utils/templates/footer.php'; ?>
