<?php session_start();
	include 'Fonctions/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
  <html lang="fr" >
  <head>
    <title>Nouveau post</title>
    <meta charset="utf-8" />
<?php
	include 'Fonctions/includeStylesheet.php';
?>
  </head>
  <body>

<?php

	function verifieChar ($dd1){

		$length = strlen($dd1);

		for ($i=0; $i<$length; $i++) {
			if ((substr($dd1,$i,2)=="<") || (substr($dd1,$i,1)==">") || (substr($dd1,$i,1)=="") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<") || (substr($dd1,$i,1)=="<")) return false;  
		}

		return true;
	}

	include 'MenuAccueil.php';
	include 'Fonctions/AdresseServeur.php';

	if (VerifieConnection()) {

		if (empty($_POST['article']) || empty($_POST['objet'])) {

		echo '<form action="'.$serveur.'EcritureNouveauPost.php" method="POST">
		   <label>Objet : <input type="text" name="objet" autofocus></label>
		   <label><p>Taper le texte de l'."'".'article : </p><textarea rows="25" cols="82" name="article"></textarea></label><br>
		    <input type="submit" value="Publier">
		</form>';

		if (!empty($_SESSION['pageCourante'])) echo '<a href="'.$_SESSION['pageCourante'].'">Annuler</a>'."\n";

		}else {

			include 'Fonctions/ConnectionBaseDonnees.php';

			$connexion = mysqli_connect($server, $user, $motdepasse, $base);
			if (!$connexion) {
			echo "Pas de connexion au serveur" ;
			}else {
				if (!$connexion) {
					echo "Pas d'accès à la base" ;
				}else {

					$idpost = mt_rand(1000000000,9999999999);

					if($_SERVER["HTTP_REFERER"] !== $serveur."EcritureNouveauPost.php") {
						echo "	<h1>Attention</h1>\n	<h4>Le formulaire est soumis depuis une source externe !</h4>";
					}

					else {

					if (!empty($_POST['article'])) $objet = htmlspecialchars($_POST['objet']);
					else echo "<h4>Veuillez entrer quelque chose, ou quitter cette page.</h4>";
		
					if (!empty($_POST['article'])) $article = htmlspecialchars($_POST['article']);
					else echo "<h4>Veuillez entrer quelque chose, ou quitter cette page.</h4>";
		
					$date = date("dmY");
					$heure = date("His");
					//echo $date;
					
					$sql = 'INSERT INTO posts (Post,Objet,date,id, idpost, heure) VALUES ("'.$article.'","'.$objet.'","'.$date.'","'.$_SESSION['id'].'","'.$idpost.'","'.$heure.'")';
					mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));

					$sql = 'UPDATE asso SET datedudernierpost="'.$date.'" WHERE id="'.$_SESSION['id'].'" AND motdepasse="'.$_SESSION['motdepasse'].'"';
					mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
		
					$requete = 'SELECT nombredeposts FROM asso WHERE id="'.$_SESSION['id'].'"';
					$resultat = mysqli_query($connexion, $requete);
					$ligne = mysqli_fetch_array($resultat);

					$nombredeposts = $ligne['nombredeposts']+1;	

					$sql = 'UPDATE asso SET nombredeposts="'.$nombredeposts.'" WHERE id="'.$_SESSION['id'].'" AND motdepasse="'.$_SESSION['motdepasse'].'"';
					mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));

					header('Location: '.$serveur.'Accueil%20%281%29.php');
	
					echo '<h4>Votre article a été enregistré.</h4>'."\n".'<p>Pour le voir, visitez la page <a href="'.$serveur.'Accueil%20%281%29.php">d'."'".'acceuil</a>.</p>';

					}
				}
			}
		}
	
	}
	
	//else include 'Connection1.php';

	include 'Fonctions/footer.php';

?>


  </body>
</html>