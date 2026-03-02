<?php session_start();
	include '../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	$_SESSION['pageCourante']=$serveur."Accueil/Presentation.php";
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

	echo '<h1 class="texte">Présentation du site : </h1>

	<p class="texte">Le site des anciens de Paris 7 a pour but de rassembler les étudiants de Paris 7, de promouvoir associations et amitiés parmis ses membres.<br><br>Vous pourrez ainsi communiquer par l'."'".'intermédiare d'."'".'échange de messages publics (les projets).<br><br> Pour participer, vous pouvez vous <a href="'.$serveur.'Inscription_Desinscription/NouveauMembre3.php">inscrire</a>, ou, si c'."'".'est déjà fait, vous identifier.</p>'; 

?>

  </body>
</html>

