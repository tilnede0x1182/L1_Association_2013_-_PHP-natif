<?php
/**
 * Liste des membres
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

$_SESSION['pageCourante'] = $serveur . "src/pages/Membres/Liste.php";
$titrePage = "Liste des membres";

// Vérifier la connexion
if (!verifieConnection()) {
	header("Location: " . $serveur . "src/pages/Accueil/index.php");
	exit;
}

$estAdmin = verifieConnectionAdmin();

// Récupérer les paramètres de tri
$classement = isset($_POST['classement']) ? $_POST['classement'] : 'id';
$ordre = isset($_POST['ordre']) ? $_POST['ordre'] : 'ASC';

// Options de tri sélectionnées
$optionsTri = array(
	'competence' => ($classement == 'competence') ? 'selected' : '',
	'id' => ($classement == 'id') ? 'selected' : '',
	'datedudernierprojet' => ($classement == 'datedudernierpost') ? 'selected' : '',
	'nombredeprojets' => ($classement == 'nombredeprojets') ? 'selected' : '',
	'datedederniereconnection' => ($classement == 'datedederniereconnection') ? 'selected' : '',
	'datedinscription' => ($classement == 'datedinscription') ? 'selected' : ''
);
$ordreOptions = array(
	'ASC' => ($ordre == 'ASC') ? 'selected' : '',
	'DESC' => ($ordre == 'DESC') ? 'selected' : ''
);

// Vérifier la source du formulaire
if (!empty($_POST) && isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== $serveur . "src/pages/Membres/Liste.php") {
	die("<h1>Attention</h1><h4>Le formulaire est soumis depuis une source externe !</h4>");
}

// Récupérer les membres
$membres = getAllMembres($classement, $ordre);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title><?= $titrePage ?></title>
	<?= includeStylesheet() ?>
</head>
<body>

<?php include __DIR__ . '/../../../utils/templates/nav.php'; ?>

<nav class="ClassementResultats">
	<form action="<?= $serveur ?>src/pages/Membres/Liste.php" method="POST">
		<label>Trier par :
			<select name="classement">
				<option <?= $optionsTri['datedudernierprojet'] ?> value="datedudernierpost">Date du dernier projet</option>
				<option <?= $optionsTri['datedinscription'] ?> value="datedinscription">Date d'inscription</option>
				<option <?= $optionsTri['datedederniereconnection'] ?> value="datedederniereconnection">Dernière connexion</option>
				<option <?= $optionsTri['nombredeprojets'] ?> value="nombredeprojets">Nombre de projets</option>
				<option <?= $optionsTri['id'] ?> value="id">Identifiant</option>
				<option <?= $optionsTri['competence'] ?> value="competence">Compétence</option>
			</select>
		</label>
		<label> par ordre :
			<select name="ordre">
				<option <?= $ordreOptions['DESC'] ?> value="DESC">Décroissant</option>
				<option <?= $ordreOptions['ASC'] ?> value="ASC">Croissant</option>
			</select>
		</label>
		<input type="submit">
	</form>
</nav>

<table border="1">
	<tr>
		<th>Compétence</th>
		<th>Identifiant</th>
		<th>Date du dernier projet</th>
		<th>Nombre de projets</th>
		<th>Dernière connexion</th>
		<th>Date d'inscription</th>
		<?php if ($estAdmin): ?><th>Modifications</th><?php endif; ?>
	</tr>
<?php foreach ($membres as $membre): ?>
	<tr>
		<td><?= htmlspecialchars($membre['competence']) ?></td>
		<td><a href="<?= $serveur ?>src/pages/Membres/Voir.php?idmembre=<?= $membre['id'] ?>"><?= htmlspecialchars($membre['id']) ?></a></td>
		<td>
			<?php if ($membre['datedudernierprojet'] == -11 || $membre['datedudernierprojet'] == 0): ?>
				Aucun projet à ce jour
			<?php else: ?>
				<?= convertDate($membre['datedudernierprojet']) ?> (<?= CalcAnciennete2($membre['datedudernierprojet']) ?>)
			<?php endif; ?>
		</td>
		<td><?= $membre['nombredeprojets'] ?></td>
		<td>
			<?php if ($membre['datedederniereconnection'] == -11 || $membre['datedederniereconnection'] == 0): ?>
				Aucune connexion
			<?php else: ?>
				<?= convertDate($membre['datedederniereconnection']) ?> (<?= CalcAnciennete2($membre['datedederniereconnection']) ?>)
			<?php endif; ?>
		</td>
		<td>
			<?php if ($membre['datedinscription'] == -11 || $membre['datedinscription'] == 0): ?>
				<?= convertDate($membre['datedinscription']) ?>
			<?php else: ?>
				<?= convertDate($membre['datedinscription']) ?> (<?= CalcAnciennete2($membre['datedinscription']) ?>)
			<?php endif; ?>
		</td>
		<?php if ($estAdmin): ?>
		<td>
			<div class="lien"><a href="<?= $serveur ?>src/pages/Membres/MonCompte.php?idmembre=<?= $membre['id'] ?>">modifier</a></div>
			<br><br><br>
			<div class="lien"><a href="<?= $serveur ?>src/pages/Membres/Supprimer.php?idmembre=<?= $membre['id'] ?>">supprimer</a></div>
		</td>
		<?php endif; ?>
	</tr>
<?php endforeach; ?>
</table>

<?php include __DIR__ . '/../../../utils/templates/footer.php'; ?>
