<?php session_start();
	include 'AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	$_SESSION['pageCourante']=$serveur."Utilitaires/Navigation/PageRedirectionVerslInscription.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>A propos</title>
<?php
	include '../Affichage/includeStylesheet.php';
?>
  </head>

  <body>

<?php
	include '../../Accueil/MenuAccueil.php';
	include '../Dates/ConversionDate.php';

	echo '<h2 class="texte">Contenu privé : </h2>

	<h3 class="texte1">Pour voir cette page vous devez vous <a href="'.$serveur.'Inscription_Desinscription/NouveauMembre3.php">inscrire</a> ou, si c'."'".'est déjà fait, vous identifer.</h3>';

	if (verifieConnection()) header('Location: '.$serveur.'Contenu/Projets/NouveauProjet.php');

?>

  </body>
</html>

