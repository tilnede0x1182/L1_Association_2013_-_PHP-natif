<?php
/**
 * Page de retrait d'un participant d'un projet
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

// Récupérer les paramètres
$idprojet = isset($_GET['idprojet']) ? $_GET['idprojet'] : '';
$idmembre = isset($_GET['idmembre']) ? $_GET['idmembre'] : '';

if (empty($idprojet) || empty($idmembre)) {
	header("Location: " . $serveur . "src/pages/Contenu/Projets/Liste.php");
	exit;
}

// Récupérer le projet
$projet = getProjet($idprojet);
if (!$projet) {
	die("Projet non trouvé");
}

// Vérifier que l'utilisateur est le créateur du projet
$estProprietaire = ($projet['id'] == $_SESSION['id']);
if (!$estProprietaire) {
	header("Location: " . $serveur . "src/pages/Contenu/Projets/Liste.php");
	exit;
}

// Vérifier que le membre à retirer n'est pas le créateur
if ($idmembre == $projet['id']) {
	header("Location: " . $serveur . "src/pages/Contenu/Projets/Liste.php");
	exit;
}

// Vérifier que le membre est bien participant
if (!estParticipant($idprojet, $idmembre)) {
	header("Location: " . $serveur . "src/pages/Contenu/Projets/Liste.php");
	exit;
}

$titrePage = "Retirer un participant";
$succes = false;

// Traitement du retrait
if (isset($_POST['confirmer'])) {
	if (retirerParticipant($idprojet, $idmembre)) {
		$succes = true;
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

<div class="texte">
<?php if ($succes): ?>
	<h2>Participant retiré</h2>
	<p><strong><?= htmlspecialchars($idmembre) ?></strong> a été retiré du projet <strong><?= htmlspecialchars($projet['Objet']) ?></strong>.</p>
	<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Projets/Liste.php">Retour à la liste des projets</a></div>
<?php else: ?>
	<h2>Exclure <?= htmlspecialchars($idmembre) ?> de <?= htmlspecialchars($projet['Objet']) ?> ?</h2>

	<p>⚠️ Attention : <strong><?= htmlspecialchars($idmembre) ?></strong> ne pourra plus modifier le projet <strong><?= htmlspecialchars($projet['Objet']) ?></strong>.</p>

	<div class="lien">
		<form method="POST" class="form-inline">
			<input type="submit" name="confirmer" value="Confirmer">
		</form>
	</div>

	<br>
	<div class="lien"><a href="<?= $_SESSION['pageCourante'] ?? $serveur . 'src/pages/Contenu/Projets/Liste.php' ?>">Annuler</a></div>
<?php endif; ?>
</div>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
