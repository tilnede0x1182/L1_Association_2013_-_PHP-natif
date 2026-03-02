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
$estAdmin = verifieConnectionMembre();
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

<h1>Liste des projets du membre <a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $membre ?>"><?= htmlspecialchars($membre) ?></a> :</h1>

<table border="1">
	<tr>
		<?php if ($estProprietaire || $estAdmin): ?>
		<th>Auteurs et dates de modification</th>
		<?php endif; ?>
		<th>Contenu du projet</th>
		<th>Date de publication</th>
	</tr>
<?php if (empty($projets)): ?>
	<tr>
		<td colspan="3">Aucun projet à ce jour.</td>
	</tr>
<?php else: ?>
	<?php foreach ($projets as $projet): ?>
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
	</tr>
	<?php endforeach; ?>
<?php endif; ?>
</table>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
