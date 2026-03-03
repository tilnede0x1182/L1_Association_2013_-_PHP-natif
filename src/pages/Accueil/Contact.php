<?php
/**
 * Page Contact
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

$_SESSION['pageCourante'] = $serveur . "src/pages/Accueil/Contact.php";
$titrePage = "Nous contacter";
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
	<h1 class="titre-ombre">Nous contacter :</h1>
	<p>
		Bonjour, nous sommes les créateurs et administrateurs du site/association des Anciens de Paris 7.<br>
		Voici la liste des responsables du site/association :
	</p>
	<p><strong class="strong-colore">Président :</strong> Jean<br>presidence.aaeipd@gmail.com</p>
	<p><strong class="strong-colore">Secrétaire :</strong> Henry<br>secretaire.aaeipd@gmail.com</p>
	<p><strong class="strong-colore">Événementiel :</strong> Eric<br>evenementiel.aaeipd@gmail.com</p>
	<p><strong class="strong-colore">Rédacteur :</strong> Laurent<br>redacteur.aaeipd@gmail.com</p>
	<p><strong class="strong-colore">Administrateur :</strong> Gabriel<br>gabriel.leblanc@universite_paris_7.etudiant.fr</p>
	<p><strong class="strong-colore">Administrateur :</strong> Philippe<br>philippe.albin@universite_paris_7.etudiant.fr</p>
	<p>
		Pour toute question ou remarque sur le site, contactez l'un des membres de l'équipe.<br><br>
		Les membres de l'organigramme.
	</p>
</div>

<?php include __DIR__ . '/../../../utils/templates/footer.php'; ?>
