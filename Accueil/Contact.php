<?php
/**
 * Page Contact
 */
require_once __DIR__ . '/../includes/init.php';

$_SESSION['pageCourante'] = $serveur . "Accueil/Contact.php";
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

<?php include __DIR__ . '/../templates/nav.php'; ?>

<h1 class="texte">Nous contacter :</h1>

<p class="texte">
	Bonjour, nous sommes les créateurs et administrateurs du site/association des Anciens de Paris 7.<br>
	Voici la liste des responsables du site/association :
</p>

<p class="texte1">Président : Samir<br>presidence.aaeipd@gmail.com</p>
<p class="texte1">Secrétaire : Henry<br>secretaire.aaeipd@gmail.com</p>
<p class="texte1">Événementiel : Eric<br>evenementiel.aaeipd@gmail.com</p>
<p class="texte1">Rédacteur : Laurent<br>redacteur.aaeipd@gmail.com</p>
<p class="texte1">Administrateurs : Jasmin<br>jasmin.diantouba@etu.univ-paris-diderot.fr</p>
<p class="texte1">Administrateurs : Cyrille<br>cyrille.dgasquet@etu.univ-paris-diderot.fr</p>

<p class="texte">
	N'hésitez pas à nous envoyer des remarques ou des revendications sur le fonctionnement ou la présentation du site.<br><br>
	Les membres de l'organigramme.
</p>

<?php include __DIR__ . '/../templates/footer.php'; ?>
