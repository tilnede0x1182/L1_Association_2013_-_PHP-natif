<?php session_start();
	include 'Fonctions/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Suppression d'un projet</title>
<?php
	include 'Fonctions/includeStylesheet.php';
?>
  </head>

  <body>

<?php
	include 'Fonctions/AdresseServeur.php';

	if (!empty($_GET['idprojet'])) $idprojet = $_GET['idprojet'];
	else $idprojet = "inconnu";

	include 'MenuAccueil.php';
	include 'Fonctions/detectlId.php';
	include 'Fonctions/ConversionDate.php';

	if (verifieConnection()){

		echo "\n".'    <div class="lien"><p><a href="'.$serveur.'CreationNouveauProjet.php">Nouveau projet</a></p></div>'."\n\n";

		include 'Fonctions/ConnectionBaseDonnees.php';
		
		$connexion = mysqli_connect($server, $user, $motdepasse, $base);
		if (!$connexion) {
			echo "Pas de connexion au serveur" ;
		}else {
			if (!$connexion) {
				echo "Pas d'accès à la base" ;
			}else {

				if (empty($_POST)) {

					echo '<h3>Voulez-vous réellement supprimer ce projet ?<br></h3>'."\n";

					echo '	 <form action="" method="POST"><input name="choix" value="1" hidden><input type="submit" value="Oui"></form>&nbsp;&nbsp;';
					echo '	 <form action="" method="POST"><input name="choix" value="0" hidden><input type="submit" value="Annuler"></form>';

				}else {

					if ($_POST['choix']==1) {
						$sql ='DELETE from projets WHERE idprojet="'.$idprojet.'"'; 
						mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));


						$sql ='DELETE from dataprojets WHERE idprojet="'.$idprojet.'"'; 
						mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion)); 

						echo '<h4>Le projet a été supprimé.</h4>'."\n";
						echo '<p><a href="'.$serveur.'NouveauProjet.php">Retour à la page des projets</a>.'."</p>";

						if (!empty($_SESSION['pageCourante'])) header('Location: '.$_SESSION['pageCourante']);
						else header('Location: '.$serveur.'NouveauProjet.php');

					}else {
						if (!empty($_SESSION['pageCourante'])) header('Location: '.$_SESSION['pageCourante']);
						else header('Location: '.$serveur.'NouveauProjet.php');

						echo '<p><a href="'.$serveur.'NouveauProjet.php">Retour à la page des projets</a>.'."</p>";
					}
				}
			}
		}
	}

?>
  </body>
</html>



