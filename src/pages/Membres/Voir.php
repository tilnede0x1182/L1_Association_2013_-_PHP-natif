<?php
/**
 * Page d'information sur un membre
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

// Gestion de la page précédente
$pagePrecedente = "";
if (!empty($_SESSION['pageCourante']) && strpos($_SESSION['pageCourante'], $serveur . "src/pages/Membres/Voir") === false) {
	$pagePrecedente = $_SESSION['pageCourante'];
}

// Récupérer l'ID du membre
$idMembre = isset($_GET['idmembre']) ? $_GET['idmembre'] : '';
$_SESSION['pageCourante'] = $serveur . "src/pages/Membres/Voir.php" . ($idMembre ? "?idmembre=" . $idMembre : "");

// Vérifier les droits
$estAdmin = verifieConnectionMembre();
$estConnecte = verifieConnection();

// Récupérer les données du membre
$membre = getMembreById($idMembre);
if (!$membre) {
	die("Membre non trouvé");
}

// Vérifier si le membre consulté est admin
$membreEstAdmin = in_array($membre['competence'], array('President', 'Secretaire', 'Administrateur'));

// Préparer les données d'affichage
$datedudernierprojet = ($membre['datedudernierprojet'] == -11 || $membre['datedudernierprojet'] == 0)
	? "Aucun projet à ce jour"
	: convertDate($membre['datedudernierprojet']) . " (" . CalcAnciennete2($membre['datedudernierprojet']) . ")";

$datedederniereconnection = ($membre['datedederniereconnection'] == -11 || $membre['datedederniereconnection'] == 0)
	? "Aucune connexion"
	: convertDate($membre['datedederniereconnection']) . " (" . CalcAnciennete2($membre['datedederniereconnection']) . ")";

$connecte = ($membre['Connecte'] == 1) ? "Oui" : "Non";
$anciennete = CalcAnciennete($membre["datedinscription"]);

$titrePage = "Information sur le membre " . $membre['id'];
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

<h1>Information sur le membre <?= htmlspecialchars($membre['id']) ?> :</h1>

<table border="1">
	<tr>
		<th>Compétence</th>
		<th>Identifiant</th>
		<th>Date du dernier projet</th>
		<?php if ($estAdmin && $membreEstAdmin): ?>
		<th>Liste des articles publiés par ce membre</th>
		<?php endif; ?>
		<?php if ($estConnecte): ?>
		<th>Liste des projets</th>
		<?php endif; ?>
		<th>Connecté en ce moment</th>
	</tr>
	<tr>
		<td><?= htmlspecialchars($membre['competence']) ?></td>
		<td><?= htmlspecialchars($membre['id']) ?></td>
		<td><?= $datedudernierprojet ?></td>
		<?php if ($estAdmin && $membreEstAdmin): ?>
		<td><a href="<?= $serveur ?>src/pages/Contenu/Articles/ListeMembre.php?idmembre=<?= $idMembre ?>">Liste des articles publiés par ce membre</a></td>
		<?php endif; ?>
		<?php if ($estConnecte): ?>
		<td><a href="<?= $serveur ?>src/pages/Contenu/Projets/ListeMembre.php?idmembre=<?= $membre['id'] ?>">Liste des projets</a></td>
		<?php endif; ?>
		<td><?= $connecte ?></td>
	</tr>
</table>

<p></p>

<table border="1">
	<tr>
		<th>Nombre de projets</th>
		<?php if ($estAdmin && $membreEstAdmin): ?>
		<th>Nombre d'articles publiés</th>
		<?php endif; ?>
		<th>Adresse e-mail</th>
		<th>Date d'inscription</th>
		<th>Ancienneté</th>
		<th>Dernière connexion</th>
	</tr>
	<tr>
		<td><?= $membre['nombredeprojets'] ?></td>
		<?php if ($estAdmin && $membreEstAdmin): ?>
		<td><?= $membre['nombredeposts'] ?></td>
		<?php endif; ?>
		<td><?= htmlspecialchars($membre['mail']) ?></td>
		<td><?= convertDate($membre["datedinscription"]) ?></td>
		<td><?= $anciennete ?></td>
		<td><?= $datedederniereconnection ?></td>
	</tr>
</table>

<?php if ($pagePrecedente): ?>
<p class="texte"><a href="<?= $pagePrecedente ?>">Retour</a></p>
<?php endif; ?>

<?php include __DIR__ . '/../../../utils/templates/footer.php'; ?>
