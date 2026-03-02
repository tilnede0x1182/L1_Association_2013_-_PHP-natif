<?php
/**
 * Page de gestion des demandes de participation
 * Accessible au créateur des projets et aux admins
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

$_SESSION['pageCourante'] = $serveur . "src/pages/Contenu/Projets/Participations.php";

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

$estAdmin = verifieConnectionAdmin();
$titrePage = "Demandes de participation";
$message = "";

// Traitement des actions (accepter/refuser)
if (isset($_POST['action']) && isset($_POST['idprojet']) && isset($_POST['idmembre'])) {
	$idprojet = $_POST['idprojet'];
	$idmembre = $_POST['idmembre'];
	$action = $_POST['action'];

	// Vérifier que l'utilisateur est bien le créateur du projet ou admin
	$projet = getProjet($idprojet);
	if ($projet && ($projet['id'] == $_SESSION['id'] || $estAdmin)) {
		if ($action == 'accepter') {
			if (accepterParticipation($idprojet, $idmembre)) {
				$message = "Participation de " . htmlspecialchars($idmembre) . " acceptée.";
			}
		} elseif ($action == 'refuser') {
			if (refuserParticipation($idprojet, $idmembre)) {
				$message = "Participation de " . htmlspecialchars($idmembre) . " refusée.";
			}
		}
	}
}

// Récupérer les demandes en attente pour les projets de l'utilisateur
$demandes = getDemandesParticipationPourCreateur($_SESSION['id']);

// Pour les admins, récupérer toutes les demandes
if ($estAdmin) {
	$connexion = getConnexion();
	$requete = 'SELECT p.*, pr.Objet as titre_projet, pr.id as createur_projet
		FROM participations p
		INNER JOIN projets pr ON p.idprojet = pr.idprojet
		WHERE p.statut="en_attente"
		ORDER BY p.date_demande DESC';
	$resultat = mysqli_query($connexion, $requete);
	$demandes = [];
	while ($ligne = mysqli_fetch_array($resultat)) {
		$demandes[] = $ligne;
	}
}

$nbDemandes = count($demandes);
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
<h2>Demandes de participation à vos projets</h2>

<?php if ($message): ?>
	<p><strong><?= $message ?></strong></p>
<?php endif; ?>

<?php if ($nbDemandes == 0): ?>
	<p>Aucune demande de participation en attente.</p>
<?php else: ?>
	<p><?= $nbDemandes ?> demande(s) en attente.</p>

	<table border="1">
		<tr>
			<th>Demandeur</th>
			<th>Projet</th>
			<?php if ($estAdmin): ?><th>Créateur</th><?php endif; ?>
			<th>Date de demande</th>
			<th>Actions</th>
		</tr>
		<?php foreach ($demandes as $demande): ?>
		<tr>
			<td>
				<a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= htmlspecialchars($demande['idmembre']) ?>">
					<?= htmlspecialchars($demande['idmembre']) ?>
				</a>
			</td>
			<td><?= htmlspecialchars($demande['titre_projet']) ?></td>
			<?php if ($estAdmin): ?>
			<td>
				<a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= htmlspecialchars($demande['createur_projet']) ?>">
					<?= htmlspecialchars($demande['createur_projet']) ?>
				</a>
			</td>
			<?php endif; ?>
			<td><?= htmlspecialchars($demande['date_demande']) ?></td>
			<td style="white-space: nowrap;">
				<form method="POST" style="display: inline-block;">
					<input type="hidden" name="idprojet" value="<?= $demande['idprojet'] ?>">
					<input type="hidden" name="idmembre" value="<?= htmlspecialchars($demande['idmembre']) ?>">
					<input type="hidden" name="action" value="accepter">
					<input type="submit" value="Oui" class="btn-accepter">
				</form>
				<form method="POST" style="display: inline-block;">
					<input type="hidden" name="idprojet" value="<?= $demande['idprojet'] ?>">
					<input type="hidden" name="idmembre" value="<?= htmlspecialchars($demande['idmembre']) ?>">
					<input type="hidden" name="action" value="refuser">
					<input type="submit" value="Non" class="btn-refuser">
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
<?php endif; ?>

<br>
<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Projets/Liste.php">Retour à la liste des projets</a></div>
</div>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
