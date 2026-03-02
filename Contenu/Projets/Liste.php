<?php
/**
 * Page des projets - Affiche les 15 derniers projets
 */
require_once __DIR__ . '/../../includes/init.php';

$_SESSION['pageCourante'] = $serveur . "Contenu/Projets/Liste.php";

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "Accueil/index.php");
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

<?php include __DIR__ . '/../../templates/nav.php'; ?>

<div class="lien"><p><a href="<?= $serveur ?>Contenu/Projets/Creer.php">Nouveau projet</a></p></div>

<table border="1">
	<tr>
		<th>Auteurs et dates de modification</th>
		<th>Derniers projets</th>
		<th>Date de publication</th>
	</tr>
<?php foreach ($projets as $projet): ?>
	<?php $estProprietaire = ($projet['id'] == $_SESSION['id']); ?>
	<tr>
		<td>
			<a href="<?= $serveur ?>Membres/Voir.php?idmembre=<?= $projet['id'] ?>"><?= htmlspecialchars($projet['id']) ?></a>
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
							<a href="<?= $serveur ?>Membres/Voir.php?idmembre=<?= $modif['idmembre'] ?>"><?= $modif['idmembre'] ?></a>
							(<?= convertDate($modif['date']) ?>)<br>
							<?php $nbAffiche++; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php if (count($modifs) > 5): ?>
						<a href="<?= $serveur ?>Contenu/Projets/Historique.php?idprojet=<?= $projet['idprojet'] ?>">Afficher la liste</a>
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
	</tr>
<?php endforeach; ?>
</table>

<div class="lien"><p><a href="<?= $serveur ?>Contenu/Projets/Creer.php">Nouveau projet</a></p></div>

<?php include __DIR__ . '/../../templates/footer.php'; ?>
