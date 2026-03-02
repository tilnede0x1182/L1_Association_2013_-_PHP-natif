<?php
/**
 * Liste complète des articles
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

$_SESSION['pageCourante'] = $serveur . "src/pages/Contenu/Articles/Liste.php";

// Récupérer les droits et articles
$estAdmin = verifieConnectionMembre();
$articles = getAllArticles(199);

$titrePage = "Liste complète des articles";
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

<table border="1">
	<tr>
		<th>Auteur</th>
		<th>Titre de l'article</th>
		<th>Dates de publication et de dernière modification</th>
		<?php if ($estAdmin): ?>
		<th>Modifications</th>
		<?php endif; ?>
	</tr>
<?php foreach ($articles as $article): ?>
	<?php
	$modifs = getModificationsArticle($article['idpost'], 1);
	$dateModif = !empty($modifs) ? ", dernière modification : " . convertDate($modifs[0]['date']) : "";
	?>
	<tr>
		<td><a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $article['id'] ?>"><?= htmlspecialchars($article['id']) ?></a></td>
		<th><a href="<?= $serveur ?>src/pages/Contenu/Articles/Voir.php?idpost=<?= $article['idpost'] ?>"><?= htmlspecialchars($article['Objet']) ?></a></th>
		<td<?php if (!$estAdmin): ?> style="text-align: center;"<?php endif; ?>>
			Publication : <?= convertDate($article['date']) ?>
			<?php if ($estAdmin): ?>
				<?= $dateModif ?>
			<?php endif; ?>
		</td>
		<?php if ($estAdmin): ?>
		<td>
			<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Articles/Editer.php?idarticle=<?= $article['idpost'] ?>">modifier</a></div>
			<br><br><br>
			<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Articles/Supprimer.php?idpost=<?= $article['idpost'] ?>">supprimer</a></div>
		</td>
		<?php endif; ?>
	</tr>
<?php endforeach; ?>
</table>

<p><a href="<?= $serveur ?>src/pages/Accueil/index.php">Retour à la page d'accueil</a></p>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
