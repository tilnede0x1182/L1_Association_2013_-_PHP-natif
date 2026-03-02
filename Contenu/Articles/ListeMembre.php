<?php
/**
 * Liste des articles d'un membre
 */
require_once __DIR__ . '/../../includes/init.php';

// Récupérer l'ID du membre
$membre = isset($_GET['idmembre']) ? $_GET['idmembre'] : 'inconnu';
$_SESSION['pageCourante'] = $serveur . "Contenu/Articles/ListeMembre.php?idmembre=" . $membre;

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "Accueil/index.php");
	exit;
}

// Récupérer les articles du membre
$articles = getArticlesByMembre($membre);

$titrePage = "Liste des articles publiés par le membre " . $membre;
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

<h1>Liste des articles publiés par le membre <a href="<?= $serveur ?>Membres/Voir.php?idmembre=<?= $membre ?>"><?= htmlspecialchars($membre) ?></a> :</h1>

<table border="1">
	<tr>
		<th>Contenu de l'article actuel</th>
		<th>Date de publication</th>
		<th>Modification</th>
	</tr>
<?php if (empty($articles)): ?>
	<tr>
		<td colspan="3">Aucun article publié à ce jour.</td>
	</tr>
<?php else: ?>
	<?php foreach ($articles as $article): ?>
	<tr>
		<td>
			<h4><a href="<?= $serveur ?>Contenu/Articles/Voir.php?idpost=<?= $article['idpost'] ?>"><?= htmlspecialchars($article['Objet']) ?></a></h4>
			<?= nl2br(detectlId($article['Post'])) ?>
		</td>
		<td><?= convertDate($article['date']) ?></td>
		<td>
			<div class="lien"><a href="<?= $serveur ?>Contenu/Articles/Editer.php?idarticle=<?= $article['idpost'] ?>">modifier</a></div>
			<br><br><br>
			<div class="lien"><a href="<?= $serveur ?>Contenu/Articles/Supprimer.php?idpost=<?= $article['idpost'] ?>">supprimer</a></div>
		</td>
	</tr>
	<?php endforeach; ?>
<?php endif; ?>
</table>

<?php include __DIR__ . '/../../templates/footer.php'; ?>
