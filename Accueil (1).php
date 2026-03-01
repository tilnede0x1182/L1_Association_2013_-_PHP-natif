<?php session_start();
	include 'Fonctions/AdresseServeur.php';
	include 'Fonctions/includeStylesheet2.php';
	if (empty($_SESSION['id'])) $_SESSION['id']=80;
	if (empty($_SESSION['motdepasse'])) $_SESSION['motdepasse']=80;
	$_SESSION['pageCourante']=$serveur."Accueil%20%281%29.php";
	if (empty($_SESSION['style'])) $_SESSION['style']=1;
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Acueuil Assossiation</title>
<?php
	echo includeStylesheet2();
?>
  </head>
  <body>
<?php

	$un=1;

	include 'MenuAccueil.php';
	include 'Fonctions/detectlId.php';
	include 'Fonctions/ConversionDate.php';
	include 'Fonctions/AdresseServeur.php';

	include 'Fonctions/ConnectionBaseDonnees.php';

	$connexion = mysqli_connect($server, $user, $motdepasse, $base);
	if (!$connexion) {
		echo "Pas de connexion au serveur" ;
	}else {
		if (!$connexion) {
			echo "Pas d'accès à la base" ;
		}else {

			$requete1 = 'SELECT Post, Objet, date, idpost, id FROM posts ORDER BY date DESC, heure DESC';
			$resultat1 = mysqli_query($connexion, $requete1);

			include 'Fonctions/VerifieCompetence.php';
			
			if ($competence==1) {

				echo '    <table border="1">
				<tr>
					<th>Auteurs et dates de modification</th>
					<th>Derniers articles</th>'."\n";
				echo '   <th>Modifications</th>'."\n";
				echo '      </tr>';

				$tmp1=0;

				while (true) {
					$tmp1=$tmp1+1;
					$ligne = mysqli_fetch_array($resultat1);

					if (($ligne==false) || ($tmp1>5)) break;

					//echo '$ligne['."'".'idpost'."'".'] = '.$ligne['idpost']."<br>\n";

					$idpost=$ligne['idpost'];

					$requete2 = 'SELECT idmembre, date FROM dataposts WHERE idpost="'.$idpost.'" ORDER BY date DESC, heure DESC';
					$resultat2 = mysqli_query($connexion, $requete2);

					$dataposts = mysqli_fetch_array($resultat2);

					if ($dataposts!=false) $affdataposts = "<br>Dernière modification : <br>\n".'<a href="'.$serveur.'InformationMembre.php?idmembre='.$dataposts['idmembre'].'">'.$dataposts['idmembre']."</a> (".convertDate($dataposts['date']).")<br>";
					else $affdataposts="";

					if (!empty($ligne['Objet'])) $titrearticle = "<h4>".$ligne['Objet']." : </h4>";
					else $titrearticle = "";

					echo "\n	 <tr>";
					echo "	  <td>".$affdataposts."<br>\nPublication : \n<br>".'<a href="'.$serveur.'InformationMembre.php?idmembre='.$ligne['id'].'">'.$ligne['id']."</a> (".convertDate($ligne['date']).") \n";
					if ($affdataposts!="") echo '<br><br><a href="'.$serveur.'ListeAuteursPost.php?idpost='.$idpost.'">Afficher la liste</a>&nbsp;&nbsp;</td>'."\n";					
					echo "	  <td>".$titrearticle.""."<p>".nl2br(detectlId ($ligne['Post']),false)."</p>"."</td>\n";

					echo '	  <td><div class="lien"><a href="'.$serveur.'ModifierArticle.php?idarticle='.$idpost.'">modifier</a></div><br><br><br>'."\n".'<div class="lien"><a href="'.$serveur.'SupprimerArticle.php?idpost='.$idpost.'">supprimer</a></td>';

					echo "	 </tr>\n";
					

				}

				echo '	 </table>';

			} else {

				$requete5 = 'SELECT Post, Objet, date, id FROM posts ORDER by date DESC, heure DESC';
				$resultat5 = mysqli_query($connexion, $requete5);

				echo '    <table border="1">
				<tr>
					<th>Auteur</th>
					<th>Derniers articles</th>
					<th>Date de publication</th>
				</tr>';

				$tmp=0;

				while (true) {
					$tmp=$tmp+1;
					$ligne = mysqli_fetch_array($resultat5);

					if (($ligne==false) || ($tmp>5)) break;

					if (!empty($ligne['Objet'])) $titrearticle = "<h4>".$ligne['Objet']." : </h4>";
					else $titrearticle = "";
					
					echo "\n<tr>";
					
					echo "<td>".'<a href="'.$serveur.'InformationMembre.php?idmembre='.$ligne['id'].'">'.$ligne['id']."</a></td>\n";
					echo "<td>".$titrearticle."".nl2br(detectlId ($ligne['Post']), false)."</td>\n";
					echo "<td>".convertDate($ligne['date'])."</td>\n";
					
					echo "      </tr>\n";
				}

				echo '    </table>'."\n";
			}

			echo '<a href="'.$serveur.'ListeCompletePosts.php">Afficher la liste complète</a>';
			
		}
	}

	include 'Fonctions/footer.php';
	?>

  </body>
</html>
