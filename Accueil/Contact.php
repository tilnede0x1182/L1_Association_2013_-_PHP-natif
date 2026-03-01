<?php session_start();
	include '../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	$_SESSION['pageCourante']=$serveur."Accueil/Accueil%20%281%29.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>A propos</title>
<?php
	include '../Utilitaires/Affichage/includeStylesheet.php';
?>
  </head>

  <body>

<?php
	include 'MenuAccueil.php';

	echo '<h1 class="texte">Nous contacter : </h1>

	<p class="texte">Bonjour, nous sommes les créateurs et administrateurs du site/association des Anciens de Paris 7.<br>Voici la liste des responsables du site/assocation : <br></p> 

	<p class="texte1"> President : Samir <br>presidence.aaeipd@gmail.com</p>
	<p class="texte1"> Secrétaire : Henry <br>secretaire.aaeipd@gmail.com</p>
	<p class="texte1"> Evenementiel : Eric <br>evenementiel.aaeipd@gmail.com</p>
	<p class="texte1"> redacteur : Laurant <br>redacteur.aaeipd@gmail.com</p>
	<p class="texte1"> Administrateurs : Jasmin <br>jasmin.diantouba@etu.univ-paris-diderot.fr</p>

	<p class="texte1"> Administrateurs : Cyrille <br>cyrille.dgasquet@etu.univ-paris-diderot.fr</p>

	<p class="texte">N'."'".'hésitez pas à nous envoyer des remarques ou des revendications sur ou le fonctionnement ou la présentation du site.<br><br> Les membres de l'."'".'organigramme.</p>'; 
?>

  </body>
</html>

