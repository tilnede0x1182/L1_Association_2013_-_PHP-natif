<?php
/**
 * Liste des projets d'un membre
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

// Récupérer l'ID du membre
$membre = isset($_GET['idmembre']) ? $_GET['idmembre'] : 'inconnu';
$_SESSION['pageCourante'] = $serveur . "src/pages/Contenu/Projets/ListeMembre.php?idmembre=" . $membre;

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

// Vérifier les droits
$estAdmin = verifieConnectionAdmin();
$estProprietaire = ($membre == $_SESSION['id']);

// Récupérer les projets du membre
$projets = getProjetsByMembre($membre);

$titrePage = "Liste des projets du membre " . $membre;
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

<h1 class="titre-ombre">Liste des projets du membre <a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $membre ?>" class="lien-titre"><?= htmlspecialchars($membre) ?></a> :</h1>

<table border="1">
	<tr>
		<?php if ($estProprietaire || $estAdmin): ?>
		<th>Auteurs et dates de modification</th>
		<?php endif; ?>
		<th>Contenu du projet</th>
		<th>Date de publication</th>
		<?php if ($estAdmin || $estProprietaire): ?><th>Modifications</th><?php endif; ?>
		<th>Participants</th>
	</tr>
<?php if (empty($projets)): ?>
	<tr>
		<td colspan="3">Aucun projet à ce jour.</td>
	</tr>
<?php else: ?>
	<?php foreach ($projets as $projet):
		$participants = getParticipants($projet['idprojet']);
		$dejaParticipant = in_array($_SESSION['id'], $participants);
		$demandeEnAttente = aDemandeEnAttente($projet['idprojet'], $_SESSION['id']);
	?>
	<tr>
		<?php if ($estProprietaire || $estAdmin): ?>
		<td>
			<?php
			$modifs = getModificationsProjet($projet['idprojet']);
			if (empty($modifs)):
			?>
				Aucune modification
			<?php else: ?>
				<?php $nbAffiche = 0; foreach ($modifs as $modif): ?>
					<?php if ($nbAffiche < 3): ?>
						<a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $modif['idmembre'] ?>"><?= $modif['idmembre'] ?></a>
						(<?= convertDate($modif['date']) ?>)<br>
						<?php $nbAffiche++; ?>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if (count($modifs) > 5): ?>
					<a href="<?= $serveur ?>src/pages/Contenu/Projets/Historique.php?idprojet=<?= $projet['idprojet'] ?>">Afficher la liste</a>
				<?php elseif (count($modifs) > 3): ?>
					... et <?= count($modifs) - 3 ?> autres
				<?php endif; ?>
			<?php endif; ?>
		</td>
		<?php endif; ?>
		<td>
			<h4><?= htmlspecialchars($projet['Objet']) ?> :</h4>
			<?= nl2br(detectlId($projet['Texte'])) ?>
		</td>
		<td><?= convertDate($projet['date']) ?></td>
		<?php if ($estAdmin || $estProprietaire): ?>
		<td>
			<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Projets/Editer.php?idprojet=<?= $projet['idprojet'] ?>">modifier</a></div>
			<br><br><br>
			<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Projets/Supprimer.php?idprojet=<?= $projet['idprojet'] ?>">supprimer</a></div>
		</td>
		<?php endif; ?>
		<td>
			<?php if (empty($participants)): ?>
				Aucun participant
			<?php else: ?>
				<?php foreach ($participants as $participant): ?>
					<span class="nowrap"><a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= htmlspecialchars($participant) ?>"><?= htmlspecialchars($participant) ?></a><?php if ($estProprietaire && $participant != $projet['id']): ?> <a href="<?= $serveur ?>src/pages/Contenu/Projets/RetirerParticipant.php?idprojet=<?= $projet['idprojet'] ?>&idmembre=<?= urlencode($participant) ?>" class="btn-retirer" title="Retirer ce participant">⤴️</a><?php endif; ?></span><br>
				<?php endforeach; ?>
			<?php endif; ?>
			<br>
			<?php if (!$estAdmin && !$estProprietaire && !$dejaParticipant && !$demandeEnAttente): ?>
				<div class="lien"><a href="<?= $serveur ?>src/pages/Contenu/Projets/Participer.php?idprojet=<?= $projet['idprojet'] ?>">Participer</a></div>
			<?php elseif ($demandeEnAttente): ?>
				<em>Demande en attente</em>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>
<?php endif; ?>
</table>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
