<?php session_start();
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
  <html lang="fr" >
  <head>
    <title>Modification d'un projet</title>
    <meta charset="utf-8" />
<?php
	include 'Fonctions/includeStylesheet.php';
?>
  </head>
  <body>

<?php

	include 'MenuAccueil.php';
	include 'Fonctions/AdresseServeur.php';

	if (VerifieConnection()) {
		if (!empty($_GET['idprojet'])) {
			$idprojet = $_GET['idprojet'];
		}else {
			$idprojet = "non identifié";
			echo '<h2>Affichage impossible pour le moment...</h2>'."\n";
			if (!empty($_SESSION['pageCourante'])) echo '<h3><a href="'.$_SESSION['pageCourante'].'">Revenir à la page précédente</a></h3>'."\n";
			else echo '<h3><a href="'.$serveur.'Accueil%20%281%29.php">Retour à la page d'."'".'accueil</a></h3>';
			exit();
		}
		

		include 'Fonctions/ConnectionBaseDonnees.php';
		
		$connexion = mysqli_connect($server, $user, $motdepasse, $base);
		if (!$connexion) {
			echo "Pas de connexion au serveur" ;
		}else {
			if (!$connexion) {
				echo "Pas d'accès à la base" ;
			}else {

				$requete1 = 'SELECT * FROM projets WHERE idprojet="'.$idprojet.'"';
				$resultat1 = mysqli_query($connexion, $requete1);
				$ligne1 = mysqli_fetch_array($resultat1);

				$date = date("dmY");
				$heure = date("His");

				if (empty($_POST)) {

					//echo $idprojet;

					//echo '"http://localhost/Projet1/ModifierProjet.php.php?idprojet='.$idprojet;

					echo '	 <form action="'.$serveur.'ModifierProjet.php?idprojet='.$idprojet.'" method="POST">
	  <label>Objet : <input type="text" value="'.$ligne1['Objet'].'" disabled></label><br>
	  <label><p>Contenu du projet : </p><textarea rows="25" cols="82" name="article" autofocus>'.$ligne1['Texte'].'</textarea></label><br>
	  <input type="submit" value="modifier">
	 </form>'."\n";

					if (!empty($_SESSION['pageCourante'])) echo '<a href="'.$_SESSION['pageCourante'].'">Annuler</a>'."\n";

				}else {

					if($_SERVER["HTTP_REFERER"] !== $serveur."ModifierProjet.php?idprojet=".$idprojet) {
						echo "	<h1>Attention</h1>\n	<h4>Le formulaire est soumis depuis une source externe !</h4>";
					}
					
					else if(empty($_POST["article"])) {	
						echo "<h4>Veuillez entrer quelque chose, ou quitter cette page.</h4>";
					}

					else {
						$sql = 'UPDATE projets SET Texte="'.htmlspecialchars($_POST['article']).'" WHERE idprojet="'.$idprojet.'"';
						mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
						
						$sql = 'INSERT INTO dataprojets (idauteur, idmembre,date,heure,idprojet) VALUES ("'.$ligne1['id'].'","'.$_SESSION['id'].'","'.$date.'","'.$heure.'","'.$idprojet.'")';
						mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));

						if (!empty($_SESSION['pageCourante'])) header('Location: '.$_SESSION['pageCourante']);
						else header('Location: '.$serveur.'NouveauProjet.php');

						echo '<h4>Le projet a été modifié.</h4>'."\n".'<a href="'.$serveur.'NouveauProjet.php">Pour le voir, visitez la page des projets</a>.</p>';

					}
				}
			}
		}

	}

	include 'Fonctions/footer.php';
?>