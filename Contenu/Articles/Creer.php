<?php
/**
 * Création d'un nouvel article
 */
require_once __DIR__ . '/../../includes/init.php';

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "Accueil/Accueil%20%281%29.php");
	exit;
}

$titrePage = "Nouveau post";
$erreur = "";

// Traitement du formulaire
if (!empty($_POST['article']) && !empty($_POST['objet'])) {
	// Vérifier la source
	if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== $serveur . "Contenu/Posts/EcritureNouveauPost.php") {
		$erreur = "Le formulaire est soumis depuis une source externe !";
	} else {
		$objet = htmlspecialchars($_POST['objet']);
		$texte = htmlspecialchars($_POST['article']);

		if (creerArticle($_SESSION['id'], $objet, $texte)) {
			header('Location: ' . $serveur . 'Accueil/Accueil%20%281%29.php');
			exit;
		} else {
			$erreur = "Erreur lors de la création de l'article.";
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

<?php include __DIR__ . '/../../templates/nav.php'; ?>

<?php if ($erreur): ?>
<h4 class="erreur"><?= $erreur ?></h4>
<?php endif; ?>

<form action="<?= $serveur ?>Contenu/Posts/EcritureNouveauPost.php" method="POST">
	<label>Objet : <input type="text" name="objet" autofocus></label>
	<label><p>Taper le texte de l'article :</p><textarea rows="25" cols="82" name="article"></textarea></label><br>
	<input type="submit" value="Publier">
</form>

<?php if (!empty($_SESSION['pageCourante'])): ?>
<a href="<?= $_SESSION['pageCourante'] ?>">Annuler</a>
<?php endif; ?>

<?php include __DIR__ . '/../../templates/footer.php'; ?>
