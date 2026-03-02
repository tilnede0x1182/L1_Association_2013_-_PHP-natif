<?php
/**
 * Modification d'un projet
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

// Récupérer l'ID du projet
$idprojet = isset($_GET['idprojet']) ? $_GET['idprojet'] : '';
if (empty($idprojet)) {
	echo '<h2>Affichage impossible pour le moment...</h2>';
	if (!empty($_SESSION['pageCourante'])) {
		echo '<h3><a href="' . $_SESSION['pageCourante'] . '">Revenir à la page précédente</a></h3>';
	} else {
		echo '<h3><a href="' . $serveur . 'src/pages/Accueil/index.php">Retour à la page d\'accueil</a></h3>';
	}
	exit;
}

// Récupérer le projet
$projet = getProjet($idprojet);
if (!$projet) {
	die("Projet non trouvé");
}

// Vérifier les droits (admin OU créateur du projet)
$estAdmin = verifieConnectionMembre();
$estProprietaire = ($projet['id'] == $_SESSION['id']);
if (!$estAdmin && !$estProprietaire) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

$titrePage = "Modification d'un projet";
$erreur = "";

// Traitement du formulaire
if (!empty($_POST)) {
	// Vérifier la source
	if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== $serveur . "src/pages/Contenu/Projets/Editer.php?idprojet=" . $idprojet) {
		$erreur = "Le formulaire est soumis depuis une source externe !";
	} elseif (empty($_POST["article"])) {
		$erreur = "Veuillez entrer quelque chose, ou quitter cette page.";
	} else {
		if (modifierProjet($idprojet, $projet['Objet'], htmlspecialchars($_POST['article']), $_SESSION['id'])) {
			if (!empty($_SESSION['pageCourante'])) {
				header('Location: ' . $_SESSION['pageCourante']);
			} else {
				header('Location: ' . $serveur . 'src/pages/Contenu/Projets/Liste.php');
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

<form action="<?= $serveur ?>src/pages/Contenu/Projets/Editer.php?idprojet=<?= $idprojet ?>" method="POST">
	<label>Objet : <input type="text" value="<?= htmlspecialchars($projet['Objet']) ?>" disabled></label><br>
	<label><p>Contenu du projet :</p><textarea rows="25" cols="82" name="article" autofocus><?= htmlspecialchars($projet['Texte']) ?></textarea></label><br>
	<input type="submit" value="Modifier">
</form>

<?php if (!empty($_SESSION['pageCourante'])): ?>
<a href="<?= $_SESSION['pageCourante'] ?>">Annuler</a>
<?php endif; ?>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
