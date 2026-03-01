<?php session_start();
	include 'Fonctions/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	if ((!empty($_SESSION['pageCourante'])) && (substr($_SESSION['pageCourante'],0,45)!=$serveur."ListeAuteursPost.php")) $pageprecedente = $_SESSION['pageCourante'];
	else $pageprecedente = "";
	$_SESSION['pageCourante']=$serveur."ListeAuteursPost.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
  <html lang="fr" >
  <head>
    <title>Liste des auteurs d'un article</title>
    <meta charset="utf-8" />
<?php
	include 'Fonctions/includeStylesheet.php';
?>
  </head>
  <body>

<?php
	include 'Fonctions/CalcAnciennete4.php';
	include 'Fonctions/ConversionDate.php';
	include 'Fonctions/AdresseServeur.php';
	include 'MenuAccueil.php';

	if (verifieConnection()) {

		include 'Fonctions/ConnectionBaseDonnees.php';
		
		$connexion = mysqli_connect($server, $user, $motdepasse, $base);
		if (!$connexion) {
			echo "Pas de connexion au serveur" ;
		}else {
			if (!$connexion) {
				echo "Pas d'accès à la base" ;
			}else {

				include 'Fonctions/VerifieCompetence.php';

				if ($competence==1) {

					if (!empty($_GET['idpost'])) $idpost = $_GET['idpost'];
					else $idpost = "";

					$_SESSION['pageCourante']=$serveur."ListeAuteursPost.php?idpost=".$idpost;

					echo '	 <table border="1">
	 <tr>
	  <th>Liste des auteurs de l'."'".'article</th>
	  <th>Date de modification</th>
	 </tr>
	 <tr>'."\n";
	 
					$requete = 'SELECT idmembre,date FROM dataposts WHERE idpost="'.$idpost.'" ORDER BY date DESC, heure DESC';
					$resultat = mysqli_query($connexion, $requete);

					$cmp=0;

					while (true) {
						$cmp = $cmp+1;

						$ligne = mysqli_fetch_array($resultat);

						if ($ligne==false){
							if ($cmp==1){
								echo '	 <tr>'."\n".'	  <td colspan="2">Aucune modification depuis la publication de l'."'".'article</td>'."\n".'	 </tr>'."\n";
								echo '</table>'."\n";
								break;
							}
							else break;
						}

						$idmembre = $ligne['idmembre'];
						$date = $ligne['date'];

						echo '	 </tr>'."\n";
						echo '	  <td><a href="'.$serveur.'InformationMembre.php?idmembre='.$idmembre.'">'.$idmembre.'</a></td>'."\n";
						echo '	  <td>'.convertDate($date).'</td>'."\n";
						echo '	 </tr>'."\n";
					}

					echo '	</table>'."\n";
					
					echo "<p>";

					if ($pageprecedente!="") echo '<a href="'.$pageprecedente.'">Retour</a><br>'."\n";

					else echo '<a href="'.$serveur.'Accueil%20%281%29.php">Retour à la page d'."'".'acceuil</a>'."\n";

					echo "</p>";
					
				}
			}	
		}
	}

	include 'Fonctions/footer.php';

?>