<?php
/**
 * Modification d'un article
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

// Vérifier la connexion admin (seuls les admins peuvent modifier les articles)
if (!verifieConnection() || !verifieConnectionAdmin()) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

// Récupérer l'ID de l'article
$idarticle = isset($_GET['idarticle']) ? $_GET['idarticle'] : 'non identifié';

// Récupérer l'article
$article = getArticle($idarticle);
if (!$article) {
	die("Article non trouvé");
}

$titrePage = "Modification d'un article";
$erreur = "";

// Traitement du formulaire
if (!empty($_POST)) {
	// Vérifier la source
	if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== $serveur . "src/pages/Contenu/Articles/Editer.php?idarticle=" . $idarticle) {
		$erreur = "Le formulaire est soumis depuis une source externe !";
	} elseif (empty($_POST["article"])) {
		$erreur = "Veuillez entrer quelque chose, ou quitter cette page.";
	} else {
		if (modifierArticle($idarticle, $article['Objet'], htmlspecialchars($_POST['article']), $_SESSION['id'])) {
			if (!empty($_SESSION['pageCourante'])) {
				header('Location: ' . $_SESSION['pageCourante']);
			} else {
				header('Location: ' . $serveur . 'src/pages/Accueil/index.php');
			}
			exit;
		} else {
			$erreur = "Erreur lors de la modification.";
		}
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

<?php include __DIR__ . '/../../../../utils/templates/nav.php'; ?>

<?php if ($erreur): ?>
<h4 class="erreur"><?= $erreur ?></h4>
<?php endif; ?>

<form action="<?= $serveur ?>src/pages/Contenu/Articles/Editer.php?idarticle=<?= $idarticle ?>" method="POST">
	<label>Objet : <input type="text" value="<?= htmlspecialchars($article['Objet']) ?>" disabled></label><br>
	<label><p>Contenu de l'article :</p><textarea rows="25" cols="82" name="article" autofocus><?= htmlspecialchars($article['Post']) ?></textarea></label><br>
	<input type="submit" value="Modifier">
</form>

<?php if (!empty($_SESSION['pageCourante'])): ?>
<div class="lien"><a href="<?= $_SESSION['pageCourante'] ?>">Annuler</a></div>
<?php endif; ?>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
