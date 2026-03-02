<?php session_start();
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
	include '../../Fonctions/includeStylesheet2.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Modifier le style</title>
<?php
	echo includeStylesheet2();
?>
  </head>

  <body>

<?php
	include '../Navigation/AdresseServeur.php';

	if (!empty($_GET['couleur'])) $style = $_GET['couleur'];
	else $style = "1";

	if ($style=="1") $_SESSION['style']="1";
	if ($style=="2") $_SESSION['style']="2";

	if (!empty($_SESSION['pageCourante'])) header('Location: '.$_SESSION['pageCourante']);
	else header('Location: '.$serveur.'Accueil/index.php');

	echo '<h4>Le style a été modifié.<br>'."\n";
	if (!empty($_SESSION['pageCourante'])) echo ' <a href="'.$_SESSION['pageCourante'].'">Retour</a>';
	else echo ' <a href="'.$serveur.'Accueil/index.php">Retour à la page d'."'".'acceuil</a>';

	include 'footer.php';
?>

  </body>
</html>