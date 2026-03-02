<?php
/**
 * Page Présentation / À propos
 */
require_once __DIR__ . '/../includes/init.php';

$_SESSION['pageCourante'] = $serveur . "Accueil/Presentation.php";
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

<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="texte">Présentation du site :</h1>

<p class="texte">
	Le site des anciens de Paris 7 a pour but de rassembler les étudiants de Paris 7, de promouvoir associations et amitiés parmi ses membres.<br><br>
	Vous pourrez ainsi communiquer par l'intermédiaire d'échange de messages publics (les projets).<br><br>
	Pour participer, vous pouvez vous <a href="<?= $serveur ?>Inscription_Desinscription/NouveauMembre3.php">inscrire</a>, ou, si c'est déjà fait, vous identifier.
</p>

<?php include __DIR__ . '/../templates/footer.php'; ?>
