<?php
/**
 * Page d'exclusion d'un participant d'un projet
 * Style alerte rouge pour montrer l'importance de l'action
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

// Vérifier que le membre à exclure n'est pas le créateur
if ($idmembre == $projet['id']) {
	header("Location: " . $serveur . "src/pages/Contenu/Projets/Liste.php");
	exit;
}

// Vérifier que le membre est bien participant
if (!estParticipant($idprojet, $idmembre)) {
	header("Location: " . $serveur . "src/pages/Contenu/Projets/Liste.php");
	exit;
}

$titrePage = "Exclure un participant";
$succes = false;

// Traitement de l'exclusion
if (isset($_POST['confirmer'])) {
	if (exclureParticipant($idprojet, $idmembre)) {
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
	<h2>Participant exclu</h2>
	<p><strong><?= htmlspecialchars($idmembre) ?></strong> a été exclu du projet <strong><?= htmlspecialchars($projet['Objet']) ?></strong>.</p>
	<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Projets/Liste.php">Retour à la liste des projets</a></div>
<?php else: ?>
	<div class="alerte-danger">
		<h2>⚠️ ATTENTION - ACTION IRRÉVERSIBLE</h2>

		<p>Vous êtes sur le point d'exclure <strong><?= htmlspecialchars($idmembre) ?></strong> du projet <strong><?= htmlspecialchars($projet['Objet']) ?></strong>.</p>

		<p><strong>Cette action est définitive.</strong></p>

		<p>Le membre exclu :</p>
		<ul>
			<li>Ne pourra plus modifier ce projet</li>
			<li>Devra refaire une demande de participation s'il souhaite revenir</li>
			<li>Ne sera pas notifié de cette exclusion</li>
		</ul>

		<p>Êtes-vous certain de vouloir procéder à cette exclusion ?</p>

		<form method="POST">
			<input type="submit" name="confirmer" value="Exclure <?= htmlspecialchars($idmembre) ?> du projet <?= htmlspecialchars($projet['Objet']) ?>" class="btn-danger">
		</form>
	</div>

	<br>
	<div class="lien"><a href="<?= $_SESSION['pageCourante'] ?? $serveur . 'src/pages/Contenu/Projets/Liste.php' ?>">Annuler</a></div>
<?php endif; ?>
</div>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
