<?php session_start();
	include 'Fonctions/includeStylesheet.php';
	include 'Fonctions/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
  <html lang="fr" >
  <head>
    <title>Projets - Création d'un nouveau projet</title>
    <meta charset="utf-8" />
<?php
	include 'Fonctions/includeStylesheet.php';
?>
  </head>
  <body>

<?php
	include 'MenuAccueil.php';
	include 'Fonctions/AdresseServeur.php';

	if (verifieConnection()){

		if ((empty($_POST['sujet'])) || (empty($_POST['contenu']))) {
			echo '<form action="'.$serveur.'CreationNouveauProjet.php" method="POST">
			   <label>Objet :  <input type="text" name="sujet" autofocus></label><br>
			   <label><p>Texte : </p><textarea rows="25" cols="82" name="contenu"></textarea></label><br>
			   <input type="submit" value="Créer">
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

					$idprojet = mt_rand(1000000000,9999999999);
		
					if (!empty($_POST['sujet'])) $objet = htmlspecialchars($_POST['sujet']);
					else echo "<h4>Veuillez entrer un titre pour votre projet.</h4>";
		
					if (!empty($_POST['contenu'])) $texte = htmlspecialchars($_POST['contenu']);
					else echo "<h4>Veuillez entrer quelque chose, ou quitter cette page.</h4>";
		
					$date = date("dmY");
					$heure = date("His");
					//echo $date;
					
					$sql = 'INSERT INTO projets (Texte, objet, idprojet, date, heure, id) VALUES ("'.$texte.'","'.$objet.'","'.$idprojet.'","'.$date.'","'.$heure.'","'.$_SESSION['id'].'")';
					mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));


					$sql = 'UPDATE asso SET datedudernierprojet="'.$date.'" WHERE id="'.$_SESSION['id'].'" AND motdepasse="'.$_SESSION['motdepasse'].'"';
					mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
		
					$requete = 'SELECT nombredeprojets FROM asso WHERE id="'.$_SESSION['id'].'"';
					$resultat = mysqli_query($connexion, $requete);

					$ligne = mysqli_fetch_array($resultat);

					$nombredeprojets = $ligne['nombredeprojets']+1;	

					//echo '$nombredeprojets'." = ".$nombredeprojets;

					$sql = 'UPDATE asso SET nombredeprojets="'.$nombredeprojets.'" WHERE id="'.$_SESSION['id'].'" AND motdepasse="'.$_SESSION['motdepasse'].'"';
					mysqli_query($connexion, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));

					header('Location: '.$serveur.'NouveauProjet.php');

					echo "<h4>Votre projet a été enregistré.</h4>\n<p>".'<a href="'.$serveur.'NouveauProjet.php">Pour le voir, visitez la page des projets</a>.'."</p>";
				}
			}
		}
	}

	include 'Fonctions/footer.php';
?>

  </body>
</html>