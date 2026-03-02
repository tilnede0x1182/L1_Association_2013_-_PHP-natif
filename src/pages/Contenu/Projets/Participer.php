<?php
/**
 * Page de demande de participation à un projet
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
	header("Location: " . $serveur . "src/pages/Contenu/Projets/Liste.php");
	exit;
}

// Récupérer le projet
$projet = getProjet($idprojet);
if (!$projet) {
	die("Projet non trouvé");
}

// Vérifier qu'on n'est pas admin, déjà participant ou créateur
$estAdmin = verifieConnectionAdmin();
$estProprietaire = ($projet['id'] == $_SESSION['id']);
$dejaParticipant = estParticipant($idprojet, $_SESSION['id']);
$demandeEnAttente = aDemandeEnAttente($idprojet, $_SESSION['id']);

// Les admins ne peuvent pas s'inscrire (ils ont accès via leurs droits)
if ($estAdmin || $estProprietaire || $dejaParticipant) {
	header("Location: " . $serveur . "src/pages/Contenu/Projets/Liste.php");
	exit;
}

$titrePage = "Demande de participation";
$message = "";
$succes = false;

// Traitement de la demande
if (isset($_POST['confirmer'])) {
	if (demanderParticipation($idprojet, $_SESSION['id'])) {
		$succes = true;
		$message = "Votre demande de participation a été envoyée. Le créateur du projet doit maintenant l'accepter.";
	} else {
		$message = "Erreur lors de l'envoi de la demande.";
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
	<h2>Demande envoyée</h2>
	<p><?= $message ?></p>
	<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Projets/Liste.php">Retour à la liste des projets</a></div>
<?php elseif ($demandeEnAttente): ?>
	<h2>Demande déjà en attente</h2>
	<p>Vous avez déjà envoyé une demande de participation pour ce projet. Veuillez attendre la réponse du créateur.</p>
	<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Projets/Liste.php">Retour à la liste des projets</a></div>
<?php else: ?>
	<h2>Participer au projet</h2>
	<h3><?= htmlspecialchars($projet['Objet']) ?></h3>
	<p>Créé par : <a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $projet['id'] ?>"><?= htmlspecialchars($projet['id']) ?></a></p>

	<p>En participant à ce projet, vous pourrez modifier son contenu.</p>
	<p>Votre demande sera envoyée au créateur du projet qui devra l'accepter.</p>

	<div class="lien">
		<form method="POST" style="display: inline;">
			<input type="submit" name="confirmer" value="Confirmer ma demande de participation">
		</form>
	</div>

	<br>
	<div class="lien"><a href="<?= $_SESSION['pageCourante'] ?? $serveur . 'src/pages/Contenu/Projets/Liste.php' ?>">Annuler</a></div>
<?php endif; ?>
</div>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
