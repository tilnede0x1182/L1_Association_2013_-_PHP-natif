<?php
/**
 * Page Présentation / À propos
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

$_SESSION['pageCourante'] = $serveur . "src/pages/Accueil/Presentation.php";
$titrePage = "À propos";
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

<div class="texte">
	<h1>Présentation du site :</h1>
	<p>
		Le site des anciens de Paris 7 a pour but de rassembler les étudiants de Paris 7, de promouvoir associations et amitiés parmi ses membres.<br><br>
		Vous pourrez ainsi communiquer par l'intermédiaire d'échange de messages publics (les projets).<br><br>
		Pour participer, vous pouvez vous <a href="<?= $serveur ?>src/pages/Auth/Inscription.php">inscrire</a>, ou, si c'est déjà fait, <a href="<?= $serveur ?>src/pages/Auth/Connexion.php">vous identifier</a>.
	</p>
</div>

<?php include __DIR__ . '/../../../utils/templates/footer.php'; ?>
