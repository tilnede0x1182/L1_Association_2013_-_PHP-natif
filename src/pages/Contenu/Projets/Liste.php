<?php
/**
 * Page des projets - Affiche les 15 derniers projets
 */
require_once __DIR__ . '/../../../../utils/includes/init.php';

$_SESSION['pageCourante'] = $serveur . "src/pages/Contenu/Projets/Liste.php";

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

// Récupérer les droits et projets
$estAdmin = verifieConnectionMembre();
$projets = getDerniersProjets(15);

$titrePage = "Nouveau Projet";
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

<div class="lien"><p><a href="<?= $serveur ?>src/pages/Contenu/Projets/Creer.php">Nouveau projet</a></p></div>

<table border="1">
	<tr>
		<th>Auteurs et dates de modification</th>
		<th>Derniers projets</th>
		<th>Date de publication</th>
		<th>Modifications</th>
	</tr>
<?php foreach ($projets as $projet): ?>
	<?php $estProprietaire = ($projet['id'] == $_SESSION['id']); ?>
	<tr>
		<td>
			<a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $projet['id'] ?>"><?= htmlspecialchars($projet['id']) ?></a>
			<?php if ($estAdmin || $estProprietaire): ?>
				<br><br>
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
			<?php endif; ?>
		</td>
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
	</tr>
<?php endforeach; ?>
</table>

<div class="lien"><p><a href="<?= $serveur ?>src/pages/Contenu/Projets/Creer.php">Nouveau projet</a></p></div>

<?php include __DIR__ . '/../../../../utils/templates/footer.php'; ?>
