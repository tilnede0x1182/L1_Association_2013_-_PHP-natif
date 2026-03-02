<?php session_start();
	include '../../Utilitaires/Navigation/AdresseServeur.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	if (!empty($_SESSION['pageCourante'])) if (substr($_SESSION['pageCourante'],0,43)!=$serveur."Contenu/Posts/AfficheArticle.php") $pageprecedente = $_SESSION['pageCourante'];
	else $pageprecedente = "";
	$_SESSION['pageCourante']=$serveur."Contenu/Posts/AfficheArticle.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Article de </title>
<?php
	include '../../Utilitaires/Affichage/includeStylesheet.php';
?>
  </head>

  <body>

<?php
	include '../../Utilitaires/Navigation/AdresseServeur.php';

	if (!empty($_GET['idpost'])) $idpost = $_GET['idpost'];
	else $idpost = "incunnu";

	$_SESSION['pageCourante']=$serveur."Contenu/Posts/AfficheArticle.php?idpost=".$idpost."";

	$un=1;

	include '../../Accueil/MenuAccueil.php';
	include '../../Utilitaires/Verification/detectlId.php';
	include '../../Utilitaires/Dates/ConversionDate.php';

	include '../../Base_de_donnees/ConnectionBaseDonnees.php';

	$connexion = mysqli_connect($server, $user, $motdepasse, $base);

	if (!$connexion) {
		echo "Pas de connexion au serveur" ;
	}else {
		if (!$connexion) {
			echo "Pas d'accès à la base" ;
		}else {

			$requete1 = 'SELECT * FROM posts WHERE idpost="'.$idpost.'"';
			$resultat1 = mysqli_query($connexion, $requete1);

			include '../../Utilitaires/Verification/VerifieCompetence.php';

			if ($competence==1) {

			echo '    <table border="1">
			      <tr>
			        <th>Auteurs et dates de modification</th>
			        <th>Contenu de l'."'".'article</th>'."\n";
			echo '   <th>Modifications</th>'."\n";
			echo '      </tr>';

				$ligne = mysqli_fetch_array($resultat1);

				//echo '$ligne['."'".'idpost'."'".'] = '.$ligne['idpost']."<br>\n";

				$idpost=$ligne['idpost'];

				$requete2 = 'SELECT idmembre, date FROM dataposts WHERE idpost="'.$idpost.'" ORDER BY date DESC';
				$resultat2 = mysqli_query($connexion, $requete2);

				$dataposts = mysqli_fetch_array($resultat2);

				if ($dataposts!=false) $affdataposts = "<br>Dernière modification : <br>\n".'<a href="'.$serveur.'Membres/InformationMembre.php?idmembre='.$dataposts['idmembre'].'">'.$dataposts['idmembre']."</a> (".convertDate($dataposts['date']).")<br>";
				else $affdataposts="";

				if (!empty($ligne['Objet'])) $titrearticle = "<h4>".$ligne['Objet']." : </h4>";
				else $titrearticle = "";

				echo "\n<tr>";
				echo "<td>".$affdataposts."<br>\nPublication : \n<br>".'<a href="'.$serveur.'Membres/InformationMembre.php?idmembre='.$ligne['id'].'">'.$ligne['id']."</a> (".convertDate($ligne['date']).") \n";
				if ($affdataposts!="") echo '<br><br><a href="'.$serveur.'Contenu/Posts/ListeAuteursPost.php?idpost='.$idpost.'">Afficher la liste</a>&nbsp;&nbsp;</td>'."\n";					
				echo "<td>".$titrearticle."".nl2br(detectlId ($ligne['Post']),false)."</td>\n";

				echo '<td><a href="'.$serveur.'Contenu/Posts/ModifierArticle.php?idarticle='.$idpost.'">modifier</a><br><br><br>'."\n".'<a href="'.$serveur.'Contenu/Posts/SupprimerArticle.php?idpost='.$idpost.'">supprimer</a></td>';

				echo "      </tr>\n";
							

			echo '    </table>';

			} else {

			$requete5 = 'SELECT Post, Objet, date, id FROM posts ORDER by date DESC';
			$resultat5 = mysqli_query($connexion, $requete5);

			echo '    <table border="1">
			      <tr>
			        <th>Auteur</th>
			        <th>Contenu de l'."'".'article</th>
			        <th>Date de publication</th>
			      </tr>';

				$ligne = mysqli_fetch_array($resultat5);

				if (!empty($ligne['Objet'])) $titrearticle = "<h4>".$ligne['Objet']." : </h4>";
				else $titrearticle = "";
	
				echo "\n<tr>";
	
					echo "<td>".'<a href="'.$serveur.'Membres/InformationMembre.php?idmembre='.$ligne['id'].'">'.$ligne['id']."</a></td>\n";
					echo "<td>".$titrearticle."".nl2br(detectlId ($ligne['Post']), false)."</td>\n";
					echo "<td>".convertDate($ligne['date'])."</td>\n";
	
					echo "      </tr>\n";
			}

			echo '    </table>'."\n";
			
			if ($pageprecedente!="") echo '	 <p><a href="'.$pageprecedente.'">Retour</a></p>';

			//echo '	 <p><a href="'.$serveur.'Contenu/Posts/ListeCompletePosts.php">Liste des articles</a></p>';
		}
	}

	include '../../Utilitaires/Affichage/footer.php';

?>

  </body>
</html>
